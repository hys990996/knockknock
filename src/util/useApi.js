import axios from "axios";

class ApiService {
  constructor(baseURL) {
    this.api = axios.create({
      baseURL,
      headers: { "Content-Type": "application/json" },
    });
  }

  async request(method, url, data = {}) {
    try {
      const response = await this.api({ method, url, ...data });
      return response.data;
    } catch (error) {
      console.error(`API Error (${method.toUpperCase()} ${url}):`, error);
      throw error;
    }
  }

  b_login(config) {
    return this.request("post", "b_login.php", { data: config });
  }

  b_getUser() {
    return this.request("get", "b_member.php");
  }

  b_logout() {
    return this.request("get", "b_logout.php");
  }

  b_getActive() {
    return this.request("get", "b_activity.php");
  }

  b_getService() {
    return this.request("get", "b_service.php");
  }

  b_qaList() {
    return this.request("get", "b_qa.php");
  }

  b_qaListOption() {
    return this.request("get", "b_qa_category.php");
  }

  b_mission() {
    return this.request("get", "b_mission.php");
  }

  updateMemberStatus(config) {
    return this.request("post", "update_b_member_status.php", { data: config });
  }

  updateQa(config) {
    return this.request("post", "b_qa_update.php", { data: config });
  }

  updateMission(config) {
    return this.request("post", "update_b_mission.php", { data: config });
  }

  getDetailActive(ACTIVEID) {
    return this.request("get", "b_detailActive.php", { params: { ACTIVEID } });
  }

  updateActivityStatus(config) {
    return this.request("post", "b_activity_updateStatus.php", {
      data: config,
    });
  }

  createActive(config) {
    return this.request("post", "b_addActivity.php", { data: config });
  }

  getRegionActive(params) {
    return this.request("get", "reigonActivity.php", { params });
  }

  getActive(params) {
    return this.request("get", "showActivity.php", { params });
  }

  getActiveDetail(ACTIVITY_ID) {
    return this.request("get", "activityInfo.php", { params: { ACTIVITY_ID } });
  }

  postActiveSignUp(data) {
    return this.request("post", "activityApply.php", { data });
  }

  ECPay(data) {
    return this.request("post", "Ecpay.php", { data });
  }
  getQuestion(id) {
    return this.request("get", "getQuestionById.php", { params: { id } });
  }
}

export const useApi = new ApiService(import.meta.env.VITE_AJAX_URL);
