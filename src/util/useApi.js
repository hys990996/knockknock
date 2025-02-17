import axios from "axios";

export const useApi = () => {
  const baseUrl = import.meta.env.VITE_AJAX_URL;
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
  const updateMemberStatus = async (config) => {
    const result = await axios.post(
      `${baseUrl}update_b_member_status.php`,
      config,
      {
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    return result.data;
  };
  const updataQa = async (config) => {
    const result = await axios.post(`${baseUrl}b_qa_update.php`, config, {
      headers: {
        "Content-Type": "application/json",
      },
      mode: "cors",
    });
    return result.data;
  };
  const updataMission = async (config) => {
    const result = await axios.post(`${baseUrl}update_b_mission.php`, config, {
      headers: {
        "Content-Type": "application/json",
      },
      mode: "cors",
    });
    return result.data;
  };
  const getDetailActive = async (data) => {
    const result = await axios.get(
      `${baseUrl}b_detailActive.php?ACTIVEID=${data}`,
      {
        headers: {
          "Content-Type": "application/json",
        },
        mode: "cors",
      }
    );
    return result.data;
  };
  const upDateActivityStatus = async (config) => {
    const result = await axios.post(
      `${baseUrl}b_activity_updateStatus.php`,
      config,
      {
        headers: {
          "Content-Type": "application/json",
        },
        mode: "cors",
      }
    );
    return result.data;
  };
  const createActive = async (config) => {
    const result = await axios.post(`${baseUrl}b_addActivity.php`, config, {
      headers: {
        "Content-Type": "application/json",
      },
      mode: "cors",
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
    updateMemberStatus,
    updataQa,
    updataMission,
    getDetailActive,
    upDateActivityStatus,
    createActive,
  };
};
