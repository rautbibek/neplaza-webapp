<template>
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#2F3B59">
    <ul class="navbar-nav pad">
      <li class="nav-item mr-auto menu-area">
        <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          All Category
        </a>
        <div class="dropdown-menu mega-area" aria-labelledby="navbarDropdown">  
            <div class="container-fluid p-3">
                <div class="card-columns">
                    <div v-for="(category,index) in categories" :key="index" class="card">
                        <div class="card-body">

                            <router-link :to="`/category/${category.slug}`" style="padding:0px; margin:0px" class="nav-color"> <i :class="category.icons"> 
                                </i> <strong>{{category.name}}</strong></router-link>
                            
                            <router-link :to="`/category/${category.id}/${sub.slug}`" v-for="(sub,index) in category.scategory" :key="index" 
                             class="dropdown-item">
                              <i class="fa fa-angle-right"></i> {{sub.name}}
                            </router-link>
                        </div>
                    </div>
                </div>
          </div>
        </div>
      </li>
    </ul>

  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active mr-2" v-for="(category,index) in cat" :key="index">
        <router-link :to="`/category/${category.slug}`" class="nav-link" href="#"> <i :class="category.icons"></i> 
        {{category.name}} <span class="sr-only">(current)</span></router-link>
      </li>
    </ul>
  </div>
</nav>
</template>


<script>
export default {
    data(){
        return{
            categories:{},
            cat:{},
        }
    },
    created(){
        axios.get(this.category_url)
             .then(response =>{
                 this.cat =response.data;
             });

        axios.get(this.subcategory_url)
             .then(response =>{
              this.categories = response.data;
        });
    },
    computed:{
        category_url(){
            return `/menu/category`;    
        },

        subcategory_url(){
           return `/menu/subCategory`;  
        }
    
    }

}
</script>
<style scoped>
    .menu-area{
        position: static;
    }
    .mega-area{
        position:absolute;
        width: 100%;
        border-radius:0px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    }
    .card{
        background: none;
        border:0px;
        margin: 0px;
        padding: 0px;
    }
    .dropdown-item{
        padding:5px;
        margin-left:7px;
        color:black;
    }
    .card-body{
        margin:0px;
        padding:10px;
    }
    .pad{
        padding:0px;
    }
    .nav-color{
        color:black;
        text-decoration:none;
    }
    /* .dropdown-toggle::after {
        content: "\f107" !important ;
    } */
    /* .dropdown-toggle::after:hover {
        content: "\f105" !important ;
    } */

</style>