<script setup>
import { reactive } from "vue";
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";

defineOptions({
  name: "QaForm",
});

const props = defineProps({
  formData: Object,
});

const { updataQa } = useApi();
const loadingStore = useLoadingStore();

const message = useMessage();

const replayConfig = reactive({
  QUESTION_ID: props.formData.QUESTION_ID,
  QUESTION_TITLE: "",
  QUESTION_CONTENT: "",
});

const submit = async () => {
  loadingStore.setLoading(true);
  const result = await updataQa(replayConfig);
  loadingStore.setLoading(false);
  if (result) {
    message.success("編輯成功");
    return;
  }
  message.error("編輯失敗");
};
</script>
<template>
  <div>
    <n-form :model="formValue">
      <n-form-item label="問題編號" path="formData.QUESTION_ID">
        <n-input disabled v-model:value="replayConfig.QUESTION_ID" />
      </n-form-item>
      <n-form-item label="常見問題標題">
        <n-input
          v-model:value="replayConfig.QUESTION_TITLE"
          placeholder="請輸入標題"
        />
      </n-form-item>
      <n-form-item label="回答內容">
        <n-input
          v-model:value="replayConfig.QUESTION_CONTENT"
          placeholder="請輸入回覆內容"
        />
      </n-form-item>
    </n-form>
    <n-button strong secondary @click="submit">送出編輯</n-button>
  </div>
</template>
