<script lang="ts">
import { Component, Prop, Vue } from "vue-property-decorator";
import { namespace } from "vuex-class";

const uStore = namespace("cars");

@Component
export default class CarsModal extends Vue {
  @Prop() form;
  @Prop() isAdd;
  @Prop() isVisible;
  @uStore.State users;
  @uStore.State cars;
  @uStore.State user;
  @uStore.Action addCar;
  @uStore.Action editCar;
  @uStore.Action loadUsers;
  @uStore.Action loadUserRole;
  @uStore.Action setModalVisible;
  @uStore.State isModalLoading;

  handleOk() {
    if (this.isAdd) {
      this.addCar(this.form);
    } else {
      this.editCar(this.form);
    }
  }

  handleClose() {
    this.setModalVisible(false);
  }
}
</script>

<template lang="pug">
b-modal(
  hide-header-close,
  :visible="isVisible",
  :cancel-title="$t('buttons.cancel')",
  :ok-disabled="isModalLoading",
  :ok-title="isModalLoading ? $t('buttons.sending') : isAdd ? $t('buttons.add') : $t('buttons.update')",
  :title="isAdd ? $t('cars.add_cars') : $t('cars.edit_cars')",
  @hide="handleClose",
  @ok.prevent="handleOk"
)
  b-form
    b-form-group(:label="$t('cars.license_plate_number')", label-for="license_plate_number")
      b-form-input#license_plate_number(
        type="text",
        v-model="form.license_plate_number",
        maxlength="191",
        required
      )
  b-form
    b-form-group(:label="$t('cars.brand')", label-for="brand")
      b-form-input#brand(
        type="text",
        v-model="form.brand",
        maxlength="191",
        required
      )
  b-form
    b-form-group(:label="$t('cars.vintage')", label-for="vintage")
      b-form-input#smd(
        type="number",
        v-model="form.vintage",
        maxlength="191",
        required
      )    
  b-form
    b-form-group(:label="$t('cars.smd')", label-for="smd")
      b-form-input#smd(
        type="number",
        v-model="form.smd",
        maxlength="191",
        required
      )

    .user-selects(v-if="users.length > 0")
    b-form-group(:label="$t('strings.user')", label-for="user", v-if="user.type_id == 1")
      b-form-select#user(v-model="form.user_id",)
          option(v-for='user, i in users',:value='user.id') {{ user.name }}

    b-form-group(:label="$t('cars.status')")
      b-form-radio-group(v-model.number="form.status_id", name="status_id")
        b-form-radio(value=1) {{ $t('strings.active') }}
        b-form-radio(value=2) {{ $t('strings.inactive') }}
</template>