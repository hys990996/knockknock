<template>
    <Backlayout>
        <template #section-right-content>
            <div class="b_active">
                <div class="active-section" :class="{ 'blurred': isBlurred }">
                    <h1>活動查詢</h1>
                    <div class="active">
                        <div class="active-img"></div>
                        <p>{{ getUserName }}</p>
                        <img @click="b_logOut" class="b_logout_img" src="../assets/images/b_login/log-out.png" alt="">
                    </div>

                </div>


                <div class="table-section" :class="{ 'blurred': isBlurred }">
                    <div class="search-section">
                        <div class="search-section-left">
                            <span @click="addActive">新增活動</span>
                        </div>
                        <div class="search-section-right">
                            <div class="form-floating mb-3">
                                <input type="search" class="form-control" id="floatingInput" placeholder="以活動名稱搜尋"
                                    v-model="activeQuery">
                                <label for="floatingInput">以活動名稱搜尋</label>
                                <span>搜尋</span>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered ">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col">活動編號</th>
                                <th scope="col">活動名稱</th>
                                <th scope="col">活動地點</th>
                                <th scope="col">活動狀態</th>
                                <th scope="col">活動日期</th>
                                <th scope="col">活動名額</th>
                                <th scope="col">剩餘名額</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(i, index) in displayedItems" :key="index">
                                <th scope="row">{{ i.ACTIVITY_ID }}</th>
                                <td>{{ i.ACTIVITY_NAME }}</td>
                                <td>{{ i.ACTIVITY_ADDRESS }}</td>
                                <td>{{ i.ACTIVITY_STATUS }}</td>
                                <td>{{ i.ACTIVITY_DATE
                                }}</td>
                                <td>{{ i.ACTIVITY_QUOTA
                                }}</td>
                                <td>{{ i.ACTIVITY_REMAINING_PLACES
                                }}</td>
                                <td><button @click="showInfo(i.ACTIVITY_ID)" class="btn btn btn-warning">查詢</button></td>
                                <td><button @click="show(index)" class="btn btn btn-warning">編輯</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="Pagination" :class="{ 'blurred': isBlurred }">

                    <ul>
                        <li v-for="page in pageCount" :key="page">
                            <button type="button" @click="changePage(page)">{{ page }}</button>
                        </li>
                    </ul>
                </div>

                <!-- 編輯活動 -->
                <div class="editActivity" id="editActivity" v-if="open">
                    <!-- 外層 -->
                    <div class="dialog" v-for="(i, index) in displayedItems" :key="i.ACTIVITY_ID">
                        <!-- 內容 -->
                        <div class="editTitle" v-if="active_show == index">
                            <span>編輯活動</span>
                        </div>
                        <div class="editContent" v-if="active_show == index">
                            <div class="editAll_left">
                                <span>活動編號</span>
                                <p>{{ i.ACTIVITY_ID }}</p>
                                <span>活動名稱</span>
                                <p>{{ i.ACTIVITY_NAME }}</p>
                                <span>活動地點</span>
                                <p>{{ i.ACTIVITY_ADDRESS }}</p>

                            </div>

                            <div class="editAll_right" v-if="active_show == index">
                                <span>活動狀態</span>
                                <select v-model="newActivityStatus">
                                    <option disabled>選擇</option>
                                    <option value="正常">正常</option>
                                    <option value="取消">取消</option>
                                </select>
                                <span>活動日期</span>
                                <p>{{ i.ACTIVITY_DATE }}</p>
                            </div>

                        </div>
                        <div class="edit_btn" v-if="active_show == index">
                            <button type="button" class="mil-link" @click="close">關閉</button>
                            <button type="button" class="mil-link" @click="upDateActivityStatus(index)">儲存</button>
                        </div>
                    </div>



                </div>




                <!-- 報名資料查詢 -->
                <div class="activeInfo" id="activeInfo" v-if="sign">
                    <!-- 外層 -->
                    <div class="dialog">
                        <!-- 內容 -->
                        <div class="editTitle">
                            <span>報名資料查詢</span>
                        </div>
                        <div class="editContent">

                            <table class="table table-show">
                                <thead>
                                    <tr>
                                        <th scope="col">姓名</th>
                                        <th scope="col">電話</th>
                                        <th scope="col">Emial</th>
                                        <th scope="col">總金額</th>
                                        <th scope="col">報名人數</th>
                                        <th scope="col">付款狀態</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(i, index) in foundActivity" :key="i.ACTIVITY_ID">
                                        <th scope="row">{{ i.MEMBER_FIRST_NAME
                                        }}{{ i.MEMBER_LAST_NAME }}</th>
                                        <td>{{ i.MEMBER_PHONE
                                        }}</td>
                                        <td>{{ i.MEMBER_ACCOUNT

                                        }}</td>
                                        <td>{{ i.REGISTER_TOTAL_PRICE }}</td>
                                        <td>{{ i.REGISTER_COUNT
                                        }}</td>
                                        <td>{{ i.REGISTER_PAIED == 0
                                            ? '否' : '是' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="edit_btn">
                        <button type="button" class="mil-link" @click="close">關閉</button>
                    </div>
                </div>

                <!-- 新增活動 -->
                <div class="addActivity" id="addActivity" v-if="add">
                    <!-- 外層 -->
                    <div class="dialog">
                        <!-- 內容 -->
                        <div class="editTitle">
                            <span>新增活動</span>
                        </div>

                        <div class="addtop">
                            <div :class="{ 'imgNone': disappear }"></div>
                            <img :class="{ 'imgNone': !disappear }" :src="imgSrc" alt="">
                            <!-- <input type="file" ref="ipAvatar" @change="upLoadImg"> -->
                        </div>

                        <div class="editContent">
                            <div class="editAll_left">

                                <span>活動編號</span>
                                <p>{{ active.length + 1 }}</p>
                                <span>選擇區域</span>
                                <select v-model="addActivityRegion">
                                    <option value="北區">北區</option>
                                    <option value="中區">中區</option>
                                    <option value="南區">南區</option>
                                    <option value="離島">離島</option>
                                </select>
                                <span>活動名稱</span>
                                <input type="text" v-model="addActivityName">
                                <span>活動地點</span>
                                <input type="text" v-model="addActivityAddress">
                                <span>單人費用</span>
                                <input type="number" v-model="addActivitySinglePrice">
                                <span>活動名額</span>
                                <input type="number" v-model="addActivityQuota">
                            </div>

                            <div class="editAll_right">
                                <span>團體費用</span>
                                <input type="number" v-model="addActivityGroupPrice">
                                <span>活動日期</span>
                                <input type="date" v-model="addActivityDate">
                                <span>報名開始</span>
                                <input type="date" v-model="addActivityStartDate">
                                <span>報名截止</span>
                                <input type="date" v-model="addActivityEndDate">
                                <span>剩餘名額</span>
                                <input type="number" v-model="addActivityRemaining">

                            </div>
                        </div>

                        <div class="activeDes">

                            <textarea name="" id="" cols="30" rows="10" v-model="addActivityDescribe" placeholder="活動描述">
                            </textarea>
                        </div>

                    </div>


                    <div class="edit_btn">
                        <input type="file" class="form-control" id="inputGroupFile04"
                            aria-describedby="inputGroupFileAddon04" aria-label="Upload" ref="ipAvatar" @change="upLoadImg">
                        <button type="button" class="mil-link" @click="close">關閉</button>
                        <button type="button" class="mil-link" @click="addActivity">新增活動</button>

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
            sign: false,
            add: false,
            isBlurred: false,
            active_show: null,
            activeQuery: '',
            pagination: {},
            filteredActive: [],
            // 當前頁面
            currentPage: 1,
            // 每頁顯示的數量
            itemPerPage: 6,

            disappear: false,
            newStatus: '',
            active: [],
            // 活動表單區域

            addActivityName: '',
            addActivityAddress: '',
            addActivityDate: '',
            addActivitySinglePrice: 0,
            addActivityGroupPrice: 0,
            addActivityDescribe: '',
            addActivityStartDate: '',
            addActivityEndDate: '',
            imgSrc: '',
            addActivityQuota: 0,
            addActivityRemaining: 0,
            addActivityRegion: '',
            // 更新活動狀態
            newActivityStatus: '',
            // 活動狀態查詢
            inquireAct: [],
            // 過濾活動id
            foundActivity: [],
        }
    },
    methods: {
        // 換頁
        changePage(page) {
            // 切換頁碼
            this.currentPage = page;
        },
        close() {
            this.open = false;
            this.sign = false;
            this.add = false;
            this.isBlurred = false;
        },

        show(index) {
            this.$root.$emit('toggleBlur', !this.open);
            this.open = !this.open;
            this.isBlurred = !this.isBlurred;
            this.active_show = index;
            this.newActivityStatus = this.active[index].ACTIVITY_STATUS
            // this.$emit('toggle-blur',this.open);
            // console.log(this.$root.$emit('toggleBlur',this.open))
        },
        showInfo(activitiId) {
            this.$root.$emit('toggleBlur', !this.sign);
            this.sign = !this.sign;
            this.isBlurred = !this.isBlurred;
            this.foundActivity = this.inquireAct.filter(i => i.ACTIVITY_ID == activitiId);
            console.log(this.foundActivity);

        },
        addActive() {
            this.$root.$emit('toggleBlur', !this.add);
            this.add = !this.add;
            this.isBlurred = !this.isBlurred
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
        // 上傳圖片
        upLoadImg() {
            if (this.$refs.ipAvatar.files[0]) {
                this.imgSrc = URL.createObjectURL(this.$refs.ipAvatar.files[0])
            }
            this.disappear = true;
            // this.imgSrc = '';
        },
        // 新增活動
        addActivity() {
            if (this.$refs.ipAvatar.files[0]) {
                const fr = new FileReader();
                fr.addEventListener("load", (e) => {
                    const imageBase64 = btoa(e.target.result);
                    fetch("api/b_addActivity.php", {
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        mode: 'cors',
                        method: 'POST',
                        body: JSON.stringify({
                            ACTIVITY_ID: this.active.length + 1,
                            ACTIVITY_NAME: this.addActivityName,
                            ACTIVITY_ADDRESS: this.addActivityAddress,
                            ACTIVITY_DATE: this.addActivityDate,
                            ACTIVITY_DESCRIBE: this.addActivityDescribe,
                            ACTIVITY_ENDDATE: this.addActivityEndDate,
                            ACTIVITY_SINGLE_PRICE: this.addActivitySinglePrice,
                            ACTIVITY_GROUP_PRICE: this.addActivityGroupPrice,
                            ACTIVITY_STARTDATE: this.addActivityStartDate, ACTIVITY_IMAGE: imageBase64,
                            ACTIVITY_STATUS: '正常',
                            ACTIVITY_REGION: this.addActivityRegion,
                            ACTIVITY_QUOTA: this.addActivityQuota,
                            ACTIVITY_REMAINING_PLACES: this.addActivityRemaining,
                        })
                    })
                        .then((res) => {
                            return res.json()
                        })
                        .then((data) => {
                            console.log(data)
                        })
                });
                fr.readAsDataURL(this.$refs.ipAvatar.files[0]);

            }
            this.close();
        },
        // 更新活動狀態
        upDateActivityStatus(key) {
            const selectSActivityStatus = this.newActivityStatus
            console.log(selectSActivityStatus);

            fetch('api/b_activity_updateStatus.php', {
                headers: {
                    'Content-Type': 'application/json'
                },
                method: 'POST',
                mode: 'cors',
                body: JSON.stringify({
                    ACTIVITY_STATUS: selectSActivityStatus,
                    ACTIVITY_ID: this.displayedItems[key].ACTIVITY_ID
                })
            })
                .then((res) => {
                    return res.text()
                })
                .then((data) => {
                    console.log(data);
                })
            this.close();
            location.reload();
        },




    },
    computed: {
        filterActive() {
            const query = this.activeQuery.toLowerCase();
            return this.active.filter((i) => {
                return i.ACTIVITY_NAME.toLowerCase().includes(query);
            });
        },
        pageCount() {
            return Math.ceil(this.filteredActive.length / this.itemPerPage)
        },
        displayedItems() {
            this.filteredActive = this.filterActive;
            const startIndex = (this.currentPage - 1) * this.itemPerPage;
            const endPage = startIndex + this.itemPerPage;
            console.log('startIndex', startIndex, 'endPage', endPage);
            console.log(this.active.slice(startIndex, endPage))
            return this.filteredActive.slice(startIndex, endPage);
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
    mounted() {
        fetch("api/b_activity.php")
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                this.active = data;
                console.log(data);

            })
        // 查詢報名資料


        fetch('api/b_InquireActivity.php')
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                console.log(data)
                this.inquireAct = data
            })



    },
    components: {
        Backlayout
    }
}
</script>