<script setup>
import { NButton } from "naive-ui";
import { h } from "vue";
import { DEFAULTPAGINATION } from "../../util/const";

defineOptions({
  name: "MissionTable",
});

const props = defineProps({
  tableData: Array,
});

const emits = defineEmits(["edit:click"]);

const columns = [
  {
    key: "MISSION_ID",
    title: "任務編號",
  },
  {
    key: "MISSION_CONTENT",
    title: "任務內容",
  },
  {
    key: "MISSION_COINS",

    title: "金幣數量",
  },
  {
    key: "MISSION_TIMES",
    title: "完成次數",
  },
  {
    key: "edit",
    title: "編輯",
    render(row) {
      return h(
        NButton,
        {
          onClick: () => {
            emits("edit:click", row);
          },
        },
        { default: () => "編輯金幣" }
      );
    },
  },
];
</script>

<template>
  <n-data-table
    :columns="columns"
    :data="tableData"
    :pagination="DEFAULTPAGINATION"
  />
</template>
