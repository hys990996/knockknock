<template>
  <MemberTable v-if="data" :tableData="data" />
</template>
<!-- <script>
//import 這頁需要的元件
import { useApi } from "../util/useApi";
import Backlayout from "../compo
nents/backlayout.vue";
export default {
  data() {
    return {
      id: 0,
      open: false,
      isBlurred: false,
      selectedIndex: null,
      searchQuery: "",
      member: [],
      itemsPerPage: 6,
      currentPage: 1,
      newStatus: "",
      newMember: [],
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    async getUser() {
      const { b_getUser } = useApi();
      const result = await b_getUser();
      this.member = result;
      console.log(result);
    },
    show(index) {
      this.$root.$emit("toggleBlur", !this.open);
      this.open = !this.open;
      this.isBlurred = !this.isBlurred;
      this.selectedIndex = index;
      this.newStatus = this.member[index].MEMBER_STATUS;

      // this.$emit('toggle-blur',this.open);
      // console.log(this.$root.$emit('toggleBlur',this.open))
    },
    close() {
      this.open = false;
      this.isBlurred = false;
    },

    changePage(page) {
      this.currentPage = page;
    },

    save(index) {
      const selectMember = this.fliterMember[index].MEMBER_ID;
      const dataStatus = this.newStatus;

      console.log("Sending data to backend:", {
        memberID: selectMember,
        newStatus: dataStatus,
      });

      fetch(this.ajax_url + "update_b_member_status.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          memberID: selectMember,
          newStatus: dataStatus,
        }),
      })
        .then((response) => response.text())
        .then((data) => {
          console.log(data);
          this.member.MEMBER_STATUS = data;
          location.reload();
        })
        .catch((error) => {
          console.error("Error updating data:", error);
        });

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
    this.getUser();
  },
  computed: {
    filterMemberID() {
      const query = this.searchQuery.toLowerCase();
      return this.member.filter((i) => {
        return i.MEMBER_ACCOUNT.toLowerCase().includes(query);
      });
    },

    fliterMember() {
      // const query = this.searchQuery.toLowerCase()

      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;

      return (
        this.filterMemberID
          // .filter(i => i.mail.toLowerCase().includes(query))
          .slice(startIndex, endIndex)
      );
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
<script setup>
import Backlayout from "../components/backlayout.vue";
import { useApi } from "../util/useApi";
import { onMounted, ref } from "vue";
import { useLoadingStore } from "../store/loading";
import MemberTable from "../components/BackMember/MemberTable.vue";

const { b_getUser } = useApi();
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;

const data = ref([]);

const getUser = async () => {
  setLoading(true);
  const response = await b_getUser();
  setLoading(false);
  data.value = response;
};

onMounted(() => {
  getUser();
});
</script>

<style>
.blurred {
  filter: blur(100px);
}
</style>
