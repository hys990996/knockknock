<script setup>
import { computed, onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
import { useRoute } from "vue-router";
import layout from "@/components/layout.vue";
import ActiveSearchCard from "../components/Active/ActiveSearchCard.vue";

const activeData = ref([]);
const isLoading = ref(false);
const { getRegionActive } = useApi();
const route = useRoute();
const page = ref(1);
const totalCount = ref(0);
const getActicve = async () => {
  isLoading.value = true;
  const response = await getRegionActive({
    ACTIVITY_REGION: route.params.activityRegion,
    page: page.value,
  });
  isLoading.value = false;
  activeData.value = response.data;
  totalCount.value = response.total;
};

const pageTotalCount = computed(() => {
  return Math.ceil(Number(totalCount.value) / 2);
});

onMounted(() => {
  getActicve();
});
</script>

<template>
  <layout>
    <template #section-right-content>
      <div class="activity-search">
        <div class="search-container">
          <ActiveSearchCard :is-loading="isLoading" :active-data="activeData" />
          <n-pagination
            v-model:page="page"
            :page-count="pageTotalCount"
            size="large"
            @change="getActicve"
          />
        </div>
      </div>
    </template>
  </layout>
</template>
