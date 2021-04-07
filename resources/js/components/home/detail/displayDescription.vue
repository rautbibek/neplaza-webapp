<template>
<div>
  <v-card
    class="card-bg"
    v-if="
      ad.brand_id ||
      ad.type_id ||
      ad.status_id ||
      ad.filter_id ||
      ad.filter_1_id ||
      ad.filter_2_id ||
      ad.property_1 ||
      ad.property_2 ||
      ad.property_3
    "
  >
    <v-card-text class="product-description">
      <v-row no-gutters>
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.brand_id">
          <div class="d-flex ma-2">
            <strong>
              <v-icon small left> mdi-check-circle-outline </v-icon>
              Brand</strong
            >
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.brand_name }}</span>
          </div>
        </v-col>
        <!-- type -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.type_id">
          <div class="d-flex ma-2">
            <strong v-if="ad.scategory.url === 'house'">
              <v-icon small left>mdi-home-city-outline</v-icon>Property
              Type</strong
            >
            <strong v-else-if="ad.scategory.url === 'shop'"
              ><v-icon small left>mdi-home-city-outline</v-icon>Property
              Type</strong
            >
            <strong v-else-if="ad.category.url === 'job'">
              <v-icon small left>mdi-briefcase</v-icon>Job Type</strong
            >
            <strong v-else-if="ad.scategory.url === 'cars'">
              <v-icon small left>mdi-fuel</v-icon>Fuel Type</strong
            >
            <strong v-else>
              <v-icon small left>mdi-format-list-bulleted-type</v-icon>
              Type</strong
            >
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.type_name }}</span>
          </div>
        </v-col>
        <!-- status -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.status_id">
          <div class="d-flex ma-2">
            <strong><v-icon small left>mdi-list-status</v-icon>Status</strong>
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.status_name }}</span>
          </div>
        </v-col>
        <!-- filter -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_id">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-table-furniture</v-icon>Furnishing</strong
            >
            <strong v-if="ad.category.url === 'fashion'"
              ><v-icon small left>mdi-arrange-bring-forward</v-icon>For
            </strong>
            <strong v-if="ad.category.url === 'job'"
              ><v-icon small left>mdi-calendar-month-outline</v-icon>Salary
              Period</strong
            >
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.filter_name }}</span>
          </div>
        </v-col>
        <!-- filter 1 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_1_id">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-account-box-outline</v-icon>Listed
              By</strong
            >
            <strong v-if="ad.category.url === 'mobile'"
              ><v-icon small left>mdi-cellphone-settings</v-icon>RAM
            </strong>
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.filter_1_name }}</span>
          </div>
        </v-col>

        <!-- filter 1 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_2_id">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-car</v-icon>Car Parking</strong
            >
            <strong v-if="ad.category.url === 'mobile'"
              ><v-icon small left>mdi-apple-icloud</v-icon>Storage
            </strong>
            <v-divider vertical></v-divider>
            <span>{{ ad.product_property.filter_2_name }}</span>
          </div>
        </v-col>

        <!-- static property 1 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_1">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-scale-bathroom</v-icon>Bathroom</strong
            >
            <strong v-if="ad.category.url === 'car'"
              ><v-icon small left>mdi-car-convertible</v-icon>KM Driven</strong
            >
            <strong v-if="ad.category.url === 'bike'"
              ><v-icon small left>mdi-bike-fast</v-icon>KM Driven</strong
            >
            <v-divider vertical></v-divider>
            <span
              >{{ ad.property_1 }}
              <span
                v-if="ad.category.url === 'car' || ad.category.url === 'bike'"
                >KM</span
              ></span
            >
          </div>
        </v-col>

        <!-- static property 2 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_2">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-bed-outline</v-icon>Bedroom</strong
            >
            <strong
              v-if="ad.category.url === 'car' || ad.category.url === 'bike'"
              ><v-icon small left>mdi-format-list-bulleted-square</v-icon>Lot
              No.</strong
            >
            <v-divider vertical></v-divider>
            <span>{{ ad.property_2 }}</span>
          </div>
        </v-col>

        <!-- static property 3 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_3">
          <div class="d-flex ma-2">
            <strong v-if="ad.category.url === 'property'"
              ><v-icon small left>mdi-home-roof</v-icon>Builtup Area</strong
            >
            <v-divider vertical></v-divider>
            <span>
              {{ ad.property_3 }}
              <span v-if="ad.filter_3_id">{{
                ad.product_property.filter_3_name
              }}</span>
            </span>
          </div>
        </v-col>
        <!-- static property 3 -->
        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.delivery">
          <div class="d-flex ma-2">
            <strong 
              ><v-icon small left>mdi-truck-delivery</v-icon>Delivery</strong
            >
            <v-divider vertical></v-divider>
            <span>
              {{ ad.delivery }}
              
            </span>
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
  <v-card
    class="card-bg mt-5"
    v-if="ad.all_product_feature.length>0"
  >
  <v-card-title class="py-0"><p><strong style="color:black">
    <span v-if="ad.category.url == 'property'">Aminities</span>
    <span v-else>Features</span>
    </strong></p></v-card-title>
    <v-card-text class="product-description ">
      <v-row no-gutters>
        <v-col cols="12" lg="3" md="3" sm="4" xs="6" v-for="feature in ad.all_product_feature" :key="feature.id">
          <div class="d-flex ma-2">
            <b>
              <v-icon small left> mdi-check-circle-outline </v-icon>
               {{feature.features.name}}
            </b>
            
          </div>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</div>
</template>
<script>
export default {
  props: ["ad"],
  data() {
    return {
      //
    };
  },
};
</script>
<style scoped>
@media screen and (max-width: 575px) {
  .card-bg {
    padding-left: 0px !important;
    padding-top: 6px !important;
    padding-bottom: 6px !important;
    padding-right: 6px !important;
  }
}
@media screen and (max-width: 374px) {
  .v-divider {
    display: none;
  }
  .d-flex {
    flex-direction: column;
  }
  .d-flex strong {
    justify-content: center;
    width: 100%;
    padding-bottom: 10px;
    border-bottom: 1px solid #ababab;
  }
  .d-flex b {
    width: 100%;
    color: #2f3b59;

  }
  .d-flex span {
    padding-top: 10px;
  }
}
.pre-formatted {
  white-space: pre-wrap;
}
.d-flex {
  background: white;
  padding: 12px 16px;
  border-radius: 4px;
  align-items: center;
  position: relative;
  justify-content: space-between;
}
.d-flex strong {
  color: #2f3b59;
  display: flex;
  align-items: center;
}
.d-flex i {
  color: #2f3b59;
}
.d-flex span {
  color: black;
}
.v-divider {
  margin: 0px;
  position: absolute;
  border-color: #ababab;
  margin-left: auto;
  margin-right: auto;
  max-height: 50%;
  min-height: 50%;
  left: 0;
  right: 0;
}
.card-bg {
  background: #f3f2ed;
  padding: 24px;
}
.product-description {
  padding: 0px;
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
  margin-left: 4px;
  padding: 16px;
  display: flex;
}
.v-sheet {
  box-shadow: none !important;
}
.product-title {
  font-size: 24px;
  padding-top: 20px;
  font-weight: 600;
  padding-left: 4px;
}
.product-username {
  margin-left: 20px;
}
.product-description {
  padding-left: 5px;
}
.product-subtitle {
  font-size: 20px;
  font-weight: 600;
  padding-left: 4px;
}
</style>
