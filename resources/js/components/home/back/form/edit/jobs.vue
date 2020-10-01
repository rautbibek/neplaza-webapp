<template>
    <div>
            <div class="text-center p-2 ">
                    <h4 class="font-weight-bold text-uppercase">{{scat.name}}</h4>
            </div>
            <v-overlay :value="overlay">
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
           <v-row justify="center" no-gutters>

               <v-col cols="12" lg="10" md="10" sm="12" xs="12" class="custom-border">
                    <v-card tile>
                        <v-form ref="form" v-model="valid" lazy-validation>
                         <div class="m-2">
                             <v-card-title class="font-weight-bold">
                                INCLUDE SOME DETAILS
                             </v-card-title>
                             <v-card-subtitle>
                                * Fileld are mendatory
                            </v-card-subtitle>
                                <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="type"
                                        :items='scat.type'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Job Type"
                                        placeholder="Job type"
                                        :rules="[select('Job type')]"
                                        outlined
                                        clearable
                                    ></v-select>
                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="filter_id"
                                        :items='scat.filter'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Salary Perios"
                                        placeholder="Salary Period"
                                        :rules="[select('Salary Period')]"
                                        outlined
                                        clearable
                                    ></v-select>
                                </v-col>
                          </div>
                          <div class="form-seperator"></div>
                          <div class="m-2">
                                <v-card-title class="font-weight-bold">
                                    AD TITLE & DESCRIPTION
                                </v-card-title>

                                <v-col cols="12" sm="12" md="8" xs="12" class="p-4">

                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        v-model="title"
                                        label="Ad Title *"
                                        placeholder="Ad Title"
                                        counter="100"
                                        :rules="[required('Title'),minLength('Title',10),maxLength('Title',100)]"
                                        outlined
                                        clearable
                                    ></v-text-field>

                                    <v-textarea style="border-radius:0px; margin-bottom:20px"
                                        v-model="description"
                                        label="Ad description *"
                                        placeholder="Ad Description "
                                        :rules="[required('Description'),minLength('Description',20),maxLength('Description',4000)]"
                                        counter="4000"
                                        outlined
                                        clearable
                                    ></v-textarea>
                                </v-col>
                            </div>
                          <div class="form-seperator"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    LOCATION & ADDRESS
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-autocomplete style="border-radius:0px; margin-bottom:20px"
                                        v-model="district"
                                        :items='city'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="District *"
                                        placeholder="District "
                                        :rules="[select('District')]"
                                        outlined
                                        clearable
                                        @change="getNhood"
                                    ></v-autocomplete>
                                    <div class="d-flex justify-content-center" style="margin-bottom:20px" v-if="loading">
                                        <div class="spinner-border" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                    <v-autocomplete style="border-radius:0px; margin-bottom:20px" v-show="nhood_display && district"
                                        v-model="nhood"
                                        :items='localArea'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Metro/Municipility/VDC *"
                                        placeholder="Metro/Municipility/VDC "
                                        :rules="[select('Metro/Municipility/VDC')]"
                                        outlined
                                        clearable
                                        :loading ="loading"
                                    ></v-autocomplete>

                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        v-model="street"
                                        label="Location/Area *"
                                        placeholder="Address where customer can find you or your office"
                                        counter="100"
                                        :rules="[required('Location/Area'),minLength('Location/Area',10),maxLength('Location/Area',100)]"
                                        outlined
                                        clearable
                                    ></v-text-field>
                                </v-col>
                          </div>

                          <div class="form-seperator"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    OFFERED SALARY
                                    <v-chip v-if="price>99"
                                      class="ma-2"
                                      small
                                      color="indigo"
                                      text-color="white"
                                    >
                                      Rs. {{ Number(price).toLocaleString() }} - {{ Number(maxprice).toLocaleString() }}
                                    </v-chip>
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        type="number"
                                        v-model="price"
                                        label="From *"
                                        placeholder="From"
                                        :rules="[v => v && v > 0 || `Salary from is invalid.`]"
                                        outlined
                                        clearable
                                    ></v-text-field>
                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        type="number"
                                        v-model="maxprice"
                                        label="To *"
                                        placeholder="To"
                                        :rules="[v => v && v > 0 || `Salary to is invalid.`]"
                                        outlined
                                        clearable
                                    ></v-text-field>
                                </v-col>
                          </div>

                          <div class="form-seperator">
                                    <v-col cols="8 py-4 ml-4">
                                    <v-btn tile large color="primary" :disabled="!valid"  @click="submit">
                                        <v-icon left>save</v-icon>
                                        update ad
                                        </v-btn>
                                </v-col>
                            </div>
                        </v-form>
                    </v-card>
               </v-col>
            </v-row>
    </div>
</template>
<script>
import imageMixins from "../../../../../mixins/editMixin";
export default {

    mixins:[imageMixins],
    methods:{
        getProduct(){
        if (!this.loggedIn) {
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
        axios.get(`/user/add/product/${this.$route.params.id}/edit`)
             .then(response =>{

                 this.product = response.data;

                 this.url         = this.product.join;
                 this.title       = this.product.title;
                 this.district    = this.product.city_id;
                 this.nhood       = this.product.nhood_id;
                 this.price       = this.product.price;
                 this.description = this.product.description;
                 this.street      = this.product.address;

                 this.type       = this.product.type_id;
                 this.maxprice   = this.product.maxprice;
                 this.filter_id  = this.product.filter_id;


                 this.getNhood();

             })
        }
    },
    mounted(){
        this.getProduct();
    }
}
</script>
