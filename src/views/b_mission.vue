<script setup>
import { onMounted, ref } from "vue";
import Backlayout from "../components/backlayout.vue";
import MissionTable from "../components/BackMember/Mission.vue";
import { useLoadingStore } from "../store/loading";
import { useApi } from "../util/useApi";
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const { b__mission } = useApi();
const missionData = ref([]);
const getMission = async () => {
  setLoading(true);
  const response = await b__mission();
  setLoading(false);
  missionData.value = response;
};
onMounted(() => {
  getMission();
});
</script>
<template>
  <MissionTable :tableData="missionData" />
</template>
<!-- <script>
//import 這頁需要的元件
import Backlayout from "../components/backlayout.vue";

export default {
  data() {
    return {
      id: 0,
      open: false,
      isBlurred: false,
      selectedIndex: null,
      missionQuery: "",
      mission: [],
      itemsPerPage: 6,
      currentPage: 1,
      newMission: [],

      // 金幣
      newCoin: "",
      // 次數
      newTimes: "",
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    show(index) {
      this.$root.$emit("toggleBlur", !this.open);
      this.open = !this.open;
      this.isBlurred = !this.isBlurred;
      this.selectedIndex = index;

      const selectedMission = this.mission[index];

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
      const selectMission = this.newMission[index].MISSION_ID;
      const dataCoin = this.newCoin !== "" ? this.newCoin : null;
      const dataTimes = this.newTimes !== "" ? this.newTimes : null;

      console.log("Sending data to backend:", {
        MISSION_ID: selectMission,
        newCoin: dataCoin,
        newTimes: dataTimes,
      });

      fetch(this.ajax_url + "update_b_mission.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          MISSION_ID: selectMission,
          newCoin: dataCoin !== "" ? dataCoin : null,
          newTimes: dataTimes !== "" ? dataTimes : null,
        }),
      })
        .then((response) => response.text())
        .then((updateData) => {
          console.log(updateData);
          this.mission[this.selectedIndex].MISSION_COINS =
            updateData.MISSION_COINS;
          this.mission[this.selectedIndex].MISSION_TIMES =
            updateData.MISSION_TIMES;
        });
      location.reload();
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
    fetch(this.ajax_url + "b_mission.php", {
      method: "POST",
      mode: "cors",
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        this.mission = data;
        this.newMission = data;
        // console.log(data);
      });
  },
  computed: {
    missionFliterID() {
      const query = this.missionQuery.toLowerCase();
      return this.mission.filter((i) => {
        // return i.MISSION_ID && typeof i.MISSION_ID === 'string' && i.MISSION_ID.toLowerCase().includes(query);
        return i.MISSION_CONTENT.toLowerCase().includes(query);
      });
    },

    missionFliter() {
      const startIndex = (this.currentPage - 1) * this.itemsPerPage;
      const endIndex = startIndex + this.itemsPerPage;

      return this.missionFliterID.slice(startIndex, endIndex);
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
