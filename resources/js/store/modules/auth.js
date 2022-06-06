import axios from 'axios';

const state = {
  user: null,
  cars: [],
  manufacturers: [],
  types: [],
  colors: []
};

const getters = {
  isAuthenticated: state => !!state.user,    
  StateCars: state => state.cars,
  StateUser: state => state.user,
  StateManufacturers: state => state.manufacturers,
  StateTypes: state => state.types,
  StateColors: state => state.colors
};

const actions = {
  async LogIn({commit}, user) {
    let response = await axios.post('api/login', user)
    await commit('setUser', response.data.user)
    return response
  },
  async LogOut({commit}){
    await axios.post('api/logout')
    commit('LogOut')
  },
  async GetCars({commit}){
    let response = await axios.post('api/cars')
    commit('setCars', response.data.cars)
  },
  async GetDropdownValues({commit}){
    let response = await axios.post('api/dropdown-values')
    commit('setManufacturers', response.data.manufacturers)
    commit('setTypes', response.data.types)
    commit('setColors', response.data.colors)
  },
  async CreateCar({dispatch}, {car, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/car', car)
    } else {
      response = await axios.put('api/car/' + car.carId, car)
    }
    if (response.data.success) {
      dispatch('GetCars')
    }
  },
  async DeleteCar({dispatch}, carId) {
    let response = await axios.delete('api/car/' + carId)
    if (response.data.success) {
      dispatch('GetCars')
    }
  },
  async CreateManufacturer({dispatch}, {manufacturer, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/manufacturer', manufacturer)
    } else {
      response = await axios.put('api/manufacturer/' + manufacturer.id, manufacturer)
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteManufacturer({dispatch}, manufacturerId) {
    let response = await axios.delete('api/manufacturer/' + manufacturerId)
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async CreateType({dispatch}, {type, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/type', type)
    } else {
      response = await axios.put('api/type/' + type.id, type)
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteType({dispatch}, typeId) {
    let response = await axios.delete('api/type/' + typeId)
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async CreateColor({dispatch}, {color, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/color', color)
    } else {
      response = await axios.put('api/color/' + color.id, color)
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteColor({dispatch}, colorId) {
    let response = await axios.delete('api/color/' + colorId)
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
};

const mutations = {
  setUser(state, user) {
    state.user = user
  },
  setCars(state, cars) {
    state.cars = cars
  },
  setManufacturers(state, manufacturers) {
    state.manufacturers = manufacturers
  },
  setTypes(state, types) {
    state.types = types
  },
  setColors(state, colors) {
    state.colors = colors
  },
  addCar(state, car) {
    state.cars = state.cars || [];
    state.cars.push(car);
  },
  LogOut(state) {
      state.user = null
      state.cars = null
  },
};

export default {
  state,
  getters,
  actions,
  mutations
};