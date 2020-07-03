<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right"><router-link :to="`/user/create/ads`">Create Ads</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{scat.name}}</li>
            </ol>
        </nav>
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
      <div >
        <div class="container">
            <div style="min-height:300px">
                              
                <!-- create controller for property -->
                <div v-if="category_url === 'property'">
                    <property :scat="scat"></property>
                </div>
                <div v-else-if="scat.url === 'car' || scat.url === 'bike'">
                    <vehicle :scat="scat"></vehicle>
                </div>
                <div v-else-if="category_url === 'mobile'">
                    <mobile :scat="scat"></mobile>
                </div>
                <div v-else-if="category_url === 'job'">
                    <jobs :scat="scat"></jobs>
                </div>
                <div v-else>
                    <other :scat="scat"></other>
                </div>
            </div>
        </div>
      </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
          overlay:false,
         scat:{},
         category_url:'',
      }
    },
    methods:{
        getSubcategory(){
            this.overlay=true;
            if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                this.overlay = false;
                return;
            }
            axios.get(`/create/ads/subcategory/${this.$route.params.slug}`)
                 .then(response => {
                     this.scat = response.data;
                     this.category_url= response.data.category.url;
                     this.overlay = false;
                 })
        }
    },

    created(){
        
       this.getSubcategory();
    }
}
</script>