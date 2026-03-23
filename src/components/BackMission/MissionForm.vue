<script setup>
import { reactive } from "vue";
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";

defineOptions({
  name: "MissonForm",
});

const props = defineProps({
  formData: Object,
});

const loadingStore = useLoadingStore();

const message = useMessage();

const missionConfig = reactive({
  MISSION_ID: props.formData.MISSION_ID,
  newCoin: Number(props.formData.MISSION_COINS),
  newTimes: Number(props.formData.MISSION_TIMES),
});

const submit = async () => {
  loadingStore.setLoading(true);
  const result = await useApi.updateMission(missionConfig);
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
    <n-form ref="formRef">
      <n-form-item label="任務編號" path="formData.MISSION_ID">
        <n-input disabled :value="missionConfig.MISSION_ID" />
      </n-form-item>
      <n-form-item label="任務內容">
        <n-input disabled :value="formData.MISSION_CONTENT" />
      </n-form-item>
      <n-form-item label="金幣數量" path="missionConfig.newCoin">
        <n-input-number
          v-model:value="missionConfig.newCoin"
          :min="0"
          placeholder="請輸入金幣數量"
        />
      </n-form-item>
      <n-form-item label="完成次數" path="missionConfig.newTimes">
        <n-input-number
          v-model:value="missionConfig.newTimes"
          :min="0"
          placeholder="完成次數"
        />
      </n-form-item>
    </n-form>
    <n-button strong secondary @click="submit">送出編輯</n-button>
  </div>
</template>
