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
          <h4 class="pen-heading">My Account</h4>
          <div v-for="tab in tabs" @click="selectedTab = tab.title" :class="{ active : selectedTab == tab.title }" class="tab-item">
            <h3 class="tab-item__heading">{{ tab.title }}</h3>
          </div>
      </div>
      <div class="col-md-9">
        <template v-if="selectedTab == 'Credit Application'">
          <h3 class="tab-content__header">Process applicants faster</h3>
          <p class="tab-content__text">Eliminate paper shuffling and data entry by sending applicants to a branded online credit application in seconds.</p>
          <a href="" class="tab-content__btn">Learn about the online credit application</a>
          <p class="tab-content__testimonial">
            "This service is incredible. The information is current and user-friendly. What a gem in the credit world!"
          </p>
          <p class="tab-content__testimonial-author">
            Penny Everest, Valiant Products Corporation
          </p>
          <img class="tab-content__testimonial-img" src="http://18.216.223.98/wp-content/uploads/2017/12/Valiant-Products.png">
        </template>
        <template v-if="selectedTab == 'Decision Assistant'">
          <h3 class="tab-content__header">Approve more applicants</h3>
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
        <template v-if="selectedTab == 'Lifetime Monitoring'">
          <h3 class="tab-content__header">Stay up-to-date with customers</h3>
          <p class="tab-content__text">Process more applications by automatically filtering which applicants are easy approvals and which need more attention.</p>
          <a href="" class="tab-content__btn">Learn about Lifetime Monitoring</a>
          <p class="tab-content__testimonial">
            "This service is incredible. The information is current and user-friendly. What a gem in the credit world!"
          </p>
          <p class="tab-content__testimonial-author">
            Penny Everest, Valiant Products Corporation
          </p>
          <img class="tab-content__testimonial-img" src="http://18.216.223.98/wp-content/uploads/2017/12/Valiant-Products.png">
        </template>
        <template v-if="selectedTab == 'Data Reporting'">
          <h3 class="tab-content__header">Get customers to pay on time</h3>
          <p class="tab-content__text">Process more applications by automatically filtering which applicants are easy approvals and which need more attention.</p>
          <a href="" class="tab-content__btn">Learn about Data Reporting</a>
          <p class="tab-content__testimonial">
            "This service is incredible. The information is current and user-friendly. What a gem in the credit world!"
          </p>
          <p class="tab-content__testimonial-author">
            Penny Everest, Valiant Products Corporation
          </p>
          <img class="tab-content__testimonial-img" src="http://18.216.223.98/wp-content/uploads/2017/12/Valiant-Products.png">
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



  </v-container>
          
</template>

<script lang='ts'>
import Vue from 'vue'
import { Component } from 'vue-property-decorator'
import { EventBus } from "@/event_bus";

@Component
export default class Dashboard extends Vue {
  
tabs= [
      {
        title: "Credit Application",
        subtitle: "Process applicants faster"
      },
      {
        title: "Decision Assistant",
        subtitle: "Approve more applicants"
      },
      {
        title: "Lifetime Monitoring",
        subtitle: "Stay up-to-date with customers"
      }
    ] ; 
    selectedTab="Credit Application"


  mounted(){
    console.log("Mounted Dash");
    EventBus.$emit("edash") ;
  }

   selectTab(x : any) {
      this.selectedTab = this.tabs[x].title;
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

