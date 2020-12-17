<template>
    <div class="container-fluid">
        <div class="border text-center ">
        <h1 class="display-4">Sorry <span style="color:#2398d2;">!</span></h1>
        <h3 ><strong style="color:#2398d2;">No Ads</strong> Found.</h3>
        <img height="150px" src="/storage/empty_product.png" alt="">

        <h3 style="color:grey">Be The First To Add One</h3>
        <br>
        <p class="lead" style="margin-top:10px">
          <v-btn outlined tile large color="#2398d2" router :to='`/user/create/ads`'>
            START SELLING
          </v-btn>
        </p>
        <br>
        </div>
    </div>
</template>
<script>

export default {

}
</script>
