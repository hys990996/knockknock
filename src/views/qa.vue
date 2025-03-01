<script setup>
import layout from "@/components/layout.vue";
import { onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
import QaPanel from "../components/Qa/QaPanel.vue";

const qaCatrgories = ref([]);
const activateTab = ref("");
const qaList = ref([]);

const getCategories = async () => {
  const response = await useApi.b_qaListOption();
  qaCatrgories.value = response;
  activateTab.value = response[0].QUESTION_CATEGORY_ID;
};

const getQaList = async () => {
  const response = await useApi.getQuestion(activateTab.value);
  qaList.value = response;
};

onMounted(async () => {
  await getCategories();
  await getQaList();
});
</script>
<template>
  <layout>
    <template #section-right-content>
      <n-card style="padding: 16px; height: 100%">
        <n-tabs
          type="card"
          animated
          tab-style="min-width: 80px;"
          size="large"
          v-model:value="activateTab"
          @click="getQaList"
        >
          <n-tab-pane
            v-for="item in qaCatrgories"
            :key="item.QUESTION_CATEGORY_ID"
            :name="item.QUESTION_CATEGORY_ID"
            :tab="item.QUESTION_CATEGORY_NAME"
          >
            <QaPanel
              :panelTitle="item.QUESTION_CATEGORY_NAME"
              :panel-data="qaList"
            />
          </n-tab-pane>
        </n-tabs>
      </n-card>
    </template>
  </layout>
</template>
