<script setup>
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";

defineOptions({
  name: "BackMemberActiveForm",
});

const props = defineProps({
  formData: Object,
});

const { upDateActivityStatus } = useApi();
const loadingStore = useLoadingStore();

const message = useMessage();

const staatusOption = [
  { label: "正常", value: "正常" },
  { label: "取消", value: "取消" },
];

const submit = async () => {
  const config = {
    ACTIVITY_STATUS: props.formData.ACTIVITY_STATUS,
    ACTIVITY_ID: props.formData.ACTIVITY_ID,
  };
  loadingStore.setLoading(true);
  const result = await upDateActivityStatus(config);
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
      <n-form-item label="活動編號" path="formData.QUESTION_ID">
        <n-input disabled :value="formData.ACTIVITY_ID" />
      </n-form-item>
      <n-form-item label="活動名稱">
        <n-input disabled :value="formData.ACTIVITY_NAME" />
      </n-form-item>
      <n-form-item label="活動地點">
        <n-input disabled :value="formData.ACTIVITY_ADDRESS" />
      </n-form-item>
      <n-form-item label="活動日期">
        <n-input disabled :value="formData.ACTIVITY_DATE" />
      </n-form-item>
      <n-form-item label="使用者狀態" path="treeSelectValue">
        <n-select
          v-model:value="formData.ACTIVITY_STATUS"
          placeholder="請選擇狀態"
          :options="staatusOption"
        />
      </n-form-item>
    </n-form>
    <n-button strong secondary @click="submit">送出編輯</n-button>
  </div>
</template>
