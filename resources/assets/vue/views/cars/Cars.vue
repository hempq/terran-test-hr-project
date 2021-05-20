<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action, namespace } from 'vuex-class';
import { BIconSearch,BIconArrowsCollapse } from 'bootstrap-vue';

import dialog from '@/utils/dialog';

import CarsCard from './components/CarsCard.vue';
import CarsModal from './components/CarsModal.vue';

const uStore = namespace('cars');

@Component({
  components: {
    CarsCard,
    CarsModal,
    BIconSearch,
    BIconArrowsCollapse
  },
})
export default class Cars extends Vue {
  @Action setBackUrl;
  @Action setMenu;
  @uStore.State cars;
  @uStore.State users;
  @uStore.State user;
  @uStore.State searchCache;
  @uStore.State userSearchName;
  @uStore.Action loadUsers;
  @uStore.Action loadUser;
  @uStore.State pagination;
  @uStore.State isLoading;
  @uStore.State isModalVisible;
  @uStore.Action deleteCar;
  @uStore.Action loadCars;
  @uStore.Action loadCarsSearch;
  @uStore.Action setModalVisible;
  @uStore.Action userNameToCarSearch;

  currentPage = 1;
  form: Partial<Car> = {};
  search: Partial<SearchForm>={};
  isModalAdd = true;
  visible = false;

  async created() {
    console.log(this.cars);
    
    if(this.userSearchName !==''){
      this.search={
        brand:'',
        license_plate_number:'',
        user:this.userSearchName,
    }
      this.searchCache.user = this.userSearchName;
      this.userNameToCarSearch('');
      this.getCars(1, this.search)
    }

    this.search={
      brand:this.searchCache.brand,
      license_plate_number:this.searchCache.license_plate_number,
      user:this.searchCache.user,
    }

    if(this.searchCache.brand !=='' || this.searchCache.license_plate_number !=='' || this.searchCache.user !==''){
      this.visible = true;
    }
    
    this.setBackUrl('/');
    this.setMenu([
      {
        key: 'add_car',
        text: 'cars.add_car',
        handler: this.addCar,
      },
    ]);

    this.currentPage = this.pagination.currentPage;

    if(Object.keys(this.user).length === 0){
      await this.loadUser(); 
    }

    if (this.cars.length == 0) {
      await this.getCars(1, this.search);
    }

    if (this.users.length == 0) {
      await this.loadUsers();
    }
  }

  addCar(): void {
    this.isModalAdd = true;
    this.setModalVisible(true);

    this.form = {
      status_id: 1,
      user_id: this.user.id,
    };
  }

  editCar(car: Car): void {
    this.isModalAdd = false;
    this.setModalVisible(true);

    this.form = { ...car };
  }

  async deleteCarConfirm(car: Car): Promise<void> {
    if (!(await dialog('front.delete_car_confirmation', true))) {
      return;
    }

    this.deleteCar(car);
  }

  async getCars(page: number, search:SearchForm): Promise<void> {
    if (search.brand === '' && search.license_plate_number ==='' && search.user ==='') {
      this.loadCars({ page });
    }else{
      this.loadCarsSearch({ 'page': page , 'search': search});
    }
  }
}
</script>

<template lang="pug">
b-container(tag='main')
  div
    b-button.mb-3(
      variant="info"
      v-b-toggle.search)
      b-icon-arrows-collapse
      | &nbsp;{{ $t('buttons.search') }}
  b-collapse#search( v-model="visible" )
    b-form(content-cols-sm)
        b-form-group
          b-form-input(
            :placeholder="$t('cars.brand')",
            v-model='search.brand',
            type="text",
        )   
        b-form-group
          b-form-input(
            :placeholder="$t('cars.license_plate_number')",
            v-model='search.license_plate_number',
            type="text",
        )
        b-form-group( v-if="user.type_id == 1")
          b-form-input(
            :placeholder="$t('cars.user')",
            v-model='search.user',
            type="text",
        )
        b-form-group
          b-button(
            variant="primary"
            @click="getCars(1, search)")
            b-icon-search

  b-pagination(
    align='center',
    v-if='pagination.totalCars > pagination.perPage',
    v-model='currentPage',
    :per-page='pagination.perPage',
    :total-rows='pagination.totalCars',
    @change="getCars(currentPage, search)",
  )

  .cars(v-if='cars.length > 0')
    cars-card(
      v-for='car, i in cars',
      :key='car.id',
      :car='car',
      @edit-car='editCar(car, i)',
      @delete-car='deleteCarConfirm(car)',
    )

  div(v-else-if='isLoading') {{ $t('strings.loading') }}...

  div(v-else) {{ $t('cars.no_cars') }}

  b-pagination(
    align='center',
    v-if='pagination.totalCars > pagination.perPage',
    v-model='currentPage',
    :per-page='pagination.perPage',
    :total-rows='pagination.totalCars',
     @change="getCars(currentPage, search)",
  )

  cars-modal(
    ref='cars_modal',
    :form='form',
    :is-add='isModalAdd',
    :is-visible='isModalVisible',
  )
</template>

<style scoped>
#search {
  width: 40%;
}
</style>