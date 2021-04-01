<template>
  <div style="background-color:#eef3eb">
     <v-container>
      <v-row>
        <v-col cols="9"><h4 class="text-caption">Browse Categories</h4></v-col>
        <v-col cols="3" class="text-right" >
          <u>
            <h4 @click="navigationDrawer" class="text-caption">
            View All
          </h4>
          </u>
          </v-col>
      </v-row>
      <vue-horizontal scroll :button="false">
        <section v-cloak v-for="(category,index) in categories" :key="index" style="width:110px;" class=" text-center">
          <router-link router :to="`/category/${category.slug}`" >
              <div  v-cloak style="background:#1b3063eb"
              class="pa-3 rounded-circle d-inline-block" >
                  <v-icon  v-cloak medium style="color:white">{{category.icons}}</v-icon> 
              </div>
              <h4 class="text-caption text-dark">
                {{category.name}}
              </h4>
          
          </router-link>
        </section>
      </vue-horizontal>
     </v-container>
  </div>
</template>

<script>
import VueHorizontal from "vue-horizontal";
export default {
  components: {VueHorizontal},
  data() {
    return {
      categories: {},
    };
  },
  methods:{
    navigationDrawer(){
      EventBus.$emit("navigationDrawer", true);
    },
  },
  created() {
    axios.get(this.subcategory_url).then(response => {
      this.categories = response.data;
    });
  },
  computed: {

    subcategory_url() {
      return `/menu/subCategory`;
    }
  }
};
</script>

