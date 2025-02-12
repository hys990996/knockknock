<template>
  <section>
    <nav class="b_Nvabar">
      <img
        class="b_Nvabar__logo"
        src="../assets/images/logo/logo_desk.svg"
        alt="logo"
      />
      <b-menu>
        <b-menu-list :activable="false">
          <b-menu-item label="會員專區">
            <b-menu-item
              label="會員管理"
              tag="router-link"
              :to="{ name: 'b_member' }"
            >
            </b-menu-item>
          </b-menu-item>
          <b-menu-item label="會員活動專區">
            <b-menu-item
              label="活動管理"
              icon="account"
              tag="router-link"
              :to="{ name: 'b_activity' }"
            ></b-menu-item>
          </b-menu-item>
          <b-menu-item label="客服專區">
            <b-menu-item
              label="客服管理"
              icon="account"
              tag="router-link"
              :to="{ name: 'b_service' }"
            ></b-menu-item>
          </b-menu-item>
          <b-menu-item label="任務專區">
            <b-menu-item
              label="任務管理"
              icon="account"
              tag="router-link"
              :to="{ name: 'b_mission' }"
            ></b-menu-item>
          </b-menu-item>
          <b-menu-item label="會員問題專區">
            <b-menu-item
              label="常見問題管理"
              icon="account"
              tag="router-link"
              :to="{ name: 'b_qa' }"
            ></b-menu-item>
          </b-menu-item>
        </b-menu-list>
      </b-menu>
    </nav>
  </section>
</template>

<script setup>
import { ref } from "vue";
const open = ref(false);
</script>
