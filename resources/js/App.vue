<template>
  <v-app id="appl">
      <AppLayout />
  </v-app>
</template>

<script lang="ts">
import Vue from 'vue'
import { Component } from 'vue-property-decorator'
import Settings from '@/settings'
import axios, { AxiosInstance } from "axios";
import AppLayout from '@/layout/AppLayout.vue'

declare module 'vue/types/vue' {
  export interface Vue {
   $axios: AxiosInstance;
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

   setupAxios() {
    const instance = axios.create({
      baseURL: "/x",
    });

    instance.interceptors.request.use((request) => {
      if (request.data == null) {
        request.data = {};
      }

      request.data["method"] = request.method?.toUpperCase();
      request.data["url"] = request.url;
      request.url = "";
      request.method = "post";
      return request;
    });

    instance.interceptors.response.use(
      (response) => {
        // Any status code that lie within the range of 2xx cause this function to trigger
        // Do something with response data
        console.log(response);
        return response;
      },
      (error) => {
        if (error.response.status === 401 || error.response.status === 404) {
          /* this.$router.go(0); */
        }
        return Promise.reject(error);
      }
    );
    Vue.prototype.$axios = instance;
  }
}
</script>
