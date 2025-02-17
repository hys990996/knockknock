<script setup>
import { useApi } from "../../util/useApi";
import { useMessage } from "naive-ui";
import { useLoadingStore } from "../../store/loading";
import { reactive } from "vue";
import FileUpload from "../FileUpload/FileUpload.vue";
import dayjs from "dayjs";
import { DEFAULTDAY } from "../../util/const";

defineOptions({
  name: "ActiveCreateForm",
});

const { createActive } = useApi();
const loadingStore = useLoadingStore();

const message = useMessage();

const regionOption = [
  { label: "北區", value: "北區" },
  { label: "中區", value: "中區" },
  { label: "南區", value: "南區" },
  { label: "離島", value: "離島" },
];

const formData = reactive({
  ACTIVITY_NAME: "",
  ACTIVITY_ADDRESS: "",
  ACTIVITY_DATE: null,
  ACTIVITY_ENDDATE: null,
  ACTIVITY_SINGLE_PRICE: "",
  ACTIVITY_GROUP_PRICE: "",
  ACTIVITY_STARTDATE: null,
  ACTIVITY_IMAGE: "",
  ACTIVITY_STATUS: "正常",
  ACTIVITY_REGION: "",
  ACTIVITY_QUOTA: "",
  ACTIVITY_REMAINING_PLACES: "",
  ACTIVITY_DESCRIBE: "",
});

const submit = async () => {
  const config = {
    ...formData,
    ACTIVITY_DATE: dayjs(formData.ACTIVITY_DATE).format(DEFAULTDAY),
    ACTIVITY_ENDDATE: dayjs(formData.ACTIVITY_ENDDATE).format(DEFAULTDAY),
    ACTIVITY_STARTDATE: dayjs(formData.ACTIVITY_STARTDATE).format(DEFAULTDAY),
    ACTIVITY_GROUP_PRICE: formData.ACTIVITY_GROUP_PRICE.toString(),
    ACTIVITY_QUOTA: formData.ACTIVITY_QUOTA.toString(),
    ACTIVITY_SINGLE_PRICE: formData.ACTIVITY_SINGLE_PRICE.toString(),
    ACTIVITY_REMAINING_PLACES: formData.ACTIVITY_REMAINING_PLACES.toString(),
    ACTIVITY_IMAGE: formData.ACTIVITY_IMAGE.split(",")[1],
  };
  loadingStore.setLoading(true);
  const result = await createActive(config);
  loadingStore.setLoading(false);
  if (result.success) {
    message.success("編輯成功");
    return;
  }
  message.error("編輯失敗");
};
</script>
<template>
  <n-form :model="formValue" class="activeForm">
    <FileUpload v-model="formData.ACTIVITY_IMAGE" class="activeForm__colFile" />
    <n-form-item
      label="活動日期"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-date-picker
        placeholder="請選擇活動日期"
        type="date"
        v-model:value="formData.ACTIVITY_DATE"
      />
    </n-form-item>
    <n-form-item
      label="報名開始日期"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-date-picker
        placeholder="請選擇報名開始日期"
        type="date"
        v-model:value="formData.ACTIVITY_STARTDATE"
      />
    </n-form-item>
    <n-form-item
      label="報名截止日期"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-date-picker
        placeholder="請選擇報名截止日期"
        type="date"
        v-model:value="formData.ACTIVITY_ENDDATE"
      />
    </n-form-item>

    <n-form-item
      label="單人費用"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-input-number
        v-model:value="formData.ACTIVITY_SINGLE_PRICE"
        placeholder="請輸入單人費用"
        :min="0"
        :options="staatusOption"
      />
    </n-form-item>
    <n-form-item
      label="團體費用"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-input-number
        v-model:value="formData.ACTIVITY_GROUP_PRICE"
        placeholder="請輸入團體費用"
        :min="0"
        :options="staatusOption"
      />
    </n-form-item>
    <n-form-item
      label="活動名額"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-input-number
        v-model:value="formData.ACTIVITY_QUOTA"
        :min="0"
        placeholder="請輸入活動名額"
      />
    </n-form-item>
    <n-form-item
      label="剩餘名額"
      path="treeSelectValue"
      class="activeForm__col2"
    >
      <n-input-number
        placeholder="請輸入剩餘名額"
        :min="0"
        v-model:value="formData.ACTIVITY_REMAINING_PLACES"
      />
    </n-form-item>
    <n-form-item label="活動區域" class="activeForm__col6">
      <n-select
        v-model:value="formData.ACTIVITY_REGION"
        :options="regionOption"
      />
    </n-form-item>

    <n-form-item label="活動名稱" class="activeForm__col6">
      <n-input
        placeholder="請輸入活動名稱"
        v-model:value="formData.ACTIVITY_NAME"
      />
    </n-form-item>
    <n-form-item label="活動地點" class="activeForm__col6">
      <n-input
        placeholder="請輸入活動地點"
        v-model:value="formData.ACTIVITY_ADDRESS"
      />
    </n-form-item>
    <n-form-item label="活動描述" class="activeForm__col6">
      <n-input
        type="textarea"
        v-model:value="formData.ACTIVITY_DESCRIBE"
        placeholder="請輸入活動描述"
      />
    </n-form-item>
  </n-form>
  <n-button strong secondary @click="submit">送出編輯</n-button>
</template>
<style lang="scss" scoped>
.activeForm {
  display: grid;
  grid-template-columns: repeat(8, 1fr);
  gap: 8px;
  &__col2 {
    grid-column: span 2;
  }
  &__col4 {
    grid-column: span 2;
  }
  &__col6 {
    grid-column: span 8;
  }
  &__colFile {
    grid-column: span 8;
    margin-bottom: 16px;
    place-items: center;
  }
}
</style>
