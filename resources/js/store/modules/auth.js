import axios from 'axios';

const state = {
  accessToken: null,
  user: null,
  cars: [],
  manufacturers: [],
  types: [],
  colors: []
};

const getters = {
  isAuthenticated: state => !!state.accessToken,
  StateAccessToken: state => state.accessToken,
  StateCars: state => state.cars,
  StateUser: state => state.user,
  StateManufacturers: state => state.manufacturers,
  StateTypes: state => state.types,
  StateColors: state => state.colors
};

const actions = {
  async LogIn({commit}, user) {
    let response = null;
    try {
      response = await axios.post('api/login', user)
    } catch(error) {
      response = error.response;
    }
    if (response.status == 200) {
      await commit('setAccessToken', response.data.access_token)
      await commit('setUser', response.data.user)
    }
    return response
  },
  async LogOut({commit, state}){
    await axios.post('api/logout', null, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    commit('LogOut')
  },
  async GetCars({commit, state}){
    let response = await axios.post('api/cars', null, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    commit('setCars', response.data.cars)
  },
  async GetDropdownValues({commit, state}){
    let response = await axios.post('api/dropdown-values', null, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    commit('setManufacturers', response.data.manufacturers)
    commit('setTypes', response.data.types)
    commit('setColors', response.data.colors)
  },
  async CreateCar({dispatch, state}, {car, isAddMode}) {
    let response = null;
    try {
      if (isAddMode) {
        response = await axios.post('api/car', car, {
          headers: {
            Authorization: 'Bearer ' + state.accessToken,
          }
        })
      } else {
        response = await axios.put('api/car/' + car.carId, car, {
          headers: {
            Authorization: 'Bearer ' + state.accessToken,
          }
        })
      }
    } catch(error) {
      response = error.response;
    }
    if (response.status == 200) {
      dispatch('GetCars')
    }

    return response;
  },
  async DeleteCar({dispatch, state}, carId) {
    let response = await axios.delete('api/car/' + carId, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    if (response.data.success) {
      dispatch('GetCars')
    }
  },
  async CreateManufacturer({dispatch, state}, {manufacturer, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/manufacturer', manufacturer, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    } else {
      response = await axios.put('api/manufacturer/' + manufacturer.id, manufacturer, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteManufacturer({dispatch, state}, manufacturerId) {
    let response = await axios.delete('api/manufacturer/' + manufacturerId, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async CreateType({dispatch, state}, {type, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/type', type, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    } else {
      response = await axios.put('api/type/' + type.id, type, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteType({dispatch, state}, typeId) {
    let response = await axios.delete('api/type/' + typeId, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async CreateColor({dispatch, state}, {color, isAddMode}) {
    let response;
    if (isAddMode) {
      response = await axios.post('api/color', color, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    } else {
      response = await axios.put('api/color/' + color.id, color, {
        headers: {
          Authorization: 'Bearer ' + state.accessToken,
        }
      })
    }
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
  async DeleteColor({dispatch, state}, colorId) {
    let response = await axios.delete('api/color/' + colorId, {
      headers: {
        Authorization: 'Bearer ' + state.accessToken,
      }
    })
    if (response.data.success) {
      dispatch('GetDropdownValues')
    }
  },
};

const mutations = {
  setAccessToken(state, accessToken) {
    state.accessToken = accessToken
  },
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
      state.accessToken = null;
  },
};

export default {
  state,
  getters,
  actions,
  mutations
};