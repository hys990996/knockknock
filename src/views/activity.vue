<template>
    <layout>
        <template #section-right-content>

            <div class="activity">
                <!-- activity banner -->
                <div class="banner">
                    <div class="banner-top">
                        <!-- 主頁區 -->
                        <div class="top-text">
                            <div class="title">主題活動</div>
                            <div class="sub-title">Let's join us!</div>
                            <div class="sub-title">與好友線上實體一起玩樂</div>

                        </div>
                    </div>
                    <div class="banner-search">
                        <div class="search-pic">
                            <img src="../assets/images/activity/party friend.png" alt="">

                        </div>
                    </div>
                    <div class="banner-pic">
                        <!-- 圖片 -->
                    </div>

                </div>

                <!-- hot topic bar -->
                <div class="sub-bar">
                    <div>最新活動</div>
                </div>
                <!-- topic card
                <div class="topic-container">
                    <div class="cards">
                    <div class="arrow" @click="changeCardContent(true)">
                        <img src="../assets/images/activity/icon_leftarrow.svg" alt="">
                    </div>

                    <router-link v-for="(card, index) in topicCards" :key="index" :to="{ name: 'activity_info' }" class="card" v-show="shouldShowCard(index)">
                        <div class="card-pic">
                        <img :src="card.image" alt="">
                        <div class="location">
                            <img src="../assets/images/activity/location.svg" alt="">
                            <div class="text">{{ card.location }}</div>
                        </div>
                        </div>
                        <div class="card-details">
                        <div class="card-details-title">{{ card.title }}</div>
                        <div class="card-details-info">
                            <img src="../assets/images/activity/calendar.svg" alt="">
                            <div>{{ card.date }}</div>
                        </div>
                        <div class="card-details-info">
                            <img src="../assets/images/activity/group.svg" alt="">
                            <div>{{ card.remainingSlots }}</div>
                        </div>
                        </div>
                    </router-link>

                    <div class="arrow" @click="changeCardContent(false)">
                        <img src="../assets/images/activity/icon_rightarrow.svg" alt="">
                    </div>
                    <div class="more">
                        查看更多 +
                    </div>
                    </div>
                </div> -->
                <!-- 原本的topic card -->
                <div class="topic-container">
                    <div class="cards">


                        <router-link :to="{ name: 'activity_info', params: { activityID: i.ACTIVITY_ID } }" class="card"
                            v-for="(i, key) in  showHotActivity" :key="i.ACTIVITY_ID" @click="getActivityId(key)">
                            <div class="card-pic">
                                <img :src="i.ACTIVITY_IMAGE" alt="">
                                <!-- <img src="../assets/images/activity/music-fes.jpg" alt=""> -->
                                <div class="location">
                                    <img src="../assets/images/activity/location.svg" alt="">
                                    <div class="text">{{ i.ACTIVITY_REGION }}，{{ i.ACTIVITY_ADDRESS.slice(0, 2) }}</div>
                                </div>
                            </div>
                            <div class="card-details">
                                <div class="card-details-title">
                                    {{ i.ACTIVITY_NAME }}
                                </div>
                                <div class="card-details-info">
                                    <img src="../assets/images/activity/calendar.svg" alt="">
                                    <div>{{ i.ACTIVITY_DATE }}</div>
                                </div>
                                <div class="card-details-info">
                                    <img src="../assets/images/activity/group.svg" alt="">
                                    <div>{{ i.ACTIVITY_REMAINING_PLACES }}</div>
                                </div>

                            </div>
                        </router-link>


                        <div class="more">
                            查看更多 +
                        </div>
                    </div>

                </div>
                <!-- 原本結束 -->

                <!-- activity region bar -->
                <div class="sub-bar">
                    <div>活動地區</div>

                </div>

                <!-- region card -->
                <div class="region-cards">
                    <div class="region-container">

                        <div class="region">
                            <router-link :to="{ name: 'activity_search', params: { activityRegion: '北區' } }" class="">
                                <div class="region-pic">
                                    <img src="../assets/images/activity/taipei.jpg" alt="">
                                </div>
                                <div class="region-text">北區</div>

                            </router-link>
                        </div>
                        <div class="region">
                            <router-link :to="{ name: 'activity_search', params: { activityRegion: '中區' } }" class="">
                                <div class="region-pic">
                                    <img src="../assets/images/activity/mid-opera.jpeg" alt="">
                                </div>
                                <div class="region-text">中區</div>

                            </router-link>
                        </div>
                        <div class="region">
                            <router-link :to="{ name: 'activity_search', params: { activityRegion: '南區' } }" class="">
                                <div class="region-pic">
                                    <img src="../assets/images/activity/kaohsiung.jpg" alt="">
                                </div>
                                <div class="region-text">南區</div>

                            </router-link>
                        </div>
                        <div class="region">
                            <router-link :to="{ name: 'activity_search', params: { activityRegion: '離島' } }" class="">
                                <div class="region-pic">
                                    <img src="../assets/images/activity/penghu.jpg" alt="">
                                </div>
                                <div class="region-text">離島</div>

                            </router-link>
                        </div>
                    </div>


                </div>

                <!-- upcoming bar -->
                <div class="sub-bar">
                    <div>即將開始</div>

                </div>

                <!-- upcoming card -->
                <div class="upcoming-cards">
                    <div class="upcoming-container">

                        <div class="upcoming">

                            <div class="upcoming-card" v-for="(i, key) in upCommingActivity" :key="i.ACTIVITY_ID">
                                <div class="card-pic">
                                    <img :src="i.ACTIVITY_IMAGE" alt="">
                                </div>
                                <div class="card-detail">
                                    <div class="title">{{ i.ACTIVITY_NAME }}</div>
                                    <div class="date">活動日期：
                                        <span>{{ i.ACTIVITY_DATE }}</span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>




            </div>
        </template>
    </layout>
</template>
<script>
//import 這頁需要的元件

import layout from '@/components/layout.vue'


export default {
    components: {
        layout
    },
    props: ["activityID", "activityRegion"],
    data() {
        return {
            totalActivity: [],
            hotActivity: [],
            activityID: 0,
            activityRegion: '',
            upCommingActivity: [],
            ajax_url: import.meta.env.VITE_AJAX_URL,
        }
    },
    methods: {
        // 獲取當下點擊的id()
        getActivityId(id) {
            this.activityID = id;
            console.log('Clicked activity ID:', id);
        },
        // 獲取當下的區域
        getActivityArea(area) {
            this.activityRegion = area
            console.log('Clicked activity Region:', area);
        }
    },
    computed: {
        showHotActivity() {
            return this.hotActivity.slice(this.hotActivity.length - 4, this.hotActivity.length - 1)
        }
    },
    mounted() {
        fetch(this.ajax_url + 'showActivity.php')
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                console.log(data)
                this.totalActivity = data;
                this.hotActivity = data;
                this.activityID = this.$route.params.activityID;
                this.upCommingActivity = this.totalActivity.filter((activity) => {
                    let currentDate = new Date();
                    let startDate = new Date(activity.ACTIVITY_DATE);

                    let curretDate = new Date();
                    curretDate.setMonth(currentDate.getMonth() + 2);

                    return startDate <= curretDate && startDate >= currentDate;
                });
                console.log(this.upCommingActivity)
            })
    }

};
</script>