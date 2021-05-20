import Vue from 'vue';

const SET_CARS = (state, payload) => {
  state.cars = payload.data;

  state.pagination = {
    currentPage: payload.current_page,
    perPage: payload.per_page,
    totalCars: payload.total,
    totalPages: payload.last_page,
  };
};

const SET_SEARCH_CACHE = (state, payload) => {
  state.searchCache = {
    brand: payload.brand,
    license_plate_number: payload.license_plate_number,
    user: payload.user,
  }
};

const SET_USERS = (state, payload) => {
  state.users = payload;
};

const SET_USER = (state, payload) => {
  state.user = payload;
};

const ADD_CAR = (state, payload) => {
  state.cars.unshift(payload);
};

const UPDATE_CAR = (state, payload) => {
  const idx = state.cars.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.set(state.cars, idx, payload);
  }
};

const DELETE_CAR = (state, payload) => {
  const idx = state.cars.findIndex(u => u.id === payload.id);

  if (idx >= 0) {
    Vue.delete(state.cars, idx);
  }
};

const SET_LOADING = (state, payload) => {
  state.isLoading = payload;
};

const SET_MODAL_LOADING = (state, payload) => {
  state.isModalLoading = payload;
};

const SET_MODAL_VISIBLE = (state, payload) => {
  state.isModalVisible = payload;
};

const USER_SEARCH_NAME = (state, payload) => {
  state.userSearchName = payload;
};

export default {
  SET_USERS,
  SET_USER,
  SET_CARS,
  ADD_CAR,
  UPDATE_CAR,
  DELETE_CAR,
  SET_LOADING,
  SET_MODAL_LOADING,
  SET_MODAL_VISIBLE,
  SET_SEARCH_CACHE,
  USER_SEARCH_NAME,
};
