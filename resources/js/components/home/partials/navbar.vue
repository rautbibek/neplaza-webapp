<template>
<div v-cloak>
  <div>
      <nav class="navbar navbar-expand-lg navbar-dark d-none d-sm-flex" style="background-color:#2F3B59">
    <ul class="navbar-nav pad">
      <li class="nav-item mr-auto menu-area" >
        <a
          class="nav-link dropdown-toggle active"
          href="#"
          id="navbarDropdown"
          role="button"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >All Category</a>
        <div class="dropdown-menu mega-area" aria-labelledby="navbarDropdown">
          <div class="container-fluid p-3">
            <div class="card-columns">
              <div v-for="(category,index) in categories" :key="index" class="card">
                <div class="card-body">
                  <router-link
                    :to="`/category/${category.slug}`"
                    style="padding:0px; margin-bottom:0px"
                    class="nav-color mb-3"
                  >
                    <span v-cloak
                      class="material-icons"
                      style="font-size: 14px; margin:3px;"
                    >{{category.icons}}</span>
                    <b style="margin-bottom:10px">{{category.name}}</b>
                  </router-link>

                  <router-link
                    :to="`/category/${category.id}/${sub.slug}`"
                    v-for="(sub,index) in category.scategory"
                    :key="index"
                    class="dropdown-item"
                  >
                    <span
                      class="material-icons"
                      style="font-size: 14px; margin:3px;"
                    >keyboard_arrow_right</span>
                    {{sub.name}} &nbsp; ({{sub.product_count}})
                  </router-link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>

    <button
      class="navbar-toggler"
      type="button"
      data-toggle="collapse"
      data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent"  v-cloak>
      <ul class="navbar-nav mr-auto">
        <li v-cloak class="nav-item active mr-2" v-for="(category,index) in cat" :key="index">
          <router-link :to="`/category/${category.slug}`" class="nav-link">
            <span class="material-icons"  v-cloak style="font-size: 14px;">{{category.icons}}</span>
            {{category.name}}
            <span class="sr-only">(current)</span>
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
  <v-navigation-drawer
      v-model="drawer"
      width="85%"
      app
      temporary
    >
    
    <div  class="mt-4 text-center">
      <div class="top-right"><v-btn
              icon
              x-small
              @click="drawer = false"
              color="blue"
            >
              <v-icon>close</v-icon>
            </v-btn></div>
      <router-link to="/">
      <v-img style="display: block;
          margin-left: auto;
          margin-right: auto;
          margin-bottom:5px;
          width: 50%;" src="/image/logo.svg"
          ></v-img>
          </router-link>
          <v-btn x-small text> follow us :</v-btn>
        <v-btn x-small fab
          v-for="(icon,index) in icons"
          :key="index"
          class="white--dark"
          :href="icon.link"
          target="_blank"
          icon
        >
          <v-icon  v-cloak>{{ icon.icon }}</v-icon>
        </v-btn>
    </div>
    <v-divider></v-divider>
      <v-list>
        <v-list-item router :to="`/`">
        <v-list-item-icon>
          <v-icon small>mdi-home</v-icon>
        </v-list-item-icon>
        <v-list-item-title style="font-size:12px"> Home</v-list-item-title>
      </v-list-item>
      <v-list-item router :to="`/contact/us`">
        <v-list-item-icon>
          <v-icon small>mdi-phone</v-icon>
        </v-list-item-icon>
        <v-list-item-title style="font-size:12px">Contact Us</v-list-item-title>
      </v-list-item>
      <v-subheader>Browse all categories</v-subheader>
      
      <v-list-group v-cloak
        v-for="(category,index) in categories" :key="index"
        :prepend-icon="category.icons"
        no-action
      >
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title style="font-size:12px" v-text="category.name"></v-list-item-title>
          </v-list-item-content>
        </template>

        <v-list-item 
          v-for="(scat,index) in category.scategory"
          :key="index"
          router :to="`/category/${category.id}/${scat.slug}`"
        >
          <v-list-item-content>
            <v-list-item-title style="font-size:11px" v-text="scat.name"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-group>
    </v-list>
    </v-navigation-drawer>
  </div>
</div>
  
</template>


<script>
export default {
  data() {
    return {
      categories: {},
      cat: {},
      drawer:false,
      icons: [
        { link: 'https://www.facebook.com/bikribazzar/', icon: 'mdi-facebook' },
        { link: '', icon: 'mdi-twitter' },
        { link: '', icon: 'mdi-linkedin' },
        { link: '', icon: 'mdi-instagram' },
        
      ],
    };
  },
  created() {
    axios.get(this.category_url).then(response => {
      this.cat = response.data;
    });

    axios.get(this.subcategory_url).then(response => {
      this.categories = response.data;
    });
    
    EventBus.$on("navigationDrawer", data => {
      this.drawer = true;
    });
  
  },
  computed: {
    category_url() {
      return `/menu/category`;
    },

    subcategory_url() {
      return `/menu/subCategory`;
    }
  }
};
</script>
<style scoped>
.menu-area {
  position: static;
}
.top-right {
  position: absolute;
  top: 8px;
  right: 16px;
}
.dropdown-item {
  white-space: unset;
}
.mega-area {
  position: absolute;
  width: 100%;
  border-radius: 0px;
  box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
}
.nav-item {
  font-family: "Nunito", sans-serif;
  font-size: 14px;
  text-align: center;
}
@media screen and (min-width: 992px) {
  .navbar-collapse > .navbar-nav {
    align-items: center;
  }
}
.nav-item > a:hover {
  transition: color 0.4s;
  color: #31febd !important;
}
.mb-3 {
  color: #2f3b59 !important;
}
.mb-3:hover {
  color: #19916b !important;
}
.nav-item > a {
  display: flex;
  align-items: center;
}
.nav-item > a > span {
  margin-right: 3px;
}
.dropdown-toggle::after {
  margin-top: 5px;
}
.card {
  background: none;
  border: 0px;
  margin: 0px;
  padding: 0px;
}
.dropdown-item {
  padding: 5px;
  margin-left: 7px;
  color: black;
}
.card-body {
  margin: 0px;
  padding: 10px;
}
.pad {
  padding: 0px;
}
.nav-color {
  color: black;
  text-decoration: none;
}
.card-body > a:hover {
  color: #19916b;
}
.card-body > a:active {
  background: #19916b;
  color: #fff;
}

</style>
