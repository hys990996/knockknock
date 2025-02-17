<script setup>
import dayjs from "dayjs";
import { NButton, NTag } from "naive-ui";
import { h } from "vue";
import { DEFAULTPAGINATION } from "../../util/const";

defineOptions({
  name: "BackServiceTable",
});

const props = defineProps({
  tableData: Array,
});

const emits = defineEmits(["edit:click"]);

const columns = [
  {
    key: "CONTACT_ID",
    title: "問題編號",
  },
  {
    key: "MEMBER_ACCOUNT",
    title: "會員信箱",
  },
  {
    key: "CONTACT_CONTACT",
    title: "問題內容",
  },
  {
    key: "userName",
    title: "提問人姓名",
    render(row) {
      return `${row.MEMBER_LAST_NAME}${row.MEMBER_FIRST_NAME}`;
    },
  },
  {
    key: "CONTACT_CREATETIME",
    title: "反應日期",
    render(row) {
      return dayjs(row.CONTACT_CREATETIME).format("YYYY-MM-DD");
    },
  },
  {
    key: "CONTACT_REPLIED",
    title: "回覆狀態",
    render(row) {
      return h(
        NTag,
        {
          type: replyStatus[row.CONTACT_REPLIED].tag,
        },
        {
          default: () => replyStatus[row.CONTACT_REPLIED].name,
        }
      );
    },
  },
  {
    key: "activeButton",
    render(row) {
      return h(
        NButton,
        {
          onClick: () => {
            emits("edit:click", row);
          },
        },
        {
          default: () =>
            row.CONTACT_REPLIED !== "0" ? "查看回覆" : "回覆使用者",
        }
      );
    },
  },
];

const replyStatus = {
  0: {
    tag: "warning",
    name: "未回覆",
  },
  1: {
    tag: "success",
    name: "已回覆",
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
