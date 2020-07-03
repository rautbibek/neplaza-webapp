<template>
    <div>
        <!-- title price and like -->
        <v-card tile>
            <favorite :product_id="ad.id" :is_favorite='ad.favorite_to_users.length>0?true:false' ></favorite>
            <v-card-title style="color:#cf0000">Rs. {{ad.product_price}} {{ad.product_max_price}}</v-card-title>
            <v-card-title class="my-0 py-0">{{ad.title}}</v-card-title>
            <v-card-text>
            <div>{{ad.created_date}}</div>
            </v-card-text>
        </v-card>


        <!-- user information -->
        <v-card tile class="mt-3 text-center" >
            
            <v-col class="col-md-6 offset-md-3">
                <v-avatar size="120">
                <img
                    :src="owner.cover"
                    :alt="owner.name"
                >
                </v-avatar>
            </v-col>
            <v-list-item-content class="text-center">
             <v-list-item-title>{{owner.name}}</v-list-item-title>
             <small style="color:grey" class="my-1" >user since : {{owner.register_date}}</small>
            </v-list-item-content>
            <v-chip
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
        <v-card class="mt-3">
            <v-list-item-content class="text-center">
             <v-list-item-title class="mt-2">
                 Contact Number :
                 <v-icon small color="green"> phone</v-icon>
                {{ owner.contact_number}} 
             </v-list-item-title>
            </v-list-item-content>

            <v-card-text class="text-center" style="background-color:#3f51b5" v-if="owner.hide_contact ==true">
                 <small class="my-1 text-white">Seller Set the Contact {{owner.contact_status}}</small>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    props:['ad','owner'],
}
</script>