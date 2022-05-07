<template>
  <v-app id="appl">
      <AppLayout />
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue'
import { Component } from 'vue-property-decorator'
import Settings from '@/settings'
import axios, { AxiosStatic } from 'axios'
import AppLayout from '@/layout/AppLayout.vue'

declare module 'vue/types/vue' {
  export interface Vue {
    $axios: AxiosStatic;
  }
}

@Component({
    components: {
        AppLayout
    }
})
export default class App extends Vue {
    mounted () {
        console.log('holle')
        this.setupAxios()
    }

    setupAxios () {
        const instance = axios.create({
            baseURL: Settings.serverUrl
        })

        instance.defaults.headers.authorization =
        'Bearer ' + localStorage.getItem('token')

        instance.interceptors.response.use(response => {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
            return response
        }, (error) => {
            if (error.response.status === 401 || error.response.status === 404) {
                localStorage.removeItem('token')
                localStorage.removeItem('user')
                this.$router.go(0)
            }
            return Promise.reject(error)
        })
        Vue.prototype.$axios = instance
    }
}
</script>
