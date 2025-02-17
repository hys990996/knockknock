<script setup>
import { reactive } from "vue";
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";
import dayjs from "dayjs";
import { DEFAULTDAY } from "../../util/const";

defineOptions({
  name: "MemberForm",
});

const props = defineProps({
  memberData: Object,
});

const { updateMemberStatus } = useApi();
const loadingStore = useLoadingStore();

const formData = reactive(props.memberData);
const message = useMessage();

const staatusOption = [
  { label: "離線中", value: "0", disabled: true },
  { label: "上線中", value: "1", disabled: false },
  { label: "流浪中", value: "2", disabled: true },
  { label: "停用", value: "3", disabled: false },
];

const submit = async () => {
  const config = {
    memberID: formData.MEMBER_ID,
    newStatus: formData.MEMBER_STATUS,
  };
  loadingStore.setLoading(true);
  const result = await updateMemberStatus(config);
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
    <n-form ref="formRef" :model="formValue" :show-label="formShowLabel">
      <n-form-item label="會員編號" path="formData.MEMBER_ID">
        <n-input
          disabled
          v-model:value="formData.MEMBER_ID"
          placeholder="输入姓名"
        />
      </n-form-item>
      <n-form-item label="帳號" path="formData.MEMBER_ACCOUNT">
        <n-input disabled :value="formData.MEMBER_ACCOUNT" />
      </n-form-item>
      <n-form-item label="姓名" path="formData.userName">
        <n-input disabled :value="formData.userName" />
      </n-form-item>
      <n-form-item label="電話" path="formData.MEMBER_PHONE">
        <n-input disabled :value="formData.MEMBER_PHONE" />
      </n-form-item>
      <n-form-item label="創建時間" path="formData.MEMBER_CREATETIME">
        <n-input
          disabled
          :value="dayjs(formData.MEMBER_CREATETIME).format(DEFAULTDAY)"
        />
      </n-form-item>
      <n-form-item label="使用者狀態" path="treeSelectValue">
        <n-select
          v-model:value="formData.MEMBER_STATUS"
          placeholder="請選擇狀態"
          :options="staatusOption"
        />
      </n-form-item>
    </n-form>
    <n-button strong secondary @click="submit">送出編輯</n-button>
  </div>
</template>
