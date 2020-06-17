<template>
    <div>
        <v-card-text text-left>
         <div style="color:black">
             <h6>
             {{ads.ad_title}}
             </h6>
             
             </div>
         
         </v-card-text>
         <div class="card-date text-left">
         
         <p class="pa-2">
             <v-icon left small>location_on</v-icon>
             <small>{{ads.nhood.name}}, {{ads.city.name}}</small>
             </p>
         </div>
    </div>
</template>
<script>
export default {
    props:['ads'],
}
</script>