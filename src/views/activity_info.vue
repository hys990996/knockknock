<script setup>
import layout from "@/components/layout.vue";
import { onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
import { useRoute } from "vue-router";
import ActiveDetailDomain from "../components/Active/ActiveDetailDomain.vue";

const route = useRoute();

const activeDetail = ref({});
const isLoading = ref(false);

const getDetailActive = async () => {
  isLoading.value = true;
  const response = await useApi.getActiveDetail(route.params.activityID);
  isLoading.value = false;
  activeDetail.value = response.data;
};

onMounted(() => {
  getDetailActive();
});
</script>
<template>
  <layout>
    <template #section-right-content>
      <div class="sub-bar">活動詳情</div>
      <ActiveDetailDomain :is-loading="isLoading" :detail-data="activeDetail" />
    </template>
  </layout>
</template>
