<template>
    <div class="container py-5">
        <button class="btn btn-primary" @click="addCar">Add Car</button>

        <transition @enter="startTransitionModal" @after-enter="endTransitionModal" @before-leave="endTransitionModal" @after-leave="startTransitionModal">
          <div class="modal fade" v-if="showCarModal" ref="modal">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">{{ isAddMode? 'Add Car' : 'Edit Car' }}</h5>
                  <button type="button" class="close" @click="showCarModal = false" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p class="text-danger" v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                      <li v-for="error in errors">{{ error }}</li>
                    </ul>
                  </p>
                  <form>
                    <div class="form-group">
                      <input type="text" class="form-control" v-model="form.carName" placeholder="Car Name">
                    </div>
                    <div class="form-group mt-2">
                      <select class="form-select" aria-label="example" v-model="form.carManufacturerId">
                        <option value="" disabled>Car Manufacturer</option>
                        <option :value="manufacturer.id" v-for="(manufacturer, index) in manufacturers">{{ manufacturer.name }}</option>
                        <option>Others...</option>
                      </select>
                    </div>
                    <div class="form-group mt-2">
                      <select class="form-select" aria-label="example" v-model="form.carTypeId">
                        <option value="" disabled>Car Type</option>
                        <option :value="type.id" v-for="(type, index) in types">{{ type.name }}</option>
                        <option>Others...</option>
                      </select>
                    </div>
                    <div class="form-group mt-2">
                      <select class="form-select" aria-label="example" v-model="form.carColorId">
                        <option value="" disabled>Car Color</option>
                        <option :value="color.id" v-for="(color, index) in colors">{{ color.name }}</option>
                        <option>Others...</option>
                      </select>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" @click="showCarModal = !showCarModal">Close</button>
                  <button class="btn btn-primary" type="button" @click="saveCar">Save</button>
                </div>
              </div>
            </div>
          </div>
        </transition>

        <div class="modal-backdrop fade d-none" ref="backdrop"></div>

        <table class="table table-striped mt-5">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Manufacturer</th>
              <th scope="col">Type</th>
              <th scope="col">Color</th>
              <th scope="col"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(car, index) in cars">
              <th scope="row">{{ index + 1 }}</th>
              <td>{{ car.carName }}</td>
              <td>{{ car.carManufacturer }}</td>
              <td>{{ car.carType }}</td>
              <td>{{ car.carColor }}</td>
              <td class="text-end">
                <a class="me-1" @click="editCar(car)"><i class="bi bi-pen"></i></a>
                <a class="ms-1" @click="deleteCar(car.carId)"><i class="bi bi-trash"></i></a>
              </td>
            </tr>
          </tbody>
        </table>
    </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            form: {
              carName: '',
              carManufacturer: '',
              carType: '',
              carColor: ''
            },
            showCarModal: false,
            isAddMode: true,
            errors: []
        }
    },
    async beforeRouteEnter(to, from, next) {
      next(vm => {
          vm.$store.dispatch('GetCars')
          vm.$store.dispatch('GetDropdownValues')
      })
    },
    computed : {
      cars : function(){ return this.$store.getters.StateCars},
      manufacturers : function(){  return this.$store.getters.StateManufacturers},
      types : function(){ return this.$store.getters.StateTypes},
      colors : function(){ return this.$store.getters.StateColors}
    },
    methods: {
      ...mapActions(["GetCars", "CreateCar", "DeleteCar"]),
      startTransitionModal() {
        this.$refs.backdrop.classList.toggle("d-none");
        this.$refs.modal.classList.toggle("d-block");
      },
      endTransitionModal() {
        this.$refs.backdrop.classList.toggle("show");
        this.$refs.modal.classList.toggle("show");
      },
      resetForm() {
        this.form = {
          carName: '',
          carManufacturerId: '',
          carTypeId: '',
          carColorId: ''
        }
      },
      addCar() {
        this.isAddMode = true;
        this.showCarModal = true;
      },
      editCar(car) {
        this.isAddMode = false;
        this.form = car;
        this.showCarModal = true;
      },
      async saveCar() {
        this.errors = [];

        let response = await this.CreateCar({
          car: this.form,
          isAddMode: this.isAddMode
        });

        if (response.status != 200 && response.data) {
          if (response.data.errors) {
            for (const [key, values] of Object.entries(response.data.errors)) {
              this.errors.push(...values);
            }
          } else if (response.data.message) {
            this.errors.push(response.data.message);
          }
        } else {
          this.showCarModal = false;
        }
      },
      async deleteCar(carId) {
        await this.DeleteCar(carId);
      }
    },
    watch: {
      showCarModal(newVal, oldVal) {
        if (newVal && this.isAddMode) {
          this.resetForm();
        }
      }
    }
};
</script>