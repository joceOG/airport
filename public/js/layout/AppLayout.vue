<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-model="drawer"
      app
    >

      <v-list dense width="500">
        <v-list-item link @click="goTo('/')">
          <v-list-item-action>
            <v-icon>mdi-view-list</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Accueil <v-icon v-if="route == 'FirsPage'" color="primary">mdi-circle-small</v-icon></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item link @click="goTo('/AxiosTest')">
          <v-list-item-action>
            <v-icon>mdi-view-list</v-icon>
          </v-list-item-action>
          <v-list-item-content>
            <v-list-item-title>Test Axios <v-icon v-if="route == 'AxiosTest'" color="primary">mdi-circle-small</v-icon></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <v-app-bar
      app
      color="primary darken-2"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title>Uniskip</v-toolbar-title>
      <v-spacer />
    </v-app-bar>

    <v-main>
            <v-container
              class="fill-height"
              fluid
            >
              <v-row
                align="start"
                justify="center"
                class="fill-height"
              >
                <router-view/>
              </v-row>
            </v-container>
    </v-main>
    <v-footer
      color="primary darken-2"
      app
    >
      <v-container class="pa-0" fluid>
        <v-row dense>
          <v-col class="pa-0">
          <span class="white--text text-caption">&copy; Uniskip</span>
          </v-col>
          <v-col class="pa-0">
            <span class="white--text text-caption d-flex flex-row-reverse" stye="position:absolute; right:20px">v{{version}}</span>
          </v-col>
        </v-row>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue'
import Settings from '@/settings'
import { Component, Watch } from 'vue-property-decorator'
import { Route } from 'vue-router'

@Component
export default class layout extends Vue {
    drawer = null
    version = Settings.version
    route:string|null|undefined = null

    mounted () {
        this.route = this.$route.name
    }

    logout () {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        this.$router.go(0)
    }

    goTo (path: string) {
        this.$router.push(path)
    }

    @Watch('$route')
    onRoute(to: Route) {
        this.route = to.name
    }
}
</script>
