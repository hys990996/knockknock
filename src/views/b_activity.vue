<script setup>
import { onMounted, ref } from "vue";
import Backlayout from "../components/backlayout.vue";
import ActiveTable from "../components/BackMember/ActiveTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
const { b_getActive } = useApi();
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;

const data = ref([]);

const getActive = async () => {
  setLoading(true);
  const response = await b_getActive();
  setLoading(false);
  data.value = response;
};

onMounted(() => {
  getActive();
});
</script>

<template>
  <ActiveTable :tableData="data" />
</template>
<!-- <script>
//import 這頁需要的元件
import Backlayout from "../components/backlayout.vue";

export default {
  data() {
    return {
      id: 0,
      open: false,
      sign: false,
      add: false,
      isBlurred: false,
      active_show: null,
      activeQuery: "",
      pagination: {},
      filteredActive: [],
      // 當前頁面
      currentPage: 1,
      // 每頁顯示的數量
      itemPerPage: 6,

      disappear: false,
      newStatus: "",
      active: [],
      // 活動表單區域

      addActivityName: "",
      addActivityAddress: "",
      addActivityDate: "",
      addActivitySinglePrice: 0,
      addActivityGroupPrice: 0,
      addActivityDescribe: "",
      addActivityStartDate: "",
      addActivityEndDate: "",
      imgSrc: "",
      addActivityQuota: 0,
      addActivityRemaining: 0,
      addActivityRegion: "",
      // 更新活動狀態
      newActivityStatus: "",
      // 活動狀態查詢
      inquireAct: [],
      // 過濾活動id
      foundActivity: [],
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    // 換頁
    changePage(page) {
      // 切換頁碼
      this.currentPage = page;
    },
    close() {
      this.open = false;
      this.sign = false;
      this.add = false;
      this.isBlurred = false;
    },

    show(index) {
      this.$root.$emit("toggleBlur", !this.open);
      this.open = !this.open;
      this.isBlurred = !this.isBlurred;
      this.active_show = index;
      this.newActivityStatus = this.active[index].ACTIVITY_STATUS;
      // this.$emit('toggle-blur',this.open);
      // console.log(this.$root.$emit('toggleBlur',this.open))
    },
    showInfo(activitiId) {
      this.$root.$emit("toggleBlur", !this.sign);
      this.sign = !this.sign;
      this.isBlurred = !this.isBlurred;
      this.foundActivity = this.inquireAct.filter(
        (i) => i.ACTIVITY_ID == activitiId
      );
      console.log(this.foundActivity);
    },
    addActive() {
      this.$root.$emit("toggleBlur", !this.add);
      this.add = !this.add;
      this.isBlurred = !this.isBlurred;
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
    // 上傳圖片
    upLoadImg() {
      if (this.$refs.ipAvatar.files[0]) {
        this.imgSrc = URL.createObjectURL(this.$refs.ipAvatar.files[0]);
      }
      this.disappear = true;
      // this.imgSrc = '';
    },
    // 新增活動
    addActivity() {
      if (this.$refs.ipAvatar.files[0]) {
        const fr = new FileReader();
        fr.addEventListener("load", (e) => {
          const imageBase64 = btoa(e.target.result);
          fetch(this.ajax_url + "b_addActivity.php", {
            headers: {
              "Content-Type": "application/json",
            },
            mode: "cors",
            method: "POST",
            body: JSON.stringify({
              ACTIVITY_ID: this.active.length + 1,
              ACTIVITY_NAME: this.addActivityName,
              ACTIVITY_ADDRESS: this.addActivityAddress,
              ACTIVITY_DATE: this.addActivityDate,
              ACTIVITY_DESCRIBE: this.addActivityDescribe,
              ACTIVITY_ENDDATE: this.addActivityEndDate,
              ACTIVITY_SINGLE_PRICE: this.addActivitySinglePrice,
              ACTIVITY_GROUP_PRICE: this.addActivityGroupPrice,
              ACTIVITY_STARTDATE: this.addActivityStartDate,
              ACTIVITY_IMAGE: imageBase64,
              ACTIVITY_STATUS: "正常",
              ACTIVITY_REGION: this.addActivityRegion,
              ACTIVITY_QUOTA: this.addActivityQuota,
              ACTIVITY_REMAINING_PLACES: this.addActivityRemaining,
            }),
          })
            .then((res) => {
              return res.json();
            })
            .then((data) => {
              console.log(data);
            });
        });
        fr.readAsDataURL(this.$refs.ipAvatar.files[0]);
      }
      this.close();
    },
    // 更新活動狀態
    upDateActivityStatus(key) {
      const selectSActivityStatus = this.newActivityStatus;
      console.log(selectSActivityStatus);

      fetch(this.ajax_url + "b_activity_updateStatus.php", {
        headers: {
          "Content-Type": "application/json",
        },
        method: "POST",
        mode: "cors",
        body: JSON.stringify({
          ACTIVITY_STATUS: selectSActivityStatus,
          ACTIVITY_ID: this.displayedItems[key].ACTIVITY_ID,
        }),
      })
        .then((res) => {
          return res.text();
        })
        .then((data) => {
          console.log(data);
        });
      this.close();
      location.reload();
    },
  },
  computed: {
    filterActive() {
      const query = this.activeQuery.toLowerCase();
      return this.active.filter((i) => {
        return i.ACTIVITY_NAME.toLowerCase().includes(query);
      });
    },
    pageCount() {
      return Math.ceil(this.filteredActive.length / this.itemPerPage);
    },
    displayedItems() {
      this.filteredActive = this.filterActive;
      const startIndex = (this.currentPage - 1) * this.itemPerPage;
      const endPage = startIndex + this.itemPerPage;
      console.log("startIndex", startIndex, "endPage", endPage);
      console.log(this.active.slice(startIndex, endPage));
      return this.filteredActive.slice(startIndex, endPage);
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
  mounted() {
    fetch(this.ajax_url + "b_activity.php")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        this.active = data;
        console.log(data);
      });
    // 查詢報名資料

    fetch(this.ajax_url + "b_InquireActivity.php")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        console.log(data);
        this.inquireAct = data;
      });
  },
  components: {
    Backlayout,
  },
};
</script> -->
