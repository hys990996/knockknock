<script setup>
import layout from "@/components/layout.vue";
import ActiveCard from "../components/Active/ActiveCard.vue";
import { onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
const { getActive } = useApi();
const activeData = ref([]);
const getAllActive = async () => {
  const response = await getActive();
  activeData.value = response;
};
onMounted(() => {
  getAllActive();
});
</script>
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
              <img src="../assets/images/activity/party friend.png" alt="" />
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
        <n-carousel
          effect="card"
          prev-slide-style="transform: translateX(-150%) translateZ(-800px);"
          next-slide-style="transform: translateX(50%) translateZ(-800px);"
          style="height: 350px"
          :show-dots="false"
        >
          <n-carousel-item
            v-for="item in activeData"
            :key="item.ACTIVITY_ID"
            :style="{ width: '60%' }"
          >
            <ActiveCard v-if="activeData" :data="item" />
          </n-carousel-item>
        </n-carousel>

        <!-- activity region bar -->
        <div class="sub-bar">
          <div>活動地區</div>
        </div>

        <!-- region card -->
        <div class="region-cards">
          <div class="region-container">
            <div class="region">
              <router-link
                :to="{
                  name: 'activity_search',
                  params: { activityRegion: '北區' },
                }"
                class=""
              >
                <div class="region-pic">
                  <img src="../assets/images/activity/taipei.jpg" alt="" />
                </div>
                <div class="region-text">北區</div>
              </router-link>
            </div>
            <div class="region">
              <router-link
                :to="{
                  name: 'activity_search',
                  params: { activityRegion: '中區' },
                }"
                class=""
              >
                <div class="region-pic">
                  <img src="../assets/images/activity/mid-opera.jpeg" alt="" />
                </div>
                <div class="region-text">中區</div>
              </router-link>
            </div>
            <div class="region">
              <router-link
                :to="{
                  name: 'activity_search',
                  params: { activityRegion: '南區' },
                }"
                class=""
              >
                <div class="region-pic">
                  <img src="../assets/images/activity/kaohsiung.jpg" alt="" />
                </div>
                <div class="region-text">南區</div>
              </router-link>
            </div>
            <div class="region">
              <router-link
                :to="{
                  name: 'activity_search',
                  params: { activityRegion: '離島' },
                }"
                class=""
              >
                <div class="region-pic">
                  <img src="../assets/images/activity/penghu.jpg" alt="" />
                </div>
                <div class="region-text">離島</div>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </template>
  </layout>
</template>
