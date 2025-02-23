<script setup>
defineOptions({
  name: "PageBanner",
});
defineProps({
  bannerData: Object,
});
</script>
<template>
  <div class="banner">
    <div class="banner-top">
      <!-- 主頁區 -->
      <div class="top-text">
        <div class="title">{{ bannerData.title }}</div>
        <div class="sub-title" v-for="item in bannerData.subTitle" :key="item">
          {{ item }}
        </div>
      </div>
    </div>
    <div class="banner-search">
      <div class="search-pic">
        <img :src="bannerData.image" />
      </div>
    </div>
  </div>
</template>
