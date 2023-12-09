<template>
    <layout>
        <template #section-right-content>
            <div class="activity-search">
                <div class="search-container">

                    <div class="search-result">
                        <div class="result">
                            <img src="../assets/images/icon/search.svg" alt="">
                            <span>搜尋結果</span>
                        </div>
                        <div class="key-word">
                            <span>關鍵字：</span>
                            <span>{{ activityRegion }}</span>

                        </div>
                    </div>
                    <router-link :to="{ name: 'activity_info', params: { activityID: i.ACTIVITY_ID } }" class="result-cards"
                        v-for="(i, key) in areaActivity" :key="i.ACTIVITY_ID" @click="getActivityId(key)">


                        <div class="result-card">
                            <div class="result-pic">
                                <img :src="i.ACTIVITY_IMAGE" alt="">
                                <div class="info">
                                    <img src="../assets/images/activity/location.svg" alt="">
                                    <div>{{ i.ACTIVITY_REGION }}，{{ i.ACTIVITY_ADDRESS.slice(0, 2) }}</div>
                                </div>
                            </div>
                            <div class="result-details">
                                <div class="result-text">
                                    <h3>{{ i.ACTIVITY_NAME }}</h3>
                                    <div class="details">

                                        <div class="detail">
                                            <img src="../assets/images/activity/calendar-dk.svg" alt="">
                                            <div>{{ i.ACTIVITY_DATE }}</div>
                                        </div>
                                        <div class="detail">
                                            <img src="../assets/images/activity/group-dk.svg" alt="">
                                            <div>名額{{ i.ACTIVITY_QUOTA }}人</div>
                                        </div>
                                        <div class="detail">
                                            <img src="../assets/images/activity/dollar.svg" alt="">
                                            <div>1人 ${{ i.ACTIVITY_SINGLE_PRICE }} /人</div>
                                        </div>
                                        <div class="detail">
                                            <div class="fake"></div>
                                            <div>3人 ${{ i.ACTIVITY_GROUP_PRICE }} /人</div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>


                    </router-link>
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
    data() {
        return {
            areaActivity: [],
            activityRegion: '',
            activityID: 0,
            ajax_url: import.meta.env.VITE_AJAX_URL,
        }
    },
    methods: {
        getActivityId(id) {
            this.activityID = id;
            console.log('Clicked activity ID:', id);
        },
    },
    mounted() {
        this.activityRegion = this.$route.params.activityRegion;
        console.log(this.activityRegion);
        fetch(this.ajax_url + "reigonActivity.php", {
            headers: {
                'Content-Type': 'application/json'
            },
            method: 'POST',
            mode: 'cors',
            body: JSON.stringify({
                ACTIVITY_REGION: this.activityRegion
            })
        })
            .then((res) => {
                return res.json()
            })
            .then((data) => {
                console.log(data)
                this.areaActivity = data
            })
    }

}
</script>