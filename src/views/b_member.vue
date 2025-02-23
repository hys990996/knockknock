<script setup>
import { useApi } from "../util/useApi";
import { onMounted, ref, shallowRef, nextTick, computed, reactive } from "vue";
import { useLoadingStore } from "../store/loading";
import MemberTable from "../components/BackMember/MemberTable.vue";
import MemberForm from "../components/BackMember/MemberForm.vue";

const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;

const data = ref([]);

const getUser = async () => {
  setLoading(true);
  const response = await useApi.b_getUser();
  console.log(response);
  setLoading(false);
  data.value = response;
};
const activeTab = ref("0");

const tabs = reactive([
  {
    name: "會員列表",
    component: shallowRef(MemberTable),
    id: "0",
    bind: computed(() => ({
      tableData: data.value,
    })),
    isClosed: false,
  },
]);

const editAddTab = (value) => {
  const existingTabIndex = tabs.findIndex((tab) => tab.id === value.MEMBER_ID);
  activeTab.value = value.MEMBER_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: `${value.MEMBER_LAST_NAME}${value.MEMBER_FIRST_NAME}`,
      component: shallowRef(MemberForm),
      id: value.MEMBER_ID,
      bind: { memberData: value },
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
  getUser();
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

<style lang="scss" scoped></style>
