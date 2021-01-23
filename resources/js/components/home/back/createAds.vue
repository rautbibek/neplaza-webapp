<template>
  <div>
    <nav aria-label="breadcrumb ">
      <ol class="breadcrumb">
        <li class="breadcrumb-item pull-right">
          <router-link :to="`/`">Home</router-link>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Sell</li>
      </ol>
    </nav>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <div class="cover-image">
      <h3 class="text-center">Select a Category</h3>
    </div>
    <v-container class="cover-container create-ad mb-5">
      <v-expansion-panels>
        <v-expansion-panel v-for="(category, index) in categories" :key="index">
          <v-expansion-panel-header>
            <v-icon style="display:block;" :to="`/category/${category.slug}`"
            left
            medium
          >{{category.icons}}</v-icon>{{ category.name }}
          </v-expansion-panel-header>
          <v-expansion-panel-content class="panel-content">
            <ul class="list-group">
              <router-link
                :to="`/create/ads/${cat.slug}`"
                class="list-group-item list-group-item-action"
                v-for="(cat, index) in category.scategory"
                :key="index"
              >
                {{ cat.name }}
              </router-link>
            </ul>
          </v-expansion-panel-content>
        </v-expansion-panel>
      </v-expansion-panels>
    </v-container>
  </div>
</template>
<script>
export default {
  data() {
    return {
      overlay: false,
      categories: [],
      url: "",
    };
  },
  methods: {
    getCategory() {
      this.overlay = true;
      if (!this.loggedIn) {
        EventBus.$emit("changeDialog", true);
        this.$router.push("/");
        this.overlay = false;
        return;
      }
      axios
        .get(`/menu/subCategory`)
        .then((response) => {
          this.categories = response.data;
          this.overlay = false;
        })
        .catch();
    },
  },
  created() {
    return this.getCategory();
  },
};
</script>
<style scoped>
.card {
  margin: 0px;
  padding: 0px;
  border: 0px;
  border-radius: 0px;
}
.list-group {
  width: 100%;
  margin: 0px;
  padding: 0px;
  border: 0px;
  border-radius: 0px;
}
a:hover {
  color: #19916b;
}
.v-expansion-panel-header > *:not(.v-expansion-panel-header__icon) {
    flex: none;
}
</style>