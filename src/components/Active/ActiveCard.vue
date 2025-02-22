<script setup>
import { LocationOutline } from "@vicons/ionicons5";
import { useRouter } from "vue-router";
defineOptions({
  name: "ActiveCard",
});
const props = defineProps({
  data: Array,
  isLoading: Boolean,
});
const router = useRouter();
const link = () => {
  router.push({
    name: "activity_info",
    params: { activityID: props.data?.ACTIVITY_ID },
  });
};
</script>
<template>
  <n-carousel
    effect="card"
    prev-slide-style="transform: translateX(-150%) translateZ(-800px);"
    next-slide-style="transform: translateX(50%) translateZ(-800px);"
    style="height: 350px"
    :show-dots="false"
  >
    <n-carousel-item
      v-for="item in data"
      :key="item.ACTIVITY_ID"
      class="activeCardCarousel"
      :style="{ width: '60%' }"
    >
      <section class="activeCard">
        <n-image
          class="activeCard__img"
          width="250"
          :src="item?.ACTIVITY_IMAGE"
        />
        <div class="activeCard__content">
          <h2 class="activeCard__title">{{ item?.ACTIVITY_NAME }}</h2>
          <div>
            <n-icon size="24">
              <LocationOutline />
            </n-icon>
            <span>{{ item?.ACTIVITY_REGION }}</span>
          </div>
          <p class="activeCard__location">
            活動地點:{{ item?.ACTIVITY_ADDRESS }}
          </p>
          <p>活動日期:{{ item?.ACTIVITY_DATE }}</p>
          <p>活欉名額:{{ item?.ACTIVITY_QUOTA }}</p>
          <p>剩餘名額:{{ item?.ACTIVITY_REMAINING_PLACES }}</p>
          <p>單人價格:{{ item?.ACTIVITY_SINGLE_PRICE }}</p>
          <p>團體價格:{{ item?.ACTIVITY_GROUP_PRICE }}</p>
          <n-button strong secondary @click="link"> 查看詳情 </n-button>
        </div>
      </section>
    </n-carousel-item>
  </n-carousel>
</template>
<style lang="scss" scoped>
.activeCard {
  background-color: #fff;
  border-radius: 10px;
  padding: 16px;
  display: flex;
  cursor: pointer;
  transition: box-shadow 0.3s ease, transform 0.3s ease;

  &:hover {
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
  }
  &__location {
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  &__title {
    color: #343575;
  }
  &__content {
    flex: 1;
    padding: 12px 16px;
    display: flex;
    flex-direction: column;
    gap: 8px;
    color: #66669a;
    font-size: 14px;
  }
  &__img {
    width: 250px;
    height: 300px;
  }
}
</style>
