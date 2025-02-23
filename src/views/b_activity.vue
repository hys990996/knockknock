<script setup>
import { computed, nextTick, onMounted, reactive, ref } from "vue";
import ActiveTable from "../components/BackActive/ActiveTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import ActiveForm from "../components/BackActive/ActiveForm.vue";
import ActiveDetailTable from "../components/BackActive/ActiveDetailTable.vue";
import ActiveCreateForm from "../components/BackActive/ActiveCreateForm.vue";

const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;

const data = ref([]);

const getActive = async () => {
  setLoading(true);
  const response = await useApi.b_getActive();
  setLoading(false);
  data.value = response;
};

const activeTab = ref("0");

const tabs = reactive([
  {
    name: "活動列表",
    component: ActiveTable,
    id: "0",
    bind: computed(() => ({
      tableData: data.value,
    })),
    isClosed: false,
  },
]);

const addActiveTab = () => {
  const tab = {
    name: "新增活動",
    component: ActiveCreateForm,
    id: "active",
    bind: null,
    isClosed: false,
  };
  const matchTabIndex = tabs.findIndex((item) => item.id === "active");
  nextTick(() => {
    activeTab.value = "active";
  });
  if (matchTabIndex !== -1) {
    return;
  }
  tabs.push(tab);
};

const editAddTab = (value, isEdit = true) => {
  const existingTabIndex = tabs.findIndex(
    (tab) => tab.id === `${value.ACTIVITY_ID}${isEdit ? "編輯" : ""}`
  );
  activeTab.value = value.ACTIVITY_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: `${isEdit ? "編輯" : ""}${value.ACTIVITY_NAME}`,
      component: isEdit ? ActiveForm : ActiveDetailTable,
      id: `${value.ACTIVITY_ID}${isEdit ? "編輯" : ""}`,
      bind: isEdit ? { formData: value } : { id: value.ACTIVITY_ID },
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
  getActive();
});
</script>

<template>
  <n-card class="activeCard" content-style="padding: 12px;">
    <n-button class="activeButton" type="primary" @click="addActiveTab"
      >新建活動</n-button
    >
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
        <template #prefix> Prefix </template>
        <keep-alive>
          <component
            :is="panel.component"
            v-bind="panel.bind"
            @edit:click="editAddTab"
            @detail:click="(e) => editAddTab(e, false)"
          ></component>
        </keep-alive>
      </n-tab-pane>
    </n-tabs>
  </n-card>
</template>
<style lang="scss" scoped>
.activeButton {
  margin-left: auto;
  display: block;
}
</style>
