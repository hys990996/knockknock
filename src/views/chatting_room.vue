<template>
    <layout>
        <template #section-right-content>
            <div class="chatroom-start" v-if="!isSubmitted">
                <h1>加入聊天大廳</h1>
                <div class="user-img-section">
                    <div class="img-select" v-for="(i, key) in imgList" :key="i.id">
                        <img :class="{ active: i.url == activeImage }" :src="i.url" alt="" @click="selectImg(i.url)">
                    </div>
                </div>
                <div class="user-content">
                    <input type="text" placeholder="請輸入暱稱" v-model="tempUsername">
                    <button @click="submitUsername" class="Btn Btn-dark chatbtn">進入</button>
                </div>
            </div>


            <div class="chatroom" v-else>
                <!-- <h1>聊天大廳</h1> -->
                <div class="chat-section">

                    <!-- 聊天內容的區域 -->
                    <ul v-for="(i, key) in chatroom" :key="key" ref="chatContainer">
                        <!-- 使用者頭像，判斷是不是當前用戶 -->
                        <span class="middle"
                            :class="{ 'user-right': i.username === username, 'user-left': i.username !== username }">
                            <img :src="i.image" alt="">
                        </span>

                        <!-- 訊息內容顯示，並判斷是不是當前用戶 -->
                        <span class="bottom" :class="{
                            'content-right': i.username === username,
                            'content-left': i.username !== username
                        }">
                            <li>{{ i.message }}</li>
                        </span>

                        <!-- 使用者名稱、發送時間，並判斷是不是當前用戶 -->
                        <span class="top"
                            :class="{ 'user-right': i.username === username, 'user-left': i.username !== username }">

                            <li class="username">{{ i.username }}</li>
                            <li> {{ i.time }}</li>

                        </span>

                    </ul>


                </div>


                <div class="user-section">

                    <div class="text-content">
                        <div class="input-section">
                            <input type="text" v-model="message" placeholder="請輸入信息">
                            <img src="../assets/images/chatroom/Vector.svg" alt="" @click="addMessage">
                        </div>

                        <button @click="addMessage" @keyup.enter="addMessage" class="Btn Btn-dark chatbtn">送出</button>
                    </div>
                </div>
            </div>
        </template>
    </layout>
</template>

<script>
import layout from '../components/layout.vue';
import { initializeApp } from 'firebase/app';
import { getAuth } from 'firebase/auth';
import { getDatabase, ref, push, set, get, query, orderByKey, limitToLast, onValue } from 'firebase/database';
import { nextTick } from 'vue';

const firebaseApp = initializeApp({
    apiKey: "AIzaSyBLqg3ReSlc8ukkM6Fq3syretEb-zJ6MDs",
    authDomain: "grouptwo-5f7c1.firebaseapp.com",
    databaseURL: "https://grouptwo-5f7c1-default-rtdb.firebaseio.com",
    projectId: "grouptwo-5f7c1",
    storageBucket: "grouptwo-5f7c1.appspot.com",
    messagingSenderId: "808510575879",
    appId: "1:808510575879:web:d0e8896ccc079472bbe1a2"
});

const auth = getAuth(firebaseApp);
const db = getDatabase(firebaseApp);
function writeUserData(userID, name, email) {
    set(ref(db, 'user/' + userID),
        {
            username: name,
            email
        })
}
const messageRef = ref(db, 'chatroom/messages');

export default {
    components: {
        layout
    },
    data() {
        return {
            activeImage: '',
            active: false,
            message: " ",
            chatroom: [],
            username: " ",
            tempUsername: "",
            isSubmitted: false,
            currentMessageImage: '', // 存放選中的圖片,
            ajax_url: import.meta.env.VITE_AJAX_URL,
            imgList: [
                {
                    id: 1,
                    url: '/thd103/g2/dist/assets/jian-86ee9b7b.png'
                },
                {
                    id: 2,
                    url: '/thd103/g2/dist/assets/boy-base-880fb11c.png'
                },
                {
                    id: 3,
                    url: '/thd103/g2/dist/assets/shi-5cc94709.png'
                },
                {
                    id: 4,
                    url: '/thd103/g2/dist/assets/face_scare-0303d344.png'
                }
            ]
        }
    },
    methods: {
        forceRerender() { // 強制重新渲染
            this.$forceUpdate(); // 使用$forceUpdate 強制重新渲染
        },

        addMessage() {
            const date = new Date().getTime();
            const newMessage = push(messageRef); // 推到firebase
            let image = this.currentMessageImage || 'src/assets/images/user/userimage.png';

            if (this.message !== "") {
                set(newMessage, {
                    username: this.username,
                    message: this.message,
                    time: new Date(date).toLocaleString(),
                    image: image,
                })
                this.message = '';
                this.$nextTick(() => { // 傳送訊息後用nextTick確保DOM更新後再次滾到底部
                    this.scrollToBottom();
                });

            } else {
                alert("請輸入信息");
            }
        },
        submitUsername() {
            if (this.tempUsername.trim() !== "") { // 用trim把兩側空格去掉
                this.username = this.tempUsername;
                this.tempUsername = "";
                this.isSubmitted = true;

                this.$nextTick(() => { // 進入頁面用nextTick確保DOM更新後滾動到底部
                    this.scrollToBottom();
                });

            } else {
                alert("請輸入暱稱")
            };
        },
        selectImg(image) {
            this.currentMessageImage = image || '';
            this.active = !this.active;
            this.activeImage = image
        },
        scrollToBottom() {
            const chatContainer = document.querySelector('.slot-content')
            if (chatContainer) {
                if (chatContainer.scrollHeight > 0) {
                    setTimeout(() => {
                        chatContainer.scrollTo(0, chatContainer.scrollHeight)
                    }, 10);
                    console.log(chatContainer.scrollHeight);
                    chatContainer.scroll({
                        top: 9000,
                    });
                } else {
                    console.warn('chatContainer.scrollHeight is 0. Cannot scroll to bottom.')
                }
            } else {
                console.error("chatContainer is undefined.");
            }
        },


    },

    mounted() {
        this.forceRerender();
        onValue(messageRef, (snapshot) => { // 監聽firebase變化
            const data = snapshot.val(); // 用snapshot抓到data的數據
            this.chatroom = data;
            this.$nextTick(() => {
                this.scrollToBottom();
            });
        });
        this.$nextTick(() => {
            const chatContainer = this.$refs.chatContainer;
            if (chatContainer) {
            } else {
                console.error("chatContainer is undefined.");
            }
        })
    },

}
</script>