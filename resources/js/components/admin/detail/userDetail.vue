<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">
    
    
    
   
    <!-- table componsent -->
    <v-row>
        <v-col cols="4">
            <v-card tile class="mt-3 text-center" >
            
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
            <v-chip router :to="`/seller/${user.id}/${user.username}`"
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                <v-avatar left>
                    <v-icon>mdi-account-circle</v-icon>
                </v-avatar>
                View User ADS

                <v-icon right>keyboard_arrow_right</v-icon>
            </v-chip>
            
        </v-card>
        </v-col>
        <v-col cols="8">
            <c-card>
                <v-card-text>
                    all ads : {{user.product_count}}
                </v-card-text>

                <v-card-text>
                    
                    Contact Number: {{user.phone}}
                </v-card-text>
            </c-card>
        </v-col>
    </v-row>
  </v-container>
  <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    props:['user','user_product','total_ad','deleted_ad','sold_ad','feature_ad','urgent_ad'],
    data: () => ({
      desserts: [], 
      nextUrl:'',    
    }),
   
  }
</script>