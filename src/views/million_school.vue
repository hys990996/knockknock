<template>
    <layout>
        <template #section-right-content>
            <main class="million_school">

                <div class="member">
                    <div class="playerimg">
                        <img :src="user_img" alt="player">
                    </div>

                    <p class="username">{{ member_name }}</p>

                    <div class="bottom">
                        <div class="score">

                            <p>最高紀錄</p>
                            <p>{{ maxScore }}題</p>

                        </div>

                        <div class="rank">
                            <p>初始分數</p>
                            <p>0</p>
                        </div>
                    </div>

                </div>

                <div class="millionimg">
                    <img src="../assets/images/million_school/qafront.svg" alt="">
                </div>

                <router-link class="mil-link" :to="{ name: 'million_school_start' }">start</router-link>

            </main>
        </template>
    </layout>
</template>
<script>
//import 這頁需要的元件
import layout from '@/components/layout.vue'
import { useUserStore } from '@/store/user';


export default {
    components: {
        layout
    },
    data() {
        return {
            MEMBER_ID: 0,
            member_name: '',
            user_img: '',
            maxScore: 0,
            ajax_url: import.meta.env.VITE_AJAX_URL,

        }


    },
    mounted() {
        const userStore = useUserStore();
        this.MEMBER_ID = userStore.userID;
        this.member_name = userStore.userName;
        this.user_img = 'data:image/png;base64,' + userStore.userImg;

        fetch(this.ajax_url + 'millionSchool_search.php', {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({
                userID: this.MEMBER_ID,
            })
        })
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                console.log(data)
                this.maxScore = data[0][0];
                if (this.maxScore == null) {
                    this.maxScore = 0
                }
                console.log(data[0][0])
            })
    }
}
</script>