<script setup>
import { computed, ref } from "vue";

defineOptions({
  name: "BackMemberMissionTable",
});

const props = defineProps({
  tableData: Array,
});

const perPage = ref(10);
const paginationModel = ref(1);

const columns = [
  {
    field: "MISSION_ID",
    label: "任務編號",
    centered: true,
  },
  {
    field: "MISSION_CONTENT",
    centered: true,
    label: "任務內容",
  },
  {
    field: "MISSION_COINS",
    centered: true,
    label: "金幣數量",
  },
  {
    field: "MISSION_TIMES",
    label: "完成次數",
    centered: true,
  },
  {
    field: "edit",
    centered: true,
  },
];

const missionData = computed(() => {
  const startIndex = (paginationModel.value - 1) * perPage.value;
  const lastIndex = startIndex + perPage.value;
  return props.tableData.slice(startIndex, lastIndex);
});
</script>

<template>
  <b-table :data="missionData">
    <b-table-column
      v-for="item in columns"
      :field="item.field"
      :label="item.label"
      centered
      v-slot="props"
    >
      <template v-if="item.field === 'edit'">
        <b-button type="is-info is-light" size="is-small">編輯任務</b-button>
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
