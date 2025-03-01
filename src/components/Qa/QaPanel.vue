<script setup>
import { ref } from "vue";
import { ChevronUp, ChevronDown } from "@vicons/ionicons5";

defineOptions({
  name: "QaPanel",
});
defineProps({
  panelTitle: String,
  panelData: Array,
  isLoading: Boolean,
});

const panelList = ref([]);
const panelContent = ref(null);
const openPanel = (id) => {
  const matchKey = panelList.value.findIndex((item) => item === id);
  if (matchKey === -1) {
    panelList.value.push(id);
    return;
  }
  panelList.value.splice(matchKey, 1);
};

const isOpen = (id) => {
  return panelList.value.includes(id);
};

/**
 * transition樣式
 */
const setHeight = (el, value) => {
  el.style.height = typeof value === "number" ? `${value}px` : "";
};

const onBeforeEnter = (el) => {
  setHeight(el, 0);
};
const onEnter = (el) => {
  setHeight(el, el.scrollHeight);
};
const onAfterEnter = (el) => {
  setHeight(el, "");
};
const onBeforeLeave = (el) => {
  setHeight(el, el.scrollHeight);
};
const onLeave = (el) => {
  setHeight(el, 0);
};
const onAfterLeave = (el) => {
  setHeight(el, "");
};
</script>
<template>
  <n-card :title="panelTitle">
    <n-skeleton height="30px" v-if="isLoading" repeat="4" />
    <template v-else-if="panelData?.length">
      <section class="qaList" v-for="item in panelData" :key="item.QUESTION_ID">
        <n-skeleton height="30px" v-if="isLoading" />
        <div
          v-else
          class="qaList__title"
          @click.stop="openPanel(item.QUESTION_ID)"
        >
          <p class="qaList__qaTitle">{{ item.QUESTION_TITLE }}</p>
          <n-icon size="24">
            <ChevronUp v-if="isOpen(item.QUESTION_ID)" />
            <ChevronDown v-else />
          </n-icon>
        </div>

        <Transition
          name="panel"
          @before-enter="onBeforeEnter"
          @enter="onEnter"
          @after-enter="onAfterEnter"
          @before-leave="onBeforeLeave"
          @leave="onLeave"
          @after-leave="onAfterLeave"
        >
          <div
            ref="panelContent"
            class="qaList__content"
            v-show="isOpen(item.QUESTION_ID)"
          >
            {{ item.QUESTION_CONTENT }}
          </div>
        </Transition>
      </section>
    </template>
    <n-empty v-else description="無資料"> </n-empty>
  </n-card>
</template>
<style lang="scss" scoped>
.qaList {
  &__title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    padding: 16px;
    border-bottom: 1px solid #f4e1ff;
    box-shadow: 3px 3px 12px rgba(150, 100, 200, 0.1); /* 超淡紫色 */

    &:hover {
      background-color: #eee9ff;
      box-shadow: 3px 3px 12px rgba(150, 100, 200, 0.1); /* 超淡紫色 */
    }
  }
  &__qaTitle {
    font-size: 20px;
    color: #66669a;
  }
  &__content {
    font-size: 18px;
    padding: 16px;
  }
}
.panel {
  &-enter-active,
  &-leave-active {
    overflow: hidden;
    transition: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 50ms;
  }
}
</style>
