<template>
  <div class="mt-3">
    <v-card outlined tile>
      <v-card-title> <v-icon>mdi-filter</v-icon> FILTER</v-card-title>
      <v-card-subtitle>sub category name</v-card-subtitle>
      <!-- PART ONE -->
        <v-divider></v-divider>
          <v-card-text>
            <h5 class="title mb-2"> <v-icon>mdi-map-marker</v-icon>  Location</h5>
            <v-select class="py-2" style="border-radius:0px"
              v-model="district"
              
              outlined
              label="District"
              append-icon="mdi-map-marker"
              
            ></v-select>

            <v-select class="py-1" style="border-radius:0px"
              v-model="metro"
              
              outlined
              label="Metro"
              append-icon="mdi-map-marker"
              
            ></v-select>
          </v-card-text>

          <!-- PART 2 -->
        <v-divider></v-divider>
          <v-card-text>
          <h5 class="title mb-2">Furnishing Type</h5>
            <v-chip-group
              v-model="bedroom"
              column
              multiple
            >
              <v-chip filter value="10" outlined>Fully Furnished</v-chip>
              <v-chip filter value="12" outlined>Unfurnished</v-chip>
              <v-chip filter value="50" outlined>Semi-Furnished</v-chip>
            </v-chip-group>
          </v-card-text>
        <v-divider></v-divider>
        <!-- PART 3 -->
          <v-card-text>
          <h5 class="title mb-2">Status</h5>
            <v-chip-group
              v-model="type"
              column
              multiple
            >
              <v-chip filter value="10" outlined>Fully Furnished</v-chip>
              <v-chip filter value="12" outlined>Unfurnished</v-chip>
              <v-chip filter value="50" outlined>Semi-Furnished</v-chip>
            </v-chip-group>
          </v-card-text>
        <v-divider></v-divider>
        <!-- PART 4 -->
          <v-card-text>
          <h5 class="title mb-2">Brand</h5>
            <v-chip-group
              v-model="status"
              column
              multiple
            >
              <v-chip filter value="10" outlined>Fully Furnished</v-chip>
              <v-chip filter value="12" outlined>Unfurnished</v-chip>
              <v-chip filter value="50" outlined>Semi-Furnished</v-chip>
            </v-chip-group>
          </v-card-text>
    </v-card>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        bedroom:[],
        status:[],
        type:[],
        district:'',
        metro:'',
        subcategory:{},
      }
    },
    methods:{
      getScategory(){
        axios.get(`/front/scategory/filter/${this.$route.params.slug}`)
             .then(response =>{
               this.subcategory = response.data;
               console.log(this.subcategory);
             })
             .catch()
      }
    },
    created(){
      this.getScategory();
    }
  }
</script>