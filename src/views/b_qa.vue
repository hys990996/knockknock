<script setup>
import { onMounted, ref } from "vue";
import Backlayout from "../components/backlayout.vue";
import QaTable from "../components/BackMember/QaTable.vue";
import { useApi } from "../util/useApi";
import { useLoadingStore } from "../store/loading";
const { b_qaList, b_qaListOption } = useApi();
const loadingStore = useLoadingStore();
const { setLoading } = loadingStore;
const qaList = ref([]);
const selectOption = ref([]);
const getQaList = async () => {
  setLoading(true);
  const result = await Promise.all([b_qaList(), b_qaListOption()]);
  setLoading(false);
  qaList.value = result[0];
  selectOption.value = result[1];
};

onMounted(() => {
  getQaList();
});
</script>
<template>
  <QaTable :tableData="qaList" :optionData="selectOption" />
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
      qaQuery: "",
      // 過濾資料
      filteredQuestions: [],
      // 問題分類區域
      filteredQa: [],
      b_qa_category: [],
      b_qa_category_id: 1,
      qa: [],
      // 當前頁面
      currentPage: 1,
      // 每頁顯示的數量
      itemPerPage: 3,
      // 修改問題資料
      update_QUESTION_TITLE: "",

      update_QUESTION_CONTENT: "",
      ajax_url: import.meta.env.VITE_AJAX_URL,
    };
  },
  methods: {
    // 收尋功能
    filterQuestions() {
      const query = this.qaQuery.toLowerCase();
      this.filteredQuestions = this.qa.filter((item) =>
        item.QUESTION_TITLE.toLowerCase().includes(query)
      );
    },
    // 切換頁面
    changePage(page) {
      this.currentPage = page;
    },
    show(index) {
      this.$root.$emit("toggleBlur", !this.open);
      this.open = !this.open;
      this.isBlurred = !this.isBlurred;
      this.selectedIndex = index;

      // this.$emit('toggle-blur',this.open);
      // console.log(this.$root.$emit('toggleBlur',this.open))
    },
    close() {
      this.open = false;
      this.isBlurred = false;
    },
    updateBlurStatus(status) {
      this.isBlurred = status;
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
    // 更新提問資料
    b_qa_update(index) {
      const selectQaTitle = this.update_QUESTION_TITLE;
      const selectQaContent = this.update_QUESTION_CONTENT;
      fetch(this.ajax_url + "b_qa_update.php", {
        header: { "Content-Type": "application/json" },
        mode: "cors",
        method: "POST",
        body: JSON.stringify({
          QUESTION_ID: this.qaDisplayItems[index].QUESTION_ID,
          QUESTION_TITLE: selectQaTitle,
          QUESTION_CONTENT: selectQaContent,
        }),
      })
        .then((res) => {
          return res.json();
        })
        .then((data) => {
          console.log(data);
        });
      this.close();
      location.reload();
    },
  },
  computed: {
    fliterQa() {
      const query = this.qaQuery.toLowerCase();
      return this.qa.filter((i) => {
        return i.QUESTION_TITLE.toLowerCase().includes(query);
      });
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
    // 選單搜尋
    filteredQuestions() {
      if (!this.b_qa_category_id) {
        return this.qa;
      } else {
        return this.qa.filter(
          (question) => question.QUESTION_CATEGORY_ID === this.b_qa_category_id
        );
      }
    },
    // 計算頁面數量
    pageCount() {
      return Math.ceil(this.filteredQuestions.length / this.itemPerPage);
    },
    qaDisplayItems() {
      this.filteredQa = this.fliterQa;
      const startIndex = (this.currentPage - 1) * this.itemPerPage;
      const endPage = startIndex + this.itemPerPage;
      return this.filteredQuestions.slice(startIndex, endPage);
    },
  },
  watch: {
    // 監視 b_qa_category_id 變化，當其改變時重新過濾資料
    b_qa_category_id() {
      if (this.b_qa_category_id) {
        this.filteredQuestions = this.qa.filter(
          (question) => question.QUESTION_CATEGORY_ID === this.b_qa_category_id
        );
      } else {
        this.filteredQuestions = this.qa;
      }
    },
    // 監視 qaQuery 變化，當其改變時重新過濾資料
    qaQuery() {
      const query = this.qaQuery.toLowerCase();
      this.filteredQuestions = this.qa.filter((item) =>
        item.QUESTION_TITLE.toLowerCase().includes(query)
      );
    },
  },
  mounted() {
    fetch(this.ajax_url + "b_qa_category.php")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        this.b_qa_category = data;
        this.b_qa_category_id = data.QUESTION_CATEGORY_ID;
        console.log(data);
      });
    fetch(this.ajax_url + "b_qa.php")
      .then((res) => {
        return res.json();
      })
      .then((data) => {
        this.qa = data;
        this.filteredQuestions = data;
        console.log(data);
      });
    console.log(this.b_qa_category_id);
  },
  components: {
    Backlayout,
  },
};
</script> -->
