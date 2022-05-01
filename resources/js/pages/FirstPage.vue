<template>
<v-container fluid class="fapp" style="padding:0px;"
  >
    <v-img
     style="width:100%;"
     height="480"
      src="https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fs3.amazonaws.com%2Fappforest_uf%2Ff1554118961164x887111650567160600%2Fmargo-brodowicz-183156-unsplash.jpg?w=2048&h=&auto=compress&dpr=1.25&fit=max"
    >
     <p class="" style="text-align: center ; margin-top:140px;"> <b><h1 style="font-size:65; color: rgb(0, 0, 51);" >Koli&Co</h1></b></p>
     <p class="" style="margin-top:-10px;text-align: center ; color: rgb(0, 0, 51);font-size:25;">Le service d'expédition PAR VOUS et POUR VOUS</p>
     <div class="" style="text-align: center;">
        <v-btn  width="550" color="white" dark>
         <h4 style="text-align: center ; color: rgb(0, 0, 51);">POSTER UNE ANNONCE</h4>
       </v-btn>
       <v-btn  style="margin-top: 10px;" width="550" color="white" dark>
         <h4 style="text-align: center ; color: rgb(0, 0, 51);">FAIRE UN ENVOI</h4>
       </v-btn>
    </div>
    </v-img>

    <v-img
        style="width:100%;
                padding:0px;
                height:350;"
        src="https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fs3.amazonaws.com%2Fappforest_uf%2Ff1554128302877x357628346214163840%2Fnasa-43563-unsplash%2520%25D0%25BA%25D0%25BE%25D0%25BF%25D0%25B8%25D1%258F.jpg?w=768&h=804&auto=compress&fit=crop&dpr=1.25"
            >
            <v-row style="margin-left:100px; text-align-center;">
            <v-col style="color:white">
            <center>
            <v-img
                style="margin-top:45px;"
                src="https://dd7tel2830j4w.cloudfront.net/f1554127872904x712962974095812700/035-booking.svg"
                height="50"
                width="50"
                ></v-img>

                <h4 style="margin-top:15px;">Easy Way To Seach Tickets</h4>
                <p style="margin-top:15px;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                </p></center>
            </v-col>
            <v-col style="color:white">
            <center>
            <v-img
                style="margin-top:45px;"
                src="https://dd7tel2830j4w.cloudfront.net/f1554127897952x720595305028315600/018-choice.svg"
                height="50"
                width="50"
                ></v-img>

                <h4 style="margin-top:15px;">Easy Way To Seach Tickets</h4>
                <p style="margin-top:15px;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                </p></center>
            </v-col>
            <v-col style="color:white">
            <center>
            <v-img
                style="margin-top:45px;"
                src="https://dd7tel2830j4w.cloudfront.net/f1554127933334x826969413992893300/046-coffee.svg"
                height="50"
                width="50"
                ></v-img>

                <h4 style="margin-top:15px;">Easy Way To Seach Tickets</h4>
                <p style="margin-top:15px;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
                </p></center>
            </v-col>
            <v-col >
            </v-col>
        </v-row>
    </v-img>

  </v-container>

</template>

<script lang='ts'>
import Vue from 'vue'
import { Component } from 'vue-property-decorator'

@Component
export default class FirstPage extends Vue {

}
</script>
<style>

.centrer {
  position: relative;
  left: 50%;
  transform: translateX(-50%);
}
</style>
