<template>
  <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
  <main class="bmain-block">
    <div class="bmain">
      <section class="bsection-left">
        <backnavBar></backnavBar>
      </section>
      <section class="bsection-right">
        <div class="topBar">
          <h1 class="topBar__title">{{ route.meta.title }}</h1>
          <div class="topBar__info">
            <div class="topBar__infoImg"></div>
            <p class="topBar__infoName">{{ userName }}</p>
            <b-button @click="logout" type="is-info" inverted>登出</b-button>
          </div>
        </div>
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
import { computed } from "vue";
import Swal from "sweetalert2";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import { storeToRefs } from "pinia";

const router = useRouter();
const route = useRoute();
const { b_logout } = useApi();
const loadingStore = useLoadingStore();
const { loading } = storeToRefs(loadingStore);
const { setLoading } = loadingStore;

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

const logout = async () => {
  Swal.fire({
    title: "再次確認!",
    text: "確認是否登出",
    icon: "question",
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
</script>
