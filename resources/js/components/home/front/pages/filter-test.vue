<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right">
                  <router-link :to="`/category/${category_slug}`">
                    {{category_name}}
                  </router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{scategory_name}}</li>
            </ol>
        </nav>
        <div>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <div class="py-2" >

            <v-content class="px-0">
              <!-- sorting -->
                <v-content class="pb-2">
                    <v-toolbar flat>
                      <v-spacer></v-spacer>
                      <!-- mobile view starts form here -->
                       <v-row justify="center">
                        <v-dialog v-model="dialog" fullscreen hide-overlay transition="dialog-bottom-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn color="primary" outlined v-on="on" class="mr-4 d-flex d-sm-none">
                               <v-icon left>mdi-filter</v-icon> filter
                            </v-btn>
                          </template>
                          <v-card>
                            <v-toolbar dark color="primary">
                              <v-btn icon dark @click="dialog = false">
                                <v-icon>mdi-close</v-icon>
                              </v-btn>
                              <v-toolbar-title>Filter</v-toolbar-title>
                              <v-spacer></v-spacer>
                              <v-toolbar-items>
                                <v-btn dark text @click="dialog = false">Close</v-btn>
                              </v-toolbar-items>
                            </v-toolbar>
                            <v-list three-line subheader>
                              <v-subheader>Ad filter</v-subheader>

                            </v-list>
                            <v-divider></v-divider>
                            <v-card outlined tile v-for="(scat,index) in subcategory" :key="index">
                        <v-card-title> <v-icon>mdi-filter</v-icon> FILTER</v-card-title>
                        <v-card-subtitle>{{scat.name}}</v-card-subtitle>
                        <!-- PART ONE -->
                          <v-divider></v-divider>
                            <v-card-text>
                              <h5 class="title mb-2">Location</h5>
                              <v-autocomplete class="py-2" style="border-radius:0px"
                                v-model="city_id"
                                :items='city'
                                :item-text="'name'"
                                :item-value="'id'"
                                dense
                                outlined
                                clearable
                                label="District"
                                append-icon="mdi-map-marker"
                                @change="getNhood"
                              ></v-autocomplete>
                              <div class="d-flex justify-content-center" style="margin-bottom:20px" v-if="loading">
                                  <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                              </div>

                              <v-autocomplete class="py-1" style="border-radius:0px" v-show="nhood_display && city_id"
                                v-model="nhood_id"
                                :items='localArea'
                                :item-text="'name'"
                                :item-value="'id'"
                                outlined
                                clearable
                                label="Metro/Municipility/VDC"
                                append-icon="mdi-map-marker"

                              ></v-autocomplete>
                            </v-card-text>
                            <v-divider></v-divider>
                            <!-- price part  -->
                            <v-card-text >
                              <h5 class="title mb-2">Price Range</h5>
                              <v-card-text @mouseleave="changing">
                                <div class="row">
                                  <div class="col">
                                    <v-text-field

                                      type="number"
                                      v-model="min_p"
                                      label="Minimum Price"
                                      single-line
                                    ></v-text-field>
                                  </div>

                                  <div class="col text-right">
                                    <v-text-field @keyup="changing"
                                      type="number"
                                      v-model="max_p"
                                      label="Maximum price"
                                      single-line
                                    ></v-text-field>
                                  </div>
                                </div>
                              </v-card-text>
                            </v-card-text>
                            <v-divider></v-divider>
                            <!-- PART 2 -->
                            <div v-if="scat.type.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{type_title}}</h5>
                                <v-chip-group
                                  v-model="type_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="type.id" outlined v-for="(type,index) in scat.type" :key="index">{{type.name}}</v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                          </div>

                            <!-- PART 3 -->
                            <div v-if="scat.status.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">Status</h5>
                                <v-chip-group
                                  v-model="status_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="status.id" outlined v-for="(status,index) in scat.status" :key="index">
                                    {{status.title}}
                                  </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 4 -->
                            <div v-if="scat.brand.length > 0">
                              <v-card-text>
                              <h5 class="title mb-2">Brand</h5>
                                <v-chip-group
                                  v-model="brand_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="brand.id" outlined v-for="(brand,index) in scat.brand" :key="index">
                                    {{brand.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_title}}</h5>
                                <v-chip-group
                                  v-model="filter_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter.id" outlined v-for="(filter,index) in scat.filter" :key="index">
                                    {{filter.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_1.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_1_title}}</h5>
                                <v-chip-group
                                  v-model="filter_1_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_1.id" outlined v-for="(filter_1,index) in scat.filter_1" :key="index">
                                    {{filter_1.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_2.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_2_title}}</h5>
                                <v-chip-group
                                  v-model="filter_2_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_2.id" outlined v-for="(filter_2,index) in scat.filter_2" :key="index">
                                    {{filter_2.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_3.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_3_title}}</h5>
                                <v-chip-group
                                  v-model="filter_3_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_3.id" outlined v-for="(filter_3,index) in scat.filter_3" :key="index">
                                    {{filter_3.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <div class="p-3" >
                              <v-btn @click="filter" color="indigo" dark  tile>
                                <v-icon left>mdi-filter</v-icon>
                                Apply Filter
                                </v-btn>
                            </div>


                      </v-card>
                          </v-card>
                        </v-dialog>
                      </v-row>
                      <!-- mobile view end here -->

                      <!-- desktop view starts from here -->
                        <v-col cols="8" lg="2" md="3" sm="6" xs="8">

                          <v-select class="mt-4"
                            @change="filter"
                            v-model="sorting"
                            clearable
                            :items="sort"
                            :item-text="'title'"
                             label="SORT BY"
                             dense


                          ></v-select>
                        </v-col>
                      </v-toolbar>
                </v-content>
                <!-- end of sorting -->
                <v-row wrap no-gutters class="px-2">
                  <v-col cols="12" md="3" lg="3" sm="4" xs="12" class="d-none d-sm-flex">
                    <div class="mt-3">
                      <v-card flat v-for="(scat,index) in subcategory" :key="index">

                        <!-- PART ONE -->

                            <v-card-text>
                              <h5 class="title mb-2">Location</h5>
                              <v-autocomplete class="py-2"
                                v-model="city_id"
                                :items='city'
                                :item-text="'name'"
                                :item-value="'id'"
                                outlined
                                clearable
                                label="District"
                                append-icon="mdi-map-marker"
                                @change="getNhood"
                              ></v-autocomplete>
                              <div class="d-flex justify-content-center" style="margin-bottom:20px" v-if="loading">
                                  <div class="spinner-border" role="status">
                                    <span class="sr-only">Loading...</span>
                                  </div>
                              </div>

                              <v-autocomplete class="py-1"  v-show="nhood_display && city_id"
                                v-model="nhood_id"
                                :items='localArea'
                                :item-text="'name'"
                                :item-value="'id'"
                                outlined
                                clearable
                                label="Metro/Municipility/VDC"
                                append-icon="mdi-map-marker"

                              ></v-autocomplete>
                            </v-card-text>
                            <v-divider></v-divider>
                            <!-- price part  -->
                            <v-card-text >
                              <h5 class="title mb-1">Price Range</h5>



                                <div class="row" >
                                  <div class="col" @mouseout="changing" >
                                    <v-text-field
                                      outlined
                                      placeholder="Min"
                                      type="number"
                                      v-model="min_p"
                                      label="Min Price"

                                    ></v-text-field>
                                  </div>

                                  <div class="col text-right">
                                    <v-text-field @mouseout="changing"
                                      outlined
                                      placeholder="Max"
                                      type="number"
                                      v-model="max_p"
                                      label="Max price"

                                    ></v-text-field>
                                  </div>
                                </div>

                            </v-card-text>
                            <v-divider></v-divider>
                            <!-- PART 2 -->
                            <div v-if="scat.type.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{type_title}}</h5>
                                <v-chip-group
                                  v-model="type_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="type.id" outlined v-for="(type,index) in scat.type" :key="index">{{type.name}}</v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                          </div>

                            <!-- PART 3 -->
                            <div v-if="scat.status.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">Status</h5>
                                <v-chip-group
                                  v-model="status_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="status.id" outlined v-for="(status,index) in scat.status" :key="index">
                                    {{status.title}}
                                  </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 4 -->
                            <div v-if="scat.brand.length > 0">
                              <v-card-text>
                              <h5 class="title mb-2">Brand</h5>
                                <v-chip-group
                                  v-model="brand_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="brand.id" outlined v-for="(brand,index) in scat.brand" :key="index">
                                    {{brand.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_title}}</h5>
                                <v-chip-group
                                  v-model="filter_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter.id" outlined v-for="(filter,index) in scat.filter" :key="index">
                                    {{filter.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_1.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_1_title}}</h5>
                                <v-chip-group
                                  v-model="filter_1_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_1.id" outlined v-for="(filter_1,index) in scat.filter_1" :key="index">
                                    {{filter_1.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_2.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_2_title}}</h5>
                                <v-chip-group
                                  v-model="filter_2_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_2.id" outlined v-for="(filter_2,index) in scat.filter_2" :key="index">
                                    {{filter_2.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <!-- PART 5 -->
                            <div v-if="scat.filter_3.length>0">
                              <v-card-text>
                              <h5 class="title mb-2">{{filter_3_title}}</h5>
                                <v-chip-group
                                  v-model="filter_3_id"
                                  column
                                  multiple
                                >
                                  <v-chip filter :value="filter_3.id" outlined v-for="(filter_3,index) in scat.filter_3" :key="index">
                                    {{filter_3.name}}
                                    </v-chip>
                                </v-chip-group>
                              </v-card-text>
                              <v-divider></v-divider>
                            </div>

                            <div class="p-3">
                              <v-btn @click="filter" color="indigo" dark tile>
                                <v-icon left>mdi-filter</v-icon>
                                Apply Filter
                                </v-btn>
                            </div>


                      </v-card>
                    </div>
                  </v-col>
                  <v-col cols="12" md="9" lg="9" sm="8" xs="12" class="mt-1">
                     <filter-ad :all_ads="all_ads" :count="count"></filter-ad>
                  </v-col>
                </v-row>
                <div class="text-center mt-5 mb-5" v-if="nextUrl">
                    <v-btn :loading="loading" outlined tile color="#2F3B59" class="" @click.prevent="more(nextUrl)">
                        Load More
                        <template v-slot:loader>
                            <span>Loading...</span>
                        </template>
                        <v-icon right>cached</v-icon>
                    </v-btn>
                </div>
            </v-content>
        </div>

        </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
        dialog:false,
        nhood_display: false,
        city:[],
        localArea:[],
        subcategory:{},
        type_id:[],
        status_id:[],
        brand_id:[],
        filter_id:[],
        filter_1_id:[],
        filter_2_id:[],
        filter_3_id:[],
        overlay:true,
        loading:false,
        count:1,
        all_ads:[],
        scategory:{},
        city_id:'',
        nhood_id:'',
        price:[],
        url:'',
        surl:'',
        min_p:'',
        max_p:'',

        category_name:'',
        category_slug:'',
        scategory_name:'',
        nextUrl : null,
        sorting:'',
        sort:[
            {
              title: 'Price : High to Low',
              value: 1,
            },
            {
              title: 'Price : Low to High',
              value: 2,
            },
            {
              title: 'Date : Recent To Old',
              value: 3,
            },
            {
              title: 'Date : Old To Recent',
              value: 4,
            },
        ]
      }
    },
    methods:{

      changing(){
        //this.price.push(this.max_p,1)
        this.price[1] = this.max_p;
        this.price[0] = this.min_p;
        this.price;
      },
      favorite(){
        if(this.$loggedIn){
            this.color= 'red';

            this.background= 'white';
        }else{
            EventBus.$emit('changeDialog', true);
        }
      },
      filter(){
        this.dialog= false;
        this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
        window.scrollTo(0,100);

      },
      fetch(url){
          this.overlay=true;
          axios.get(url,{
            params:{
              type_id     : this.type_id,
              status_id   : this.status_id,
              filter_id   : this.filter_id,
              filter_1_id : this.filter_1_id,
              filter_2_id : this.filter_2_id,
              filter_3_id : this.filter_3_id,
              brand_id    : this.brand_id,
              city_id     : this.city_id,
              nhood_id    : this.nhood_id,
              price       : this.price,
              sort        : this.sorting,
            }
          })
               .then(({data}) =>{
                     this.all_ads = data.data;
                     this.count = this.all_ads.length;
                     this.nextUrl = data.next_page_url
                     this.count = this.all_ads.length;
                     this.all_ads = data.data;
                     this.overlay= false;
            }).catch((error) => {
            if (error.response.status === 404) {
              window.location.href = '/pageNotFound';
            }
          });
      },
      more(nextUrl){
        this.loading=true;
        axios.get(nextUrl)
             .then(({data}) =>{
                this.all_ads.push(...data.data);
                this.nextUrl = data.next_page_url
                this.loading = false;
            })
      },
      getScategory(){
        this.overlay=true;
        axios.get(`/front/scategory/filter/${this.$route.params.slug}`)
             .then(response =>{
               this.subcategory = response.data;
               this.category_name = this.subcategory[0].category.name;
               this.category_slug = this.subcategory[0].category.slug;
               this.scategory_name = this.subcategory[0].name;
               this.url = this.subcategory[0].category.url;
               this.surl = this.subcategory[0].url;
               this.overlay= false;
             });

      },
      getCity() {
            axios.get(`/all/city`)
                .then(response => {
                    this.city = response.data;
                })
                .catch();
        },

      getNhood() {
            this.loading = true;
            this.nhood_display = false;
            axios.get(`/get/nhood/${this.city_id}`)
                .then(response => {
                    this.localArea = response.data;
                    this.loading = false;
                    this.nhood_display = true;

                })
                .catch()
        },
    },
    computed:{
      type_title(){
        if(this.url === 'property'){
          return "Property Type"
        }else if(this.url === 'job'){
          return "Job Type"
        }else if(this.surl === 'Car'){
          return "Fuel Type"
        }else{
          return "Type";
        }
      },
      filter_title(){
        if(this.url === 'property'){
          return "Furnishing"
        }else if(this.url === 'fashion'){
          return "For"
        }else if(this.url === 'job'){
          return "Salary Period"
        }
      },

      filter_1_title(){
        if(this.url === 'property'){
          return "Listed By"
        }else if(this.url === 'mobile'){
          return "RAM"
        }
      },
      filter_2_title(){
        if(this.url === 'property'){
          return "Car Parking"
        }else if(this.url === 'mobile'){
          return "Memory"
        }
      },

      filter_3_title(){
        if(this.url === 'property'){
          return "Area Unit"
        }
      }
    },
    created(){
        this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
        this.getScategory();
        this.getCity();
    },


    watch:{
      $route(to,from){
        this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
        this.getScategory();
      }
    }

}
</script>
