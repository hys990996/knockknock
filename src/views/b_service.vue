<script setup>
import { computed, markRaw, nextTick, onMounted, reactive, ref } from "vue";
import ServiceTable from "../components/BackMember/ServiceTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
import ServiecForm from "../components/BackMember/ServiecForm.vue";
const { b_getService } = useApi();
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const serviceData = ref([]);
const getService = async () => {
  setLoading(true);
  const response = await b_getService();
  setLoading(false);
  serviceData.value = response;
};

const activeTab = ref("0");
const tabs = reactive([
  {
    name: "客服列表",
    component: markRaw(ServiceTable),
    id: "0",
    bind: computed(() => ({
      tableData: serviceData.value,
    })),
    isClosed: false,
  },
]);

const editAddTab = (value) => {
  const existingTabIndex = tabs.findIndex((tab) => tab.id === value.CONTACT_ID);
  activeTab.value = value.CONTACT_ID;
  if (existingTabIndex === -1) {
    const newTab = {
      name: `${value.MEMBER_LAST_NAME}${value.MEMBER_FIRST_NAME}`,
      component: markRaw(ServiecForm),
      id: value.CONTACT_ID,
      bind: { formData: value },
      isClosed: true,
    };
    tabs.push(newTab);
    nextTick(() => {
      activeTab.value = newTab.id;
    });
  }
};

const clearTab = (value) => {
  const matchIndex = tabs.findIndex((item) => item.id === value);
  if (matchIndex > -1) {
    tabs.splice(matchIndex, 1);
    activeTab.value = "0";
  }
};

onMounted(() => {
  getService();
});
</script>
<template>
  <n-card content-style="padding: 12px;">
    <n-tabs
      v-model:value="activeTab"
      type="card"
      closable
      tab-style="min-width: 80px;"
      @close="clearTab"
    >
      <n-tab-pane
        v-for="panel in tabs"
        :key="panel"
        :tab="panel.name.toString()"
        :name="panel.id"
      >
        <keep-alive>
          <component
            :is="panel.component"
            v-bind="panel.bind"
            @edit:click="editAddTab"
          ></component>
        </keep-alive>
      </n-tab-pane>
    </n-tabs>
  </n-card>
</template>
<!-- <script>
//import 這頁需要的元件
import Backlayout from "../components/backlayout.vue";
import ServiceTable from "../components/BackMember/ServiceTable.vue";

export default {
  data() {
    return {
      id: 0,
      open: false,
      serve_qa_index: null,
      serveQuery: "",
      serve_qa: [],
      itemsPerPage: 6,
      currentPage: 1,

      // 回覆資料
      replyContent: "",
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    show(index) {
      this.$root.$emit("toggleBlur", !this.open);
      this.open = !this.open;
      this.isBlurred = !this.isBlurred;
      this.serve_qa_index = index;
    },
    close() {
      this.open = false;
      this.isBlurred = false;
    },
    changePage(page) {
      this.currentPage = page;
    },

    save(index) {
      // 按下儲存後更新資料

      const selectContact = this.serveFliter[index];
      // console.log(selectContact);
      if (selectContact.CONTACT_REPLIED == 0) {
        selectContact.CONTACT_REPLIED == 1;
        console.log("success change");
      } else {
        console.log("nonono");
      }

      const replyData = {
        // 問題的編號
        contactID: selectContact.CONTACT_ID,
        // 回覆的內容
        replyContent: this.replyContent,
      };

      fetch(this.ajax_url + "insert_b_service.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(replyData),
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("success fetch");
          location.reload();
        });

      this.replyContent = "";
      this.close();
    },
    // 管理員登出
    deleteCookie(name) {
      document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
      location.reload();
    },
    // 管理員登出
    b_logOut() {
      fetch(this.ajax_url + "b_logout.php")
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          if (window.confirm("確定登出嗎?")) {
            if (data.message == "登出成功") {
              this.deleteCookie("bUserName");
              this.deleteCookie("bUserId");
              this.$router.push("/backend");
              console.log(data);
            }
          }
        });
    },
  },
  mounted() {
    fetch(this.ajax_url + "b_service.php", {
      method: "POST",
      mode: "cors",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        this.serve_qa = data;
        console.log(data);
      });
  },
  computed: {
    serveFliterID() {
      const query = this.serveQuery.toLowerCase();
      return this.serve_qa.filter((i) => {
        return i.CONTACT_REPLIED.toLowerCase().includes(query);
      });
    },

    serveFliter() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;

      return this.serveFliterID.slice(startIndex, endIndex);
    },
    getUserName() {
      const cookie = document.cookie;
      const cookiesArray = cookie.split(";");
      let username = "";
      cookiesArray.forEach((cookieItem) => {
        const [name, value] = cookieItem.trim().split("=");
        if (name === "bUserName") {
          username = value;
        }
      });
      // 如果找到 'bUserName' 的 cookie，則取出其值
      if (username !== "") {
        console.log(`Username: ${username}`);
        return username; // 返回取得的 username
      } else {
        console.log("找不到 bUserName 的 Cookie");
        return ""; // 或者返回空字符串或其他你認為合適的值
      }
    },
  },
  components: {
    Backlayout,
  },
};
</script> -->
