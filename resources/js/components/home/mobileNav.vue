<template>
  <div style="background-color:#eef3eb" >
     <v-container>
      <v-row><v-col><h4 class="text-caption">Brows Categories</h4></v-col></v-row>
      <vue-horizontal scroll :button="false">
        <section v-for="(category,index) in categories" :key="index" style="width:110px;" class=" text-center" >
          <router-link router :to="`/category/${category.slug}`" >
              <div 
              class="pa-3 bg-blue rounded-circle d-inline-block">
                  <v-icon large style="color:white">{{category.icons}}</v-icon> 
              </div>
              <p class="font-weight-black text-dark">
                {{category.name}}
              </p>
          
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

