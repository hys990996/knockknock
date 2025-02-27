<script setup>
import { LocationOutline } from "@vicons/ionicons5";
import { useRouter } from "vue-router";
import { decodeBase64 } from "../../util/decodeBase64";
defineOptions({
  name: "ActiveCard",
});
const props = defineProps({
  data: Object,
  isLoading: Boolean,
});
const router = useRouter();
const link = (activityID) => {
  router.push({
    name: "activity_info",
    params: { activityID },
  });
};
</script>
<template>
  <section class="activeCard" v-if="isLoading">
    <n-skeleton height="300px" />
  </section>
  <section class="activeCard" v-else>
    <template v-for="data in data">
      <n-image
        class="activeCard__img"
        width="250"
        :src="decodeBase64(data.ACTIVITY_IMAGE)"
      />
      <div class="activeCard__content">
        <h2 class="activeCard__title">{{ data?.ACTIVITY_NAME }}</h2>
        <div class="activeCard__price">
          <div class="activeCard__priceDetail">
            <p class="activeCard__location">
              <n-icon size="24">
                <LocationOutline />
              </n-icon>
              <span>{{ data?.ACTIVITY_REGION }}</span>
              {{ data?.ACTIVITY_ADDRESS }}
            </p>
            <p>活動日期:{{ data?.ACTIVITY_DATE }}</p>
            <p>活欉名額:{{ data?.ACTIVITY_QUOTA }}</p>
            <p>剩餘名額:{{ data?.ACTIVITY_REMAINING_PLACES }}</p>
          </div>
          <div class="activeCard__priceSection">
            <p>單人價格:{{ data?.ACTIVITY_SINGLE_PRICE }}</p>
            <p>團體價格:{{ data?.ACTIVITY_GROUP_PRICE }}</p>
          </div>
        </div>

        <n-button strong secondary @click="link(data.ACTIVITY_ID)">
          查看詳情
        </n-button>
      </div>
    </template>
  </section>
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
  &__price {
    display: grid;
    grid-template-columns: auto auto;
  }
  &__priceDetail {
    display: flex;
    flex-direction: column;
    gap: 8px;
  }
  &__priceSection {
    display: flex;
    flex-direction: column;
    gap: 8px;
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
    justify-content: space-between;
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
