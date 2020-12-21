<template>
  <div>
    <v-card>
      <div class="flex">
        <small>{{ ad.created_date }}</small>
        <div>
          <v-icon class="mr-1">mdi-share-variant-outline</v-icon>
          <favorite
            :product_id="ad.id"
            :from_details="true"
            :is_favorite="ad.favorite_to_users.length > 0 ? true : false"
          ></favorite>
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
      <v-avatar size="100">
        <img :src="ad.user.cover" :alt="ad.user.name" />
      </v-avatar>
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
    <!-- product id -->
    <!-- 
    <v-card tile class="mt-3">
      <v-card-text>
        <v-row class="text-center">
          <v-col cols="2">
            <v-icon>share</v-icon>
          </v-col>
          <v-col cols="10">
            <share-it iconSize="sm" :url="url" :icons="true" outline />
          </v-col>
        </v-row>
        <v-row no-gutters class="mt-2">
          <v-col class="mt-2" style="color: black">
            <span class="text-uppercase ml-3"
              >AD ID : #{{ ad.productid }}</span
            ></v-col
          >
          <v-col class="text-right"> <report-ad :ads="ad"></report-ad> </v-col>
        </v-row>
      </v-card-text>
    </v-card> -->
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
</style>