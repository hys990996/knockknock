<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import MissionTable from "../components/BackMission/MissionTable.vue";
import { useLoadingStore } from "../store/loading";
import { useApi } from "../util/useApi";
import MissionForm from "../components/BackMission/MissionForm.vue";
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const { b__mission } = useApi();
const missionData = ref([]);
const getMission = async () => {
  setLoading(true);
  const response = await b__mission();
  setLoading(false);
  missionData.value = response;
};

const activeTab = ref("0");
const tabs = reactive([
  {
    name: "常見列表",
    component: MissionTable,
    id: "0",
    bind: computed(() => ({
      tableData: missionData.value,
    })),
    isClosed: false,
  },
]);
const editAddTab = (value) => {
  const existingTabIndex = tabs.findIndex((tab) => tab.id === value.MISSION_ID);
  activeTab.value = value.MISSION_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: value.MISSION_CONTENT,
      component: MissionForm,
      id: value.MISSION_ID,
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
  getMission();
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
        :key="panel.id"
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
