<script setup>
import { ref } from "vue";
import { useApi } from "../util/useApi";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const router = useRouter();
const loading = ref(false);

const username = ref("");
const password = ref("");

const login = async () => {
  loading.value = true;
  const response = await useApi.b_login({
    username: username.value,
    password: password.value,
  });
  loading.value = false;
  if (!response.data.success) {
    Swal.fire({
      title: "登入失敗",
      text: "請重新確認您的帳號與密碼",
    });
    return;
  }
  const expirationDate = new Date();
  expirationDate.setHours(expirationDate.getHours() + 1); // 過期時間設定為一小時後
  const expires = expirationDate.toUTCString(); // 將過期時間轉換為 UTC 字串;
  document.cookie = `bUserId=${response.data.id}; expires=${expires} ; bUserName=${response.data.username}`;
  document.cookie = `bUserName=${response.data.username};expires=${expires} `;
  router.push("/backend/member_management");
};
</script>

<template>
  <div class="b_index">
    <b-loading is-full-page v-model="loading" :can-cancel="true"></b-loading>
    <div class="b_index_login">
      <router-link :to="{ name: 'home' }" class="nav-brandlogo">
        <img src="../assets/images/logo/logo_desk.svg" alt="logo" />
      </router-link>
      <h1>後台管理員登入</h1>
      <div class="login-section">
        <n-input
          v-model:value="username"
          placeholder="請輸入使用者名稱"
          size="small"
        />
        <n-input
          type="password"
          show-password-on="mousedown"
          v-model:value="password"
          placeholder="請輸入使用者名稱"
          size="small"
        />
        <n-button strong secondary type="info" @click="login" size="large">
          登入
        </n-button>
      </div>
    </div>
  </div>
</template>
