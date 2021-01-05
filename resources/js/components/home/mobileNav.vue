<template>
  <div style="background-color:#80808026" >
     <v-container>
         <v-row class="text-center" justify="center">
        <v-col cols="3" v-for="(category,index) in categories" :key="index">
        <router-link router :to="`/category/${category.slug}`">
            <div 
            class="pa-5 bg-blue rounded-circle d-inline-block">
                <v-icon medium style="color:white">{{category.icons}}</v-icon> 
            </div>
            <p class="font-weight-black text-dark">
               {{category.name}}
            </p>
        
        </router-link>
        </v-col>
     </v-row>
     </v-container>
  </div>
</template>

<script>
export default {
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

