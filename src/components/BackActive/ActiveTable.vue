<script setup>
import { h } from "vue";
import { NButton, NTag } from "naive-ui";
import { DEFAULTPAGINATION } from "../../util/const";
defineOptions({
  name: "BackMemberActiveTable",
});

const props = defineProps({
  tableData: Array,
});

const emits = defineEmits(["edit:click", "detail:click", "delete:click"]);

const columns = [
  {
    key: "ACTIVITY_ID",
    title: "活動編號",
  },
  {
    key: "ACTIVITY_NAME",
    title: "活動名稱",
  },
  {
    key: "ACTIVITY_ADDRESS",
    title: "活動地點",
  },
  {
    key: "ACTIVITY_STATUS",
    title: "活動狀態",
    render(row) {
      return h(
        NTag,
        {
          type: activeStatus[row.ACTIVITY_STATUS],
        },
        { default: () => row.ACTIVITY_STATUS }
      );
    },
  },
  {
    key: "ACTIVITY_DATE",
    title: "活動日期",
  },
  {
    key: "ACTIVITY_QUOTA",
    title: "活動名額",
  },
  {
    key: "ACTIVITY_REMAINING_PLACES",
    title: "剩餘名額",
  },
  {
    key: "editActive",
    render(row) {
      return h(
        NButton,
        {
          onClick: () => {
            emits("delete:click", row);
          },
        },
        { default: () => "活動詳情" }
      );
    },
  },
  {
    key: "editActive",
    render(row) {
      return h(
        NButton,
        {
          onClick: () => {
            emits("edit:click", row);
          },
          type: "info",
        },
        { default: () => "變更活動" }
      );
    },
  },
  // {
  //   key: "editActive",
  //   render(row) {
  //     return h(
  //       NButton,
  //       {
  //         onClick: () => {
  //           emits("delete:click", row);
  //         },
  //         type: "error",
  //       },
  //       { default: () => "刪除活動" }
  //     );
  //   },
  // },
];

const activeStatus = {
  正常: "success",
  取消: "error",
};
</script>

<template>
  <n-data-table
    :columns="columns"
    :data="tableData"
    :pagination="DEFAULTPAGINATION"
  />
</template>
