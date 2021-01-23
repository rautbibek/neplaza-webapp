<template>
  <div>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row no-gutters>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            scat.filter.length || scat.status.length || scat.type.length
              ? '6'
              : '12'
          "
          v-if="scat.brand.length"
        >
          <v-autocomplete
            v-if="brand_count > 0"
            v-model="brand_id"
            :items="scat.brand"
            :item-text="'name'"
            :item-value="'id'"
            label="Brand *"
            tabindex="1"
            color="#19916B"
            outlined
            clearable
          ></v-autocomplete>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            scat.filter.length || scat.status.length || scat.brand.length
              ? '6'
              : '12'
          "
          v-if="scat.type.length"
        >
          <v-select
            v-model="type"
            :items="scat.type"
            tabindex="2"
            color="#19916B"
            :item-text="'name'"
            :item-value="'id'"
            label="Type *"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            scat.type.length || scat.status.length || scat.brand.length
              ? '6'
              : '12'
          "
          v-if="scat.filter.length"
        >
          <v-select
            v-model="filter_id"
            :items="scat.filter"
            :item-text="'name'"
            :item-value="'id'"
            label="For *"
            tabindex="3"
            color="#19916B"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            scat.type.length || scat.filter.length || scat.brand.length
              ? '6'
              : '12'
          "
          v-if="scat.status.length"
        >
          <v-select
            v-model="status"
            :items="scat.status"
            color="#19916B"
            tabindex="4"
            :item-text="'title'"
            :item-value="'id'"
            label="Status *"
            outlined
            clearable
          ></v-select>
        </v-col>
      </v-row>
      <v-divider
        v-if="
          scat.brand.length ||
          scat.type.length ||
          scat.filter.length ||
          scat.status.length
        "
      ></v-divider>
      <div>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
          {{ "Title & Description" }}
        </v-card-title>

        <v-col class="p-0">
          <v-text-field
            v-model="title"
            label="Ad Title *"
            tabindex="5"
            counter="100"
            color="#19916B"
            :rules="[
              required('Title'),
              minLength('Title', 10),
              maxLength('Title', 100),
            ]"
            outlined
            clearable
          ></v-text-field>

          <v-textarea
            tabindex="6"
            v-model="description"
            label="Ad description *"
            :rules="[
              required('Description'),
              minLength('Description', 20),
              maxLength('Description', 4000),
            ]"
            counter="4000"
            outlined
            color="#19916B"
            clearable
          ></v-textarea>
        </v-col>
      </div>
      <v-divider></v-divider>
      <div>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
          {{ "Address" }}
        </v-card-title>
        <v-col cols="12" class="p-0">
          <v-autocomplete
            v-model="district"
            :items="city"
            color="#19916B"
            tabindex="7"
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
            v-show="nhood_display && district"
            v-model="nhood"
            :items="localArea"
            color="#19916B"
            tabindex="8"
            :item-text="'name'"
            :item-value="'id'"
            label="Metro/Municipility/VDC *"
            :rules="[select('Metro/Municipility/VDC')]"
            outlined
            clearable
            :loading="loading"
          ></v-autocomplete>

          <v-text-field
            tabindex="9"
            v-model="street"
            label="Location/Area *"
            counter="100"
            color="#19916B"
            :rules="[
              required('Location/Area'),
              maxLength('Location/Area', 100),
            ]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
      </div>

      <v-divider></v-divider>
      <div>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
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
        <v-col class="p-0">
          <v-text-field
            type="number"
            color="#19916B"
            tabindex="10"
            min="0"
            v-model="price"
            label="Price *"
            :rules="[priceVlidate('price')]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
      </div>

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
          Update
        </v-btn>
      </v-col>
    </v-form>
  </div>
</template>
<script>
import imageMixins from "../../../../../mixins/editMixin";
export default {
  props: ["brand_count", "filter_count", "status_count", "type_count"],
  mixins: [imageMixins],
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
          this.brand_id = this.product.brand_id;
          this.type = this.product.type_id;
          this.filter_id = this.product.filter_id;
          this.status = this.product.status_id;
          this.street = this.product.address;
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