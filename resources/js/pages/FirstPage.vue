<template>
 <v-container fluid class="fapp" style="padding:0px;"
  >  
    <v-img
     style="width:100%;"
     height="480"
      src="https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fs3.amazonaws.com%2Fappforest_uf%2Ff1554118961164x887111650567160600%2Fmargo-brodowicz-183156-unsplash.jpg?w=2048&h=&auto=compress&dpr=1.25&fit=max"
    >
     <p class="" style="text-align: center ; margin-top:140px;"> <b><h1 style="font-size:65; color: rgb(0, 0, 51);" >Koli&Co</h1></b></p>
     <p class="" style="margin-top:-10px;text-align: center ; color: rgb(0, 0, 51);font-size:25;">Le service d'expédition Par Vous et Pour Vous</p>
     <p class="" style="text-align: center">

       <v-btn  width="550" color="white" dark>     
         <h4 style="text-align: center ; color: rgb(0, 0, 51);"> AEROPORT</h4>      
       </v-btn>

     </p>
    </div>
    </v-img>

             <v-img
                style="width:100%; 
                        padding:0px; 
                      height:350;"
                src="https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fs3.amazonaws.com%2Fappforest_uf%2Ff1554128302877x357628346214163840%2Fnasa-43563-unsplash%2520%25D0%25BA%25D0%25BE%25D0%25BF%25D0%25B8%25D1%258F.jpg?w=768&h=804&auto=compress&fit=crop&dpr=1.25"      
                 >
                 <v-row style="margin-left:100px;">
                    <v-col >
                    </v-col>
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

           <v-dialog v-model="dialog" width="500">
               <v-card>
                  <h3 style="text-align: center">LOGIN/REGISTER <br/></h3>
                     <v-img style="display:inline-block;" class="centrer" width="100" height="100" src="./assets/logo.png"></v-img>
                       <h3 style="text-align: center">Sign In <br/></h3> 
                  <v-form style="padding: 32; width=300px;" justify-content="center" ref="form" v-model="valid" lazy-validation>
                          <v-alert v-show="showalert == true" class="ma-2" :type="typealert" dense><span style="font-size: 10px">{{ notif }}</span>
                        </v-alert>
                            <v-text-field
                            placeholder="Email"
                              v-model="email"
                              outlined
                              :rules="emailRules"
                              label="Email"
                              required
                          ></v-text-field>
                          <v-text-field
                            placeholder="Email"
                              type="password"
                              v-model="password"
                              outlined
                              :rules="passwordRules"
                              label="Password"
                              required
                          ></v-text-field>
                     </v-form>

                        <v-btn
                          class="ma-2 centrer"
                          color="primary"
                          @click="signin"
                        >
                        Sign In
                        </v-btn>

                    <center><p class="">  Don't have an account? <a>Sign Up</a></p></center>  <v-divider></v-divider>

                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn
                        color="primary"
                        text
                        @click="dialog2 = false"
                      >
                        I accept
                      </v-btn>
                    </v-card-actions>
              </v-card>
          </v-dialog>


    </v-container>
</template>

<script lang='ts'>
import Vue from 'vue'
import { Component, Ref } from 'vue-property-decorator'
import { EventBus } from "@/event_bus";
import { VForm } from "@/VForm";
import axios from "axios";


@Component
export default class FirstPage extends Vue {

   @Ref("form") readonly form!: VForm;
   @Ref("form2") readonly form2!: VForm;

  dialog = false
  dialog2 = false
  valid = true
  validsu = true
  email = "";
  password = "";
  emailRules = [
    (v: any) => !!v || "E-mail is required",
    (v: string) => /.+@.+\..+/.test(v) || "E-mail must be valid",
  ];
  passwordRules = [(v: string) => !!v || "Password is required"];
  confirmRules = [(v: string) => !!v || "Confirmation is required"];
  emailsu = "";
  passwordsu = "";
  confirmsu = "";
  emailsuRules = [
    (v: any) => !!v || "E-mail is required",
    (v: string) => /.+@.+\..+/.test(v) || "E-mail must be valid",
  ];
  passwordsuRules = [(v: string) => !!v || "Password is required"];
  confirmsuRules = [(v: string) => !!v || "Confirmation is required"];
  showalert = false;
  typealert = "success";
  notif = ""

    mounted(){
    console.log("Mounted First Page");
    EventBus.$emit("efirst") ;
    EventBus.$on("signin" , this.opsignin) ;
    EventBus.$on("signup" , this.opsignup) ;
   
  }


  
   opsignin(){
      this.dialog = true
   }

   opsignup(){
      this.dialog2 = true
   }

   async signup(){
      this.form2.validate();
      const data = {
                  "user":{
                  "first_name": this.emailsu,
                  "email": this.emailsu,
                  "password": this.passwordsu,
                  }
                 };

       try {
          const result = await axios.post("http://127.0.0.1:8000/api/user/store" , data);
          const res = result.data
          console.log('res', res)
          if (res) {
            this.message(res , 1)
          }
        } catch (err) {
          console.log(err);
        }   
   }

  async signin(){
      this.form.validate();
      const data = {
                  "user":{
                  "first_name": this.email,
                  "email": this.email,
                  "password": this.password,
                  }
                 };

       try {
          const result = await axios.post("http://127.0.0.1:8000/api/user/check" , data);
          const res = result.data
          console.log('res', res)
          if (res) {
             this.message(res , 2)
          }
        } catch (err) {
          console.log(err);
        }   
   }
    goTo (path: string) {
        this.$router.push(path)
    }
   message(payload:any , x:any){
 
      if( x = 1 )
      {      if (payload.status = true) {
                this.notif = "Inscription Reussie"; this.typealert = "success" ; this.showalert = true;                               
                setTimeout(() => { this.showalert = false; this.dialog = false;  this.goTo('/Dashboard'); }, 1500);     
                                                            
              }else{
                this.notif = "Inscription Echouée"; this.typealert = "error"; this.showalert = true;  
                setTimeout(() => { this.showalert = false; this.dialog = false; }, 1500);
              }
      }

      if( x = 2 )
      {         
              if (payload.status = true) {
                this.notif = "Connection Reussie"; this.typealert = "success";
                this.showalert = true; setTimeout(() => { this.showalert = false; this.dialog2 = false;  this.goTo('/Dashboard');}, 1500);   
              }else{
                this.notif = payload.message;  this.typealert = "error"; this.showalert = true;  
                setTimeout(() => { this.showalert = false; this.dialog2 = false; }, 1500);  }
      }

     }
}
</script>

<style>
.centrer{  
  position: relative;
  left: 50%;
  transform: translateX(-50%);
}
</style>