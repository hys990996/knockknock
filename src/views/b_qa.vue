<script setup>
import {  onMounted, reactive, ref, computed, nextTick } from "vue";
import QaTable from "../components/BackQa/QaTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import QaForm from "../components/BackQa/QaForm.vue";
const { b_qaList, b_qaListOption } = useApi();
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const qaList = ref([]);
const selectOption = ref([]);

const getQaList = async () => {
  setLoading(true);
  const result = await Promise.all([b_qaList(), b_qaListOption()]);
  setLoading(false);
  qaList.value = result[0];
  selectOption.value = result[1].map((item) => ({
    label: item.QUESTION_CATEGORY_NAME,
    value: item.QUESTION_CATEGORY_ID,
  }));
};

const activeTab = ref("0");

const tabs = reactive([
  {
    name: "常見列表",
    component: QaTable,
    id: "0",
    bind: computed(() => ({
      tableData: qaList.value,
      optionData: selectOption.value,
    })),
    isClosed: false,
  },
]);

const editAddTab = (value) => {
  const existingTabIndex = tabs.findIndex(
    (tab) => tab.id === value.QUESTION_ID
  );
  activeTab.value = value.QUESTION_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: value.QUESTION_TITLE,
      component: QaForm,
      id: value.QUESTION_ID,
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
  getQaList();
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
