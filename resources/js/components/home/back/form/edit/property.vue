<template>
  <div>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-form ref="form" v-model="valid" lazy-validation>
      <v-row no-gutters>
        <v-col cols="12" sm="12" md="6" class="pa-0 pr-3">
          <v-select
            class="textfield"
            v-model="type"
            :items="scat.type"
            :item-text="'name'"
            :item-value="'id'"
            label="Type *"
            tabindex="1"
            color="#19916B"
            :rules="[select('Type')]"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          md="6"
          class="pa-0 pl-3"
          v-if="scat.url !== 'land'"
        >
          <v-select
            v-model="status"
            :items="scat.status"
            :item-text="'title'"
            :item-value="'id'"
            tabindex="2"
            class="textfield"
            color="#19916B"
            label="Construction Status *"
            :rules="[select('Status')]"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          md="6"
          class="pa-0"
          v-bind:class="scat.url !== 'land' ? 'pr-3' : 'pl-3'"
        >
          <v-select
            v-model="filter_1_id"
            :items="scat.filter_1"
            :item-text="'name'"
            class="textfield"
            tabindex="3"
            color="#19916B"
            :item-value="'id'"
            label="Listed By *"
            :rules="[select('Listed by')]"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          md="6"
          sm="12"
          class="pa-0"
          v-bind:class="scat.url !== 'land' ? 'pl-3' : 'pr-3'"
        >
          <v-text-field
            type="number"
            v-model="property_3"
            class="textfield"
            tabindex="4"
            color="#19916B"
            label="Builtup Area *"
            :rules="[required('Builtup Area')]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
        <v-col
          cols="12"
          xs="12"
          class="pa-0"
          v-bind:class="scat.url === 'land' && 'pl-3'"
          v-bind:md="scat.url !== 'land' ? '12' : '6'"
        >
          <v-select
            v-model="filter_3_id"
            tabindex="5"
            :items="scat.filter_3"
            :item-text="'name'"
            color="#19916B"
            :item-value="'id'"
            class="textfield"
            label="Builtup Area unit*"
            :rules="[select('Area unit')]"
            outlined
            clearable
          ></v-select>
        </v-col>
      </v-row>
      <div v-if="scat.url !== 'land'">
        <v-divider></v-divider>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
          More Details
        </v-card-title>
        <v-row no-gutters>
          <v-col cols="12" sm="12" md="6" class="p-0 pr-3">
            <v-select
              v-model="filter_2_id"
              :items="scat.filter_2"
              :item-text="'name'"
              class="textfield"
              tabindex="6"
              color="#19916B"
              :item-value="'id'"
              label="Car Parking *"
              :rules="[select('Car parking')]"
              outlined
              clearable
            ></v-select>
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="6"
            class="p-0 pl-3"
            v-if="scat.url !== 'shop'"
          >
            <v-select
              v-model="property_1"
              :items="bedroom_items"
              label="Bedroom *"
              tabindex="7"
              color="#19916B"
              class="textfield"
              :rules="[select('Bedroom')]"
              outlined
              clearable
            ></v-select>
          </v-col>
          <v-col
            cols="12"
            sm="12"
            md="6"
            class="p-0"
            v-bind:class="scat.url !== 'shop' ? 'pr-3' : 'pl-3'"
          >
            <v-select
              v-model="property_2"
              :items="bathroom_items"
              label="Bathroom *"
              tabindex="8"
              color="#19916B"
              class="textfield"
              :rules="[select('Bathroom')]"
              outlined
              clearable
            ></v-select>
          </v-col>
          <v-col
            cols="12"
            sm="12"
            v-bind:md="scat.url !== 'shop' ? '6' : '12'"
            class="p-0"
            v-bind:class="scat.url !== 'shop' && 'pl-3'"
          >
            <v-select
              v-model="filter_id"
              :items="scat.filter"
              :item-text="'name'"
              class="textfield"
              :item-value="'id'"
              tabindex="9"
              color="#19916B"
              label="Furnishing *"
              :rules="[select('Furnishing')]"
              outlined
              clearable
            ></v-select>
          </v-col>
        </v-row>
      </div>
      <v-divider></v-divider>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Title & Description" }}
      </v-card-title>

      <v-col class="p-0">
        <v-text-field
          v-model="title"
          label="Ad Title *"
          class="textfield"
          tabindex="10"
          color="#19916B"
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
          v-model="description"
          label="Ad description *"
          tabindex="11"
          class="textfield"
          color="#19916B"
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
      <v-row no-gutters>
        <v-col cols="12" class="p-0">
          <v-autocomplete
            v-model="district"
            :items="city"
            :item-text="'name'"
            :item-value="'id'"
            tabindex="12"
            class="textfield"
            label="District *"
            color="#19916B"
            :rules="[select('District')]"
            outlined
            clearable
            :loading="loading"
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
            class="textfield"
            :items="localArea"
            color="#19916B"
            tabindex="13"
            :item-text="'name'"
            :item-value="'id'"
            label="Metro/Municipility/VDC *"
            :rules="[select('Metro/Municipility/VDC')]"
            outlined
            clearable
          ></v-autocomplete>

          <v-text-field
            v-model="street"
            label="Location/Area *"
            class="textfield"
            tabindex="14"
            counter="100"
            color="#19916B"
            :rules="[
              required('Location/Area'),
              minLength('Location/Area', 10),
              maxLength('Location/Area', 100),
            ]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
      </v-row>
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
      <v-col class="p-0">
        <v-text-field
          style="border-radius: 0px; margin-bottom: 20px"
          type="number"
          v-model="price"
          class="textfield"
          color="#19916B"
          tabindex="15"
          label="Price *"
          :rules="[priceVlidate('price')]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
      <v-divider></v-divider>

      <v-col cols="12 pa-0 text-center ad-button-container">
        <v-btn
          tile
          large
          dark
          color="#2f3b59"
          :disabled="!valid"
          class="create-ad-button"
          @click="submit"
        >
          <v-icon left>save</v-icon>
          Update</v-btn
        >
      </v-col>
    </v-form>
  </div>
</template>
<script>
import imageMixins from "../../../../../mixins/editMixin";
export default {
  mixins: [imageMixins],
  data() {
    return {
      bedroom_items: ["1", "2", "3", "4", "5", "6+"],
      bathroom_items: ["1", "2", "3", "4+"],
    };
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
          this.filter_id = this.product.filter_id;
          this.filter_1_id = this.product.filter_1_id;
          this.filter_2_id = this.product.filter_2_id;
          this.filter_3_id = this.product.filter_3_id;
          this.property_1 = this.product.property_1;
          this.property_2 = this.product.property_2;
          this.property_3 = this.product.property_3;
          this.status = this.product.status_id;
          this.type = this.product.type_id;
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
