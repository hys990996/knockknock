import axios from "axios";

export const useApi = () => {
  const baseUrl = "https://tibamef2e.com/thd103/g2/dist/api/";
  const b_login = async (config) => {
    const result = await axios.post(`${baseUrl}b_login.php`, config, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result;
  };
  const b_getUser = async () => {
    const result = await axios.get(`${baseUrl}b_member.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  const b_logout = async () => {
    const result = await axios.get(`${baseUrl}b_logout.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result;
  };
  const b_getActive = async () => {
    const result = await axios.get(`${baseUrl}b_activity.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  const b_getService = async () => {
    const result = await axios.get(`${baseUrl}b_service.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  const b_qaList = async () => {
    const result = await axios.get(`${baseUrl}b_qa.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  const b_qaListOption = async () => {
    const result = await axios.get(`${baseUrl}b_qa_category.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  const b__mission = async () => {
    const result = await axios.get(`${baseUrl}b_mission.php`, {
      headers: {
        "Content-Type": "application/json",
      },
    });
    return result.data;
  };
  return {
    b_login,
    b_getUser,
    b_logout,
    b_getActive,
    b_getService,
    b_qaList,
    b_qaListOption,
    b__mission,
  };
};
