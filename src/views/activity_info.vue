<script setup>
import layout from "@/components/layout.vue";
import { onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
import { useRoute } from "vue-router";
import ActiveDetailDomain from "../components/Active/ActiveDetailDomain.vue";
const route = useRoute();
const activeDetail = ref({});
const getDetailActive = async () => {
  const response = await useApi.getActiveDetail(route.params.activityID);
  activeDetail.value = response;
};
onMounted(() => {
  getDetailActive();
});
</script>
<template>
  <layout>
    <template #section-right-content>
      <div class="sub-bar">活動詳情</div>
      <ActiveDetailDomain :detail-data="activeDetail" />
      <div id="paymentContainer"></div>
    </template>
  </layout>
</template>

//
<script>
// import layout from "@/components/layout.vue";
// import { useUserStore } from "@/store/user";
// export default {
//   components: {
//     layout,
//   },
//   data() {
//     return {
//       activityId: 0,
//       showModal: false,
//       quantity: 0, // 合並data
//       amount: 1200, // 假設初始費用為1200
//       contentChanged: false,
//       isChecked: false,
//       activityData: {
//         ACTIVITY_NAME: "",
//         ACTIVITY_ADDRESS: "",
//         ACTIVITY_DATE: "",
//         ACTIVITY_ENDDATE: "",
//         ACTIVITY_DESCRIBE: "",
//         ACTIVITY_QUOTA: "",
//         ACTIVITY_SINGLE_PRICE: "",
//         ACTIVITY_GROUP_PRICE: "",
//         ACTIVITY_REMAINING_PLACES: "",
//       },
//       activityId: 0,
//       fetchactivity: [],
//       data: null,
//       loading: false,
//       // 綠界日期
//       MerchantTradeDate: "",
//       REGISTER_ID: 0,
//       MEMBER_ID: "",
//       // 會員資料
//       getMember: [],
//       member_name: "",
//       user_img: "",
//       ajax_url: import.meta.env.VITE_AJAX_URL,
//       now: "",
//     };
//   },
//   mounted() {
//     this.activityId = this.$route.params.activityID;
//     console.log("Activityinfo ID:", this.activityId);
//     this.getActivityData();
//     this.formatDateTime();
//     const userStore = useUserStore();
//     this.MEMBER_ID = userStore.userID;
//     this.member_name = userStore.userName;
//     this.user_img = "data:image/png;base64," + userStore.userImg;

//     fetch(this.ajax_url + "queryMember.php", {
//       method: "POST",
//       mode: "cors",
//       headers: {
//         "Content-Type": "application/json",
//       },
//       body: JSON.stringify({
//         userID: userStore.userID,
//       }),
//     })
//       .then((res) => {
//         return res.json();
//       })
//       .then((data) => {
//         console.log(data);
//         this.getMember = data;
//       });
//   },
//   methods: {
//     // 確認是否報名
//     confirmRegistration(activityId) {
//       if (window.confirm("確認是否報名？")) {
//         this.showModal = true;
//       }
//     },
//     closeModal(event) {
//       if (event.target.classList.contains("modal")) {
//         this.showModal = false;
//       }
//     },
//     closeModal2() {
//       this.showModal = false;
//       this.contentChanged = false; // 重置內容狀態
//     },
//     validateQuantity(single, group, activityRemaining) {
//       if (this.quantity > activityRemaining) {
//         this.quantity = activityRemaining;
//       }
//       if (this.quantity < 0) {
//         this.quantity = 0;
//       } else if (this.quantity >= 3) {
//         this.amount = group; // 如果人數超過3，費用變更
//       } else {
//         this.amount = single; // 如果人數少於3，費用恢復
//       }
//     },
//     showSuccessMessage() {
//       // 更新 contentChanged 屬性以顯示報名成功訊息
//       this.contentChanged = true;
//     },
//     checkBeforeNavigate() {
//       if (this.checked) {
//         // window.location.href = "https://www.";
//       } else {
//         // 如果未勾選，顯示提醒
//         alert("請先勾選同意條款和條件。");
//       }
//     },

//     handleButtonClick() {
//       if (this.isChecked) {
//         // 執行一些操作，因為 checkbox 已經被勾選
//         alert("Checkbox is checked. Proceeding with the action.");
//       } else {
//         // 提醒用戶勾選 checkbox
//         alert("Please check the checkbox first.");
//       }
//     },
//     getActivityData() {
//       fetch(this.ajax_url + "activityInfo.php", {
//         headers: {
//           "Content-Type": "application/json",
//         },
//         method: "POST",
//         mode: "cors",
//         body: JSON.stringify({
//           ACTIVITY_ID: this.activityId,
//         }),
//       })
//         .then((res) => {
//           return res.json();
//         })
//         .then((data) => {
//           this.activityData = { ...this.activityData, ...data };
//           this.fetchactivity = data;
//           console.log(this.activityData);
//           console.log(data);
//         });
//     },
//     // 綠界支付
//     EcPay(activityId, activityDesc, activityName) {
//       fetch(this.ajax_url + "activityApply.php", {
//         headers: {
//           "Content-Type": "application/json",
//         },
//         method: "POST",
//         mode: "cors",
//         body: JSON.stringify({
//           REGISTER_COUNT: this.quantity,
//           REGISTER_TOTAL_PRICE: this.total,
//           REGISTER_PAIED: 0,
//           ACTIVITY_ID: activityId,
//           MEMBER_ID: this.MEMBER_ID,
//         }),
//       })
//         .then((res) => {
//           return res.json();
//         })
//         .then((data) => {
//           console.log(data);

//           data.forEach((element) => {
//             console.log(element.REGISTER_ID);
//             this.REGISTER_ID = element.REGISTER_ID;
//             this.activityId = element.ACTIVITY_ID;
//           });
//           console.log(this.REGISTER_ID);
//           console.log(this.activityId);
//         });
//       setTimeout(() => {
//         fetch(this.ajax_url + "Ecpay.php", {
//           headers: {
//             "Content-Type": "application/json",
//           },
//           method: "POST",
//           mode: "cors",
//           body: JSON.stringify({
//             MerchantTradeNo: this.MerchantTradeNo,
//             MerchantTradeDate: this.MerchantTradeDate,
//             PaymentType: "aio",
//             TotalAmount: this.total,
//             TradeDesc: "活動",
//             ItemName: activityName,
//             ChoosePayment: "ALL",
//             quantity: this.quantity,
//             REGISTER_ID: this.REGISTER_ID,
//             activityId: this.activityId,
//           }),
//         })
//           .then((res) => {
//             return res.text();
//           })
//           .then((data) => {
//             // 在成功接收到 HTML 內容後將其插入到指定元素中
//             document.getElementById("paymentContainer").innerHTML = data;
//             document.getElementById("__ecpayForm").style.display = "none";
//             document.getElementById("__ecpayForm").submit();
//             this.showModal = true;
//           });
//         fetch(this.ajax_url + "ECPay_ReturnURL.php")
//           .then((res) => {
//             return res.text();
//           })
//           .then((data) => {
//             console.log(data);
//           });
//       }, 1000);
//     },
//     // 綠界日期
//     formatDateTime() {
//       const currentDate = new Date();
//       const year = currentDate.getFullYear();
//       const month = (currentDate.getMonth() + 1).toString().padStart(2, "0");
//       const day = currentDate.getDate().toString().padStart(2, "0");
//       const hour = currentDate.getHours().toString().padStart(2, "0");
//       const minute = currentDate.getMinutes().toString().padStart(2, "0");
//       const second = currentDate.getSeconds().toString().padStart(2, "0");
//       // 格式化日期時間為 YYYY/MM/DD HH:mm:ss
//       this.MerchantTradeDate = `${year}/${month}/${day} ${hour}:${minute}:${second}`;
//     },
//   },
//   computed: {
//     total() {
//       // 當沒有輸入時，總金額不計算
//       return this.quantity !== null && this.quantity !== ""
//         ? this.quantity * this.amount
//         : 0;
//     },
//   },
// };
//
</script>
