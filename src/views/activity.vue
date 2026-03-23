<script setup>
import layout from "@/components/layout.vue";
import ActiveCard from "../components/Active/ActiveCard.vue";
import { onMounted, reactive, ref } from "vue";
import { useApi } from "../util/useApi";
import taipei from "../assets/images/activity/taipei.jpg";
import taichung from "../assets/images/activity/mid-opera.jpeg";
import kaohsiung from "../assets/images/activity/kaohsiung.jpg";
import penghu from "../assets/images/activity/penghu.jpg";
import bannerImage from "../assets/images//activity/party friend.png";
import PageBanner from "../components/Banner/PageBanner.vue";
const activeData = ref({});
const isLoading = ref(false);
const cardConfig = reactive({
  page: 1,
  total: 1,
});

const ACTIVE_REGION = [
  { image: taipei, regionLabel: "北區" },
  { image: taichung, regionLabel: "中區" },
  { image: kaohsiung, regionLabel: "南區" },
  { image: penghu, regionLabel: "離島" },
];

const BANNER = {
  title: "主題活動",
  subTitle: ["Let's join us!", "與好友線上實體一起玩樂"],
  image: bannerImage,
};

const getAllActive = async () => {
  isLoading.value = true;
  const response = await useApi.getActive({
    page: cardConfig.page,
    perPage: 1,
  });
  isLoading.value = false;
  activeData.value = response.data;
  cardConfig.total = Number(response.total);
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
        <PageBanner :banner-data="BANNER" />
        <!-- hot topic bar -->
        <div class="sub-bar">活動列表</div>
        <ActiveCard :is-loading="isLoading" :data="activeData" />
        <n-pagination
          class="pagina"
          v-model:page="cardConfig.page"
          :page-count="cardConfig.total"
          @update:change="getAllActive"
        />
        <div class="sub-bar">最新活動</div>
        <div class="region-cards">
          <div class="region-container">
            <div
              class="region"
              v-for="item in ACTIVE_REGION"
              :key="item.regionLabel"
            >
              <router-link
                :to="{
                  name: 'activity_search',
                  params: { activityRegion: item.regionLabel },
                }"
              >
                <div class="region-pic">
                  <img :src="item.image" alt="item.regionLabel" />
                </div>
                <div class="region-text">{{ item.regionLabel }}</div>
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </template>
  </layout>
</template>
<style lang="scss" scoped>
.pagina {
  margin-top: 16px;
}
</style>
