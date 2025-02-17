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
              <n-button type="info">{{ userName }}</n-button>
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
import { computed, h } from "vue";
import Swal from "sweetalert2";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import { storeToRefs } from "pinia";
import { NButton, NTag } from "naive-ui";

const router = useRouter();
const route = useRoute();
const { b_logout } = useApi();
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
      await b_logout();
      setLoading(false);
      deletCookie("bUserName");
      deletCookie("bUserId");
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

const userName = computed(() => {
  const cookie = document.cookie;
  const cookiesArray = cookie.split(";");
  let username = "";
  cookiesArray.forEach((item) => {
    const [name, value] = item.trim().split("=");
    if (name === "bUserName") {
      username = value;
    }
  });
  return username || "";
});

const deletCookie = (name) => {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
};
</script>

<style lang="scss" scoped>
.topBar {
  background-color: #7957d5;
  padding: 12px;

  &__title {
    color: white;
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
