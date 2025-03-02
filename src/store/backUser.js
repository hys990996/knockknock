import { defineStore } from "pinia";
import { ref } from "vue";

export const useBackStore = defineStore(
  "backUser",
  () => {
    const backUserInfo = ref({});
    const setUserStore = (userInfo) => {
      backUserInfo.value = userInfo;
    };
    const clearUserStore = () => {
      backUserInfo.value = {};
      localStorage.removeItem("backUser");
    };

    return {
      backUserInfo,
      setUserStore,
      clearUserStore,
    };
  },
  {
    persist: {
      enabled: true,
      persist: localStorage,
    },
  }
);
