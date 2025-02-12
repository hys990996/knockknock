<script setup>
import { computed, ref } from "vue";

defineOptions({
  name: "BackMemberQaTable",
});

const props = defineProps({
  tableData: Array,
  optionData: Array,
});

const perPage = ref(10);
const paginationModel = ref(1);
const selectData = ref(null);

const columns = [
  {
    field: "QUESTION_ID",
    label: "編號",
    width: "60",
  },
  {
    field: "QUESTION_TITLE",
    label: "常見提問",
  },
  {
    field: "QUESTION_CONTENT",
    label: "回覆內容",
  },
  {
    field: "actionButton",
    centered: true,
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

const qaData = computed(() => {
  const startIndex = (paginationModel.value - 1) * perPage.value;
  const lastIndex = startIndex + perPage.value;
  return selectedData.value.slice(startIndex, lastIndex);
});
</script>

<template>
  <div>
    <b-select v-model="selectData" class="option" placeholder="請選擇篩選條件">
      <option
        v-for="option in optionData"
        :value="option.QUESTION_CATEGORY_ID"
        :key="option.QUESTION_CATEGORY_ID"
      >
        {{ option.QUESTION_CATEGORY_NAME }}
      </option>
    </b-select>
    <b-table :data="qaData">
      <b-table-column
        v-for="item in columns"
        :field="item.field"
        :label="item.label"
        v-bind="item"
        v-slot="props"
      >
        <template v-if="item.field === 'actionButton'">
          <b-button size="is-small" type="is-primary" outlined>編輯</b-button>
        </template>
        <template v-else>
          <span>
            {{ props.row[item.field] ?? "-" }}
          </span>
        </template>
      </b-table-column>
    </b-table>
  </div>
  <b-pagination
    order="is-centered"
    :total="selectedData?.length ?? 0"
    :per-page="perPage"
    v-model="paginationModel"
  >
    <template #previous="props">
      <b-pagination-button :page="props.page"> 上一頁 </b-pagination-button>
    </template>
    <template #next="props">
      <b-pagination-button :page="props.page"> 下一頁 </b-pagination-button>
    </template>
  </b-pagination>
</template>

<style lang="scss" scoped>
.option {
  margin-bottom: 24px;
}
</style>
