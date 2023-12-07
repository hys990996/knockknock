<template>
  <layout>
    <template #section-right-content>
      <div class="activity_info" v-for="i in fetchactivity">
        <!-- <div class="activity_info-post">
            <input type="text" />
          </div> -->
        <h1>{{ i.ACTIVITY_NAME }}</h1>
        <div class="act_ph">
          <img :src="i.ACTIVITY_IMAGE" alt="夏日音樂祭" class="activity_ph" />
        </div>

        <div class="act-content">
          <div class="content-top">
            <div class="content-top-L">
              <div class="content-top-L-1">
                <span>
                  <img src="../assets/images/actitity-info/location-outline.svg" alt="活動地址" /></span>
                {{ i.ACTIVITY_ADDRESS }}
              </div>
              <div class="content-top-L-2">
                <span><img src="../assets/images/actitity-info/Date.svg" alt="活動日期" /> </span>{{
                  i.ACTIVITY_DATE }}
              </div>
              <div class="content-top-L-3">
                <div class="content-top-L-3-1">
                  <span><img src="../assets/images/actitity-info/截止時間.svg" alt="報名截止" /></span>
                  {{ i.ACTIVITY_ENDDATE }} 截止報名
                </div>
                <div class="content-top-L-3-2">
                  <span><img src="../assets/images/actitity-info/人數.svg" alt="活動名額" /></span>
                  名額{{ i.ACTIVITY_QUOTA }}人(剩餘名額:
                  {{ i.ACTIVITY_REMAINING_PLACES }}人)
                </div>
              </div>
              <div class="content-top-L-4">
                <span>
                  <img src="../assets/images/actitity-info/費用.svg" alt="活動費用" />
                </span>
                1人${{ i.ACTIVITY_SINGLE_PRICE }}/人 3人${{
                  i.ACTIVITY_GROUP_PRICE
                }}/人
              </div>
            </div>
            <div class="content-top-R">
              <div id="btn">
                <!-- 觸發按鈕 -->
                <button @click="confirmRegistration(i.ACTIVITY_ID)" class="Btn Btn-dark chatbtn" :disabled="i.ACTIVITY_REMAINING_PLACES<=0" >
                  {{ i.ACTIVITY_REMAINING_PLACES <=0 ?'已完售':'我要報名' }}
                </button>
                <!-- 彈跳視窗 -->
                <div v-if="showModal" class="modal" @click="closeModal2">
                  <!-- 彈跳視窗內容 -->
                  <div class="modal-content" @click.stop>
                    <span class="close" @click="
                      showModal = false;
                    closeModal2();
                    ">&times;</span>
                    <div v-if="contentChanged" class="if">
                      <div>
                        <p class="list2-m">付款成功</p>
                        <div class="list2-n">
                          <div>王小明</div>
                          <div>
                            <img src="../assets/images/actitity-info/小明.svg" alt="小明自拍照" />
                          </div>
                        </div>
                        <div class="list2-f">
                          <div class="list2">
                            <div class="gp-1">
                              <span class="list2-1">活動名稱</span><span class="list2-1-2">{{
                                activityData.ACTIVITY_NAME
                              }}</span>
                            </div>
                            <div class="gp-2">
                              <span class="list2-2">活動日期</span><span class="list2-2-2">{{ activityData.ACTIVITY_DATE
                              }}</span>
                            </div>
                            <div class="gp-3">
                              <span class="list2-3">報名人數</span><span class="list2-3-2">{{ quantity }}人</span>
                            </div>
                            <div class="gp-4">
                              <span class="list2-4">總金額</span><span class="list2-4-2"> ${{ this.total }}</span>
                            </div>
                          </div>
                          <div class="gp-4">
                            <p class="list2-check">
                              您已經付款報名成功，以上是您的揪團資訊。
                            </p>
                            <!-- 當連結被點擊時，調用 checkBeforeNavigate 方法 -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- @@@@@@@@@@@@@@@@@ -->
                    <div v-else class="else" v-for="i in fetchactivity">
                      <div  >
                        <p class="list-m">報名資訊</p>
                        <div class="list-n">
                          <div>{{member_name}}</div>
                          <div>
                            <img :src="user_img" alt="小明自拍照" />
                          </div>
                        </div>
                        <div class="list">
                          <div class="list-L">
                            <div class="group-1">
                              <span class="list-1">活動名稱</span><span class="list-1-2">{{
                                i.ACTIVITY_NAME
                              }}</span>
                            </div>
                            <div class="group-2">
                              <span class="list-2">活動日期</span><span class="list-2-2">
                                {{ i.ACTIVITY_DATE }}</span>
                            </div>
                            <div class="group-3">
                              <span class="list-3">報名人數</span><span class="list-3-2">
                                <input type="number" v-model.number="quantity"
                                  @input="validateQuantity(i.ACTIVITY_SINGLE_PRICE, i.ACTIVITY_GROUP_PRICE,i.ACTIVITY_REMAINING_PLACES)"
                                  placeholder="請輸入人數" /></span>
                            </div>
                            <div class="group-4">
                              <span class="list-4">總金額</span><span class="list-4-2">
                                <label v-if="quantity !== null && quantity !== ''">
                                  {{ total }}元
                                </label></span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- @@@@@@@@@@@@@@@@@ -->

                      <div class="modal-footer">
                        <button type="button" class="Btn Btn-dark chatbtn"
                          @click=" EcPay(i.ACTIVITY_ID, i.ACTIVITY_DESCRIBE, i.ACTIVITY_NAME)">
                          前往結帳
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="content-bottom">
            <div class="b-t">
              <p v-html="activityData.ACTIVITY_DESCRIBE.replace(`n`, '<br>')" :style="{ 'white-space': 'pre-wrap' }"></p>
            </div>
          </div>
        </div>
      </div>
      <div id="paymentContainer"></div>
    </template>
  </layout>
</template>

<script>
import layout from "@/components/layout.vue";
import axios from "axios";
import { useUserStore } from '@/store/user';
export default {
  components: {
    layout,
  },
  data() {
    return {
      activityId: 0,
      showModal: false,
      quantity: 0, // 合並data
      amount: 1200, // 假設初始費用為1200
      contentChanged: false,
      isChecked: false,
      activityData: {
        ACTIVITY_NAME: "",
        ACTIVITY_ADDRESS: "",
        ACTIVITY_DATE: "",
        ACTIVITY_ENDDATE: "",
        ACTIVITY_DESCRIBE: "",
        ACTIVITY_QUOTA: "",
        ACTIVITY_SINGLE_PRICE: "",
        ACTIVITY_GROUP_PRICE: "",
        ACTIVITY_REMAINING_PLACES: "",
      },
      activityId: 0,
      fetchactivity: [],
      data: null,
      loading: false,
      // 綠界日期
      MerchantTradeDate: "",
      REGISTER_ID: 0,
      MEMBER_ID:'',
      // 會員資料
      getMember:[],
      member_name:'',
      user_img:''
    };
  },
  mounted() {
    this.activityId = this.$route.params.activityID;
    console.log('Activityinfo ID:', this.activityId);
    this.getActivityData();
    this.formatDateTime()
    const userStore = useUserStore();
    this.MEMBER_ID = userStore.userID;
    this.member_name = userStore.userName;
    this.user_img = 'data:image/png;base64,'+userStore.userImg;


      fetch('http://localhost/1206Team/queryMember.php',{
      method:'POST',
      mode:'cors',
      headers:{
        'Content-Type':'application/json'
      },
      body:JSON.stringify({
        userID:userStore.userID
      })
    })
    .then((res)=>{
      return res.json()
    })
    .then((data)=>{
      console.log(data)
      this.getMember = data
    })
  },
  methods: {
    // 確認是否報名
    confirmRegistration(activityId) {
      if (window.confirm('確認是否報名？')) {
        this.showModal = true;

      }
    },
    closeModal(event) {
      if (event.target.classList.contains("modal")) {
        this.showModal = false;
      }
    },
    closeModal2() {
      this.showModal = false;
      this.contentChanged = false; // 重置內容狀態
    },
    validateQuantity(single, group,activityRemaining) {
      if(this.quantity>activityRemaining){
        this.quantity = activityRemaining
      }
      if (this.quantity < 0) {
        this.quantity = 0;
      } else if (this.quantity >= 3) {
        this.amount = group; // 如果人數超過3，費用變更
      } else {
        this.amount = single; // 如果人數少於3，費用恢復
      }
    },
    showSuccessMessage() {
      // 更新 contentChanged 屬性以顯示報名成功訊息
      this.contentChanged = true;
    },
    checkBeforeNavigate() {
      if (this.checked) {
        // window.location.href = "https://www.";
      } else {
        // 如果未勾選，顯示提醒
        alert("請先勾選同意條款和條件。");
      }
    },

    handleButtonClick() {
      if (this.isChecked) {
        // 執行一些操作，因為 checkbox 已經被勾選
        alert("Checkbox is checked. Proceeding with the action.");
      } else {
        // 提醒用戶勾選 checkbox
        alert("Please check the checkbox first.");
      }
    },
    getActivityData() {
      fetch("api/activityInfo.php", {
        headers: {
          'Content-Type': 'application/json'
        },
        method: 'POST',
        mode: 'cors',
        body: JSON.stringify({
          ACTIVITY_ID: this.activityId
        })
      })
        .then((res) => {
          return res.json()
        })
        .then((data) => {
          this.activityData = { ...this.activityData, ...data };
          this.fetchactivity = data;
          console.log(this.activityData);
          console.log(data);
        })

    },
    // 綠界支付
    EcPay(activityId, activityDesc, activityName) {
      fetch("api/activityApply.php", {
        headers: {
          'Content-Type': 'application/json'
        },
        method: 'POST',
        mode: 'cors',
        body: JSON.stringify({
          REGISTER_COUNT: this.quantity,
          REGISTER_TOTAL_PRICE: this.total,
          REGISTER_PAIED: 0,
          ACTIVITY_ID: activityId,
          MEMBER_ID: this.MEMBER_ID,

        })
      })
        .then((res) => {
          return res.json()
        })
        .then((data) => {
          console.log(data)

          data.forEach(element => {
            console.log(element.REGISTER_ID)
            this.REGISTER_ID = element.REGISTER_ID;
            this.activityId = element.ACTIVITY_ID
          });
          console.log(this.REGISTER_ID)
          console.log(this.activityId)
        })
      setTimeout(() => {
        fetch('api/Ecpay.php', {
          headers: {
            'Content-Type': 'application/json'
          },
          method: 'POST',
          mode: 'cors',
          body: JSON.stringify({
            MerchantTradeNo: this.MerchantTradeNo,
            MerchantTradeDate: this.MerchantTradeDate,
            PaymentType: "aio",
            TotalAmount: this.total,
            TradeDesc: '活動',
            ItemName: activityName,
            ChoosePayment: "ALL",
            quantity: this.quantity,
            REGISTER_ID: this.REGISTER_ID,
            activityId: this.activityId
          })
        })
          .then((res) => {
            return res.text()
          })
          .then((data) => {
            // 在成功接收到 HTML 內容後將其插入到指定元素中
            document.getElementById('paymentContainer').innerHTML = data;
            document.getElementById("__ecpayForm").style.display = "none";
            document.getElementById("__ecpayForm").submit();
            this.showModal = true
          })
        fetch('api/ECPay_ReturnURL.php')
          .then((res) => {
            return res.text()
          })
          .then((data) => {
            console.log(data)
          })
      }, 1000);

    },
    // 綠界日期
    formatDateTime() {
      const currentDate = new Date();
      const year = currentDate.getFullYear();
      const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
      const day = currentDate.getDate().toString().padStart(2, '0');
      const hour = currentDate.getHours().toString().padStart(2, '0');
      const minute = currentDate.getMinutes().toString().padStart(2, '0');
      const second = currentDate.getSeconds().toString().padStart(2, '0');
      // 格式化日期時間為 YYYY/MM/DD HH:mm:ss
      this.MerchantTradeDate = `${year}/${month}/${day} ${hour}:${minute}:${second}`;
    },
  },
  computed: {
    total() {
      // 當沒有輸入時，總金額不計算
      return this.quantity !== null && this.quantity !== ""
        ? this.quantity * this.amount
        : 0;
    },

  },
};
</script>
