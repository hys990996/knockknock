<script setup>
import {
  CalendarNumberOutline,
  ManOutline,
  CashOutline,
  Cash,
  ManSharp,
  AirplaneOutline,
} from "@vicons/ionicons5";
import { useRouter } from "vue-router";
import { decodeBase64 } from "../../util/decodeBase64";
defineOptions({
  name: "ActiveSearchCard",
});
defineProps({
  activeData: Array,
  isLoading: Boolean,
});

const router = useRouter();

const CARD_DETAIL = [
  { icon: CalendarNumberOutline, key: "ACTIVITY_DATE", context: "活動日期" },
  {
    icon: ManSharp,
    key: "ACTIVITY_REMAINING_PLACES",
    context: "活動名額",
  },
  { icon: ManOutline, key: "ACTIVITY_QUOTA", context: "剩餘名額" },
  { icon: CashOutline, key: "ACTIVITY_SINGLE_PRICE", context: "單人費用" },
  { icon: Cash, key: "ACTIVITY_GROUP_PRICE", context: "多人費用" },
];

const linkDetail = (activityID) => {
  router.push({ name: "activity_info", params: { activityID } });
};
</script>
<template>
  <section v-if="isLoading" class="cardSkeleton" v-for="item in 2" :key="item">
    <n-skeleton height="300px" />
  </section>
  <section
    v-else
    class="result-cards"
    v-for="i in activeData"
    :key="i.ACTIVITY_ID"
  >
    <div class="result-card">
      <div class="result-pic">
        <img class="activeCard__img" :src="decodeBase64(i.ACTIVITY_IMAGE)" />
        <div class="info">
          <n-icon size="24">
            <AirplaneOutline />
          </n-icon>
          <div>
            {{ i.ACTIVITY_REGION }}，{{ i.ACTIVITY_ADDRESS.slice(0, 2) }}
          </div>
        </div>
      </div>
      <div class="result-details">
        <div class="result-text">
          <h3>{{ i.ACTIVITY_NAME }}</h3>
          <div class="details">
            <div class="detail" v-for="cardItem in CARD_DETAIL">
              <n-icon size="24">
                <component :is="cardItem.icon" />
              </n-icon>
              <div>{{ cardItem.context }}:{{ i[cardItem.key] }}</div>
            </div>
            <n-button strong secondary @click="linkDetail(i.ACTIVITY_ID)"
              >前往查看</n-button
            >
          </div>
        </div>
      </div>
    </div>
  </section>
</template>
<style lang="scss" scoped>
.cardSkeleton {
  border-radius: 32px;
  height: 350px;
  background-color: #fff;
  padding: 16px;
}
</style>
