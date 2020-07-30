<template>
    <div>
        <v-card-text text-left>
         <div style="color:black">
             <span
                class="d-inline-block text-truncate"
                style="max-width: 200px;"
                >
                {{ads.ad_title}}
                </span>
             
             </div>
         
         </v-card-text>
         <div class="card-date text-left">
         
         <p class="pa-2" style="color:black" >
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