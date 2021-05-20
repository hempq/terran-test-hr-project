<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action } from 'vuex-class';

import dialog from '@/utils/dialog';
import formValidation from '@/utils/formValidation';
import checkResponse from '@/utils/checkResponse';

@Component
export default class AuthRegister extends Vue {
  @Action setDialogMessage;

  form = {};
  isSending = false;
  terms = false;

  async doRegister() {
    const response = await this.axios.post('register', this.form);

    const checkErrors = checkResponse(response);

    if (checkErrors) {
      this.setDialogMessage(checkErrors.message);
      return;
    }

    this.setDialogMessage('login.account_created');

    this.$router.push({ name: 'auth.login' });
  }

  async register(evt: Event) {
    if (!formValidation(evt)) return;

    this.isSending = true;

    try {
      await this.doRegister();
    } catch {
      this.setDialogMessage('errors.generic_error');
    }

    this.isSending = false;
  }

  isDisabled(){
    return !this.terms;
  }


}
</script>

<template lang="pug">
b-form(@submit='register')
  .title {{ $t('login.register') }}

  b-form-group(
    :label='$t("strings.name")'
    label-for='name',
  )
    b-form-input(
      type='text',
      v-model='form.name',
      maxlength='191',
      required,
      autofocus,
    )

  b-form-group(
    :label='$t("strings.email")'
    label-for='email',
  )
    b-form-input(
      type='email',
      v-model='form.email',
      name='email',
      maxlength='191',
      required,
    )

  b-form-group(
    :label='$t("strings.phone")'
    label-for='phone',
  )
    b-form-input(,
      v-model='form.phone',
      name='phone',
      maxlength='191',
    )
  
  b-form-group(
    :label='$t("strings.password")'
    label-for='password',
  )
    b-form-input(
      type='password',
      v-model='form.password',
      name='password',
      required,
    )

  b-form-group(
    :label='$t("settings.password_confirmation")'
    label-for='password_confirmation',
  )
    b-form-input(
      type='password',
      v-model='form.password_confirmation',
      name='password_confirmation',
      required,
    )

  b-form-group#boxes
    .d-flex.justify-content-between.align-items-center
      b-form-checkbox(
        v-model='terms',
        checked-value=true,
        unchecked-value=false,
      ) {{ $t('settings.general_terms_and_conditions') }}


  b-form-group
    b-button(
      type='submit',
      variant='primary',
      :disabled='isDisabled()',
      :class='{ disabled: isSending }',
    ) {{ $t('login.register') }}
</template>
