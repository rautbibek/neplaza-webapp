<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right"><router-link :to="`/user/create/ads`">Create Ads</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">{{scat.name}}</li>
            </ol>
        </nav>
      <div >
        <v-container>
            <div style="min-height:300px">
                <!-- create controller for property -->
                <div v-if="category_url === 'property'">
                    <property :scat="scat"></property>
                </div>
                <div v-else-if="scat.url === 'car' || scat.url === 'bike'">
                    create vehicles {{scat.url}}
                </div>
                <div v-else-if="category_url === 'mobile'">
                    create mobile
                </div>
                <div v-else-if="category_url === 'job'">
                    create jobs
                </div>
                <div v-else>
                    all other items
                </div>
            </div>
        </v-container>
      </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
         scat:[],
         category_url:'',
      }
    },
    methods:{
        getSubcategory(){
            if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
            axios.get(`/create/ads/subcategory/${this.$route.params.slug}`)
                 .then(response => {
                     this.scat = response.data;
                     this.category_url= response.data.category.url;
                 })
        }
    },

    created(){
       return  this.getSubcategory();
    }
}
</script>