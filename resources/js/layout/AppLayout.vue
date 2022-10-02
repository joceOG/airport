<template>
  <v-app id="inspire">
   
   <!-- <v-navigation-drawer
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
    </v-navigation-drawer>-->

    <v-app-bar
      app
      height="110"
      color="white"
    >  
         <!--  <v-app-bar-nav-icon @click="drawer = !drawer" color="black"></v-app-bar-nav-icon> -->
      

          <v-img
            max-height="78"
            max-width="78"
            src="./assets/logo.png"
          ></v-img>
                           <v-spacer></v-spacer>
                          <v-row justify ="end" height="" style="margin-right:10px;">
                            <v-btn
                            v-show="e==0"
                            class="ma-3 bt1"
                            outlined
                            rounded
                            x-small
                            color=" rgb(0, 0, 51);"
                            @click="opensignin"
                            style="height:60px"
                          >
                          <h5 class="hbt"> SE CONNECTER</h5>
                          </v-btn>

                          <v-btn
                            v-show="e==0"
                            class="ma-3 bt1"
                            outlined
                            rounded
                            x-small
                            color=" rgb(0, 0, 51);"
                            @click="opensignup"
                            
                            style="height:60px"
                          >
                            <h5 class="hbt">S'INSCRIRE</h5>
                          </v-btn>

                              <v-btn
                              v-show="e==0"
                            class="ma-3 bt1"
                            outlined
                            rounded
                            x-small
                            color=" rgb(0, 0, 51);"
                            @click="goTo('/DashBoard')"
                            style="height:60px"
                          >
                            <h5 class="hbt">SE DECONNECTER</h5>
                          </v-btn>



                                <v-btn
                                style="margin-right:30px !important"
                                    icon
                                    class="ma-3"
                                    color="#314f8d"
                                    v-show="e == 1"
                                    
                                  >
                                    <v-icon  size="60">mdi-package-variant-closed</v-icon>
                                  </v-btn>

                            <v-menu
                              bottom

                              min-width="200px"
                              rounded
                              offset-y
                            >
                              <template v-slot:activator="{ on }">
                                <v-btn
                                  icon
                                  class="ma-3"
                                  x-large
                                  v-on="on"
                                  v-show="e == 1"
                                >
                                  <v-avatar
                                    color="brown"
                                    size="85"
                                  >
                                    <span class="white--text text-h6">{{ user.initials }}</span>
                                  </v-avatar>
                                </v-btn>
                              </template>
                              <v-card>
                                <v-list-item-content class="justify-center">
                                  <div class="mx-auto text-center">
                                    <v-avatar
                                      color="brown"
                                    >
                                      <span class="white--text text-h5">{{ user.initials }}</span>
                                    </v-avatar>
                                    <h3>{{ user.fullName }}</h3>
                                    <p class="text-caption mt-1">
                                      {{ user.email }}
                                    </p>
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn
                                      depressed
                                      rounded
                                      text
                                    >
                                      PAREMETRES
                                    </v-btn>
                                    <v-divider class="my-3"></v-divider>
                                    <v-btn
                                      depressed
                                      rounded
                                      text
                                    >
                                      DECONNEXION
                                    </v-btn>
                                  </div>
                                </v-list-item-content>
                              </v-card>
                            </v-menu>
                      </v-row>
    </v-app-bar>

    <v-container
              class="fill-height"
              style="width:100px; padding:0px;"
              fluid
            >
                <router-view/>
    </v-container>
    <v-footer
      color="primary darken-2"
      app
    >
      <v-container class="pa-0" fluid>
        <v-row dense>
          <v-col class="pa-0">
          <span class="white--text text-caption">&copy; Koli Ko </span>
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
import { EventBus } from "@/event_bus";
import axios, { AxiosInstance } from "axios";
import { Component, Watch } from 'vue-property-decorator'
import { Route } from 'vue-router'
@Component
export default class layout extends Vue {
    drawer = false ;
    version = Settings.version
    route:string|null|undefined = null
     e = 0
     dialog = false
    links = [
        'Sign In',
        'Sign Up',
        'Next',
      ]
      items = [
          { title: 'Dashboard', icon: 'mdi-view-dashboard' },
          { title: 'Photos', icon: 'mdi-image' },
          { title: 'About', icon: 'mdi-help-box' },
        ]
      user = {
        initials: 'JD',
        fullName: 'John Doe',
        email: 'john.doe@doe.com',
      }
    mounted () {
        this.route = this.$route.name
        EventBus.$on("edash" , this.edash) ;
        EventBus.$on("efirst" , this.efirst) ;
    }
    edash(){
      console.log('Change e dash ')
      this.e = 1
    }
     efirst(){
      console.log('Change e')
      this.e = 0
    }

    opensignin() {
          EventBus.$emit("signin") ;
    }
    opensignup(){
          EventBus.$emit("signup") ;
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

<style>
.bt1:hover {
  background: rgb(0, 0, 51);
  color: rgb(255, 255, 255);
}
.hbt:hover{
  color: rgb(255, 255, 255);
}
</style>
