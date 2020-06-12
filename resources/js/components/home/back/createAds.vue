<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Create Ads</li>
            </ol>
        </nav>
        <div class="container py-5">
        <div class="card-columns">
            <div v-for="(category,index) in categories" :key="index" class="card mt-3" >
                <div class="">
                    <ul class="list-group" >
                    <li class="list-group-item " style="background-color:#2f3b59; color:white"> <i :class="category.icons"> </i>  {{category.name}}</li>
                    <router-link :to="`/create/ads/${cat.slug}`" class="list-group-item list-group-item-action" v-for="(cat,index) in category.scategory" :key="index">
                        <i class="fa fa-angle-right"> </i> {{cat.name}}
                    </router-link>
                </ul>
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
            categories:[],
            url:''
        }
    },
    methods:{
        getCategory(){
            if(!this.loggedIn){
                EventBus.$emit('changeDialog', true);
                this.$router.push("/");
                
                return;
            }
            axios.get(`/menu/subCategory`)
                 .then(response =>{
                     this.categories = response.data;
                 })
                 .catch();
        }
    },
    created(){
        return this.getCategory();
    },

}
</script>
<style scoped>

    .card{
        margin: 0px;
        padding: 0px;
        border:0px;
        border-radius:0px;
    }
    .list-group{
        width:100%;
        margin:0px;
        padding:0px;
        border:0px;
        border-radius:0px;
    }
    
</style>