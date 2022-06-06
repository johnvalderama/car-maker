<template>
    <div class="container py-5">
      <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="nav-item">
              <a href="#" class="nav-link" :class="{active: tabs.manufacturerActive}" role="tab" data-toggle="tab" @click.stop.prevent="setActive(1)">Manufacturer</a>
          </li>
          <li role="presentation" class="nav-item">
              <a href="#" class="nav-link" :class="{active: tabs.typeActive}" role="tab" data-toggle="tab" @click.stop.prevent="setActive(2)">Types</a>
          </li>
          <li role="presentation" class="nav-item">
              <a href="#" class="nav-link" :class="{active: tabs.colorActive}" role="tab" data-toggle="tab" @click.stop.prevent="setActive(3)">Colors</a>
          </li>
      </ul>
      <div class="tab-content">
          <div role="tabpanel" class="tab-pane active">
            <table class="table table-striped mt-5">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(property, index) in properties" :key="property.id">
                  <th scope="row">{{ index + 1 }}</th>
                  <td>
                    <div v-if="property.editMode">
                      <input type="text" class="form-control form-control-sm" v-model="property.name">
                    </div>
                    <div v-else>
                      {{ property.name }}
                    </div>
                  </td>
                  <td class="text-end">
                    <div class="d-inline-block" v-if="property.editMode">
                      <a class="me-1" @click="saveProperty(property)"><i class="bi bi-save"></i></a>
                    </div>
                    <div class="d-inline-block" v-else>
                      <a class="me-1" @click="editProperty(property)"><i class="bi bi-pen"></i></a>
                    </div>
                    <div class="d-inline-block" v-if="!property.editMode">
                      <a class="ms-1" @click="deleteProperty(property.id)"><i class="bi bi-trash"></i></a>
                    </div>
                  </td>
                </tr>
                <tr>
                  <th scope="row">{{ properties.length + 1 }}</th>
                  <td>
                    <div>
                      <input type="text" class="form-control form-control-sm" v-model="newPropertyName">
                    </div>
                  </td>
                  <td class="text-end">
                    <div class="d-inline-block">
                      <a class="me-1" @click="addProperty"><i class="bi bi-save"></i></a>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
      </div>
    </div>
</template>
<script>
import { mapActions } from "vuex";

export default {
    data() {
        return {
            message: 'Hello World JDbels',
            tabs: {
              manufacturerActive: true,
              typeActive: false,
              colorActive: false
            },
            isAddMode: true,
            newPropertyName: ''
        }
    },
    computed: {
      manufacturers : function(){ return this.$store.getters.StateManufacturers},
      types : function(){ return this.$store.getters.StateTypes},
      colors : function(){ return this.$store.getters.StateColors},
      properties: function(){
         if (this.tabs.manufacturerActive) {
          return this.manufacturers;
        } else if (this.tabs.typeActive) {
          return this.types;
        } else if (this.tabs.colorActive) {
          return this.colors;
        }
      },
    },
    async beforeRouteEnter(to, from, next) {
      next(vm => {
          vm.$store.dispatch('GetDropdownValues')
      })
    },
    methods: {
      ...mapActions(["CreateManufacturer", "DeleteManufacturer", "CreateType", "DeleteType", "CreateColor", "DeleteColor"]),
      setActive(tabNumber) {
        this.tabs.manufacturerActive = false;
        this.tabs.typeActive = false;
        this.tabs.colorActive = false;

        switch(tabNumber) {
          case 1:
            this.tabs.manufacturerActive = true;
            break;
          case 2:
            this.tabs.typeActive = true;
            break;
          case 3:
          this.tabs.colorActive = true;
            break;
        }
      },
      async addProperty() {
        this.isAddMode = true;
        let property = {
          name: this.newPropertyName
        }
        await this.saveProperty(property)
      },
      editProperty(property) {
        this.$set(property, 'editMode', true) 
        this.isAddMode = false
      },
      async saveProperty(property) {
        if (this.tabs.manufacturerActive) {
          await this.CreateManufacturer({
            manufacturer: property,
            isAddMode: this.isAddMode
          });
        } else if (this.tabs.typeActive) {
          await this.CreateType({
            type: property,
            isAddMode: this.isAddMode
          });
        } else if (this.tabs.colorActive) {
          await this.CreateColor({
            color: property,
            isAddMode: this.isAddMode
          });
        }
        this.isAddMode = false;
        this.newPropertyName = '';
      },
      async deleteProperty(propertyId) {
        if (this.tabs.manufacturerActive) {
         await this.DeleteManufacturer(propertyId);
        } else if (this.tabs.typeActive) {
          await this.DeleteType(propertyId);
        } else if (this.tabs.colorActive) {
          await this.DeleteColor(propertyId);
        }
      }
    }
};
</script>