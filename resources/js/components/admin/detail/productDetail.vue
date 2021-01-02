<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">
      <hr>
      <h4 >Product detail</h4>
      <hr>
    <!-- table componsent -->
    <v-row>
        <v-row>
            <v-col cols="12"  lg="8" md="8" sm="12" xs="12" >
                        <ad-image :images="ad.product_image"></ad-image>
                        <ad-description :ad="ad"></ad-description>
            </v-col>
            
            <v-col cols="12" lg="4" md="4" sm="12" xs="12">
                 <div>
                    <!-- title price and like -->
                    <v-card tile>
                                    <v-card-title style="color:#cf0000">Rs. {{ad.product_price}} {{ad.product_max_price}}</v-card-title>
                                    <v-card-title class="my-0 py-0">{{ad.title}}</v-card-title>
                                    <v-card-text>
                                    <div>{{ad.created_date}}</div>
                                    </v-card-text>
                    </v-card>


                    <!-- user information -->
                    <v-card tile class="mt-3 text-center" >
                                    
                                    <v-col class="">
                                        <v-responsive>
                                            <v-avatar size="120">
                                            <img
                                                :src="ad.user.cover"
                                                :alt="ad.user.name"
                                            >
                                            </v-avatar>
                                        </v-responsive>
                                    </v-col>
                                    <v-list-item-content class="text-center">
                                    <v-list-item-title>{{ad.user.name}}</v-list-item-title>
                                    <small style="color:grey" class="my-1" >user since : {{ad.user.register_date}}</small>
                                    </v-list-item-content>
                                    <v-chip :href="`/admin/user/${ad.user.id}`"
                                        class="ma-2"
                                        color="indigo"
                                        text-color="white"
                                        >
                                        <v-avatar left>
                                            <v-icon>mdi-account-circle</v-icon>
                                        </v-avatar>
                                        User Detail

                                        <v-icon right>keyboard_arrow_right</v-icon>
                                    </v-chip>
                                    
                    </v-card>
                      
                    <!-- contact number -->
                    <v-card class="mt-3">
                                    <v-list-item-content class="text-center">
                                    <v-list-item-title class="mt-2">
                                        Contact Number :
                                        <v-icon small color="green"> phone</v-icon>
                                        {{ ad.user.contact_number}} 
                                    </v-list-item-title>
                                    </v-list-item-content>

                                    <v-card-text class="text-center" style="background-color:#3f51b5" v-if="ad.user.hide_contact ==true">
                                        <small class="my-1 text-white">Seller Set the Contact {{ad.user.contact_status}}</small>
                                    </v-card-text>
                    </v-card>
                    <!-- product id -->
                    <v-card class="mt-3" tile flat>
                                    <v-row>

                                        <v-col> <v-btn text>AD ID : #{{ad.productid}}</v-btn></v-col>
                                        <v-col class="text-right"> <report-ad :ads="ad"></report-ad>  </v-col>
                                    </v-row>            
                    </v-card>
                    
                </div>
            </v-col>
        </v-row>
    </v-row>
    <!-- featured ad -->
    <v-row v-if="ad.featured">
        <v-col cols="12" class="border my-3">
            <v-card-title>Feature ad Deadline</v-card-title>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Remailnin date time</th>
                        <th class="text-left">Created Date</th>
                        <th class="text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <v-chip small v-if="ad.featured.remaining_days<3"
                                        class="ma-2"
                                        color="red"
                                        text-color="white"
                                        >
                                        {{ad.featured.remaining_days}} day                               </v-chip>
                                <v-chip small v-else
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                        >
                                        {{ad.featured.remaining_days}} day                               </v-chip>
                                
                            </td>
                            <td>{{ad.featured.created_at}}</td>
                            <td>
                            <v-btn x-small text @click="delete_feature(ad.featured.id)">
                                <v-icon small>mdi-delete</v-icon>
                            </v-btn>
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>

            
        </v-col>
    </v-row>

    <!-- urgent ad -->
    <v-row v-if="ad.urgent">
        <v-col cols="12" class="border mb-3">
            <v-card-title>Urgent ad Deadline</v-card-title>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">Remailnin date time</th>
                        <th class="text-left">Created Date</th>
                        <th class="text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <v-chip small v-if="ad.urgent.remaining_days<3"
                                        class="ma-2"
                                        color="red"
                                        text-color="white"
                                        >
                                        {{ad.urgent.remaining_days}} day                                </v-chip>
                                <v-chip small v-else
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                        >
                                        {{ad.urgent.remaining_days}} day                               </v-chip>
                            </td>
                            <td>{{ad.urgent.created_at}}</td>
                            <td>
                            <v-btn x-small text @click="delete_urgent(ad.urgent.id)">
                                <v-icon small>mdi-delete</v-icon>
                            </v-btn>
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>

            
        </v-col>
    </v-row>
    <v-row class="mb-2">

        <v-col cols="12" md="6" lg="6" xs="12" class="border">
            <v-card-title class="text-center">Make this ad featured</v-card-title>
                <v-row>
                    <v-col cols="6">
                        <v-date-picker v-model="feature_expire_date" :show-current="false"></v-date-picker>
                
                    </v-col>
                    <v-col cols="6">
                        <v-card-text v-if="ad.featured" >
                            Remaining : {{ad.featured.remaining_days}} day                       </v-card-text>
                        <v-card-text v-else>
                        <p>{{feature_expire_date}}</p>
                        <v-btn color="indigo" @click="addFeatured" dark>save expiry date</v-btn>
                        </v-card-text>
                    </v-col>
                </v-row>
            
        </v-col>
        <v-col cols="12" md="6" lg="6" xs="12" class="border">
            <v-card-title>Make urgent sell ad</v-card-title>
                
                <v-row>
                    
                    <v-col cols="6">
                        <v-card-text v-if="ad.urgent" >
                            Remaining : {{ad.urgent.remaining_days}} days
                        </v-card-text>
                        <v-card-text v-else>
                        <p>{{urgent_expire_date}}</p>
                        <v-btn color="indigo" dark @click="addUrgent">save expiry date</v-btn>
                    </v-card-text>
                    </v-col>

                    <v-col cols="6">
                        <v-date-picker v-model="urgent_expire_date" :show-current="false"></v-date-picker>
                
                    </v-col>
                </v-row>
        </v-col>
    </v-row>

    <v-row v-if="ad.report" class="mb-5">
        <v-col cols="12" class="border mb-3">
            <v-card-title>Report by customer
                <v-spacer></v-spacer>
            <v-btn small dark color="indigo" href="/admin/report">All Reports</v-btn>
            </v-card-title>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th class="text-left">###</th>
                        <th class="text-left">Reported By</th>
                        <th class="text-left">Report Reason </th>
                        <th class="text-left">Description </th>
                        <th class="text-left">seen/unseen </th>
                        <th class="text-left">sent date </th>
                        <th class="text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(report,index) in ad.report" :key="index">
                            <td>{{index+1}}</td>
                            <td>
                                {{report.reported_by}}
                            </td>
                            <td>{{report.reason_for_report}}</td>
                            <td>{{report.description}}</td>
                            <td>
                                <v-chip small v-if="report.seen"
                                        class="ma-2"
                                        color="green"
                                        text-color="white"
                                        >
                                        seen
                                </v-chip>
                                <v-chip small v-else
                                        class="ma-2"
                                        color="red"
                                        text-color="white"
                                        >
                                        unseen
                                </v-chip>
                            </td>
                            <td>{{report.created}}</td>
                            <td>
                            <v-btn x-small text @click="delete_report(report.id)">
                                <v-icon small>mdi-delete</v-icon>
                            </v-btn>
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        </v-col>
    </v-row>
  </v-container>
  <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    props:['ad'],
    data: () => ({
      product_id:'',
      feature_expire_date:new Date().toISOString().substr(0, 10),
      urgent_expire_date:new Date().toISOString().substr(0, 10),
    }),
    methods:{
        addFeatured(){
            axios.post(`/admin/add/featured`,{
                expire_date:this.feature_expire_date,
                product_id:this.ad.id,
            })
                 .then(response=>{
                    this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                    });
                    
                 })
                 .catch(error=>{
                     this.$toast.error(error.response.data.message,'error' , {
                         timeout: 3000,
                         position: 'topRight',
                     });
                 })
        },
        addUrgent(){
            axios.post(`/admin/add/urgent`,{
                expire_date:this.urgent_expire_date,
                product_id:this.ad.id,
            })
                 .then(response=>{
                    this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                    });
                    
                 })
                 .catch(error=>{
                     this.$toast.error(error.response.data.message,'error' , {
                         timeout: 3000,
                         position: 'topRight',
                     });
                 })
        },

        delete_feature(id){
            if(confirm('are you sure to want to delete ??')){
            axios.delete(`/admin/delete/featured/`+id)
                 .then(response=>{
                     this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                    });
                    
                 })
                 .catch(error=>{
                     this.$toast.error(error.response.data.message,'error' , {
                         timeout: 3000,
                         position: 'topRight',
                     });
                 })
            }
        },
        delete_urgent(id){
            if(confirm('are you sure to want to delete ??')){
            axios.delete(`/admin/delete/urgent/`+id)
                 .then(response=>{
                     this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                    });
                    
                 })
                 .catch(error=>{
                     this.$toast.error(error.response.data.message,'error' , {
                         timeout: 3000,
                         position: 'topRight',
                     });
                 })
            }
        }
    }

   
  }
</script>