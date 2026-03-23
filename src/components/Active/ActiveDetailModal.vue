<script setup>
import { computed, ref } from "vue";

defineOptions({
  name: "ActiveDetailModal",
});
const props = defineProps(["modelValue"]);
const emit = defineEmits(["update:modelValue"]);
const moduleValue = computed({
  get: () => props.modelValue,
  set: (newValue) => emit("update:modelValue", newValue),
});
const bodyStyle = {
  width: "600px",
};
</script>
<template>
  <n-modal
    v-model:show="moduleValue"
    class="custom-card"
    preset="card"
    :style="bodyStyle"
    title="報名資訊"
    size="huge"
    :bordered="false"
    :segmented="segmented"
  >
    <slot></slot>
    <template #footer>
      <slot name="footer"></slot>
    </template>
  </n-modal>
</template>
