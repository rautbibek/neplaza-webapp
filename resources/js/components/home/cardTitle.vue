<template>
    <div>
        <v-card-text text-left class="text-capitalize subtitle-2">
         <div style="color:black">
             <span
                class="d-inline-block text-truncate"
                style="max-width: 200px;"
                >
                {{ads.title}}
                </span>

             </div>

         </v-card-text>
         <div class="card-date text-left">

         <p class="pa-2" style="color:black" >
             <v-icon left small>location_on</v-icon>
             <small>{{ads.product_property.nhood_name}}, {{ads.product_property.city_name}}</small>
             </p>
         </div>
    </div>
</template>
<script>
export default {
    props:['ads'],
}
</script>
