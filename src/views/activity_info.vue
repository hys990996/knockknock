<template>
  <layout>
    <template #section-right-content>
      <div class="activity_info">
        <!-- <div class="activity_info-post">
            <input type="text" />
          </div> -->
        <h1>{{ activityData.ACTIVITY_NAME }}</h1>
        <div class="act_ph">
          <img
            src="../assets/images/actitity/001.jpg"
            alt="夏日音樂祭"
            class="activity_ph"
          />
        </div>

        <h1>活動資訊</h1>
        <div>
          <p>活動名稱: {{ activityData.ACTIVITY_NAME }}</p>
          <p>活動地址: {{ activityData.ACTIVITY_ADDRESS }}</p>
          <p>活動日期: {{ activityData.ACTIVITY_DATE }}</p>
          <p>報名截止日期時間: {{ activityData.ACTIVITY_ENDDATE }}</p>
          <p>活動描述: {{ activityData.ACTIVITY_DESCRIBE }}</p>
          <p>活動名額: {{ activityData.ACTIVITY_QUOTA }}</p>
          <p>單人金額: {{ activityData.ACTIVITY_SINGLE_PRICE }}</p>
          <p>團報金額: {{ activityData.ACTIVITY_GROUP_PRICE }}</p>
          <p>剩餘名額: {{ activityData.REMAINING_PLACES }}</p>
        </div>

        <div class="act-content">
          <div class="content-top">
            <div class="content-top-L">
              <div class="content-top-L-1">
                <span>
                  <img
                    src="../assets/images/actitity/location-outline.svg"
                    alt="活動地址"
                /></span>
                {{ activityData.ACTIVITY_ADDRESS }}
              </div>
              <div class="content-top-L-2">
                <span
                  ><img
                    src="../assets/images/actitity/Date.svg"
                    alt="活動日期"
                  /> </span
                >{{ activityData.ACTIVITY_DATE }}
              </div>
              <div class="content-top-L-3">
                <div class="content-top-L-3-1">
                  <span
                    ><img
                      src="../assets/images/actitity/截止時間.svg"
                      alt="報名截止"
                  /></span>
                  {{ activityData.ACTIVITY_ENDDATE }} 截止報名
                </div>
                <div class="content-top-L-3-2">
                  <span
                    ><img
                      src="../assets/images/actitity/人數.svg"
                      alt="活動名額"
                  /></span>
                  名額{{ activityData.ACTIVITY_QUOTA }}人(剩餘名額:
                  {{ activityData.REMAINING_PLACES }}人)
                </div>
              </div>
              <div class="content-top-L-4">
                <span>
                  <img
                    src="../assets/images/actitity/費用.svg"
                    alt="活動費用"
                  />
                </span>
                1人${{ activityData.ACTIVITY_SINGLE_PRICE }}/人 3人${{
                  activityData.ACTIVITY_GROUP_PRICE
                }}/人
              </div>
            </div>
            <div class="content-top-R">
              <div id="btn">
                <!-- 觸發按鈕 -->
                <button @click="showModal = true" class="btn btn-dark">
                  我要報名
                </button>
                <!-- 彈跳視窗 -->
                <div v-if="showModal" class="modal" @click="closeModal2">
                  <!-- 彈跳視窗內容 -->
                  <div class="modal-content" @click.stop>
                    <span
                      class="close"
                      @click="
                        showModal = false;
                        closeModal2();
                      "
                      >&times;</span
                    >
                    <div v-if="contentChanged" class="if">
                      <div>
                        <p class="list2-m">報名成功</p>
                        <div class="list2-n">
                          <div>王小明</div>
                          <div>
                            <img
                              src="../assets/images/actitity/小明.svg"
                              alt="小明自拍照"
                            />
                          </div>
                        </div>
                        <div class="list2-f">
                          <div class="list2">
                            <div class="gp-1">
                              <span class="list2-1">活動名稱</span
                              ><span class="list2-1-2">{{
                                activityData.ACTIVITY_NAME
                              }}</span>
                            </div>
                            <div class="gp-2">
                              <span class="list2-2">活動日期</span
                              ><span class="list2-2-2">2023/12/25</span>
                            </div>
                            <div class="gp-3">
                              <span class="list2-3">報名人數</span
                              ><span class="list2-3-2">1人</span>
                            </div>
                            <div class="gp-4">
                              <span class="list2-4">總金額</span
                              ><span class="list2-4-2"> $1000/人</span>
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
                    <div v-else class="else">
                      <div>
                        <p class="list-m">報名資訊</p>
                        <div class="list-n">
                          <div>王小明</div>
                          <div>
                            <img
                              src="../assets/images/actitity/小明.svg"
                              alt="小明自拍照"
                            />
                          </div>
                        </div>
                        <div class="list">
                          <div class="list-L">
                            <div class="group-1">
                              <span class="list-1">活動名稱</span
                              ><span class="list-1-2">{{
                                activityData.ACTIVITY_NAME
                              }}</span>
                            </div>
                            <div class="group-2">
                              <span class="list-2">活動日期</span
                              ><span class="list-2-2">
                                {{ activityData.ACTIVITY_DATE }}</span
                              >
                            </div>
                            <div class="group-3">
                              <span class="list-3">報名人數</span
                              ><span class="list-3-2">
                                <input
                                  type="number"
                                  v-model.number="quantity"
                                  @input="validateQuantity"
                                  placeholder="請輸入人數"
                              /></span>
                            </div>
                            <div class="group-4">
                              <span class="list-4">總金額</span
                              ><span class="list-4-2">
                                <label
                                  v-if="quantity !== null && quantity !== ''"
                                >
                                  {{ total }}/人
                                </label></span
                              >
                            </div>
                          </div>
                        </div>
                        <div class="list-check">
                          <input
                            type="checkbox"
                            id="agree"
                            v-model="isChecked"
                          />
                          <label for="agree">
                            我已閱讀並同意遵守本網站的使用
                            <span class="link" @click="goToItem1">條款</span>和
                            <span class="link" @click="goToItem2"
                              >隱私政策</span
                            ></label
                          >
                          <!-- 當連結被點擊時，調用 checkBeforeNavigate 方法 -->
                        </div>
                      </div>
                      <!-- @@@@@@@@@@@@@@@@@ -->

                      <div class="modal-footer">
                        <button
                          type="button"
                          class="btn btn-dark btn-center"
                          @click="changeContent()"
                          :disabled="!isChecked"
                        >
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
              <br />
              <div>炎炎夏日，與音樂相遇！</div>
              <div>
                夏日的風，熱情的陽光，和你最愛的旋律，2023夏日音樂祭邀請你一同來場音樂的派對！
              </div>
              <br />
              <div class="b-b">
                <div class="b-b1">
                  <span
                    ><img
                      src="../assets/images/actitity/🎤活動1-內容icon(1).svg"
                      alt="知名歌手" /></span
                  >國內外知名歌手現場演出
                </div>
                <div class="b-b2">
                  <span
                    ><img
                      src="../assets/images/actitity/🍹活動1-內容icon(2).svg"
                      alt="美食" /></span
                  >美食和飲品攤位，讓你的味蕾也來場盛宴
                </div>
                <div class="b-b3">
                  <span
                    ><img
                      src="../assets/images/actitity/💃活動1-內容icon(3).svg"
                      alt="舞池" /></span
                  >現場DJ和舞池，讓你舞動夏日
                </div>
                <div class="b-b4">
                  <span
                    ><img
                      src="../assets/images/actitity/🎨活動1-內容icon(4).svg"
                      alt="遊戲" /></span
                  >藝術裝置和互動遊戲，讓你與朋友留下美好回憶
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </template>
  </layout>
</template>

<script>
import layout from "@/components/layout.vue";
import axios from "axios";
export default {
  components: {
    layout,
  },
  data() {
    return {
      showModal: false,
      quantity: null, // 合並data
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
        REMAINING_PLACES: "",
      },
      data: null,
      loading: false,
    };
  },
  mounted() {
    this.getActivityData();
  },
  methods: {
    closeModal(event) {
      if (event.target.classList.contains("modal")) {
        this.showModal = false;
      }
    },
    closeModal2() {
      this.showModal = false;
      this.contentChanged = false; // 重置內容狀態
    },
    validateQuantity() {
      if (this.quantity < 0) {
        this.quantity = 0;
      } else if (this.quantity >= 3) {
        this.amount = 1000; // 如果人數超過3，費用變更
      } else {
        this.amount = 1200; // 如果人數少於3，費用恢復
      }
    },
    changeContent() {
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

    goToItem1() {
      window.location.href = "https://www.google.com"; // 替換成實際的條款頁面 URL
    },
    goToItem2() {
      window.location.href = "https://edition.cnn.com/"; // 替換成實際的隱私政策頁面 URL
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
      axios
        .get("http://localhost:80/group-ts/TS/getUserData.php")
        .then((response) => {
          console.log(response.data); // 輸出查看數據
          this.activityData = response.data;
        })
        .catch((error) => {
          console.error(
            "There was an error fetching the activity data: ",
            error
          );
        });
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
