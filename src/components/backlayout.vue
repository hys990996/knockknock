<template>
  <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
  <main class="bmain-block">
    <div class="bmain">
      <section class="bsection-left">
        <backnavBar></backnavBar>
      </section>
      <section class="bsection-right">
        <b-navbar class="topBar">
          <template #brand>
            <b-navbar-item tag="h1" class="topBar__title">
              {{ route.meta.title }}
            </b-navbar-item>
          </template>
          <template #end>
            <n-dropdown :options="option">
              <n-button type="info">{{ backUserInfo.userName }}</n-button>
            </n-dropdown>
          </template>
        </b-navbar>

        <div class="bsection-right__tableSection">
          <router-view></router-view>
        </div>
      </section>
    </div>
  </main>
</template>

<script setup>
import { useRoute, useRouter } from "vue-router";
import backnavBar from "../components/backnavBar.vue";
import Swal from "sweetalert2";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import { storeToRefs } from "pinia";
import { NButton } from "naive-ui";
import { useBackStore } from "../store/backUser";

const backUserStore = useBackStore();
const { backUserInfo } = storeToRefs(backUserStore);
const router = useRouter();
const route = useRoute();
const loadingStore = useLoadingStore();
const { loading } = storeToRefs(loadingStore);
const { setLoading } = loadingStore;

const logout = async () => {
  Swal.fire({
    title: "再次確認!",
    text: "確認是否登出",
    showCancelButton: true,
    confirmButtonText: "確定登出",
    cancelButtonText: "取消",
  }).then(async (result) => {
    if (result.isConfirmed) {
      setLoading(true);
      await useApi.b_logout();
      setLoading(false);
      backUserStore.clearUserStore();
      router.push({ path: "/backend" });
    }
  });
};

const option = [
  {
    label: "上線中",
    key: "status",
    disabled: true,
  },
  {
    label: "登出",
    key: "status",
    props: {
      onClick: logout,
    },
  },
];
</script>

<style lang="scss" scoped>
.topBar {
  background-color: #f2effb;
  padding: 12px;

  &__title {
    color: #7957d5;
  }

  &__info {
    display: flex;
    gap: 16px;
    align-items: center;
  }

  &__dropdown {
    display: flex;
    background-color: white;
  }
}
</style>
