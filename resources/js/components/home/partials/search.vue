<template>
<div class="col-md-11  search" >
        <div class="input-group" >
            <input class="form-control searchinput" value="`${this.$route.query.q}`" @select="show==true" @keyup="search" v-model="keyword" type="text" @keydown.enter="submit"  placeholder="Enter your search keyword..." aria-label="Search">
            <div class="input-group-append ">
                    <a href="javascript:void(0)" class="input-group-text searchbtn" @click="submit()">
                      <span class="material-icons" style="color:white">
                       search
                     </span>
                    </a>
            </div>
        </div>

        <div class="autocomplete " style="margin-top:-22px" v-show="show" v-if="searchResult.length" >
          <div class="container">
           <ul class="list-group" @click="select">
            <router-link :to='`/search/?q=${search.title}`'  class="list-group-item" v-for="search in searchResult" :key="search.id">
              <b>{{search.category.name}}</b><br>
              {{search.title}}

            </router-link>
          </ul>
        </div>
      </div>
    </div>
</template>
<script>

$("body").click
(
  function(e)
  {
    if(e.target.className !== "search")
    {
      $(".autocomplete").hide();
    }
  }
);
export default {
  data(){
    return{

      keyword:'',
      show:false,
      searchResult:[],
    }
  },
  methods:{
    submit(){
        this.show=false;
        if(this.keyword){
          this.$router.replace({path: '/search/', query: { q: this.keyword} }).catch(err => {});
        }
      },
    select(){
        this.keyword = this.$route.query.q;
        this.show=false;
      },
    search:_.debounce(function(){

       axios.get('/ad/search',
          {params:{
            search : this.keyword,
          }}
        )
          .then((response) =>{
            this.show = true;
            this.searchResult = response.data;

          })
        .catch();
    },2000)
  },
  mounted(){
      this.keyword = this.$route.query.q;
  },
  watch:{
      $route(to,from){
        //return this.search();
        //console.log(this.cat_posts);
        this.keyword = this.$route.query.q;


      }
    },

}

</script>
<style scoped>
  .form-control{
    border-radius:0px;
  }
  .searchinput {
    font-size: 14px;
  }
  .input-group{
    border-radius:0px;
    border:1px solid #D9D9D9;
    border-right: 0px;
  }
 .autocomplete {
    position: absolute;
    width: 100%;
    z-index: 1000;
    display: inline-block;
    top: 100%;
    overflow:hidden;
    max-height: 410px;
    left:0;
  }
  .form-control:focus{
      border-color:white;
      box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075), 0 0 8px #2f3b59;
  }

   .searchbtn:focus{
      box-shadow:none;
  }


  .searchbtn{
    background-color:#2f3b59;
  }

  a{
    color: black !important;
  }
  ul{
    padding:0px !important;
  }
  input[type="text"]::-webkit-search-cancel-button {
    -webkit-appearance: searchfield-cancel-button;
  }



</style>
