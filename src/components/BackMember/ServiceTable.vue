<script setup>
import dayjs from "dayjs";
import { computed, ref } from "vue";

defineOptions({
  name: "BackServiceTable",
});

const props = defineProps({
  tableData: Array,
});

const perPage = ref(10);
const paginationModel = ref(1);

const columns = [
  {
    field: "CONTACT_ID",
    label: "問題編號",
    centered: true,
    numeric: true,
  },
  {
    field: "MEMBER_ACCOUNT",
    centered: true,
    label: "會員信箱",
  },
  {
    field: "CONTACT_CONTACT",
    centered: true,
    label: "問題內容",
  },
  {
    field: "userName",
    label: "提問人姓名",
    centered: true,
  },
  {
    field: "CONTACT_CREATETIME",
    label: "反應日期",
    centered: true,
  },
  {
    field: "CONTACT_REPLIED",
    label: "回覆狀態",
    centered: true,
  },
  {
    field: "activeButton",
  },
];

const activeData = computed(() => {
  const startIndex = (paginationModel.value - 1) * perPage.value;
  const lastIndex = startIndex + perPage.value;
  return props.tableData.slice(startIndex, lastIndex);
});

const replyStatus = {
  0: {
    tag: "is-warning",
    name: "未回覆",
  },
  1: {
    tag: "is-success",
    name: "已回覆",
  },
};
</script>

<template>
  <b-table :data="activeData">
    <b-table-column
      v-for="item in columns"
      :field="item.field"
      :label="item.label"
      centered
      v-slot="props"
    >
      <template v-if="item.field === 'CONTACT_CREATETIME'">
        <span class="tag is-dark">
          {{ dayjs(props.row.MEMBER_CREATETIME).format("YYYY-MM-DD") }}
        </span>
      </template>
      <template v-else-if="item.field === 'userName'">
        {{ `${props.row.MEMBER_LAST_NAME}${props.row.MEMBER_FIRST_NAME}` }}
      </template>
      <template v-else-if="item.field === 'CONTACT_REPLIED'">
        <b-tag :type="replyStatus[props.row.CONTACT_REPLIED].tag">
          {{ replyStatus[props.row.CONTACT_REPLIED].name }}</b-tag
        >
      </template>
      <template v-else-if="item.field === 'activeButton'">
        <b-button
          size="is-small"
          v-if="props.row.CONTACT_REPLIED === '0'"
          type="is-primary"
          outlined
          >回覆</b-button
        >
      </template>
      <template v-else>
        <span>
          {{ props.row[item.field] ?? "-" }}
        </span>
      </template>
    </b-table-column>
  </b-table>
  <b-pagination
    order="is-centered"
    :total="tableData?.length ?? 0"
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
