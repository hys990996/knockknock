<script setup>
import { NButton } from "naive-ui";
import { computed, h, ref } from "vue";
import { DEFAULTPAGINATION } from "../../util/const";

defineOptions({
  name: "BackMemberQaTable",
});

const props = defineProps({
  tableData: Array,
  optionData: Array,
});

const emits = defineEmits(["edit:click"]);

const selectData = ref(null);

const columns = [
  {
    key: "QUESTION_ID",
    title: "編號",
    width: 80,
  },
  {
    key: "QUESTION_TITLE",
    title: "常見提問",
  },
  {
    key: "QUESTION_CONTENT",
    title: "回覆內容",
  },
  {
    key: "actionButton",
    render(row) {
      return h(
        NButton,
        {
          onClick: () => {
            emits("edit:click", row);
          },
        },
        {
          default: () => "編輯問題",
        }
      );
    },
  },
];

/**
 * 處理篩選邏輯
 */
const selectedData = computed(() => {
  return props.tableData.filter(
    (item) =>
      !selectData.value || item.QUESTION_CATEGORY_ID === selectData.value
  );
});
</script>

<template>
  <n-space vertical class="option">
    <n-select v-model:value="selectData" size="large" :options="optionData" />
  </n-space>
  <n-data-table
    :columns="columns"
    :data="selectedData"
    :pagination="DEFAULTPAGINATION"
  />
</template>

<style lang="scss" scoped>
.option {
  margin: 12px 0 24px 0;
}
</style>
