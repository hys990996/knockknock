<template>
    <layout>
        <template #section-right-content>
            <main class="playground">
                <div class="banner">
                    <section class="s_left">
                        <h1>遊樂場</h1>
                        <p>經典復古小遊戲 免費無限暢玩</p>
                        <p>打敗名人榜 成為小遊戲小天才</p>
                    </section>
                    <section class="s_right">
                        <img src="../assets/images/playground/player2.svg" alt="">
                    </section>
                </div>
                <div class="intro">
                    <div class="left-img">
                        <img src="../assets/images/playground/5281748 1.svg" alt="">
                    </div>
                    <div class="right-content">
                        <h2>百萬小學堂 Quiz</h2>
                        <p>百萬小學堂（Million School）是一款教育性質的小遊戲，通常是基於答題的方式。玩家在遊戲中需要回答一系列的問題，可以涵蓋各種主題，例如數學、語言、科學等。遊戲的目標通常是回答盡可能多的問題，以取得更高的分数。</p>
                        <router-link class="Btn Btn-dark mil-link" :to="{ name: 'million_school' }"> start</router-link>
                    </div>
                </div>
                <div class="ranking">
                    <section class="left">
                        <h2>排行榜</h2>
                        <div class="rank-list">
                            <div class="ranking-item" v-for="(i,key) in schoolRank" :key="key">
                               
                                <h1>第{{ key+1}}名</h1>
                                <img class="player_img" :src="'data:image/png;base64,'+i.MEMBER_PIC" alt="">
                                <p>{{ i.MEMBER_LAST_NAME }}{{ i.MEMBER_FIRST_NAME }}</p>
                            </div>
                           
                        </div>
                    </section>
                    <section class="right">
                        <img src="../assets/images/playground/Rectangle 30.svg" alt="">
                    </section>
                </div>


                <!-- ------------------下半部------------------ -->

                <div class="intro">
                    <div class="left-img">
                        <img src="../assets/images/playground/snake.svg" alt="">
                    </div>
                    <div class="right-content">
                        <h2>貪吃蛇 Sankes</h2>
                        <p>蛇一開始只有一個短小的身體。蛇可以在四個方向（上、下、左、右）上移動，通過控制鍵盤或其他輸入設備。每當蛇吃掉食物時，它會變得稍微變長，玩家必須避免蛇撞到牆壁或自己的身體，否則遊戲將結束。</p>
                        <router-link class="Btn Btn-dark mil-link" :to="{ name: 'snake' }"> start</router-link>
                    </div>
                   
                </div>
                <div class="ranking">
                    <section class="left">
                        <h2>排行榜</h2>
                        <div class="rank-list" >
                            <div class="ranking-item" v-for="(i,key) in snakeRank" :key="key">
                                <h1>第{{ key+1}}名</h1>
                                <img class="player_img" :src="'data:image/png;base64,'+i.MEMBER_PIC" alt="">
                                <p>{{ i.MEMBER_LAST_NAME }}{{ i.MEMBER_FIRST_NAME }}</p>
                            </div>
                           
                        </div>
                    </section>
                    <section class="right">
                        <img src="../assets/images/playground/Rectangle 31.svg" alt="">
                    </section>
                </div>
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
    data(){
        return{
            snakeRank:[],
            schoolRank:[],
            medalNumber: 1, // 根據需要的數字初始化,

        }
    },
    mounted(){
        const userStore = useUserStore();
        this.MEMBER_ID = userStore.userID;
        this.member_name = userStore.userName;
        this.user_img = 'data:image/png;base64,'+userStore.userImg;

        // snake Ranking
        fetch('api/snakeRanking.php')
        .then((res)=>{
            return res.json()
        })
        .then((data)=>{
            console.log(data)
            this.snakeRank = data;
        })

        // million school Ranking
        fetch('api/schoolRanking.php')
        .then((res)=>{
            return res.json()
        })
        .then((data)=>{
            console.log(data)
            this.schoolRank = data;
        })

    }
}
</script>
