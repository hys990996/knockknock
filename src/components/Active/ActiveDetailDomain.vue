<script setup>
import { computed, ref } from "vue";
import { formatTwd } from "../../util/cashFormat";
import dayjs from "dayjs";
import ActiveDetailModal from "./ActiveDetailModal.vue";
import { useUserStore } from "../../store/user";
import defaultUserImg from "../../assets/images/user/userimage.png";
import { decodeBase64 } from "../../util/decodeBase64";
import { useApi } from "../../util/useApi";

defineOptions({
  name: "ActiveDetailDomain",
});
const props = defineProps({
  detailData: Object,
  isLoading: Boolean,
});

const isOpenDialog = ref(false);

const openDialog = () => {
  isOpenDialog.value = !isOpenDialog.value;
};
/**
 * 圖片錯誤處理
 */
const userStore = useUserStore();
const handleErrorImg = (e) => {
  e.target.src = defaultUserImg;
};

const CARD_CONTENT = [
  { label: "活動地點", key: "ACTIVITY_ADDRESS" },
  { label: "活動日期", key: "ACTIVITY_DATE" },
  { label: "報名截止日期", key: "ACTIVITY_ENDDATE" },
  { label: "活動名額", key: "ACTIVITY_QUOTA" },
  { label: "剩餘名額", key: "ACTIVITY_REMAINING_PLACES" },
  { label: "單人活動費用", key: "ACTIVITY_SINGLE_PRICE" },
  { label: "團體活動費用(3人含以上)", key: "ACTIVITY_GROUP_PRICE" },
];

const tagFormat = (key) => {
  if (key === "ACTIVITY_ENDDATE") {
    return "error";
  }
  return "success";
};

/**
 * 是否已超過報名日期
 */
const isExpired = computed(() =>
  dayjs().isAfter(dayjs(props.detailData.ACTIVITY_ENDDATE))
);

const memberCount = ref(0);
/**
 * 是否能報名
 */
const notSignup = computed(() => isExpired.value || memberCount.value <= 0);

const totalCount = computed(() => {
  const isSingal = memberCount.value < 3;
  const price = isSingal
    ? props.detailData.ACTIVITY_SINGLE_PRICE
    : props.detailData.ACTIVITY_GROUP_PRICE;
  return memberCount.value * Number(price);
});
const numberAnimate = ref(null);
const option = computed(() => {
  return Array.from(
    { length: props.detailData.ACTIVITY_REMAINING_PLACES },
    (_, i) => ({ label: i + 1, value: i + 1 })
  );
});

/**
 * 綠界處理
 */
const ECPayForm = ref(null);

const singUpActive = async () => {
  const config = {
    MerchantTradeDate: dayjs().format("YYYY/MM/DD HH:mm:ss"),
    PaymentType: "aio",
    TotalAmount: totalCount.value,
    TradeDesc: "活動",
    ItemName: props.detailData.ACTIVITY_NAME,
    ChoosePayment: "ALL",
    quantity: memberCount.value,
    activityId: props.detailData.ACTIVITY_ID,
  };

  const response = await useApi.ECPay(config);
  if (response) {
    const formContainer = document.createElement("div");
    formContainer.innerHTML = response;
    formContainer.style.display = "none";
    document.body.appendChild(formContainer);
    document.getElementById("__ecpayForm").submit();
  }
};
</script>
<template>
  <div class="detailImage">
    <n-image :src="decodeBase64(detailData.ACTIVITY_IMAGE)" />
  </div>
  <n-card :title="detailData.ACTIVITY_NAME" footer-class="flex">
    <template #header-extra>
      <n-tag :bordered="false" :type="isExpired ? 'error' : 'success'">
        {{ isExpired ? "已過期" : "現正報名中" }}</n-tag
      >
    </template>
    <n-skeleton v-if="isLoading" text :repeat="7" height="40px" />
    <template v-else>
      <div v-for="item in CARD_CONTENT" :key="item.key" class="detailCard">
        <p>{{ item.label }}</p>
        <n-tag
          v-if="['ACTIVITY_ENDDATE', 'ACTIVITY_DATE'].includes(item.key)"
          :bordered="false"
          :type="tagFormat(item.key)"
          >{{ detailData[item.key] }}</n-tag
        >
        <p
          v-else-if="
            ['ACTIVITY_SINGLE_PRICE', 'ACTIVITY_GROUP_PRICE'].includes(item.key)
          "
        >
          {{ formatTwd(detailData[item.key]) }}
        </p>

        <p v-else>{{ detailData[item.key] }}</p>
      </div>
    </template>

    <template #footer>
      <n-skeleton v-if="isLoading" text height="40px" />
      <template v-else>
        <n-select
          placeholder="請選擇活動人數"
          v-model:value="memberCount"
          :options="option"
          class="detailCard"
          clearable
          :disabled="isExpired"
        />
        <div class="detailCard">
          <p>總計</p>
          <div>
            <span>$</span>
            <n-number-animation
              ref="numberAnimate"
              :from="0"
              :to="totalCount"
              locale="zh-TW"
              show-separator
            />
          </div>
        </div>
      </template>
    </template>
    <template #action>
      <div class="cardFooter">
        <n-button type="success" :disabled="notSignup" @click="openDialog"
          >前往報名</n-button
        >
      </div>
    </template>
  </n-card>
  <ActiveDetailModal v-model="isOpenDialog">
    <div class="checkModal">
      <img :src="userStore.userImg" @error="handleErrorImg" />
      <p>訂購人姓名：{{ userStore.userName }}</p>
      <p>訂購人信箱：{{ userStore.userAccount }}</p>
      <p>活動地點：{{ detailData.ACTIVITY_ADDRESS }}</p>
      <p>活動日期：{{ detailData.ACTIVITY_DATE }}</p>
      <p>活動費用：{{ formatTwd(totalCount) }}</p>
    </div>
    <template #footer>
      <div class="checkModal__footer">
        <n-button type="info" @click="singUpActive" size="large"
          >前往結賬</n-button
        >
      </div>
    </template>
  </ActiveDetailModal>
</template>
<style lang="scss" scoped>
.detailImage {
  width: 60%;
  margin: 0 auto;
  height: 400px;
  border-radius: 8px;
  overflow: hidden;
  margin-bottom: 24px;
}
.detailCard {
  display: flex;
  justify-content: space-between;
  margin-bottom: 24px;
  &:last-of-type {
    margin-bottom: 0;
  }
}
.cardFooter {
  display: flex;
  justify-content: end;
}
.checkModal {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
  &__footer {
    display: flex;
    justify-content: center;
  }
}
</style>
