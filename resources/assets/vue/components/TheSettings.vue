<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { State, Action, namespace } from 'vuex-class';
import checkResponse from '@/utils/checkResponse'

import axios from 'axios';

import dialog from '@/utils/dialog';

const aStore = namespace('auth');

@Component
export default class TheSettings extends Vue {
  @Action setDialogMessage;
  @aStore.State user;

  isSending = false;
  okText = 'buttons.save';

  async handleOk() {
    this.isSending = true;
    this.okText = 'buttons.sending';

    try {
    const user = {
      name: this.user.name,
      email: this.user.email,
      phone: this.user.phone,
      type_id: this.user.type_id,
      status_id: this.user.status_id,
    };
    const response = await axios.put(`users/${this.user.id}`, user);
    const checkErrors = checkResponse(response);
    if(checkErrors){
      this.setDialogMessage(checkErrors.message);
    }
    } catch {
      this.resetState();
      this.setDialogMessage('errors.generic_error');
    }
    (<any>this.$refs.modal).hide();
    this.resetState();
  }

  resetState() {
    this.isSending = false;
    this.okText = 'buttons.save';
  }
}
</script>

<template lang="pug">
b-modal(
  hide-header-close=true,
  ref='modal',
  :cancel-title='$t("buttons.cancel")',
  :ok-disabled='isSending',
  :ok-title='$t(okText)',
  :title='$t("strings.settings")',
  @ok.prevent='handleOk'
)
  b-form
    b-form-group(
      :label='$t("strings.name")'
      label-for='name',
    )
      b-form-input(,
        v-model='user.name',
        name='name',
        maxlength='191',
      )
    b-form-group(
      :label='$t("strings.email")'
      label-for='email',
    )
      b-form-input(,
        v-model='user.email',
        name='email',
        maxlength='191',
      )  
    b-form-group(
      :label='$t("strings.phone")'
      label-for='phone',
    )
      b-form-input(,
        v-model='user.phone',
        name='phone',
        maxlength='191',
      )
</template>
