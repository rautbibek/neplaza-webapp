<template>
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#2F3B59">
    <ul class="navbar-nav pad">
      <li class="nav-item mr-auto menu-area">
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
                    <span
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

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active mr-2" v-for="(category,index) in cat" :key="index">
          <router-link :to="`/category/${category.slug}`" class="nav-link">
            <span class="material-icons" style="font-size: 14px;">{{category.icons}}</span>
            {{category.name}}
            <span class="sr-only">(current)</span>
          </router-link>
        </li>
      </ul>
    </div>
  </nav>
</template>


<script>
export default {
  data() {
    return {
      categories: {},
      cat: {}
    };
  },
  created() {
    axios.get(this.category_url).then(response => {
      this.cat = response.data;
    });

    axios.get(this.subcategory_url).then(response => {
      this.categories = response.data;
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
}
.navbar-collapse > .navbar-nav {
  align-items: center;
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
