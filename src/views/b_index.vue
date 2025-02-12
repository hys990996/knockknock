<script setup>
import { ref } from "vue";
import { useApi } from "../util/useApi";
import Swal from "sweetalert2";
import { useRouter } from "vue-router";

const { b_login } = useApi();
const router = useRouter();
const loading = ref(false);

const username = ref("");
const password = ref("");

const login = async () => {
  loading.value = true;
  const response = await b_login({
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
        <div class="mb-3">
          <b-field label="使用者名稱">
            <b-input
              v-model="username"
              placeholder="請輸入使用者名稱"
              size="is-medium"
            ></b-input>
          </b-field>
        </div>
        <div class="mb-3">
          <b-field label="使用者密碼">
            <b-input
              type="password"
              password-reveal
              v-model="password"
              size="is-medium"
              placeholder="請輸入密碼"
              @keydown.enter="login"
            ></b-input>
          </b-field>
        </div>
        <b-button type="is-primary" outlined @click="login" size="is-large"
          >登入</b-button
        >
      </div>
    </div>
  </div>
</template>

<!-- <script>
export default {
  data() {
    return {
      username: "",
      password: "",
      error: false,
      Verificationcode: [],
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    async getData() {
      const response = await fetch(
        "https://tibamef2e.com/thd103/g2/dist/api/" + "b_login.php",
        {
          method: "POST",
          mode: "cors",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: this.username,
            password: this.password,
          }),
        }
      )
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          if (data.success == true) {
            const expirationDate = new Date();
            expirationDate.setHours(expirationDate.getHours() + 1); // 過期時間設定為一小時後
            const expires = expirationDate.toUTCString(); // 將過期時間轉換為 UTC 字串;
            document.cookie = `bUserId=${data.id}; expires=${expires} ; bUserName=${data.username}`;
            document.cookie = `bUserName=${data.username};expires=${expires} `;
            this.$router.push("/backend/member_management");
          } else {
            this.error = true;
          }
        });
    },
    changeCode() {
      this.Verificationcode;
    },
  },
  mounted() {},
};
</script> -->
