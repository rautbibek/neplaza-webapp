<template>
    <div>
        <!-- title price and like -->
        <v-card tile>
            <favorite :product_id="ad.id" :is_favorite='ad.favorite_to_users.length>0?true:false' ></favorite>
            <v-card-title style="color:#cf0000">Rs. {{ad.product_price}} {{ad.product_max_price}} </v-card-title>
            <v-card-text class="my-0 py-0 subtitle-1 text-capitalize">{{ad.title}}</v-card-text>
            <v-card-text>
            <v-row >
                <v-col>
                    <small>{{ad.created_date}}</small>
                </v-col>
                <v-col class="text-right">
                    <v-btn small text>
                        <v-icon small left color="blue">visibility</v-icon>
                         {{ad.view_count}} views
                    </v-btn>
                </v-col>

            </v-row>
            </v-card-text>
        </v-card>


        <!-- user information -->
        <v-card tile class="mt-3 text-center" >

            <v-col class="">
                <v-responsive>
                    <v-avatar size="120">
                    <img
                        :src="owner.cover"
                        :alt="owner.name"
                    >
                    </v-avatar>
                </v-responsive>
            </v-col>
            <v-list-item-content class="text-center">
             <v-list-item-title>{{owner.name}}</v-list-item-title>
             <small style="color:grey" class="my-1" >user since : {{owner.register_date}}</small>
            </v-list-item-content>
            <v-chip router :to="`/seller/${owner.id}/${owner.username}`"
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                <v-avatar left>
                    <v-icon>mdi-account-circle</v-icon>
                </v-avatar>
                More about seller

                <v-icon right>keyboard_arrow_right</v-icon>
            </v-chip>

        </v-card>

        <!-- contact number -->
        <v-card tile class="mt-3 " >
            <div class="py-5">
                <span class="ml-3">Contact Number :</span>
                <v-btn small text >
                        <v-icon left small color="green"> phone</v-icon>
                        <a :href="'tel:'+owner.contact_number">{{ owner.contact_number}} </a>
                </v-btn>
                <div class="text-center">
                  <v-card-text style="color:green" v-if="owner.phone_verified">
                    <span ><v-icon color="green">done_all</v-icon> Verified</span>
                  </v-card-text>
                  <v-card-text style="color:red" v-else>
                    <span ><v-icon color="red">error</v-icon>Not Verified</span>
                  </v-card-text>
                </div>
            </div>
            <Message :seller="owner"/>
            <v-card-text class="text-center" style="background-color:#3f51b5" v-if="owner.hide_contact ==true">
                 <small class="my-1 text-white">Seller Set the Contact {{owner.contact_status}}</small>
            </v-card-text>
        </v-card>
        <!-- product id -->


        <v-card tile class="mt-3">
            <v-card-text>
            <v-row class="text-center">
                <v-col cols="2">
                    <v-icon>share</v-icon>
                </v-col>
                <v-col cols="10">
                    <share-it iconSize="sm" :url="url" :icons="true" outline/>
                </v-col>
            </v-row>
            <v-row no-gutters class="mt-2">
                <v-col class="mt-2 " style="color:black"> <span class="text-uppercase ml-3">AD ID : #{{ad.productid}}</span></v-col>
                <v-col class="text-right"> <report-ad :ads="ad"></report-ad>  </v-col>
            </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
import shareIt from 'vue-share-it';
import Message from './Message';
var Vue = require('vue')
Vue.use(shareIt);
export default {
    components:{
        Message,
    },
    props:['ad','owner'],
    computed:{
        url(){
            return window.location.href;
        }
    }
}
</script>
