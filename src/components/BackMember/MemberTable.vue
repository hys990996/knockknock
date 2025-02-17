<script setup>
import dayjs from "dayjs";
import { NButton, NTag } from "naive-ui";
import { h, ref } from "vue";
import { DEFAULTPAGINATION } from "../../util/const";

defineOptions({
  name: "BackMemberMemberTable",
});

const props = defineProps({
  tableData: Array,
});
const emits = defineEmits(["edit:click"]);

const columns = [
  {
    key: "MEMBER_ID",
    title: "會員ID",
  },
  {
    key: "MEMBER_ACCOUNT",
    title: "帳號",
  },
  {
    key: "MEMBER_PHONE",
    title: "電話",
    render(row) {
      return row.MEMBER_PHONE ?? "-";
    },
  },
  {
    key: "MEMBER_FIRST_NAME",
    title: "姓名",
    render(row) {
      return `${row.MEMBER_LAST_NAME}${row.MEMBER_FIRST_NAME}`;
    },
  },
  {
    key: "MEMBER_STATUS",
    title: "帳號狀態",
    render(row) {
      return h(
        NTag,
        {
          type: memberStatue[row.MEMBER_STATUS].badge,
        },
        { default: () => memberStatue[row.MEMBER_STATUS].name }
      );
    },
  },
  {
    key: "MEMBER_CREATETIME",
    title: "創建時間",
    render(row) {
      return h(
        NTag,
        {
          type: "info",
        },
        { default: () => dayjs(row.MEMBER_CREATETIME).format("YYYY-MM-DD") }
      );
    },
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
        {
          default: () => "編輯用戶",
        }
      );
    },
  },
];

const memberStatue = {
  0: {
    name: "離線中",
    badge: "warning",
  },
  1: {
    name: "上線中",
    badge: "success",
  },
  3: {
    name: "停用中",
    badge: "error",
  },
};
</script>

<template>
  <n-data-table
    :columns="columns"
    :data="tableData"
    :pagination="DEFAULTPAGINATION"
  />
</template>
