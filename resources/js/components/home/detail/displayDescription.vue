<template>
    <div >
        <v-card tile>
            <v-card-title>Ad Detail</v-card-title>
                <v-card-text >

                    <v-row no-gutters class="ml-3">

                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.brand_id">

                            <v-row>
                                <v-col> <strong>Brand</strong> </v-col>
                                <v-col>{{ad.product_property.brand_name}}</v-col>
                            </v-row>
                        </v-col>
                        <!-- type -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.type_id">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.scategory.url === 'house'">Property Type</strong>
                                    <strong v-else-if="ad.scategory.url === 'shop'">Property Type</strong>
                                    <strong v-else-if="ad.category.url === 'job'">Job Type</strong>
                                    <strong v-else-if="ad.scategory.url === 'cars'">Fuel Type</strong>
                                    <strong v-else>Type</strong>
                                </v-col>
                                <v-col>{{ad.product_property.type_name}}</v-col>
                            </v-row>
                        </v-col>
                        <!-- status -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.status_id">
                            <v-row>
                                <v-col> <strong>Status</strong> </v-col>
                                <v-col>{{ad.product_property.status_name}}</v-col>
                            </v-row>
                        </v-col>
                        <!-- filter -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_id">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.category.url === 'property'">Furnishing</strong>
                                    <strong v-if="ad.category.url === 'fashion'">For </strong>
                                    <strong v-if="ad.category.url === 'job'">Salary Period</strong>

                                </v-col>
                                <v-col>{{ad.product_property.filter_name}}</v-col>
                            </v-row>
                        </v-col>
                        <!-- filter 1 -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_1_id">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.category.url === 'property'">Listed By</strong>
                                    <strong v-if="ad.category.url === 'mobile'">RAM </strong>

                                </v-col>
                                <v-col>{{ad.product_property.filter_1_name}}</v-col>
                            </v-row>
                        </v-col>

                        <!-- filter 1 -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.filter_2_id">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.category.url === 'property'">Car Parking</strong>
                                    <strong v-if="ad.category.url === 'mobile'">Storage </strong>
                                </v-col>
                                <v-col>{{ad.product_property.filter_2_name}}</v-col>
                            </v-row>
                        </v-col>

                        <!-- static property 1 -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_1">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.category.url === 'property'">Bathroom</strong>
                                    <strong v-if="ad.category.url === 'car'">KM Driven</strong>
                                    <strong v-if="ad.category.url === 'bike'">KM Driven</strong>
                                </v-col>
                                <v-col>{{ad.property_1}} <span v-if="ad.category.url === 'car' || ad.category.url ==='bike'">KM</span></v-col>
                            </v-row>
                        </v-col>

                        <!-- static property 2 -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_2">
                            <v-row>
                                <v-col>
                                    <strong v-if="ad.category.url === 'property'">Bedroom</strong>
                                    <strong v-if="ad.category.url === 'car' || ad.category.url ==='bike'">Lot No.</strong>
                                </v-col>
                                <v-col>{{ad.property_2}}</v-col>
                            </v-row>
                        </v-col>

                        <!-- static property 3 -->
                        <v-col cols="12" lg="6" md="6" sm="12" xs="12" v-if="ad.property_3">
                            <v-row>
                                <v-col>

                                    <strong v-if="ad.category.url === 'property'">Builtup Area</strong>
                                </v-col>
                                <v-col style="color:#1060a0">{{ad.property_3}} <span  v-if="ad.filter_3_id">{{ad.product_property.filter_3_name}}</span> </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-card-text>
            <v-divider></v-divider>
            <v-card-title>Ad Location & Address</v-card-title>
              <v-card-text>
                  <v-row no-gutters class="ml-3">
                    <v-col cols="12" lg="6" md="6" sm="12" xs="12">
                        <v-row>
                            <v-col><strong>District</strong></v-col>
                            <v-col>{{ad.product_property.city_name}}</v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" lg="6" md="6" sm="12" xs="12">
                        <v-row>
                            <v-col><strong>Metro/Municipility</strong></v-col>
                            <v-col style="color:#cf0000">{{ad.product_property.nhood_name}}</v-col>
                        </v-row>
                    </v-col>
                    <v-col cols="12" lg="6" md="6" sm="12" xs="12">
                        <v-row>
                            <v-col><strong>Address</strong></v-col>
                            <v-col >{{ad.address}}</v-col>
                        </v-row>
                    </v-col>
                </v-row>
              </v-card-text>
            <v-divider></v-divider>
              <v-card-title>Ad Description</v-card-title>
              <v-card-text class="ml-3">
                  <p class="pre-formatted" v-html="ad.description"></p>

              </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    props:['ad'],
    data(){
      return{
        //
      }
    },
    
}
</script>
<style scoped>

  .pre-formatted {
    white-space: pre-wrap;
  }

</style>
