<script setup>
import { ref, computed, onMounted } from "vue";
import { DEFAULTPAGINATION } from "../../util/const";
import { useApi } from "../../util/useApi";
import { useLoadingStore } from "../../store/loading";
defineOptions({
  name: "BackMemberActiveDetailTable",
});

const props = defineProps({
  id: String,
});

const emits = defineEmits(["edit:click", "detail:click"]);
const loadingStore = useLoadingStore();

const data = ref([]);
const getDetail = async () => {
  loadingStore.setLoading(true);
  const response = await useApi.getDetailActive(props.id);
  loadingStore.setLoading(false);
  data.value = response.data;
};

const columns = computed(() => [
  {
    key: "userName",
    title: "姓名",
    render(row) {
      return `${row.MEMBER_LAST_NAME}${row.MEMBER_FIRST_NAME}`;
    },
  },
  {
    key: "MEMBER_PHONE",
    title: "電話",
  },
  {
    key: "MEMBER_ACCOUNT",
    title: "Emial",
  },
  {
    key: "REGISTER_TOTAL_PRICE",
    title: "總金額",
  },
  {
    key: "REGISTER_COUNT",
    title: "報名人數",
  },
  {
    key: "REGISTER_COUNT",
    title: "剩餘名額",
  },
  {
    key: "REGISTER_PAIED",
    title: "付款狀態",
    render(row) {
      return payStatus[row.REGISTER_PAIED];
    },
  },
]);

const payStatus = {
  0: "已付款",
  1: "尚未付款",
};

onMounted(() => {
  getDetail();
});
</script>

<template>
  <n-data-table
    :columns="columns"
    :data="data"
    :pagination="DEFAULTPAGINATION"
  />
</template>
