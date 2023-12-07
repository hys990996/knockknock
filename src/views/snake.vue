<template>
    <layout>
        <template #section-right-content>
            <main class="snake">
                <canvas class="snake_canvas" width="300" height="300" ref="canvas"></canvas>
                <div class="score-section">
                    <p>最高分數: {{ maxScore }}</p>
                    <p>遊戲分數:{{ score }}</p>
                    <div>
                        <span class="left" @click="left"></span>
                        <span class="right" @click="right"></span>
                    </div>
                    <button @click="gameStart">{{ gameInProgress ? 'RESTART' : 'START'
                    }}</button>
                </div>

            </main>
        </template>
    </layout>
</template>

<script>
import layout from '@/components/layout.vue';
import { useUserStore } from '@/store/user';


export default {
    components: {
        layout
    },
    data() {
        return {
            score: 0,
            block_count: 20,
            block_size: 20,
            gameInterval: null,
            snake: {
                body: [{
                    x: 10,
                    y: 10
                }],
                size: 5,
                direction: {
                    x: 0, y: -1
                }
            },
            newBlock: {},
            apple: {
                x: null,
                y: null
            },
            gameRunning: false,
            // score: 0,
            MEMBER_ID :0,
            member_name:'',
            user_img:'',
            gameScoreCreateTime:new Date(),
            maxScore:0
        }
    },
    methods: {
        gameStart() {
            if (!this.gameRunning) {
                this.gameRunning = true;
                this.resetGame();
                this.gameInterval = setInterval(this.gameRoutine, 100);
                this.putApple();
                this.updateCanvas();
            }
        },
        gameRoutine() {
            this.moveSnake();
            if (this.snakeIsDead()) {
                this.ggler();
                return;
            }
            this.updateCanvas();
        },
        updateCanvas() {
            const context = this.$refs.canvas.getContext('2d');
            context.fillStyle = 'white';
            context.strokeRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
            context.fillRect(0, 0, this.$refs.canvas.width, this.$refs.canvas.height);
            context.fillStyle = 'lime';
            for (let i = 0; i < this.snake.body.length; i++) {
                context.fillRect(
                    this.snake.body[i].x * this.block_size + 1,
                    this.snake.body[i].y * this.block_size + 1,
                    this.block_size - 1,
                    this.block_size - 1
                );
            }
            context.fillStyle = 'red';
            context.fillRect(this.apple.x * this.block_size + 1, this.apple.y * this.block_size + 1, this.block_size - 1, this.block_size - 1);
        },
        moveSnake() {
            this.newBlock = {
                x: this.snake.body[0].x + this.snake.direction.x,
                y: this.snake.body[0].y + this.snake.direction.y
            };
            this.snake.body.unshift(this.newBlock);
            while (this.snake.body.length > this.snake.size) {
                this.snake.body.pop();
            }
            if (this.apple.x === this.snake.body[0].x && this.apple.y === this.snake.body[0].y) {
                this.eatApple();
            }
        },
        // snakeIsDead() {
        //     if (this.snake.body[0].x < 0 || this.snake.body[0].x >= this.canvas.width || this.snake.body[0].y < 0 || this.snake.body[0].y >= this.canvas.height) {
        //         // 蛇頭超出邊界
        //         return true;
        //     }
        //     // 檢查蛇頭有沒有碰到自身
        //     for (let i = 1; i < this.snake.body.length; i++) {
        //         if (this.snake.body[0].x === this.snake.body[i].x && this.snake.body[0].y === this.snake.body[i].y) {
        //             return true; // 蛇头与自身发生碰撞，返回 true 表示游戏结束
        //         }
        //     }

        //     return false; // 游戏继续进行
        // },



        snakeIsDead() {
            if (this.snake.body[0].x < 0) {
                return true
            }
            else if (this.snake.body[0].x >= 15) {
                return true
            }
            else if (this.snake.body[0].y < 0) {
                return true
            }
            else if (this.snake.body[0].y >= 15) {
                return true
            }
            // if (this.snake.body[0].x < 0) this.snake.body[0].x = this.block_count - 1;
            // if (this.snake.body[0].x >= this.block_count) this.snake.body[0].x = 0;
            // if (this.snake.body[0].y < 0) this.snake.body[0].y = this.block_count - 1;
            // if (this.snake.body[0].y >= this.block_count) this.snake.body[0].y = 0;
            // if (this.snake.body[0].x < 0 || this.snake.body[0].x >= this.block_count || this.snake.body[0].y < 0 || this.snake.body[0].y >= this.block_count) {
            //     return true;
            // }
            for (let i = 1; i < this.snake.body.length; i++) {
                if (this.snake.body[0].x === this.snake.body[i].x && this.snake.body[0].y === this.snake.body[i].y) {
                    return true;
                }
            }
            return false;
        },
        ggler() {
            clearInterval(this.gameInterval);
            this.gameRunning = false;
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            const formattedDateTime = `${year}/${month}/${day} ${currentDate.getHours()}:${currentDate.getMinutes()}:${currentDate.getSeconds()}`;
            fetch('api/snake_insert.php',{
                headers:{
                    'Content-Type':'application/json'
                },
                method:'POST',
                mode:'cors',
                body:JSON.stringify({
                    userID:this.MEMBER_ID,
                    gameID:1,
                    gameScore:this.score,
                    gameScoreCreateTime: formattedDateTime

                })
            })
            .then((res)=>{
                return res.json()
            })
            .then((data)=>{
                console.log(data);
                
            })
            
        },
        resetGame() {
            this.snake = {
                body: [{
                    x: 10,
                    y: 10
                }],
                size: 5,
                direction: {
                    x: 0, y: -1
                }
            };
            this.newBlock = {};
            this.putApple();
            this.score = 0
        },
        putApple() {
            this.apple.x = Math.floor(Math.random() * this.block_count / 2);
            this.apple.y = Math.floor(Math.random() * this.block_count / 2);
            for (let i = 0; i < this.snake.body.length; i++) {
                if (this.snake.body[i].x === this.apple.x && this.snake.body[i].y === this.apple.y) {
                    this.putApple();
                    break;
                }
            }
        },
        eatApple() {
            this.snake.size += 1;
            this.putApple();
            this.score++
        },
        left() {
            let originX = this.snake.direction.x;
            let originY = this.snake.direction.y;
            this.snake.direction.x = originY;
            this.snake.direction.y = originX;
        },
        right() {
            let originX = this.snake.direction.x;
            let originY = this.snake.direction.y;
            this.snake.direction.x = -originY;
            this.snake.direction.y = originX;
        }
    },
    computed:{
   
    },
    mounted() {
        const userStore = useUserStore();
        this.MEMBER_ID = userStore.userID;
        this.member_name = userStore.userName;
        this.user_img = 'data:image/png;base64,'+userStore.userImg;

        // 最高分數
        fetch('api/snake_search.php',{
            headers:{
                    'Content-Type':'application/json'
                },
                method:'POST',
                mode:'cors',
                body:JSON.stringify({
                    userID:this.MEMBER_ID,
                })
        })
        .then((res)=>{
            return res.json()
        })
        .then((data)=>{
            console.log(data)
            
            this.maxScore = data[0][0];
            if(this.maxScore == null){
                this.maxScore =0
            }
            console.log(data[0][0])
        })
        

       

        console.log(this.$refs.canvas.width, this.$refs.canvas.height)
        document.addEventListener("keydown", (e) => {
            let originX = this.snake.direction.x;
            let originY = this.snake.direction.y;
            if (e.keyCode === 37) {
                this.snake.direction.x = originY;
                this.snake.direction.y = originX;
            } else if (e.keyCode === 39) {
                this.snake.direction.x = -originY;
                this.snake.direction.y = originX;
            }
        })
    }
}
</script>