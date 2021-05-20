<script lang="ts">
import { Component, Prop, Vue } from 'vue-property-decorator';
import { BIconPencilFill, BIconTrashFill } from 'bootstrap-vue';

@Component({
  components: {
    BIconPencilFill,
    BIconTrashFill,
  },
})
export default class CarsCard extends Vue {
  @Prop() car: any;

  get actualUser() {
    return this.$store.state.auth.user;
  }
}
</script>

<template lang="pug">
b-card.cars-card.mb-3(no-body)
  h4(slot='header') {{ car.license_plate_number }}

  b-card-body
    p.card-text
      span.font-weight-bold {{ $t('cars.license_plate_number') }}:
      | &nbsp;{{ car.license_plate_number }}
      br/
      span.font-weight-bold {{ $t('cars.brand') }}:
      | &nbsp;{{ car.brand }}
      br/
      span.font-weight-bold {{ $t('cars.vintage') }}:
      | &nbsp;{{ car.vintage }}
      br/
      span.font-weight-bold {{ $t('cars.smd') }}:
      | &nbsp;{{ car.smd }}
      br/
      span.font-weight-bold {{ $t('cars.user') }}:
      | &nbsp;{{ car.user.name }}
      br/
      span.font-weight-bold {{ $t('cars.status') }}:
      | &nbsp;{{ car.status_id === 1 ? $t('strings.active') : $t('strings.inactive') }}

  b-card-footer
    b-button(@click='$emit("edit-car")', variant='link')
      b-icon-pencil-fill
      | &nbsp;{{ $t('buttons.edit') }}

    b-button.text-danger(
      @click='$emit("delete-car")'
      variant='link')
      b-icon-trash-fill
      | &nbsp;{{ $t('buttons.delete') }}
</template>

<style lang="scss" scoped>
.card-footer {
  display: flex;
  justify-content: flex-end;
  button {
    display: flex;
    align-items: center;
  }
}
</style>
