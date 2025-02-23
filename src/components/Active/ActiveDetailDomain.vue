<script setup>
import { computed, ref } from "vue";
import { formatTwd } from "../../util/cashFormat";

defineOptions({
  name: "ActiveDetailDomain",
});
const props = defineProps({
  detailData: Object,
});

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

const memberCount = ref(0);
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
</script>
<template>
  <div class="detailImage">
    <n-image :src="detailData.ACTIVITY_IMAGE" />
  </div>
  <n-card
    :title="detailData.ACTIVITY_NAME"
    footer-class="flex"
    :segmented="{
      content: true,
      footer: 'soft',
    }"
  >
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
    <template #footer>
      <n-select
        placeholder="請選擇活動人數"
        v-model:value="memberCount"
        :options="option"
        class="detailCard"
        clearable
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
    <template #action>
      <div class="cardFooter">
        <n-button type="success" :disabled="memberCount <= 0"
          >前往報名</n-button
        >
      </div>
    </template>
  </n-card>
</template>
<style lang="scss" scoped>
.detailImage {
  height: 500px;
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
</style>
