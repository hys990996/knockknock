<script setup>
import { reactive } from "vue";
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";
import dayjs from "dayjs";
import { DEFAULTDAY } from "../../util/const";

defineOptions({
  name: "ServiceForm",
});

const props = defineProps({
  formData: Object,
});

const loadingStore = useLoadingStore();

const message = useMessage();

const replayConfig = reactive({
  contactID: props.formData.CONTACT_ID,
  replyContent: props.formData.CONTACT_REPLY_CONTENT,
});

const submit = async () => {
  loadingStore.setLoading(true);
  const result = await useApi.updateMission(replayConfig);
  loadingStore.setLoading(false);
  if (result) {
    message.success("編輯成功");
    return;
  }
  message.error("編輯失敗");
};

const replyStatus = {
  0: "未回覆",
  1: "已回覆",
};
</script>
<template>
  <div>
    <n-form>
      <n-form-item label="問題編號">
        <n-input disabled :value="replayConfig.contactID" />
      </n-form-item>
      <n-form-item label="問題狀態">
        <n-input :value="replyStatus[formData.CONTACT_REPLIED]" disabled />
      </n-form-item>
      <n-form-item label="提問內容">
        <n-input :value="formData.CONTACT_CONTACT" disabled />
      </n-form-item>
      <n-form-item label="反應日期">
        <n-input
          :value="dayjs(formData.CONTACT_CREATETIME).format(DEFAULTDAY)"
          disabled
        />
      </n-form-item>
      <n-form-item label="姓名">
        <n-input
          :value="`${formData.MEMBER_LAST_NAME}${formData.MEMBER_FIRST_NAME}`"
          disabled
        />
      </n-form-item>
      <n-form-item label="會員信箱">
        <n-input :value="formData.MEMBER_ACCOUNT" disabled />
      </n-form-item>
      <n-form-item label="回覆內容">
        <n-input
          :disabled="formData.CONTACT_REPLIED !== '0'"
          v-model:value="replayConfig.replyContent"
          placeholder="請輸入回覆內容"
        />
      </n-form-item>
    </n-form>
    <n-button strong secondary @click="submit">送出編輯</n-button>
  </div>
</template>
