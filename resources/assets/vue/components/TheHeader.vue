<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { State, namespace } from 'vuex-class';
import { BIconArrowLeftShort} from 'bootstrap-vue';

import TheSettings from './TheSettings.vue';

const aStore = namespace('auth');

@Component({
  components: {
    TheSettings,
    BIconArrowLeftShort
  },
})
export default class TheHeader extends Vue {
  @State backUrl;
  @State menu;
  @aStore.State user;
  @aStore.Action logout;

  showSettings(): void {
    (<any>this.$refs.the_settings).$refs.modal.show();
  }

  get homePath() {
    return this.user.home_path;
  }

  get path(): string {
    return this.$route.name || '';
  }
}
</script>

<template lang="pug">
div
  b-navbar.navbar-expand-lg.bg-light(type='light', style='background-color: #f8f9fa;')
    b-container
      b-link.back-button.text-secondary(v-show='path !== homePath', :to='backUrl')
        b-icon-arrow-left-short(style='width: 30px; height: 30px;')

      b-navbar-brand(:to='homePath', :class='{"has-back": path !== homePath}')
        h6.logo TERRAN-TEST

      b-navbar-toggle(target='nav_collapse')

      b-collapse#nav_collapse(is-nav)
        b-navbar-nav.ml-auto
          b-nav-item.menu(
            v-for='item in menu',
            :key='item.key',
            @click.prevent='item.handler',
            href='#',
          ) {{ $t(item.text) }}

          b-nav-item-dropdown(:text='user.name')
            b-dropdown-item(
              @click='showSettings',
            ) {{ $t('strings.settings') }}

            b-dropdown-item(
              @click='logout',
            ) {{ $t('home.logout') }}
  the-settings(ref='the_settings')
</template>

<style scoped>
.has-back {
  padding-left: 15px;
}

.logo {
  margin: 0 0 !important;
}
</style>
