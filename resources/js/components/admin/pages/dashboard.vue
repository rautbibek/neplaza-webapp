<template>
  <v-app id="inspire" >
    <admin-sidebar></admin-sidebar>
      <v-container class="my-5" style="min-height:600px;">
        <div class="mt-5"></div>
        <!-- first row -->


        <v-row>
          <v-col class="sizing" cols="12" sm="12" md="4" lg="4" >
            <v-alert 
              color="#2A3B4D"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>TOTAL PRODUCT</P>
              <h5>{{report.total_product}}</h5>
            </v-alert>
          </v-col>

          <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
            <v-alert
              color="deep-purple accent-4"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>FEATURED PRODUCT</P>
              <h5>{{report.featured_product}}</h5>
            </v-alert>
          </v-col>
          <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
            <v-alert
              color="purple darken-1"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>URGENT PRODUCT</P>
              <h5>{{report.urgent_product}}</h5>
            </v-alert>
          </v-col>
          
          
          <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
           
          </v-col>
          
          
        </v-row>



        <!-- second row -->
        <v-row>
            <v-col cols="8" style="padding-left:0px; padding-top:0px">
                <v-card
                    class="mx-auto text-center"
                    color="brown "
                    dark
                    height="375"
                  >
                    <v-card-text>
                      <v-sheet color="rgba(0, 0, 0, .12)">
                        <v-sparkline
                          :value="value"
                          :labels="labels"
                          color="rgba(255, 255, 255, .7)"
                          height="100"
                          padding="24"
                          stroke-linecap="round"
                          smooth
                        >
                          <template v-slot:label="item">
                            {{ item.value }}
                          </template>
                        </v-sparkline>
                      </v-sheet>
                    </v-card-text>
                  </v-card>
            </v-col>
            <v-col style="padding-left:0px; padding-top:0px; padding-bottom:0px" cols="4">
               <v-col style="margin:0px; padding:0px">
            <v-alert
              color="success"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>USERS</P>
              <p>{{user_count}}</p>
              <v-row no-gutters>
                <v-col cols="8">
                  <v-text-field dense
                  outlined
                  v-model="day"
                  label="enter the day"
                  required
                  
                ></v-text-field>
                </v-col>
                <v-col cols="3" class="mt-2"><v-icon right @click="dayUser">mdi-account-circle</v-icon></v-col>
              </v-row>
            </v-alert>
          </v-col>
          <v-col style="margin:0px; padding:0px">
            <v-alert
              color="info"
              dark
              icon="chrome_reader_mode"
              border="left"
              prominent
            >
              <P>PRODUCTS</P>
              <p>{{product_count}}</p>
              <v-row no-gutters>
                <v-col cols="9">
                  <v-text-field dense
                  outlined
                  v-model="product_day"
                  label="enter the day"
                  required
                  
                ></v-text-field>
                </v-col>
                <v-col cols="3" class="mt-2"><v-icon right @click="productDay">save</v-icon></v-col>
              </v-row>
            </v-alert>
          </v-col>
            
            
            </v-col>
        </v-row>


        
        <!-- third row -->
        <v-row>
          <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
            <v-alert
              color="red darken-2"
              dark
              dense
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>DELETED PRODUCT</P>
              <h5>{{report.deleted_product}}</h5>
            </v-alert>
          </v-col>
          <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
              <v-alert dense
              color="#C51162"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>TOTAL SELLER</P>
              <h5>{{report.total_seller}}</h5>
            </v-alert>
            </v-col>
            <v-col class="sizing" cols="12" sm="12" md="4" lg="4">
              <v-alert dense
              color="indigo darken-4"
              dark
              icon="mdi-account-circle"
              border="left"
              prominent
            >
              <P>TOTAL USER</P>
              <h5>{{report.total_user}}</h5>
            </v-alert>
            </v-col>
        </v-row>
        <v-col class="text-center"> <v-btn color="error" @click="cache_clear">Cache Clear</v-btn></v-col>
      </v-container>
    <dialog-component></dialog-component>
  </v-app>
</template>
<script>
export default {
  data(){
    return{
      day:0,
      user_count:0,
      total_user:0,
      product_day:0,
      product_count:0,
      total_featured:0,
      total_urgent:0,
      total_deleted:0,
      seller:0,
      report:{},
      value: [
        423,
        446,
        675,
        510,
        590,
        610,
        760,
        423,
        446,
        675,
        510,
        590,
      ],

      labels: [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
      ],
      

    }
  },
  methods:{
    dayUser(){
      axios.get(`dayuser/${this.day}`)
      .then(response=>{
        this.user_count = response.data;
      })
      .catch();
    },
    productDay(){
      axios.get(`productday/${this.product_day}`)
      .then(response=>{
        this.product_count = response.data;
      })
      .catch();
    },

    countAll(){
      axios.get(`count/all`)
           .then(response=>{
            this.report = response.data;
           })
           .catch();
    },
    cache_clear(){
      this.overlay = true;
      axios.post(`/admin/cache/clear`).then(response=>{
        this.$toast.success(response.data, 'success', {
              timeout: 3000,
              position: 'topRight',
        });
        this.overlay = false;
      }).catch()
    }

  },
  created(){
     this.dayUser();
     this.productDay();
     this.countAll();
  }
}
</script>
<style scoped>
  .sizing{
    margin:0px;
    padding-bottom:0px;
    padding-top:0px;
    padding-left: 0px;
  }
</style>