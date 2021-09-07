<template>
  <div>
    <div>
      <nav aria-label="breadcrumb" style="background:white !important">
        <ol class="breadcrumb" style="padding-left: 5px">
          <li class="breadcrumb-item pull-right">
            <router-link :to="`/`">Home</router-link>
          </li>
          <li class="breadcrumb-item pull-right">
            <router-link :to="`/category/${category_slug}`">
              {{ category_name }}
            </router-link>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            {{ scategory_name }}
          </li>
        </ol>
      </nav>
    </div>

    <div>
      <!-- overlay -->
      <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
      </v-overlay>
      <!-- end of overlay -->

      <!-- sort by mobile view -->

      <div class="text-center pa-3">
        <v-bottom-sheet v-model="sheet">
          <v-list>
            <v-col class="text-right pa-0 ma-0">
              <v-btn icon @click="sheet = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-col>

            <v-subheader>-- SORT BY --</v-subheader>
            <v-radio-group @change="filter" class="px-3" v-model="sorting">
              <v-radio
                v-for="(sort, index) in sort"
                :key="index"
                :label="sort.title"
                :value="sort.value"
              ></v-radio>
            </v-radio-group>
          </v-list>
        </v-bottom-sheet>
      </div>
      <!-- end of sort by mobile view -->
      <!-- mobile view filter button and sort by button navigation -->
      <v-row justify="center">
        <v-dialog
          v-model="dialog"
          fullscreen
          hide-overlay
          transition="dialog-bottom-transition"
        >
          <v-card flat v-for="(scat, index) in subcategory" :key="index">
            <v-toolbar dark color="#2f3b59">
              <v-toolbar-title>AD FILTER</v-toolbar-title>
              <v-spacer></v-spacer>
              <v-btn icon dark @click="dialog = false">
                <v-icon small>mdi-close</v-icon>
              </v-btn>
            </v-toolbar>

            <v-container>
              <v-form ref="form">
                <!-- location -->
                <v-card-text>
                  <p class="subtitle-1 text-uppercase font-weight-bold">
                    LOCATIONS
                  </p>
                  <v-autocomplete
                    class="py-1"
                    v-model="city_id"
                    :items="city"
                    :item-text="'name'"
                    :item-value="'id'"
                    outlined
                    clearable
                    dense
                    label="District"
                    append-icon="keyboard_arrow_down"
                    @change="getNhood"
                  ></v-autocomplete>
                  <div
                    class="d-flex justify-content-center"
                    style="margin-bottom: 20px"
                    v-if="loading"
                  >
                    <div class="spinner-border" role="status">
                      <span class="sr-only">Loading...</span>
                    </div>
                  </div>

                  <v-autocomplete
                    v-show="nhood_display && city_id"
                    v-model="nhood_id"
                    :items="localArea"
                    :item-text="'name'"
                    :item-value="'id'"
                    outlined
                    dense
                    clearable
                    label="Metro/Municipility/VDC"
                    append-icon="keyboard_arrow_down"
                  ></v-autocomplete>
                </v-card-text>
                <v-divider></v-divider>
                <!-- location -->
                <!-- price part  -->
                <v-card-text>
                  <p class="subtitle-1 text-uppercase font-weight-bold">
                    BUDGET
                  </p>
                  <v-row>
                    <v-col @mouseout="changing">
                      <v-text-field
                        outlined
                        dense
                        placeholder="Min"
                        type="number"
                        v-model="min_p"
                        label="Min Price"
                      ></v-text-field>
                    </v-col>

                    <v-col class="text-right">
                      <v-text-field
                        @mouseout="changing"
                        outlined
                        dense
                        placeholder="Max"
                        type="number"
                        v-model="max_p"
                        label="Max price"
                      ></v-text-field>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-divider></v-divider>
                <!-- end of price -->
                <!-- type -->
                <div v-if="scat.type.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      {{ type_title }}
                    </p>

                    <v-checkbox
                      v-for="(type, index) in scat.type"
                      :key="index"
                      class="checkbox"
                      multiple
                      v-model="type_id"
                      :label="type.name"
                      :value="type.id"
                    ></v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- end of type -->

                <!-- status -->
                <div v-if="scat.status.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      Status
                    </p>

                    <v-checkbox
                      v-for="(status, index) in scat.status"
                      :key="index"
                      class="checkbox"
                      multiple
                      v-model="status_id"
                      :label="status.title"
                      :value="status.id"
                    ></v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- status end -->

                <!-- brand start -->
                <div v-if="scat.brand.length > 0">
                  <v-card-text style="max-height: 300px; overflow-y: auto">
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      brands
                    </p>
                    <v-checkbox
                      v-for="(brand, index) in scat.brand"
                      :key="index"
                      style="margin: 0px; padding: 0px"
                      multiple
                      v-model="brand_id"
                      :label="brand.name"
                      :value="brand.id"
                    ></v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- end of brand -->
                <!-- filter start -->
                <div v-if="scat.filter.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      {{ filter_title }}
                    </p>
                    <v-checkbox
                      v-for="(filter, index) in scat.filter"
                      :key="index"
                      class="checkbox"
                      v-model="filter_id"
                      :value="filter.id"
                      :label="filter.name"
                      multiple
                    >
                    </v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- filter end -->

                <!-- filter 1 start -->
                <div v-if="scat.filter_1.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      {{ filter_1_title }}
                    </p>
                    <v-checkbox
                      v-for="(filter_1, index) in scat.filter_1"
                      :key="index"
                      class="checkbox"
                      v-model="filter_1_id"
                      :value="filter_1.id"
                      :label="filter_1.name"
                      multiple
                    >
                    </v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- filter 1 end -->

                <!-- filter 2 start -->
                <div v-if="scat.filter_2.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      {{ filter_2_title }}
                    </p>
                    <v-checkbox
                      v-for="(filter_2, index) in scat.filter_2"
                      :key="index"
                      class="checkbox"
                      v-model="filter_2_id"
                      :value="filter_2.id"
                      :label="filter_2.name"
                      multiple
                    >
                    </v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- filter 2 end -->

                <!-- filter 2 start -->
                <div v-if="scat.filter_3.length > 0">
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      {{ filter_3_title }}
                    </p>
                    <v-checkbox
                      v-for="(filter_3, index) in scat.filter_3"
                      :key="index"
                      class="checkbox"
                      v-model="filter_3_id"
                      :value="filter_3.id"
                      :label="filter_3.name"
                      multiple
                    >
                    </v-checkbox>
                  </v-card-text>
                  <v-divider></v-divider>
                </div>
                <!-- filter 2 end -->
              </v-form>
              <v-row>
                <v-col
                  ><v-btn @click="filter" color="primary" dark
                    >Apply Filter</v-btn
                  ><v-btn class="ml-1" @click="clearFilter" color="error" dark
                    >Clear filter</v-btn
                  ></v-col
                >
              </v-row>
            </v-container>
          </v-card>
        </v-dialog>
      </v-row>
      <!--end of mobile view filter button and sort by button navigation -->
      <v-main>
        <v-row no-gutters style="margin: 0px; padding: 0px">
          <!-- desktop view -->
          <v-col
            cols="6"
            lg="3"
            sm="4"
            md="4"
            class="border-right d-none d-sm-flex sidebar"
          >
            <v-container class="mt-2">
              <v-card
                color="#00000000"
                flat
                v-for="(scat, index) in subcategory"
                :key="index"
                class=""
              >
                <!-- form start -->
                <v-form ref="form">
                  <!-- location -->
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      LOCATIONS
                    </p>
                    <v-autocomplete
                      class="py-1"
                      v-model="city_id"
                      :items="city"
                      :item-text="'name'"
                      :item-value="'id'"
                      outlined
                      clearable
                      dense
                      label="District"
                      append-icon="keyboard_arrow_down"
                      @change="getNhood"
                    ></v-autocomplete>
                    <div
                      class="d-flex justify-content-center"
                      style="margin-bottom: 20px"
                      v-if="loading"
                    >
                      <div class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>

                    <v-autocomplete
                      v-show="nhood_display && city_id"
                      v-model="nhood_id"
                      :items="localArea"
                      :item-text="'name'"
                      :item-value="'id'"
                      outlined
                      dense
                      clearable
                      label="Metro/Municipility/VDC"
                      append-icon="keyboard_arrow_down"
                    ></v-autocomplete>
                  </v-card-text>
                  <v-divider></v-divider>
                  <!-- location -->
                  <!-- price part  -->
                  <v-card-text>
                    <p class="subtitle-1 text-uppercase font-weight-bold">
                      BUDGET
                    </p>
                    <v-row>
                      <v-col @mouseout="changing">
                        <v-text-field
                          outlined
                          dense
                          placeholder="Min"
                          type="number"
                          v-model="min_p"
                          label="Min Price"
                        ></v-text-field>
                      </v-col>

                      <v-col class="text-right">
                        <v-text-field
                          @mouseout="changing"
                          outlined
                          dense
                          placeholder="Max"
                          type="number"
                          v-model="max_p"
                          label="Max price"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-card-text>
                  <v-divider></v-divider>
                  <!-- end of price -->
                  <!-- type -->
                  <div v-if="scat.type.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        {{ type_title }}
                      </p>

                      <v-checkbox
                        v-for="(type, index) in scat.type"
                        :key="index"
                        class="checkbox"
                        multiple
                        v-model="type_id"
                        :label="type.name"
                        :value="type.id"
                      ></v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- end of type -->

                  <!-- status -->
                  <div v-if="scat.status.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        Status
                      </p>

                      <v-checkbox
                        v-for="(status, index) in scat.status"
                        :key="index"
                        class="checkbox"
                        multiple
                        v-model="status_id"
                        :label="status.title"
                        :value="status.id"
                      ></v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- status end -->

                  <!-- brand start -->
                  <div v-if="scat.brand.length > 0">
                    <v-card-text style="max-height: 300px; overflow-y: auto">
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        brands
                      </p>
                      <v-checkbox
                        v-for="(brand, index) in scat.brand"
                        :key="index"
                        style="margin: 0px; padding: 0px"
                        multiple
                        v-model="brand_id"
                        :label="brand.name"
                        :value="brand.id"
                      ></v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- end of brand -->
                  <!-- filter start -->
                  <div v-if="scat.filter.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        {{ filter_title }}
                      </p>
                      <v-checkbox
                        v-for="(filter, index) in scat.filter"
                        :key="index"
                        class="checkbox"
                        v-model="filter_id"
                        :value="filter.id"
                        :label="filter.name"
                        multiple
                      >
                      </v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- filter end -->

                  <!-- filter 1 start -->
                  <div v-if="scat.filter_1.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        {{ filter_1_title }}
                      </p>
                      <v-checkbox
                        v-for="(filter_1, index) in scat.filter_1"
                        :key="index"
                        class="checkbox"
                        v-model="filter_1_id"
                        :value="filter_1.id"
                        :label="filter_1.name"
                        multiple
                      >
                      </v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- filter 1 end -->

                  <!-- filter 2 start -->
                  <div v-if="scat.filter_2.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        {{ filter_2_title }}
                      </p>
                      <v-checkbox
                        v-for="(filter_2, index) in scat.filter_2"
                        :key="index"
                        class="checkbox"
                        v-model="filter_2_id"
                        :value="filter_2.id"
                        :label="filter_2.name"
                        multiple
                      >
                      </v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- filter 2 end -->

                  <!-- filter 2 start -->
                  <div v-if="scat.filter_3.length > 0">
                    <v-card-text>
                      <p class="subtitle-1 text-uppercase font-weight-bold">
                        {{ filter_3_title }}
                      </p>
                      <v-checkbox
                        v-for="(filter_3, index) in scat.filter_3"
                        :key="index"
                        class="checkbox"
                        v-model="filter_3_id"
                        :value="filter_3.id"
                        :label="filter_3.name"
                        multiple
                      >
                      </v-checkbox>
                    </v-card-text>
                    <v-divider></v-divider>
                  </div>
                  <!-- filter 2 end -->
                </v-form>
                <v-row>
                  <v-col cols="6"
                    ><v-btn tile @click="filter" color="primary" dark
                      >Apply filter</v-btn
                    ></v-col
                  >
                  <v-col cols="6"
                    ><v-btn tile text @click="clearFilter" color="red" dark
                      >Clear filter</v-btn
                    ></v-col
                  >
                </v-row>

                <!-- end of form -->
              </v-card>
            </v-container>
          </v-col>
          <!-- end of desktop view -->

          <!-- product display column -->
          <v-col cols="12" sm="8" lg="9" md="8" xs="12">
            <v-toolbar
              class="d-sm-none"
              flat
              height="40px"
              style="padding: 0px; background: none"
            >
              <v-row no-gutters>
                <v-col
                  cols="6"
                  class="text-center border-right"
                  @click="sheet = true"
                  style="margin: 0px; padding: 0px"
                >
                  <span class="subtitle-1"> Sort By</span> <v-icon>sort</v-icon>
                </v-col>

                <v-col
                  cols="6"
                  style="margin: 0px; padding: 0px"
                  class="text-center"
                  @click="dialog = true"
                >
                  <span class="subtitle-1"> Filter </span>
                  <v-icon>filter_list</v-icon>
                </v-col>
              </v-row>
            </v-toolbar>

            <div class="d-none d-sm-flex">
              <v-toolbar flat style="background: none">
                <v-spacer></v-spacer>
                <!-- mobile view starts form here -->
                <v-col
                  cols="8"
                  lg="3"
                  md="3"
                  sm="6"
                  xs="8"
                  class="text-right mt-1"
                >
                  <v-select
                    class="mt-4"
                    @change="filter"
                    v-model="sorting"
                    clearable
                    prepend-icon="sort"
                    :items="sort"
                    :item-text="'title'"
                    label="SORT BY"
                    dense
                  ></v-select>
                </v-col>
              </v-toolbar>
            </div>
            <filter-ad
              :all_ads="all_ads"
              class="px-2"
              :count="count"
            ></filter-ad>
            <div class="text-center mt-5 mb-5" v-if="nextUrl">
              <v-btn
                :loading="loading"
                outlined
                tile
                color="#2F3B59"
                class=""
                @click.prevent="more(nextUrl)"
              >
                Load More
                <template v-slot:loader>
                  <span>Loading...</span>
                </template>
                <v-icon right>cached</v-icon>
              </v-btn>
            </div>
          </v-col>
          <!-- end of display product column -->
        </v-row>
      </v-main>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dialog: false,
      nhood_display: false,
      city: [],
      localArea: [],
      subcategory: {},
      type_id: [],
      status_id: [],
      brand_id: [],
      filter_id: [],
      filter_1_id: [],
      filter_2_id: [],
      filter_3_id: [],
      overlay: true,
      loading: false,
      count: 1,
      all_ads: [],
      scategory: {},
      city_id: "",
      nhood_id: "",
      price: [0, 0],
      url: "",
      surl: "",
      min_p: "",
      max_p: "",

      category_name: "",
      category_slug: "",
      scategory_name: "",
      nextUrl: null,
      sheet: false,
      sorting: "",
      sort: [
        {
          title: "Price : High to Low",
          value: 1,
        },
        {
          title: "Price : Low to High",
          value: 2,
        },
        {
          title: "Date : Recent To Old",
          value: 3,
        },
        {
          title: "Date : Old To Recent",
          value: 4,
        },
      ],
    };
  },
  methods: {
    changing() {
      //this.price.push(this.max_p,1)
      this.price[1] = this.max_p;
      this.price[0] = this.min_p;
      this.price;
    },
    favorite() {
      if (this.$loggedIn) {
        this.color = "red";
        this.background = "white";
      } else {
        EventBus.$emit("changeDialog", true);
      }
    },
    filter() {
      this.sheet = false;
      this.dialog = false;
      this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
      window.scrollTo(0, 100);
    },
    fetch(url) {
      this.overlay = true;
      axios
        .get(url, {
          params: {
            type_id: this.type_id,
            status_id: this.status_id,
            filter_id: this.filter_id,
            filter_1_id: this.filter_1_id,
            filter_2_id: this.filter_2_id,
            filter_3_id: this.filter_3_id,
            brand_id: this.brand_id,
            city_id: this.city_id,
            nhood_id: this.nhood_id,
            price: this.price,
            sort: this.sorting,
          },
        })
        .then(({ data }) => {
          this.all_ads = data.data;
          this.count = this.all_ads.length;
          this.nextUrl = data.next_page_url;
          this.count = this.all_ads.length;
          this.all_ads = data.data;
          this.overlay = false;
        })
        .catch((error) => {
          if (error.response.status === 404) {
            window.location.href = "/pageNotFound";
          }
        });
    },
    more(nextUrl) {
      this.loading = true;
      axios.get(nextUrl).then(({ data }) => {
        this.all_ads.push(...data.data);
        this.nextUrl = data.next_page_url;
        this.loading = false;
      });
    },
    getScategory() {
      this.overlay = true;
      axios
        .get(`/front/scategory/filter/${this.$route.params.slug}`)
        .then((response) => {
          this.subcategory = response.data;
          this.category_name = this.subcategory[0].category.name;
          this.category_slug = this.subcategory[0].category.slug;
          this.scategory_name = this.subcategory[0].name;
          this.url = this.subcategory[0].category.url;
          this.surl = this.subcategory[0].url;
          this.overlay = false;
        });
    },
    getCity() {
      axios
        .get(`/all/city`)
        .then((response) => {
          this.city = response.data;
        })
        .catch();
    },

    getNhood() {
      this.loading = true;
      this.nhood_display = false;
      axios
        .get(`/get/nhood/${this.city_id}`)
        .then((response) => {
          this.localArea = response.data;
          this.loading = false;
          this.nhood_display = true;
        })
        .catch();
    },
    clearFilter() {
      (this.type_id = []), (this.status_id = []);
      this.filter_id = [];
      this.filter_1_id = [];
      this.filter_2_id = [];
      this.filter_3_id = [];
      this.brand_id = [];
      this.city_id = [];
      this.nhood_id = [];
      this.price = [0, 0];
      this.sorting = "";
      this.min_p = "";
      this.max_p = "";
      this.filter();
    },
  },
  computed: {
    display() {
      switch (this.$vuetify.breakpoint.name) {
        case "xs":
          return "d-none d-sm-flex";
        case "sm":
          return "d-none d-sm-flex";
        case "md":
          return "";
        case "lg":
          return "";
        case "xl":
          return "";
      }
    },
    type_title() {
      if (this.url === "property") {
        return "Property Type";
      } else if (this.url === "job") {
        return "Job Type";
      } else if (this.surl === "car") {
        return "Fuel Type";
      } else {
        return "Type";
      }
    },
    filter_title() {
      if (this.url === "property") {
        return "Furnishing";
      } else if (this.url === "fashion") {
        return "For";
      } else if (this.url === "job") {
        return "Salary Period";
      }
    },

    filter_1_title() {
      if (this.url === "property") {
        return "Listed By";
      } else if (this.url === "mobile") {
        return "RAM";
      }
    },
    filter_2_title() {
      if (this.url === "property") {
        return "Car Parking";
      } else if (this.url === "mobile") {
        return "Memory";
      }
    },

    filter_3_title() {
      if (this.url === "property") {
        return "Area Unit";
      }
    },
  },
  created() {
    this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
    this.getScategory();
    this.getCity();
  },
  metaInfo() {
    return {
      meta: [
        { name: "title", content: this.scategory_name },
        { property: "og:title", content: this.scategory_name },
        { property: "og:site_name", content: "Bikribazzar" },
        { property: "og:type", content: "website" },
        { name: "robots", content: "index,follow" },
      ],
    };
  },

  watch: {
    $route(to, from) {
      this.fetch(`/front/scategory/product/${this.$route.params.slug}`);
      this.getScategory();
    },
  },
};
</script>
<style scoped>
.sidebar {
  height: calc(100vh - 50px);
  overflow-y: scroll;
  position: sticky;
  top: 50px;
}
::-webkit-scrollbar {
  width: 5px;
}
::-webkit-scrollbar-track {
  background-color: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background-color: rgb(190, 185, 185);
}

.checkbox {
  margin: 0px;
  padding: 0px;
}

.v-input__slot {
  margin-bottom: 0px;
}

.theme--light.v-label {
  color: #000000ed;
}
label {
  margin-bottom: 0rem;
}
</style>
