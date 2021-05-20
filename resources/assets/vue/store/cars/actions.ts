import axios from 'axios';
import checkResponse from '@/utils/checkResponse';



const loadCars = async ({ commit }, payload) => {
  let searchEmpty: Partial<SearchForm>={brand:'', license_plate_number:'',user:''};
  commit('SET_SEARCH_CACHE', searchEmpty);
  commit('SET_LOADING', true);
  
  try {
    const response = await axios.get(`cars?page=${payload.page}`);

    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_CARS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};

const userNameToCarSearch = async ({ commit }, payload) => {
  commit('USER_SEARCH_NAME', payload);
};

const loadCarsSearch = async ({ commit }, payload) => {
  commit('SET_LOADING', true);
  commit('SET_SEARCH_CACHE', payload.search);
  try {
    const response = await axios.post(`cars-search?page=${payload.page}`, payload.search)

    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('SET_CARS', response.data);
    }
  } catch (e) {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_LOADING', false);
  }
};


const loadUsers = async ({ commit }) => {
  const response = await axios.get('user-select');
  commit('SET_USERS', response.data);
};

const loadUser = async ({ commit }) => {
  const response = await axios.get('auth-user');
  commit('SET_USER', response.data);
};

const addCar = async ({ commit }, payload) => {
  const car = {
    license_plate_number: payload.license_plate_number,
    brand: payload.brand,
    vintage: payload.vintage,
    smd: payload.smd,
    user_id: payload.user_id,
    status_id: payload.status_id,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.post('cars', car);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('ADD_CAR', response.data);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const editCar = async ({ commit }, payload) => {
  const car = {
    license_plate_number: payload.license_plate_number,
    brand: payload.brand,
    vintage: payload.vintage,
    smd: payload.smd,
    user_id: payload.user_id,
    status_id: payload.status_id,
  };

  commit('SET_MODAL_LOADING', true);

  try {
    const response = await axios.put(`cars/${payload.id}`, car);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('UPDATE_CAR', response.data);
      commit('SET_MODAL_VISIBLE', false);
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  } finally {
    commit('SET_MODAL_LOADING', false);
  }
};

const deleteCar = async ({ commit }, payload) => {
  try {
    const response = await axios.delete(`cars/${payload.id}`);
    const checkErrors = checkResponse(response);

    if (checkErrors) {
      commit('SET_DIALOG_MESSAGE', checkErrors.message, { root: true });
    } else {
      commit('DELETE_CAR', payload);
      commit('SET_DIALOG_MESSAGE', 'front.deleted_successfully', { root: true });
    }
  } catch {
    commit('SET_DIALOG_MESSAGE', 'errors.generic_error', { root: true });
  }
};

const setModalVisible = ({ commit }, payload) => {
  commit('SET_MODAL_VISIBLE', payload);
};

export default {
  loadCars,
  loadCarsSearch,
  addCar,
  editCar,
  deleteCar,
  setModalVisible,
  loadUsers,
  loadUser,
  userNameToCarSearch,
};
