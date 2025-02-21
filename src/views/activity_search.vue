<script setup>
import { computed, onMounted, ref } from "vue";
import { useApi } from "../util/useApi";
import { useRoute } from "vue-router";
import layout from "@/components/layout.vue";
import ActiveCard from "../components/Active/ActiveCard.vue";

const activeData = ref([]);
const { getRegionActive } = useApi();
const route = useRoute();
const page = ref(1);
const totalCount = ref(0);
const getActicve = async () => {
  const response = await getRegionActive({
    ACTIVITY_REGION: route.params.activityRegion,
    page: page.value,
  });
  activeData.value = response.data;
  totalCount.value = response.total;
};

const pageTotalCount = computed(() => {
  return Math.ceil(Number(totalCount.value) / 3);
});

onMounted(() => {
  getActicve();
});
</script>

<template>
  <layout>
    <template #section-right-content>
      <div class="activity-search">
        <div class="search-container">
          <router-link
            :to="{
              name: 'activity_info',
              params: { activityID: i.ACTIVITY_ID },
            }"
            class="result-cards"
            v-for="(i, key) in activeData"
            :key="i.ACTIVITY_ID"
            @click="getActivityId(key)"
          >
            <div class="result-card">
              <div class="result-pic">
                <img :src="i.ACTIVITY_IMAGE" alt="" />
                <div class="info">
                  <img src="../assets/images/activity/location.svg" alt="" />
                  <div>
                    {{ i.ACTIVITY_REGION }}，{{
                      i.ACTIVITY_ADDRESS.slice(0, 2)
                    }}
                  </div>
                </div>
              </div>
              <div class="result-details">
                <div class="result-text">
                  <h3>{{ i.ACTIVITY_NAME }}</h3>
                  <div class="details">
                    <div class="detail">
                      <img
                        src="../assets/images/activity/calendar-dk.svg"
                        alt=""
                      />
                      <div>{{ i.ACTIVITY_DATE }}</div>
                    </div>
                    <div class="detail">
                      <img
                        src="../assets/images/activity/group-dk.svg"
                        alt=""
                      />
                      <div>名額{{ i.ACTIVITY_QUOTA }}人</div>
                    </div>
                    <div class="detail">
                      <img src="../assets/images/activity/dollar.svg" alt="" />
                      <div>1人 ${{ i.ACTIVITY_SINGLE_PRICE }} /人</div>
                    </div>
                    <div class="detail">
                      <div class="fake"></div>
                      <div>3人 ${{ i.ACTIVITY_GROUP_PRICE }} /人</div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </router-link>
          <n-pagination
            v-model:page="page"
            :page-count="pageTotalCount"
            size="small"
            show-quick-jumper
            show-size-picker
            @change="getActicve"
          />
        </div>
      </div>
    </template>
  </layout>
</template>
//
<script>
// //import 這頁需要的元件

// import layout from "@/components/layout.vue";

// export default {
//   components: {
//     layout,
//   },
//   data() {
//     return {
//       areaActivity: [],
//       activityRegion: "",
//       activityID: 0,
//       ajax_url: import.meta.env.VITE_AJAX_URL,
//     };
//   },
//   methods: {
//     getActivityId(id) {
//       this.activityID = id;
//       console.log("Clicked activity ID:", id);
//     },
//   },
//   mounted() {
//     this.activityRegion = this.$route.params.activityRegion;
//     fetch(this.ajax_url + "reigonActivity.php", {
//       headers: {
//         "Content-Type": "application/json",
//       },
//       method: "POST",
//       mode: "cors",
//       body: JSON.stringify({
//         ACTIVITY_REGION: this.activityRegion,
//       }),
//     })
//       .then((res) => {
//         return res.json();
//       })
//       .then((data) => {
//         console.log(data);
//         this.areaActivity = data;
//       });
//   },
// };
//
</script>
