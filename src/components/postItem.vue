<template>
    <div class="post-item" v-for="(item, index) in  postItems " :key="item.id">
        <div class="post-user-delete">
            <div class="post-user-info">
                <div class="post-user-image">
                    <img :src=item.userImg alt="">
                </div>
                <div class="post-user-time">
                    <p class="user-name">{{ item.userName }}</p>
                    <div class="post-time">
                        <p class="user-post-time">{{ item.createTime.replaceAll('-', '/') }}</p>
                        <img :src="'data:image/*;base64,' + item.status" alt="">
                    </div>
                </div>
            </div>
            <div v-if="showDelete" class="delete-post" @click="deletePost($event, index, item.id)">
                <img src="../assets/images/wander/X.png" alt="close-icon">
            </div>
        </div>
        <div class="post-content">
            <p>
                {{ item.content }}
            </p>
        </div>
        <div :class="['post-images', { 'show': item.postImages.length > 0 }]">
            <div class="img-item" v-for="(img, index) in item.postImages" :key="img.id"><img :src="img.src" alt=""></div>
        </div>
        <div class="post-feedback">
            <div class="good-block">
                <img :src="'data:image/jpg;base64,' + item.liked ? like : unlike" alt="" class="good"
                    @click="likePost($event, index, item.id)">
                <p class="good-nums">{{ item.likes }}</p>
                <p>人</p>
            </div>
            <div class="reply-block">
                <img src="../assets/images/icon/message.svg" alt="">
                <p class="reply-nums">{{ item.replieds.length }}</p>
                <p>則</p>
            </div>
        </div>
        <div class="post-reply">
            <div ref="repliedContainer" class="replied showScrollbar">
                <div class="replied-msg" v-for="(comment, index) in  item.replieds " :key="comment.id">
                    <div class="user-image">
                        <img :src="comment.userImg" alt="">
                    </div>
                    <div class="replied-message">
                        <div class="user-name">{{ comment.name }}</div>
                        <div class="content">
                            <div class="text">{{ comment.commemtText }}</div>
                            <div class="replied-time">{{ comment.createTime }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="reply-message">
                <div class="user-image">
                    <img :src="'data:image/png;base64,' + userImage" alt="">
                </div>
                <div class="reply-input">
                    <input type="text" class="inputCommon" @blur="bindCommentText($event)"
                        @keyup.enter="bindCommentText($event), enterAddComment($event, index, item.id)">
                    <button type="button" @click="addComment($event, index, item.id)">
                        <img src="../assets/images/icon/submit.svg" alt="">
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


// import { Luminous } from "luminous-lightbox";
import unlike from '@/assets/images/icon/good-line.svg';
import like from '@/assets/images/icon/good-fill.svg';

import { useUserStore } from '@/store/user';
import axios from 'axios';

export default {
    props: ["postItems", "userImage"],
    emits: ["addComment"],
    data() {
        return {
            commemtText: '',
            unlike,
            like,
            userId: '',
            showDelete: true,
            ajax_url: import.meta.env.VITE_AJAX_URL,
        }
    },
    methods: {
        scrollToBottom() {
            const scrollContainer = this.$refs.repliedContainer;
            // console.log(scrollContainer.scrollHeight)

            // 視窗滾到底部
            // scrollContainer.scrollTop = scrollContainer.scrollHeight;
        },
        bindCommentText(e) {
            if (e.target.value != '') {
                //將input資料設定至commentText變數
                this.commemtText = e.target.value;
            }
        },
        addComment(e, i, postId) {

            if (this.commemtText != '') {
                //將回覆內容傳回父層(home)
                const comment = this.commemtText;
                this.$emit('addComment', e, i, postId, comment)

                //清空變數跟input欄位
                this.commemtText = '';
                // console.log(e.target.parentNode.previousSibling);
                e.target.parentNode.previousSibling.value = '';

            } else {
                alert('請輸入回覆內容');
            }
        },
        enterAddComment(e, i, postId) {

            this.addComment(e, i, postId);
            e.target.value = '';
        },
        likePost(e, i, postId) {
            const imgString = e.target.src;

            if (!imgString.includes('-line')) {
                e.target.src = unlike;
                this.postItems[i].likes--;
                e.target.src = '/thd103/g2/dist/assets/good-line-f550979a.svg';
                const likeData = {
                    userId: this.userId,
                    postId: postId,
                    action: 'M'
                }

                axios.post(this.ajax_url + 'updatePostLike.php', JSON.stringify(likeData))
                    .then(response => {

                        if (response.data != 1) {
                            console.log('update fail')
                        }
                    }).catch(error => {
                        console.log(error);
                    });
                return true;

            } else {
                e.target.src = like;
                this.postItems[i].likes++;
                e.target.src = '/thd103/g2/dist/assets/good-fill-3b2acaae.svg';
                const likeData = {
                    userId: this.userId,
                    postId: postId,
                    action: 'P'
                }

                axios.post(this.ajax_url + 'updatePostLike.php', JSON.stringify(likeData))
                    .then(response => {
                        if (response.data != 1) {
                            console.log('update fail')
                        }
                    }).catch(error => {
                        console.log(error);
                    });
                return true;
                // console.log(this.postItems[i])
            }
        },
        deletePost(e, i, postId) {

            let r = confirm("確定刪除這篇貼文嗎？");

            if (r) {

                e.target.parentElement.parentElement.parentElement.classList.add("fade_out");

                setTimeout(() => {
                    this.postItems.splice(i, 1);
                }, 500);

                axios.post(this.ajax_url + 'updatePostDeleted.php', { postId })
                    .then(response => {
                        if (response.data == 1) {
                            alert('刪除成功');
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });

            }

        },
    },
    beforeMount() {
        //取得會員資料
        const userStore = useUserStore();

        this.userId = userStore.userID;

        //控制刪除按鈕
        let page = '';
        page = this.$route.name;
        if (page.includes('home')) {
            this.showDelete = false;
        } else {
            this.showDelete = true;
        }

    },
    mounted() {
        // this.scrollToBottom();
    },
}
</script>