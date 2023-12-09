<template>
    <Backlayout>
        <template #section-right-content>
            <div class="b_serve">
                <div class="serve-section" :class="{ 'blurred': isBlurred }">
                    <h1>客服管理</h1>
                    <div class="serve">
                        <div class="serve-img"></div>
                        <p>{{ getUserName }}</p>
                        <img @click="b_logOut" class="b_logout_img" src="../assets/images/b_login/log-out.png" alt="">
                    </div>

                </div>


                <div class="table-section" :class="{ 'blurred': isBlurred }">
                    <div class="search-section">
                        <div class="form-floating mb-3">
                            <input type="search" class="form-control" id="floatingInput" placeholder="以回復狀態搜尋"
                                v-model="serveQuery">
                            <label for="floatingInput">以回覆狀態搜尋</label>
                            <span @click="serveFliter">搜尋</span>
                        </div>
                    </div>
                    <table class="table table-bordered ">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col">問題編號</th>
                                <th scope="col">會員信箱</th>
                                <th scope="col">問題內容</th>
                                <th scope="col">提問人姓名</th>
                                <th scope="col">反應日期</th>
                                <th scope="col"></th>
                                <th scope="col">回覆狀態</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, index) in  serveFliter" :key="i.CONTACT_ID">
                                <th scope="row">{{ i.CONTACT_ID }}</th>
                                <td>{{ i.MEMBER_ACCOUNT }}</td>
                                <td>{{ i.CONTACT_CONTACT }}</td>
                                <td>{{ i.MEMBER_FIRST_NAME }}{{ i.MEMBER_LAST_NAME }}</td>

                                <!-- 反應日期 -->
                                <td>{{ i.CONTACT_CREATETIME }}</td>

                                <!-- 回覆日期 -->
                                <td></td>

                                <td :class="{ 'active': i.CONTACT_REPLIED == '未回覆' }">{{ i.CONTACT_REPLIED }}</td>
                                <td><button class="btn btn btn-warning" @click="show(index)"
                                        v-if="i.CONTACT_REPLIED == 0">回覆</button>
                                    <button class="btn btn btn-warning" @click="show(index)"
                                        v-if="i.CONTACT_REPLIED == 1">查詢</button>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="Pagination" :class="{ 'blurred': isBlurred }">
                    <ul>
                        <li v-for="page in Math.ceil(serveFliterID.length / itemsPerPage)" :key="page">
                            <button @click="changePage(page)">{{ page }}</button>
                        </li>

                    </ul>
                </div>

                <div class="serviceRes" id="serviceRes" v-if="open">
                    <!-- 外層 -->
                    <div class="dialog" v-for="(i, index) in serveFliter" :key="i.CONTACT_ID">
                        <!-- 內容 -->
                        <div class="editTitle" v-if="serve_qa_index == index">
                            <span>客服問題</span>
                        </div>
                        <div class="editContent" v-if="serve_qa_index == index">
                            <div class="editAll_left">
                                <span>問題編號</span>
                                <p>{{ i.CONTACT_ID }}</p>
                                <span>提問內容</span>
                                <p>{{ i.CONTACT_CONTACT }}</p>
                                <span>姓名</span>
                                <p>{{ i.MEMBER_FIRST_NAME }}{{ i.MEMBER_LAST_NAME }}</p>
                                <span>會員信箱</span>
                                <p>{{ i.MEMBER_ACCOUNT }}</p>
                            </div>

                            <div class="editAll_right">
                                <span>問題狀態</span>
                                <p>{{ i.CONTACT_REPLIED }}</p>
                                <span>反應日期</span>
                                <p>{{ i.CONTACT_CREATETIME }}</p>
                                <span>回覆內容</span>
                                <p>{{ i.CONTACT_REPLY_CONTENT }}</p>
                                <input type="date" v-if="i.state == '未回覆'">
                            </div>

                        </div>
                        <div class="reply" v-if="i.CONTACT_REPLIED == 0 && serve_qa_index == index">
                            <textarea v-model="replyContent" name="" id="" cols="30" rows="10">
                                </textarea>
                        </div>
                        <div class="edit_btn" v-if="serve_qa_index == index">
                            <button type="button" class="mil-link" @click="close">關閉</button>
                            <button type="button" class="mil-link" @click="save(index)"
                                v-if="i.CONTACT_REPLIED == 0">儲存</button>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </Backlayout>
</template>
<script>
//import 這頁需要的元件
import { query } from "firebase/database";
import Backlayout from "../components/backlayout.vue";

export default {
    data() {
        return {
            id: 0,
            open: false,
            serve_qa_index: null,
            serveQuery: '',
            serve_qa: [],
            itemsPerPage: 6,
            currentPage: 1,

            // 回覆資料
            replyContent: '',
            ajax_url: import.meta.env.VITE_AJAX_URL,
        }
    },
    methods: {
        show(index) {
            this.$root.$emit('toggleBlur', !this.open);
            this.open = !this.open;
            this.isBlurred = !this.isBlurred;
            this.serve_qa_index = index
        },
        close() {
            this.open = false;
            this.isBlurred = false;
        },
        changePage(page) {
            this.currentPage = page;
        },

        save(index) {

            // 按下儲存後更新資料

            const selectContact = this.serveFliter[index];
            // console.log(selectContact);
            if (selectContact.CONTACT_REPLIED == 0) {
                selectContact.CONTACT_REPLIED == 1
                console.log('success change');
            } else {
                console.log('nonono')
            }

            const replyData = {
                // 問題的編號
                contactID: selectContact.CONTACT_ID,
                // 回覆的內容
                replyContent: this.replyContent,
            };

            fetch(this.ajax_url + 'insert_b_service.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(replyData),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('success fetch')
                    location.reload()
                })

            this.replyContent = '';
            this.close();
        },
        // 管理員登出
        deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
            location.reload()
        },
        // 管理員登出
        b_logOut() {
            fetch(this.ajax_url + "b_logout.php",
            )
                .then((res) => {
                    return res.json()
                })
                .then((data) => {
                    if (window.confirm('確定登出嗎?')) {
                        if (data.message == '登出成功') {
                            this.deleteCookie("bUserName")
                            this.deleteCookie("bUserId")
                            this.$router.push('/backend')
                            console.log(data)
                        }

                    }


                })
        },

    },
    mounted() {
        fetch(this.ajax_url + 'b_service.php', {
            method: 'POST',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                this.serve_qa = data;
                console.log(data);
            })
    },
    computed: {

        serveFliterID() {
            const query = this.serveQuery.toLowerCase();
            return this.serve_qa.filter((i) => {
                return i.CONTACT_REPLIED.toLowerCase().includes(query);
            })
        },

        serveFliter() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;

            return this.serveFliterID
                .slice(startIndex, endIndex)
        }
    },
    components: {
        Backlayout
    }
}
</script>