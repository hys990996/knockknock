<template>
  <section>
    <nav class="b_Nvabar">
      <img
        class="b_Nvabar__logo"
        src="../assets/images/logo/logo_desk.svg"
        alt="logo"
      />
      <n-menu
        :options="menuOptions"
        @update:value="handleUpdateValue"
        :default-value="$route.name"
      />
    </nav>
  </section>
</template>

<script setup>
import {
  BookOutline,
  PersonOutline,
  PaperPlaneSharp,
  PhonePortraitOutline,
  PrismOutline,
} from "@vicons/ionicons5";
import { NIcon } from "naive-ui";
import { h } from "vue";
import { RouterLink } from "vue-router";

const renderIcon = (icon) => {
  return () => h(NIcon, null, { default: () => h(icon) });
};

const createLabel = (routeName, label) => {
  return h(
    RouterLink,
    {
      to: {
        name: routeName,
      },
    },
    { default: () => label }
  );
};

const menuOptions = [
  {
    label: () => createLabel("b_member", "會員管理"),
    key: "b_member",
    icon: renderIcon(PersonOutline),
  },
  {
    label: () => createLabel("b_activity", "活動管理"),
    key: "b_activity",
    icon: renderIcon(PrismOutline),
  },
  {
    label: () => createLabel("b_service", "客服管理"),
    key: "b_service",
    icon: renderIcon(PhonePortraitOutline),
  },
  {
    label: () => createLabel("b_mission", "任務管理"),
    key: "b_mission",
    icon: renderIcon(BookOutline),
  },
  {
    label: () => createLabel("b_qa", "常見問題管理"),
    key: "b_qa",
    icon: renderIcon(PaperPlaneSharp),
  },
];
</script>
