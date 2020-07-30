<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">
    <!-- table componsent -->
    <v-row>
        <v-col cols="12" lg="3" md="3">
                    <v-card tile class="text-center" >
                        <v-col class="">
                            <v-responsive>
                                <v-avatar size="120">
                                <img
                                    :src="user.cover"
                                    :alt="user.name"
                                >
                                </v-avatar>
                            </v-responsive>
                        </v-col>
                        <v-list-item-content class="text-center">
                        <v-list-item-title>{{user.name}}</v-list-item-title>
                        <small style="color:grey" class="my-1" >user since : {{user.register_date}}</small>
                        </v-list-item-content>    
                    </v-card>
                    <v-card tile class=" mt-3 pa-3" v-if="user.city">
                            <h5 class="m-2 text-center"><i class="fa fa-map-marker"> </i> Address Location </h5>
                            <hr>
                            <div class="row">
                                <div class="col-6"> Located District :</div>
                                <div class="col-6">{{user.city.name}}</div>
                            </div>
                            <div class="row">
                                <div class="col-6">Metro/Municipility/VDC :</div>
                                <div class="col-6">{{user.nhood.name}}</div>
                            </div>
                    </v-card>
                    <!-- contact number -->
                    <v-card class="mt-3 pa-3">
                        <v-list-item-content class="text-center">
                        <v-list-item-title class="mt-2">
                            Contact Number :
                            <v-icon small color="green"> phone</v-icon>
                            {{ user.contact_number}} 
                        </v-list-item-title>
                        </v-list-item-content>

                        <v-card-text class="text-center" style="background-color:#3f51b5" v-if="user.hide_contact ==true">
                            <small class="my-1 text-white">Seller Set the Contact {{user.contact_status}}</small>
                        </v-card-text>
                    </v-card>
                
                </v-col>
        <v-col cols="12" lg="9" md="9">
            <v-card class="mt-3" tile v-if="user.about">
                        <v-card-title>
                            About {{user.name}}
                        </v-card-title>
                        <v-card-text>
                            <blockquote>{{user.about}}</blockquote>
                        </v-card-text>
             </v-card>
            
        </v-col>
    </v-row>
    <v-row>
        <v-col cols="12">
            <v-chip small
                    class="ma-2"
                    color="green"
                    text-color="white"
                    >
                    Total Ads: {{user.product_count}}
            </v-chip>
            <v-chip small
                    class="ma-2"
                    color="indigo"
                    text-color="white"
                    >
                    Feature ad:{{feature_ad}}
            </v-chip>

            <v-chip small
                    class="ma-2"
                    color="black"
                    text-color="white"
                    >
                    urgent ad : {{urgent_ad}}
            </v-chip>

            <v-chip small
                    class="ma-2"
                    color="blue"
                    text-color="white"
                    >
                    sold ad : {{sold_ad}}
            </v-chip>

            <v-chip small
                    class="ma-2"
                    color="red"
                    text-color="white"
                    >
                    deleted ad : {{deleted_ad}}
            </v-chip>
            
            <v-simple-table>
        
                <template v-slot:default>
                    
                    <thead>
                    
                    <tr>
                        <th class="text-left">#ID</th>
                        <th class="text-left">Product Id</th>
                        <th class="text-left">Product Title</th>
                        <th class="text-left">Premium</th>
                        <th class="text-left">sold</th>
                        <th class="text-left">urgent sell</th>
                        <th class="text-left">deleted</th>
                        <th class="text-left">Created Date</th>
                        <th class="text-left">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in user.product" :key="index">
                        <td>{{ index+1 }}</td>
                        <td><a :href="'/admin/product/'+item.id">{{ item.productid }} </a></td>
                        <td>{{ item.title }}</td>
                        <td>
                            <v-chip small v-if="item.premium"
                                    class="ma-2"
                                    color="yellow"
                                    text-color="white"
                                    >
                                    premium
                            </v-chip>
                            <v-chip small v-else
                                class="ma-2"
                                color="secondary"
                                text-color="white"
                                >
                                no premium
                            </v-chip>
                        </td>
                        <td>
                        <v-chip small v-if="item.sold"
                                class="ma-2"
                                color="black"
                                text-color="white"
                                >
                                sold out
                            </v-chip>
                            <v-chip small v-else
                                class="ma-2"
                                color="voilet"
                                text-color="white"
                                >
                                available
                            </v-chip>
                        </td>
                        <td>
                        
                        <v-chip v-if="item.emergency_sell" small
                            class="ma-2"
                            color="indigo"
                            text-color="white"
                            >
                            yes
                        
                            </v-chip>
                            <v-chip v-else small
                                class="ma-2"
                                color="blck"
                                text-color="white"
                                >
                                no
                                
                            </v-chip>
                        </td>
                        <td>
                        <v-chip small v-if="item.deleted"
                                class="ma-2"
                                color="red"
                                text-color="white"
                                >
                                deleted
                            </v-chip>
                            <v-chip small v-else
                                class="ma-2"
                                color="green"
                                text-color="white"
                                >
                                available
                            </v-chip>
                        </td>
                        <td>
                            {{item.created_date}}
                        </td>
                        
                        <td>
                        
                        <v-btn x-small text @click="del(item.id,item)">
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
    props:['user','user_product','deleted_ad','sold_ad','feature_ad','urgent_ad'],
    data: () => ({
      desserts: [], 
      nextUrl:'',    
    }),
    methods:{
        del(id,item){
            if(confirm('are you sure to wnat to delete this user')){
            this.overlay = true;
            axios.delete(`/admin/product/`+id)
                
                .then(response=>{
                
                this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                    });
                    this.overlay = false;
                    this.desserts.splice(this.desserts.indexOf(item), 1);
                })
                .catch();
            }
        },
    },
   
  }
</script>