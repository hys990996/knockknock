<template>
    <Backlayout>
        <template #section-right-content>
            <div class="b_mission">
                <div class="mission-section" :class="{ 'blurred': isBlurred }">
                    <h1>任務管理</h1>
                    <div class="mission">
                        <div class="mission-img"></div>
                        <p>{{ getUserName }}</p>
                        <img @click="b_logOut" class="b_logout_img" src="../assets/images/b_login/log-out.png" alt="">
                    </div>

                </div>


                <div class="table-section" :class="{ 'blurred': isBlurred }">
                    <div class="search-section">
                        <div class="search-section-left">
                        </div>
                        <div class="search-section-right">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="floatingInput" placeholder="以任務內容搜尋"
                                    v-model="missionQuery">
                                <label for="floatingInput">以任務內容搜尋</label>
                                <span @click="missionFliter">搜尋</span>
                            </div>
                        </div>
                    </div>

                    <table class="table table-bordered ">
                        <thead>
                            <tr class="table-warning">
                                <th scope="col">任務編號</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">任務內容</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">金幣數量</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col">完成次數</th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(mission, index) in missionFliter" :key="mission.MISSION_ID">
                                <th scope="row">{{ mission.MISSION_ID }}</th>
                                <td></td>
                                <td></td>
                                <td>{{ mission.MISSION_CONTENT }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ mission.MISSION_COINS }}</td>
                                <td></td>
                                <td></td>
                                <td>{{ mission.MISSION_TIMES }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button class="btn btn btn-warning" @click="show(index)">編輯</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="Pagination" :class="{ 'blurred': isBlurred }">
                    <ul>
                        <li v-for="page in Math.ceil(missionFliterID.length / itemsPerPage)" :key="page">
                            <button @click="changePage(page)">{{ page }}</button>
                        </li>
                    </ul>
                </div>

                <div class="editMission" id="editMission" v-if="open">
                    <!-- 外層 -->
                    <div class="dialog" v-for="(mission, index) in missionFliter" :key="mission.MISSION_ID">
                        <!-- 內容 -->
                        <div class="editTitle" v-if="selectedIndex == index">
                            <span>任務管理</span>
                        </div>
                        <div class="editContent" v-if="selectedIndex == index">
                            <div class="editAll_left">
                                <span>任務編號</span>
                                <p>{{ mission.MISSION_ID }}</p>
                                <span>任務內容</span>
                                <p>{{ mission.MISSION_CONTENT }}</p>
                            </div>

                            <div class="editAll_right">
                                <span>金幣數量</span>
                                <input type="number" v-model="newCoin">
                                <span>完成次數</span>
                                <input type="number" v-model="newTimes">
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
            missionQuery: '',
            mission: [],
            itemsPerPage: 6,
            currentPage: 1,
            newMission: [],

            // 金幣
            newCoin: '',
            // 次數
            newTimes: '',
            ajax_url: import.meta.env.VITE_AJAX_URL,
        }
    },
    methods: {
        show(index) {
            this.$root.$emit('toggleBlur', !this.open);
            this.open = !this.open;
            this.isBlurred = !this.isBlurred
            this.selectedIndex = index;

            const selectedMission = this.mission[index];

            // this.$emit('toggle-blur',this.open);
            // console.log(this.$root.$emit('toggleBlur',this.open))
        },
        close() {
            this.open = false;
            this.isBlurred = false;
        },
        changePage(page) {
            this.currentPage = page;
        },

        save(index) {
            const selectMission = this.newMission[index].MISSION_ID;
            const dataCoin = this.newCoin !== '' ? this.newCoin : null;
            const dataTimes = this.newTimes !== '' ? this.newTimes : null;

            console.log('Sending data to backend:', {
                MISSION_ID: selectMission,
                newCoin: dataCoin,
                newTimes: dataTimes,
            });

            fetch(this.ajax_url + 'update_b_mission.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    MISSION_ID: selectMission,
                    newCoin: dataCoin !== '' ? dataCoin : null,
                    newTimes: dataTimes !== '' ? dataTimes : null,
                }),
            })
                .then(response => response.text())
                .then(updateData => {
                    console.log(updateData)
                    this.mission[this.selectedIndex].MISSION_COINS = updateData.MISSION_COINS;
                    this.mission[this.selectedIndex].MISSION_TIMES = updateData.MISSION_TIMES;
                })
            location.reload();
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
        fetch(this.ajax_url + 'b_mission.php', {
            method: 'POST',
            mode: 'cors',
            headers: {
                'Content-Type': 'application/json',
            },
        })
            .then(response => response.json())
            .then(data => {
                this.mission = data;
                this.newMission = data;
                // console.log(data);
            })
    },
    computed: {

        missionFliterID() {
            const query = this.missionQuery.toLowerCase();
            return this.mission.filter((i) => {
                // return i.MISSION_ID && typeof i.MISSION_ID === 'string' && i.MISSION_ID.toLowerCase().includes(query);
                return i.MISSION_CONTENT.toLowerCase().includes(query);
            })
        },

        missionFliter() {
            const startIndex = (this.currentPage - 1) * this.itemsPerPage;
            const endIndex = startIndex + this.itemsPerPage;

            return this.missionFliterID
                .slice(startIndex, endIndex)
        },


    },
    components: {
        Backlayout
    }
}
</script>