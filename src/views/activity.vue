<script setup>
import layout from "@/components/layout.vue";
import ActiveCard from "../components/Active/ActiveCard.vue";
import { ref } from "vue";
import { useApi } from "../util/useApi";
const { getActive } = useApi();
const activeData = ref([]);
const isLoading = ref(false);
const getAllActive = async () => {
  isLoading.value = true;
  const response = await getActive();
  isLoading.value = false;
  activeData.value = response;
};
getAllActive();
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
        </div>

        <!-- hot topic bar -->
        <div class="sub-bar">
          <div>最新活動</div>
        </div>
        <ActiveCard :is-loading="isLoading" :data="activeData" />
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
