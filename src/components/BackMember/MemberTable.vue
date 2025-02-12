<script setup>
import dayjs from "dayjs";
import { computed, ref } from "vue";

defineOptions({
  name: "BackMemberMemberTable",
});

const props = defineProps({
  tableData: Array,
});

const perPage = ref(10);
const paginationModel = ref(1);

const columns = [
  {
    field: "MEMBER_ID",
    label: "會員ID",
    centered: true,
    numeric: true,
  },
  {
    field: "MEMBER_ACCOUNT",
    centered: true,
    label: "帳號",
  },
  {
    field: "MEMBER_PHONE",
    centered: true,
    label: "電話",
  },
  {
    field: "MEMBER_FIRST_NAME",
    label: "姓名",
    centered: true,
  },
  {
    field: "MEMBER_STATUS",
    label: "帳號狀態",
    centered: true,
  },
  {
    field: "MEMBER_CREATETIME",
    label: "創建時間",
    centered: true,
  },
  {
    field: "edit",
    label: "編輯",
    centered: true,
  },
];

const userData = computed(() => {
  const startIndex = (paginationModel.value - 1) * perPage.value;
  const lastIndex = startIndex + perPage.value;
  return props.tableData.slice(startIndex, lastIndex);
});

const memberStatue = {
  0: {
    name: "離線中",
    badge: "is-warning",
  },
  1: {
    name: "上線中",
    badge: "is-success",
  },
  3: {
    name: "停用中",
    badge: "is-danger",
  },
};
</script>

<template>
  <b-table :data="userData">
    <b-table-column
      v-for="item in columns"
      :field="item.field"
      :label="item.label"
      centered
      v-slot="props"
    >
      <template v-if="item.field === 'MEMBER_CREATETIME'">
        <span class="tag is-dark">
          {{ dayjs(props.row.MEMBER_CREATETIME).format("YYYY-MM-DD") }}
        </span>
      </template>
      <template v-else-if="item.field === 'MEMBER_STATUS'">
        <span class="tag" :class="memberStatue[props.row.MEMBER_STATUS].badge">
          {{ memberStatue[props.row.MEMBER_STATUS].name }}
        </span>
      </template>
      <template v-else-if="item.field === 'edit'">
        <b-button size="is-small" type="is-link is-light">編輯用戶</b-button>
      </template>
      <template v-else>
        <span>
          {{ props.row[item.field] ?? "-" }}
        </span>
      </template>
    </b-table-column>
  </b-table>
  <b-pagination
    :total="tableData?.length ?? 0"
    :per-page="perPage"
    v-model="paginationModel"
    order="is-centered"
  >
    <template #previous="props">
      <b-pagination-button :page="props.page"> 上一頁 </b-pagination-button>
    </template>
    <template #next="props">
      <b-pagination-button :page="props.page"> 下一頁 </b-pagination-button>
    </template>
  </b-pagination>
</template>
