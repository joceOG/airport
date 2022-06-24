<template>
<v-container fluid class="fapp" style="padding:0px;"
  >
    <v-img
     style="width:100%;"
     height="1000"
      src="./assets/blank.jpg"
    >

 <p style="margin-top:140px;">

   <div id="v-tabs">

  <div class="container">
    <div class="row">
      <div class="col-md-3">
          <h4 class="pen-heading">Mes comptes</h4>
          <div v-for="tab in tabs" @click="selectedTab = tab.title" :class="{ active : selectedTab == tab.title }" class="tab-item">
            <h3 class="tab-item__heading"> <v-icon style="padding:10">mdi-school</v-icon> {{ tab.title }}</h3>
          </div>
      </div>
      <div class="col-md-9">
        <template v-if="selectedTab == 'Mes Details'">
          <h3 class="tab-content__header">My Details</h3>
          <p class="tab-content__text"> <h3><b>Personnal Information</b></h3> <v-divider height="5" style="border: solid 5px;"></v-divider></p>
          <v-row>
          <v-col cols="4">
                    <p class="tab-content__text2">Eliminate paper shuffling and data entry by sending applicants to a branded online credit application in seconds.</p>
          </v-col>
          <v-col cols="4">
                    <p class="tab-content__text">
                      <v-text-field
                        placeholder="FirstName"
                          v-model="firstName"
                          outlined
                          :rules="firstName"
                          label="First Name"
                          required
                      ></v-text-field>
                    </p>
          </v-col>
          <v-col cols="4">
                    <p class="tab-content__text">Eliminate paper shuffling and data entry by sending applicants to a branded online credit application in seconds.</p>
          </v-col>
          </v-row>
        </template>
        <template v-if="selectedTab == 'Mes Livraisons'">
          <h3 class="tab-content__header">Mes Livraisons</h3>
          <p class="tab-content__text">Process more applications by automatically filtering which applicants are easy approvals and which need more attention.</p>
          <a href="" class="tab-content__btn">Learn about the Decision Assistant</a>
          <p class="tab-content__testimonial">
            "This service is incredible. The information is current and user-friendly. What a gem in the credit world!"
          </p>
          <p class="tab-content__testimonial-author">
            Penny Everest, Valiant Products Corporation
          </p>
          <img class="tab-content__testimonial-img" src="http://18.216.223.98/wp-content/uploads/2017/12/Valiant-Products.png">
        </template>
        <template v-if="selectedTab == 'Mes Commandes'">
          <h3 class="tab-content__header">Mes Commandes</h3>
          <p class="tab-content__text">Process more applications by automatically filtering which applicants are easy approvals and which need more attention.</p>
          <a href="" class="tab-content__btn">Learn about the Decision Assistant</a>
          <p class="tab-content__testimonial">
            "This service is incredible. The information is current and user-friendly. What a gem in the credit world!"
          </p>
          <p class="tab-content__testimonial-author">
            Penny Everest, Valiant Products Corporation
          </p>
          <img class="tab-content__testimonial-img" src="http://18.216.223.98/wp-content/uploads/2017/12/Valiant-Products.png">
        </template>
        <template v-if="selectedTab == 'Je fais un envoi'">
          <h3 class="tab-content__header">JE FAIS UN ENVOI</h3>
          <v-row>
                    <v-col cols="2">                            
                          <v-img
                            style="display:inline-block;" 
                            class="centrer"   
                            width="100"
                            height="100"
                            src="./assets/logo.png"
                          ></v-img>
                    </v-col>

                    <v-col cols="3">
                              <h3 style="text-align: center; margin-top:10px;">JE FAIS UN ENVOI <br/></h3>

                                <v-form ref="form2" v-model="valid2" style="padding: 32; width=600px;" justify-content="center"   lazy-validation>
                                    <v-text-field placeholder="Type" v-model="type" outlined :rules="typeRules" label="Type" required ></v-text-field>
                                    <v-text-field placeholder="Categorie" v-model="categorie" outlined :rules="categorieRules" label="Categorie" required ></v-text-field>
                                    <v-text-field placeholder="Nombre de Kilos" v-model="nkilo" type="number" outlined :rules="nkiloRules" required ></v-text-field>
                                    <v-menu v-model="menu" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto" >
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-text-field v-model="date" label="Picker without buttons" prepend-icon="mdi-calendar"  readonly v-bind="attrs"  v-on="on"></v-text-field>
                                    </template>
                                    <v-date-picker v-model="date" @input="menu = false" ></v-date-picker>
                                    </v-menu>          
                              </v-form>                
                    </v-col>
                    <v-col cols="3">
                        <v-form style="padding: 32; width=600px;margin-top:30px;" justify-content="center" ref="form2" v-model="valid2" lazy-validation>
                              <v-text-field placeholder="Depart" v-model="depart" outlined  :rules="departRules" label="Depart" required ></v-text-field>
                              <v-text-field placeholder="Destination" v-model="destination" outlined  :rules="destinationRules"  label="Destitanation"  required ></v-text-field>                               
                                <v-text-field placeholder="Prix" v-model="prix" outlined  type="number"  label="Prix"  required ></v-text-field>
                              <v-divider></v-divider> 
                              <v-btn depressed outlined color="#314f8d"  @click="dialog = true;">ENVOYER</v-btn>
                             
                        </v-form>         
                    </v-col>

                            <v-col cols="4">
                                          <!-- <v-row>
                                            <v-subheader><b>Notifications :</b></v-subheader>
                                          </v-row>
                                          <v-container id="scroll-target" style="height: 3000px" class="overflow-y-auto">
                                            <v-row style="height: 300px">
                                              <v-list rounded>
                                                      <v-list-item-group
                                                        v-model="selectedItem"
                                                        color="primary"
                                                      >
                                                        <v-list-item
                                                          v-for="(item, i) in items"
                                                          :key="i"
                                                        >
                                                          <v-list-item-icon>
                                                            <v-icon v-text="item.icon"></v-icon>
                                                          </v-list-item-icon>
                                                          <v-list-item-content>
                                                            <v-list-item-title v-text="item.text"></v-list-item-title>
                                                          </v-list-item-content>
                                                        </v-list-item>
                                                      </v-list-item-group>
                                                    </v-list>
                                            </v-row>
                                          </v-container> -->
                              </v-col>     
            </v-row>
             
                  <v-snackbar :value="snack" timeout="2000" absolute centered color="primary" text right></v-snackbar>
                     {{notif}}
                  </v-snackbar>  

        </template>
       <template v-if="selectedTab == 'J\'ai des Kilos'">
          <v-row>
                <v-col cols="2">                            
                    <v-img style="display:inline-block;" class="centrer"  width="70" height="70" src="./assets/logo.png"></v-img>
                </v-col>     
                  <v-col cols="3">
                   <h3 style="text-align: center; margin-top:10px;">J'AI DES KILOS <br/></h3>
                      <v-form style="padding: 32; width=600px;" justify-content="center" ref="form" v-model="valid" lazy-validation>
                    
                                <v-text-field v-model="billet" placeholder="Billet" outlined :rules="billetRules" label="Billet" required></v-text-field>
                                <v-text-field placeholder="Espace" type="number" v-model="espace" outlined :rules="espaceRules" label="Espace" required ></v-text-field>
                                <v-text-field placeholder="Compagnie" v-model="compagnie" outlined :rules="compagnieRules" label="Compagnie" required></v-text-field>
 
                              <v-menu v-model="menuk" :close-on-content-click="false" :nudge-right="40" transition="scale-transition" offset-y min-width="auto">
                                <template v-slot:activator="{ on, attrs }">
                                   <v-text-field v-model="datek" label="Picker without buttons" prepend-icon="mdi-calendar"
                                                 readonly v-bind="attrs" v-on="on"
                                     ></v-text-field>
                                </template>
                                <v-date-picker v-model="datek" @input="menuk = false" ></v-date-picker>
                              </v-menu>
                      </v-form>
                  </v-col>
                  <v-col cols="3">
                          <v-form style="padding: 32; width=600px;margin-top:30px;" justify-content="center"
                               ref="form" v-model="valid" lazy-validation>
                           <v-text-field placeholder="" v-model="departk" outlined :rules="departkRules"
                                   label="Depart"  required        
                           ></v-text-field>                   
                           <v-text-field placeholder="Destination" v-model="destinationk"  outlined         
                                   :rules="destinationkRules"  label="Destitanation"  required         
                           ></v-text-field> 
                              <v-text-field placeholder="Categorie Accepted" v-model="categorie_accept"  outlined         
                                   :rules="categorieacceptRules"  label="Categorie Accepted"  required         
                           ></v-text-field> 
                             
                          <v-row>
                            <v-col cols="11">
                             <v-text-field placeholder="Categorie Accepted" v-model="categorie_accept"  outlined         
                                   :rules="categorieacceptRules"  label="Categorie Accepted"  required         
                             ></v-text-field>
                            </v-col>  

                              <v-col cols="1">
                                    <v-btn class="mx-2" fab dark small color="primary"
                                    >
                                      <v-icon dark>
                                        mdi-plus
                                      </v-icon>
                                    </v-btn>
                              </v-col>   
                          </v-row>
                           

                           
                          

                          

                             <v-divider></v-divider>
                           <v-btn depressed outlined color="#314f8d" @click="addAds()">
                                   ENVOYER           
                           </v-btn>                     
                        </v-form>              
                  </v-col>
                  <v-col cols="4">
                              <!-- <v-row>
                               <v-subheader><b>Notifications :</b></v-subheader>
                              </v-row>
                              <v-container id="scroll-target" style="height: 300px" class="overflow-y-auto">
                                <v-row style="height: 300px">
                                  <v-list rounded>
                                          <v-list-item-group
                                            v-model="selectedItem"
                                            color="primary"
                                          >
                                            <v-list-item
                                             v-for="(item, i) in items"
                                              :key="i"
                                            >
                                              <v-list-item-icon>
                                                <v-icon v-text="item.icon"></v-icon>
                                              </v-list-item-icon>
                                              <v-list-item-content>
                                                <v-list-item-title v-text="item.text"></v-list-item-title>
                                              </v-list-item-content>
                                            </v-list-item>
                                          </v-list-item-group>
                                        </v-list>
                                </v-row> 
                              </v-container> -->
                  </v-col>
                 <v-snackbar :value="snack" timeout="2000" absolute centered color="primary" text right></v-snackbar>
                     {{notif}}
                  </v-snackbar>  
          </v-row>
        </template>
      </div>
    </div>
  </div>
</div>
            </p>
    </v-img>

         <v-img
                style="width:100%;
                        padding:0px;
                      height:350;"
                src="https://d1muf25xaso8hp.cloudfront.net/https%3A%2F%2Fs3.amazonaws.com%2Fappforest_uf%2Ff1554128302877x357628346214163840%2Fnasa-43563-unsplash%2520%25D0%25BA%25D0%25BE%25D0%25BF%25D0%25B8%25D1%258F.jpg?w=768&h=804&auto=compress&fit=crop&dpr=1.25"
                 >
                 <v-form>

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

                      <h4 style="margin-top:15px;">Easy Way To Search Tickets</h4>
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
               </v-form>
          </v-img>
                 
            <v-dialog v-model="dialog" width="500">
               <v-card>
                  <h3 style="text-align: center">MATCHS<br/></h3>
                     

                    <v-card-actions>                   
                    </v-card-actions>
              </v-card>
          </v-dialog>
            
  </v-container>

</template>

<script lang='ts'>
import Vue from 'vue'
import { Component, Ref  } from 'vue-property-decorator'
import { EventBus } from "@/event_bus";
import { VForm } from "@/VForm";
import axios from "axios";

@Component
export default class Dashboard extends Vue {

  @Ref("form") readonly form!: VForm;
  @Ref("form2") readonly form2!: VForm;
    valid = true
    valid2 = true
     categorie = "";
     type = "";
     nkilo = 0 ;
     depart = "" ;
     destination = "" ;
     prix = "";
     categorieRules  = [(v: string) => !!v || "Categorie is required"];
     typeRules  = [(v: string) => !!v || "Billet is required"];
     nkiloRules  = [(v: string) => !!v || "Nombre de Kilo is required"];
     departRules  = [(v: string) => !!v || "Depart is required"];
     destinationRules  = [(v: string) => !!v || "Destination is required"];
     prixRules  = [(v: string) => !!v || "Prix is required"];

     billet = "";
     espace = 0;
     compagnie = "" ;
     destinationk = "" ;
     departk = "" ;
     categorie_accept = "";
 
     billetRules  = [(v: string) => !!v || "Billet is required"];
     espaceRules  = [(v: string) => !!v || "Espace is required"];
     compagnieRules  = [(v: string) => !!v || "Compagnie is required"];
     departkRules  = [(v: string) => !!v || "Depart is required"];
     destinationkRules  = [(v: string) => !!v || "Destination is required"];
    categorieacceptRules = [(v: string) => !!v || "Categorie Accepted is required"];
     snack = false
     firstName = ""
     notif = ""
     envoi = ["Notification 1"];
      selectedItem = 1
      items =  [
        { text: 'Real-Time', icon: 'mdi-clock' },
        { text: 'Audience', icon: 'mdi-account' },
        { text: 'Conversions', icon: 'mdi-flag' },
      ]

        date = (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10);
        datek = (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10);
        menuk = false;
        menu = false;
  
tabs= [
      {
        title: "Mes Details",
      },
      {
        title: "Mes Livraisons",
      },
      {
        title: "Mes Commandes",
      },
      {
        title: "Je fais un envoi",
      }
      ,
      {
        title: "J'ai des Kilos",
      }
    ] ; 
    selectedTab="Mes Details"
    dialog = false;


  mounted(){
    console.log("Mounted Dash");
    EventBus.$emit("edash") ;
  }

   selectTab(x : any) {
      this.selectedTab = this.tabs[x].title;
    }

    async addPackage(){
      this.form2.validate();
      const data = {
                  "package":{
                  "item": this.categorie,
                  "category": this.categorie,
                  "weight": this.nkilo,
                  "departure": this.depart,
                  "destination": this.destination,
                  "departure_date": this.date,
                  "price": this.prix,
                  }
                 };
      
            
       try {
          const result = await axios.post("http://127.0.0.1:8000/api/package/store" , data);
          const res = result.data
          console.log('res', res)
          if (res) {
             this.message()
          }
        } catch (err) {
          console.log(err);
        }   
   }

  async addAds(){
      this.form.validate();
      const data = {
                  "ad":{
                  "ticket_number": this.billet,
                  "travel_company ": this.compagnie,
                  "departure": this.departk,
                  "destination": this.destinationk,
                  "departure_date": this.datek,
                  "arrival_date": this.datek,
                  "space": this.espace,
                  "categories_accepted ": this.categorie_accept,
                  }
                 };
      
            
       try {
          const result = await axios.post("http://127.0.0.1:8000/api/ad/store" , data);
          const res = result.data
          console.log('res', res)
          if (res) {
             this.message2()
          }
        } catch (err) {
          console.log(err);
        }   
   }

    message(){

       this.categorie = ""
       this.categorie = ""
       this.nkilo = 0
       this.depart = ""
       this.destination = ""
       this.date =  (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10);
       this.notif = "Depart Enregisté Avec Succès" ;
       this.snack = true;
      // this.dialog = true;

     }

     message2(){

       this.billet = ""
       this.compagnie = ""
       this.departk = ""
       this.destinationk = ""
       this.espace = 0
       this.categorie_accept = ""
       this.datek =  (new Date(Date.now() - (new Date()).getTimezoneOffset() * 60000)).toISOString().substr(0, 10);
       this.notif = "Annonce Enregisté Avec Succès" ;
       this.snack = true;
     }

}
</script>
<style>

.fapp{
    width: 100%;
    left: 0px;
    position: absolute;
    box-sizing: border-box;
    z-index: 3;
    top: 35px;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 0px;
}

.centrer{
  position: relative;
  left: 50%;
  transform: translateX(-50%);
}

.pen-heading {
  font-weight: bold;
  font-size: 2em;
  text-align: center;
  margin-bottom: 40px;
  color: ##333;
}

.tab-item {
  background: white;
  border: 1px #D5DADF solid;
  border-left: 5px solid #D5DADF;
  box-shadow: 0 2px 3px rgba(213,218,223,0.35);
  padding: 10px;
  border-radius: 3px;
  cursor: pointer;
  transition: all .2s ease;
  margin-bottom: 15px;
}

.tab-item:hover, .tab-item.active {
  box-shadow: 0px 3px 3px 2px rgba(213,218,223,0.35);
  border-left: 5px solid #28AB26;
}

.tab-item__heading {
  font-weight: bold;
  font-size: 16px;
  line-height: 1.3em;
  letter-spacing: 0.02em;
  color: #314f8d;
  margin: 0px;
}

.tab-item__subheading {
  font-size: 18px;
  color: #333;
  margin: 0px;
}

.tab-content__header {
  color: #314f8d;
  font-weight: bold;
   margin: 0px 0px 30px;
  font-size: 36px;
  line-height: 1.3em;
  letter-spacing: 0.02em;
}

.tab-content__text {
  margin: 0px 0px 30px;
  font-size: 1.25em;
}

.tab-content__text2 {
  margin: 0px 0px 30px;
  font-size: 1.05em;
}

.tab-content__btn {
  display: inline-block;
  margin-bottom: 30px;
  padding: 16px 50px;
  cursor: pointer;
  text-decoration: none;
  font-size: 14px;
  text-transform: uppercase;
  font-weight: 900;
  position: relative;
  transition: all .3s ease;
  text-align: center;
  line-height: 1;
  border: 2px solid;
  border-radius: 3px;
  background-color: transparent;
  box-shadow: 0 2px 3px rgba(213,218,223,0.35);
  color: #24a926;
  fill: #24a926;
  border-color: #24a926;
}

.tab-content__btn:hover {
  color: #24a926;
  text-decoration: none;
  box-shadow: 0px 3px 3px 2px rgba(213,218,223,0.35);
}

.tab-content__testimonial {
  margin-bottom: 15px;
  font-size: 1em;
  color: rgba(0,0,0,.75);
  font-style: italic;
}

.tab-content__testimonial-author {
  margin-bottom: 5px;
  font-size: 1em;
  color: rgba(0,0,0,.75);
  font-weight: bold;
}

</style>
