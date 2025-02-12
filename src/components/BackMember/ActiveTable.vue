<script setup>
import dayjs from "dayjs";
import { computed, ref } from "vue";

defineOptions({
  name: "BackMemberActiveTable",
});

const props = defineProps({
  tableData: Array,
});

const perPage = ref(10);
const paginationModel = ref(1);

const columns = [
  {
    field: "ACTIVITY_ID",
    label: "活動編號",
    centered: true,
    numeric: true,
  },
  {
    field: "ACTIVITY_NAME",
    centered: true,
    label: "活動名稱",
  },
  {
    field: "ACTIVITY_ADDRESS",
    centered: true,
    label: "活動地點",
  },
  {
    field: "ACTIVITY_STATUS",
    label: "活動狀態",
    centered: true,
  },
  {
    field: "ACTIVITY_DATE",
    label: "活動日期",
    centered: true,
  },
  {
    field: "ACTIVITY_QUOTA",
    label: "活動名額",
    centered: true,
  },
  {
    field: "ACTIVITY_REMAINING_PLACES",
    label: "剩餘名額",
    centered: true,
  },
  {
    field: "detail",
    label: "查詢",
    centered: true,
  },
];

const activeData = computed(() => {
  const startIndex = (paginationModel.value - 1) * perPage.value;
  const lastIndex = startIndex + perPage.value;
  return props.tableData.slice(startIndex, lastIndex);
});

const activeStatus = {
  正常: "is-success",
  取消: "is-danger",
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
      <template v-if="item.field === 'ACTIVITY_DATE'">
        <span class="tag is-dark">
          {{ dayjs(props.row.MEMBER_CREATETIME).format("YYYY-MM-DD") }}
        </span>
      </template>
      <template v-else-if="item.field === 'ACTIVITY_STATUS'">
        <span
          class="tag is-dark"
          :class="activeStatus[props.row.ACTIVITY_STATUS]"
        >
          {{ props.row.ACTIVITY_STATUS }}
        </span>
      </template>
      <template v-else-if="item.field === 'detail'">
        <b-button type="is-primary" size="is-small" outlined>編輯活動</b-button>
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
