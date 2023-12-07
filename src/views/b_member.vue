<template>
    <Backlayout>
        <template #section-right-content>
            <div class="b_member">
                <div class="member-section" :class="{ 'blurred': isBlurred }">
                    <h1>會員查詢</h1>
                    <div class="member">
                        <div class="member-img"></div>
                        <p>{{ getUserName }}</p>
                        <img @click="b_logOut" class="b_logout_img" src="../assets/images/b_login/log-out.png" alt="">

                    </div>

                </div>


                <div class="table-section" :class="{ 'blurred': isBlurred }">
                    <div class="search-section">
                        <div class="form-floating mb-3">
                            <input type="search" class="form-control" id="floatingInput" placeholder="以會員帳號搜尋"
                                v-model="searchQuery">
                            <label for="floatingInput">以會員帳號搜尋</label>
                            <span @click="fliterMember">搜尋</span>
                        </div>
                    </div>
                    <table class="table table-bordered ">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col">會員編號</th>
                                <th scope="col">帳號</th>
                                <th scope="col">電話</th>
                                <th scope="col">姓名</th>
                                <th scope="col">帳號狀態</th>
                                <th scope="col">創建時間</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, index) in  fliterMember" :key="i.MEMBER_ID">
                                <th scope="row">{{ i.MEMBER_ID}}</th>
                                <td>{{ i.MEMBER_ACCOUNT }}</td>
                                <td>{{ i.MEMBER_PHONE }}</td>
                                <td>{{ i.MEMBER_FIRST_NAME}}{{i.MEMBER_LAST_NAME}}</td>
                                <td>{{ i.MEMBER_STATUS }}</td>
                                <td>{{ i.MEMBER_CREATETIME}}</td>
                                <td><button @click="show(index)" class="btn btn btn-warning">編輯</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="Pagination" :class="{ 'blurred': isBlurred }">
                    <ul>
                        <li v-for="page in Math.ceil(filterMemberID.length / itemsPerPage)" :key="page">
                            <button @click="changePage(page)">{{ page }}</button>
                        </li>
                        
                    </ul>
                </div>


                <div class="editMember" id="editMember" v-if="open">
                    <!-- 外層 -->
                    <div class="dialog" v-for="(i, index) in fliterMember" :key="i.MEMBER_ID">
                        <!-- 內容 -->
                        <div class="editTitle" v-if="selectedIndex == index">
                            <span>編輯帳號</span>
                        </div>
                        <div class="editContent" v-if="selectedIndex == index">
                            <div class="editAll_left">
                                <span>會員編號</span>
                                <p>{{ i.MEMBER_ID }}</p>
                                <span>帳號</span>
                                <p>{{ i.MEMBER_ACCOUNT }}</p>
                                <span>姓名</span>
                                <p>{{ i.MEMBER_FIRST_NAME}}{{i.MEMBER_LAST_NAME}}</p>
                            </div>

                            <div class="editAll_right">
                                <span>帳號狀態</span>
                                <select v-model="newStatus">
                                    <option value="0" disabled>離線中</option>
                                    <option value="1">上線中</option>
                                    <option value="2" disabled>流浪中</option>
                                    <option value="3">停用中</option>
                                </select>
                                <span>電話</span>
                                <p>{{ i.MEMBER_PHONE }}</p>
                                <span>創建時間</span>
                                <p>{{ i.MEMBER_CREATETIME}}</p>
                            </div>
                        </div>
                        <div class="edit_btn" v-if="selectedIndex == index">
                            <button type="button" class="mil-link" @click="close">關閉</button>
                            <button type="button" class="mil-link" @click="save(index)">儲存</button>
                        </div>
                    </div>
                </div>
            </div>

        </template>
    </Backlayout>
</template>
<script>
//import 這頁需要的元件
import Backlayout from "../components/backlayout.vue";

export default {
    data() {
        return {
            id: 0,
            open: false,
            isBlurred: false,
            selectedIndex: null,
            searchQuery: '',
            member: [],
            itemsPerPage:6,
            currentPage:1,
            newStatus:'',
            newMember:[],
        }
    },
    methods: {

        show(index) {
            this.$root.$emit('toggleBlur', !this.open);
            this.open = !this.open;
            this.isBlurred = !this.isBlurred;
            this.selectedIndex = index;
            this.newStatus = this.member[index].MEMBER_STATUS;

            // this.$emit('toggle-blur',this.open);
            // console.log(this.$root.$emit('toggleBlur',this.open))
        },
        close() {
            this.open = false;
            this.isBlurred = false;
        },

        changePage(page){
            this.currentPage = page;
        },

        
        save(index) {
            const selectMember = this.fliterMember[index].MEMBER_ID ;
            const dataStatus = this.newStatus;
            
            console.log('Sending data to backend:', {
                memberID: selectMember,
                newStatus: dataStatus,
            });

            fetch('api/update_b_member_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    memberID: selectMember,
                    newStatus: dataStatus,
            
                }),
            })
            .then(response => response.text())
            .then(data => {
                console.log(data);
                this.member.MEMBER_STATUS = data;
                location.reload()
               
            })
            .catch(error => {
                console.error('Error updating data:', error);
            });

            this.close();
        },
        // 管理員登出
        deleteCookie(name) {
            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:00 UTC;';
            location.reload()
        },
        // 管理員登出
        b_logOut() {
            fetch("api/b_logout.php",
            )
                .then((res) => {
                    return res.json()
                })
                .then((data) => {
                    if (window.confirm('確定登出嗎?')) {
                        if (data.message == '登出成功') {
                            this.deleteCookie("bUserName");
                            this.deleteCookie("bUserId");
                            this.$router.push('/backend');
                            console.log(data)
                        }
                    }
                })
        },
    },
    mounted(){
        fetch('api/b_member.php', {
            method: 'POST',
            mode:'cors',
            headers: {
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
        this.member = data;
        console.log(data);
        })
    },
    computed: {
        filterMemberID(){
            const query = this.searchQuery.toLowerCase();
            return this.member.filter((i)=>{
                return i.MEMBER_ACCOUNT.toLowerCase().includes(query);
            })
        },

        fliterMember() {
            // const query = this.searchQuery.toLowerCase()
            
            const startIndex = (this.currentPage -1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;
            
            return this.filterMemberID
                // .filter(i => i.mail.toLowerCase().includes(query))
                .slice(startIndex, endIndex)
        },
        getUserName() {
            const cookie = document.cookie;
            const cookiesArray = cookie.split(';');
            let username = '';
            cookiesArray.forEach((cookieItem) => {
                const [name, value] = cookieItem.trim().split('=');
                if (name === 'bUserName') {
                    username = value;
                }
            });
            // 如果找到 'bUserName' 的 cookie，則取出其值
            if (username !== '') {
                console.log(`Username: ${username}`);
                return username; // 返回取得的 username
            } else {
                console.log('找不到 bUserName 的 Cookie');
                return ''; // 或者返回空字符串或其他你認為合適的值
            }
        }
    },
    components: {
        Backlayout
    }
}
</script>

<style>
.blurred {
    filter: blur(100px);
}
</style>