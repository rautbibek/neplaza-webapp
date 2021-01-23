<template>
  <div>
    <v-card color="#00000000">
      <div class="flex">
        <small>{{ ad.created_date }}</small>
        
        
        <div>
          
          <Message :seller="owner"/>
         
          <v-menu offset-y>
            <template v-slot:activator="{ on, attrs }">
              
              <v-icon v-bind="attrs" v-on="on" class="mr-2"
                >mdi-share-variant-outline</v-icon>
            </template>
            <div class="share">
              <span>Share</span>
              <share-it iconSize="lg" :url="url" :icons="true" />
            </div>
          </v-menu>
          <!-- <div><report-ad :ads='ad'></report-ad></div> -->
          <favorite
            :product_id="ad.id"
            :from_details="true"
            :is_favorite="ad.favorite_to_users.length > 0 ? true : false"
          ></favorite>
          
          
          <v-menu offset-y close-on-content-click>
            <template v-slot:activator="{ on, attrs }">
              <v-icon class="ml-1" v-bind="attrs" v-on="on"
                >mdi-dots-vertical</v-icon
              >
              
            </template>
            <v-list class="other-options">
              <v-list-item @click="copy(ad.productid)">Copy Product ID</v-list-item>
              <div v-if="loggedIn">
                <div v-if="loginUser.id === ad.user_id">
                  <v-list-item route :to="`/edit/ad/${ad.id}/image`">Edit Image</v-list-item>
                  <v-list-item route :to="`/edit/${ad.id}/ad`">Edit Details</v-list-item>
                  <v-list-item @click="softDelete(ad)">Delete</v-list-item>
                  <v-list-item @click="soldOut(ad)">Mark as Sold Out</v-list-item>
                </div>
              </div>
              
            </v-list>
          </v-menu>
          
        </div>
        
      </div>
      <v-card-title class="text-capitalize product-title">{{
        ad.title 
      }}</v-card-title>
      
      <p class="">
        <v-icon color="#19916b" small>mdi-map-marker-circle</v-icon>
        {{ ad.address }}, {{ ad.product_property.nhood_name }},
        {{ ad.product_property.city_name }}
        
      </p>
      <p class="pre-formatted product-description" v-html="ad.description"></p>
      <p class="price">Rs. {{ ad.product_price }} {{ ad.product_max_price }}</p>
      
    </v-card>
    <!-- user information -->
    <v-card class="card-user" :to="`/seller/${ad.user.id}/${ad.user.username}`">
    <v-responsive style="margin:0px; padding:0px; flex:none">
      <v-avatar size="120">
        <img :src="ad.user.cover" :alt="ad.user.name" />
      </v-avatar>
      </v-responsive>
      <div class="product-username">
        
        <p class="owner mb-1">Owner</p>
        <p class="user-name d-flex mb-1">
          {{ ad.user.name }}
          <v-icon
            color="#00a2f0"
            class="ml-2"
            small
            v-if="ad.user.phone_verified"
            >mdi-check-decagram</v-icon
          >
        </p>
        <p class="phone-number mb-1">
          <v-icon small color="#19916B">mdi-phone-outline</v-icon>
          {{ ad.user.contact_number }}
        </p>
        <small style="color: grey" class="my-1">
          User Since : {{ ad.user.register_date }}</small
        >
      </div>
    </v-card>
    
  </div>
</template>
<script>
import shareIt from "vue-share-it";
import Message from "./Message";
var Vue = require("vue");
Vue.use(shareIt);
export default {
  components: {
    Message,
  },
  props: ["ad", "owner"],
  computed: {
    url() {
      return window.location.href;
    },
  },
  methods:{
    softDelete(ads) {
      if (
        confirm(
          "Are you sure you want to delete this? You can still recover the item later."
        )
      ) {
        this.overlay = true;
        axios
          .put(`/trash/ad/${ads.id}`)
          .then((response) => {
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });
            window.location.href = "/myads/deleted";
            this.overlay = false;
          })
          .catch();
      }
    },
    soldOut(ads) {
      this.overlay = true;
      axios
        .put(`/sold/ad/${ads.id}`)
        .then((response) => {
          this.$toast.success(response.data, "success", {
            timeout: 3000,
            position: "topRight",
          });
          window.location.href = "/myads/soldout";
          this.overlay = false;
        })
        .catch();
    },
    copy(productId){
      console.log(productId);
      try{
        navigator.clipboard.writeText(productId)
        this.$toast.success(' to clipboard <b>'+ productId+" </b>" , "Copied", {
            timeout: 15000,
            position: "topRight",
          });
      }catch(e){
        throw e;
      }
    },
  }
};
</script>
<style scoped>
.pre-formatted {
  white-space: pre-wrap;
}
.flex {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.flex > small {
  color: #757575;
}
.product-description {
  padding: 0px;
}
.price {
  font-size: 21px;
  font-weight: 600;
  letter-spacing: 0.5px;
  color: #19916b;
}
.user-name {
  font-weight: 600;
  font-size: 17px;
}
.owner {
  color: #898880;
  font-weight: 600;
}
.card-user {
  background: #f3f2ed;
  padding: 16px;
  display: flex;
}
.v-sheet {
  box-shadow: none !important;
}
.product-title {
  font-size: 24px;
  font-weight: 600;
  padding: 0px;
  margin-bottom: 16px;
}
.product-username {
  margin-left: 20px;
}
.product-subtitle {
  font-size: 20px;
  font-weight: 600;
  padding-left: 4px;
}
.share {
  min-height: 60px;
  display: flex;
  min-width: 300px;
  align-items: center;
  background: #fff;
  padding-left: 10px;
}
.share > span {
  color: #0000008a;
}
.share > div {
  justify-content: center;
}
.other-options {
  min-width: 160px;
}
</style>