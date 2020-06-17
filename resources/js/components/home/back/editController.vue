<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right"><router-link :to="`/user/myads`">My Ads</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Ad {{status_count}}</li>
                <li class="breadcrumb-item active" aria-current="page">{{name}}</li>
            </ol>
        </nav>
      <div >
        <div class="container">
            <div style="min-height:300px" v-if="product">
                              
                <!-- create controller for property -->
                <div v-if="category_url === 'property'">
                    <editproperty :product='product' :scat='scat'></editproperty>
                </div>
                <div v-else-if="scat_url === 'car' || scat_url === 'bike'">
                    <editvehicle :product="product" :scat='scat'></editvehicle>
                </div>
                <div v-else-if="category_url === 'mobile'">
                    <editmobile :product="product" :scat='scat'></editmobile>
                </div>
                <div v-else-if="category_url === 'job'">
                    <editjobs :product="product" :scat='scat'></editjobs>
                </div>
                <div v-else>
                    <edit-other 
                        :product="product" 
                        :scat='scat' 
                        :brand_count="brand_count"
                        :filter_count="filter_count"
                        :type_count="type_count"
                        :status_count="status_count"
                    ></edit-other>
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
         scat_url:'',
         product:[],
         scat:[],
         category_url:'',
         name:'',
         brand_count:0,
         filter_count:0,
         type_count:0,
         status_count:0,
      }
    },
    methods:{
        getSubcategory(url) {
            
            axios.get(url)
                .then(response => {
                    this.scat = response.data;
                    this.brand_count  = this.scat.brand.length;
                    this.filter_count = this.scat.filter.length;
                    this.type_count   = this.scat.type.length;
                    this.status_count = this.scat.status.length;
                })
        },

        getProduct(){
        if (!this.loggedIn) {
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
        axios.get(`/user/add/product/${this.$route.params.id}/edit`)
             .then(response =>{
                 this.product = response.data;
                 this.category_url = this.product.category.url;
                 this.scat_url = this.product.scategory.url;
                 this.name = this.product.scategory.name;
                 let slug = this.product.scategory.slug;
                 this.getSubcategory(`/create/ads/subcategory/${slug}`);
             })
        }
    },

    created(){
        
       this.getProduct();
    }
}
</script>