<script setup>
import { computed, markRaw, nextTick, onMounted, reactive, ref } from "vue";
import ServiceTable from "../components/BackService/ServiceTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import ServiecForm from "../components/BackService/ServiecForm.vue";
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const serviceData = ref([]);
const getService = async () => {
  setLoading(true);
  const response = await useApi.b_getService();
  setLoading(false);
  serviceData.value = response;
};

const activeTab = ref("0");
const tabs = reactive([
  {
    name: "客服列表",
    component: markRaw(ServiceTable),
    id: "0",
    bind: computed(() => ({
      tableData: serviceData.value,
    })),
    isClosed: false,
  },
]);

const editAddTab = (value) => {
  const existingTabIndex = tabs.findIndex((tab) => tab.id === value.CONTACT_ID);
  activeTab.value = value.CONTACT_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: `${value.MEMBER_LAST_NAME}${value.MEMBER_FIRST_NAME}`,
      component: markRaw(ServiecForm),
      id: value.CONTACT_ID,
      bind: { formData: value },
      isClosed: true,
    };
    tabs.push(newTab);
    nextTick(() => {
      activeTab.value = newTab.id;
    });
  }
};

const clearTab = (value) => {
  const matchIndex = tabs.findIndex((item) => item.id === value);
  if (matchIndex > -1) {
    tabs.splice(matchIndex, 1);
    activeTab.value = "0";
  }
};

onMounted(() => {
  getService();
});
</script>
<template>
  <n-card content-style="padding: 12px;">
    <n-tabs
      v-model:value="activeTab"
      type="card"
      closable
      tab-style="min-width: 80px;"
      @close="clearTab"
    >
      <n-tab-pane
        v-for="panel in tabs"
        :key="panel"
        :tab="panel.name.toString()"
        :name="panel.id"
      >
        <keep-alive>
          <component
            :is="panel.component"
            v-bind="panel.bind"
            @edit:click="editAddTab"
          ></component>
        </keep-alive>
      </n-tab-pane>
    </n-tabs>
  </n-card>
</template>
