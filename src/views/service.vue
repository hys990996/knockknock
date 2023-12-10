<template>
  <layout>
      <template #section-right-content>
          <div class="service">
      <div class="title">
          <h1>聯絡我們</h1>
      </div>

      <div class="menu_grid">
          <router-link :to="{ name: 'contact_us' }" class="question">
              <div class="card">
                  <img src="../assets/images/service/email.png" alt="email">
                  <div class="content">
                      <h2>填寫表單</h2>
                      <p>
                        請將您的意見以填寫表單方式送出，我們將於工作日由專人以郵件回復您的問題。</p>
                  </div>
              </div>
          </router-link>

          <router-link :to="{ name: 'qa' }" class="question">
              <div class="card">
                  <img src="../assets/images/service/question.png" alt="question">
                  <div class="content">
                      <h2>常見問題</h2>
                      <p>
                        您可以找到關於常見問題的解答。將可能遇到的問題都納入這裡，幫助您快速找。</p>
                  </div>
              </div>
          </router-link>

          <router-link :to="{ name: 'chatbot' }" class="question">
              <div class="card">
                  <img src="../assets/images/service/robot.png" alt="robot">
                  <div class="content">
                      <h2>客服機器人</h2>
                      <p>機器人將為您提供幫助，只需與機器人互動，它將盡力提供準確快速的解答。</p>
                  </div>
              </div>
          </router-link>
      </div>
  </div>
      </template>
  </layout>
</template>
<script>
//import 這頁需要的元件
import layout from '@/components/layout.vue'

export default {
  components: {
      layout
  }
}
</script>