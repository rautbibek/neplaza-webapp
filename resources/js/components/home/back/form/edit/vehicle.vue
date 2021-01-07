<template>
  <div>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row no-gutters>
        <v-col cols="12" sm="12" md="6" class="pa-0 pr-3">
          <v-autocomplete
            color="#19916B"
            tabindex="1"
            v-model="brand_id"
            :items="scat.brand"
            :item-text="'name'"
            :item-value="'id'"
            label="Brand *"
            :rules="[select('Brand')]"
            outlined
            clearable
          ></v-autocomplete>
        </v-col>
        <v-col cols="12" sm="12" md="6" class="pa-0 pl-3">
          <v-select
            color="#19916B"
            tabindex="2"
            v-model="status"
            :items="scat.status"
            :item-text="'title'"
            :item-value="'id'"
            label="Status *"
            :rules="[select('Status')]"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col cols="12" sm="12" md="6" class="pa-0 pr-3">
          <v-select
            color="#19916B"
            tabindex="3"
            v-model="type"
            :items="scat.type"
            :item-text="'name'"
            :item-value="'id'"
            :label="label"
            :rules="[select('Type')]"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col cols="12" sm="12" md="6" class="pa-0 pl-3">
          <v-text-field
            color="#19916B"
            tabindex="4"
            type="number"
            v-model="property_2"
            label="Lot Number *"
            :rules="[required('Lot Number')]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
        <v-col cols="12" class="pa-0">
          <v-text-field
            color="#19916B"
            tabindex="5"
            type="number"
            v-model="property_1"
            label="KM Driven *"
            :rules="[required('KM Driven')]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
      </v-row>
      <v-divider></v-divider>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Title & Description" }}
      </v-card-title>

      <v-col cols="12" class="p-0">
        <v-text-field
          color="#19916B"
          tabindex="6"
          v-model="title"
          label="Ad Title *"
          counter="100"
          :rules="[
            required('Title'),
            minLength('Title', 10),
            maxLength('Title', 100),
          ]"
          outlined
          clearable
        ></v-text-field>

        <v-textarea
          color="#19916B"
          tabindex="7"
          v-model="description"
          label="Ad description *"
          :rules="[
            required('Description'),
            minLength('Description', 20),
            maxLength('Description', 4000),
          ]"
          counter="4000"
          outlined
          clearable
        ></v-textarea>
      </v-col>
      <v-divider></v-divider>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Address" }}
      </v-card-title>
      <v-col cols="12" class="p-0">
        <v-autocomplete
          color="#19916B"
          tabindex="8"
          v-model="district"
          :items="city"
          :item-text="'name'"
          :item-value="'id'"
          label="District *"
          :rules="[select('District')]"
          outlined
          clearable
          @change="getNhood"
        ></v-autocomplete>
        <div
          class="d-flex justify-content-center"
          style="margin-bottom: 20px"
          v-if="loading"
        >
          <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>
        <v-autocomplete
          color="#19916B"
          tabindex="9"
          v-show="nhood_display && district"
          v-model="nhood"
          :items="localArea"
          :item-text="'name'"
          :item-value="'id'"
          label="Metro/Municipility/VDC *"
          :rules="[select('Metro/Municipility/VDC')]"
          outlined
          clearable
          :loading="loading"
        ></v-autocomplete>

        <v-text-field
          color="#19916B"
          tabindex="10"
          v-model="street"
          label="Location/Area *"
          counter="100"
          :rules="[
            required('Location/Area'),
            minLength('Location/Area', 10),
            maxLength('Location/Area', 100),
          ]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
      <v-divider></v-divider>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        Price
        <v-chip
          v-if="price > 99"
          class="ma-2"
          small
          color="#2f3b59"
          text-color="white"
        >
          Rs. {{ Number(price).toLocaleString() }}
        </v-chip>
      </v-card-title>
      <v-col cols="12" class="p-0">
        <v-text-field
          color="#19916B"
          tabindex="11"
          type="number"
          v-model="price"
          label="Price *"
          :rules="[priceVlidate('Price')]"
          outlined
          clearable
        ></v-text-field>
      </v-col>

      <v-col cols="12 pa-0 text-center ad-button-container">
        <v-btn
          tile
          large
          dark
          color="#2f3b59"
          class="create-ad-button"
          :disabled="!valid"
          @click="submit"
        >
          <v-icon left>save</v-icon>
          update
        </v-btn>
      </v-col>
    </v-form>
  </div>
</template>
<script>
import imageMixins from "../../../../../mixins/editMixin";
export default {
  mixins: [imageMixins],

  computed: {
    label() {
      return this.scat.url === "bike" ? "Type *" : "Fuel Type *";
    },
  },
  methods: {
    getProduct() {
      if (!this.loggedIn) {
        this.$router.push("/");
        EventBus.$emit("changeDialog", true);
        return;
      }
      axios
        .get(`/user/add/product/${this.$route.params.id}/edit`)
        .then((response) => {
          this.product = response.data;

          this.url = this.product.join;
          this.title = this.product.title;
          this.district = this.product.city_id;
          this.nhood = this.product.nhood_id;
          this.price = this.product.price;
          this.description = this.product.description;
          this.street = this.product.address;

          this.brand_id = this.product.brand_id;
          this.type = this.product.type_id;
          this.filter_id = this.product.filter_id;
          this.status = this.product.status_id;
          this.property_2 = this.product.property_2;
          this.property_1 = this.product.property_1;

          this.getNhood();
        });
    },
  },
  mounted() {
    this.getProduct();
  },
};
</script>
<style scoped>
@media screen and (max-width: 959px) {
  .pr-3 {
    padding-right: 0px !important;
  }
  .pl-3 {
    padding-left: 0px !important;
  }
}
</style>
