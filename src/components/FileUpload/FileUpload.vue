<script setup>
import { useMessage } from "naive-ui";
import { computed, ref } from "vue";

defineOptions({
  name: "FileUpload",
});
const props = defineProps(["modelValue"]);
const emits = defineEmits(["update:modelValue"]);
const fileUpload = ref(null);
const imageUrl = computed({
  get: () => props.modelValue,
  set: (value) => emits("update:modelValue", value),
});
const message = useMessage();
const upload = () => {
  fileUpload.value.click();
};
const imgUpload = (event) => {
  const file = event.target.files[0];
  if (file && /^image\//.test(file.type)) {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      imageUrl.value = reader.result;
    };
  } else {
    message.warning("請上傳圖片");
  }
};
</script>
<template>
  <div>
    <div v-if="!imageUrl" class="fileUpload" @click="upload">上傳圖片</div>
    <n-image v-else width="100" height="100" :src="imageUrl" />
    <input
      class="fileUpload__input"
      ref="fileUpload"
      type="file"
      @change="imgUpload"
    />
  </div>
</template>
<style lang="scss" scoped>
.fileUpload {
  display: flex;
  cursor: pointer;
  justify-content: center;
  align-items: center;
  background-color: rgb(250, 250, 252);
  border-radius: 4px;
  border: 1px solid rgb(224, 224, 230);
  width: 100px;
  height: 100px;
  &:hover {
    border: 1px solid #18a058;
  }
  &__input {
    display: none;
  }
}
</style>
