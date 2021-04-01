<template>
<div>
  <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  <v-form ref="form" v-model="valid" lazy-validation>
    <div v-for="(subcategory, index) in sub" :key="index">
      <v-row no-gutters>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            subcategory.filter.length ||
            subcategory.status.length ||
            subcategory.type.length
              ? '6'
              : '12'
          "
          v-if="subcategory.brand.length"
        >
          <v-autocomplete
            v-model="brand_id"
            :items="subcategory.brand"
            :item-text="'name'"
            tabindex="1"
            :item-value="'id'"
            color="#19916B"
            label="Brand *"
            outlined
            clearable
          ></v-autocomplete>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            subcategory.filter.length ||
            subcategory.status.length ||
            subcategory.brand.length
              ? '6'
              : '12'
          "
          v-if="subcategory.type.length"
        >
          <v-select
            v-model="type"
            :items="subcategory.type"
            :item-text="'name'"
            tabindex="2"
            :item-value="'id'"
            color="#19916B"
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
            subcategory.type.length ||
            subcategory.status.length ||
            subcategory.brand.length
              ? '6'
              : '12'
          "
          v-if="subcategory.filter.length"
        >
          <v-select
            v-model="filter_id"
            :items="subcategory.filter"
            :item-text="'name'"
            tabindex="3"
            :item-value="'id'"
            color="#19916B"
            label="For *"
            outlined
            clearable
          ></v-select>
        </v-col>
        <v-col
          cols="12"
          sm="12"
          class="pa-0 pr-3"
          v-bind:md="
            subcategory.type.length ||
            subcategory.filter.length ||
            subcategory.brand.length
              ? '6'
              : '12'
          "
          v-if="subcategory.status.length"
        >
          <v-select
            v-model="status"
            :items="subcategory.status"
            :item-text="'title'"
            tabindex="4"
            :item-value="'id'"
            color="#19916B"
            label="Status *"
            outlined
            clearable
          ></v-select>
        </v-col>
      </v-row>
      <v-col cols="12" class="p-0">
      
      </v-col>
      
    </div>

    <v-col cols="12" class="p-0 pr-3">
      <v-select
          v-model="delivery"
          :items="delivery_option"
          :item-text="'name'"
          :item-value="'name'"
          tabindex="4"
          label="Delivery Option *"
          color="#19916B"
          outlined
          clearable
        ></v-select>
      </v-col>
        <v-divider></v-divider>
    <div>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
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
          v-model="description"
          tabindex="6"
          label="Ad description *"
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
    </div>
    <v-divider></v-divider>
    <div>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Address" }}
      </v-card-title>
      <v-col cols="12" class="p-0">
        <v-autocomplete
          v-model="district"
          :items="city"
          :item-text="'name'"
          tabindex="7"
          :item-value="'id'"
          label="District *"
          color="#19916B"
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
          tabindex="8"
          :items="localArea"
          :item-text="'name'"
          :item-value="'id'"
          color="#19916B"
          label="Metro/Municipility/VDC *"
          :rules="[select('Metro/Municipility/VDC')]"
          outlined
          clearable
          :loading="loading"
        ></v-autocomplete>

        <v-text-field
          v-model="street"
          tabindex="9"
          label="Street Address *"
          color="#19916B"
          counter="100"
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
          type="number"
          v-model="price"
          min="0"
          tabindex="10"
          color="#19916B"
          label="Price *"
          :rules="[required('Price'), priceVlidate('Price')]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
    </div>
    <v-divider></v-divider>
    <div class="m-2">
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        Select Image
      </v-card-title>
      <v-col cols="12" class="p-0">
        <div class="form-group">
          <div
            class="uploader"
            @dragenter="OnDragEnter"
            @dragleave="OnDragLeave"
            @dragover.prevent
            @drop="onDrop"
            :class="{ dragging: isDragging }"
          >
            <div class="upload-control" v-show="image.length">
              <label for="file">Select a file</label>
            </div>

            <div v-show="!image.length">
              <i class="fa fa-cloud-upload"></i>
              <p>Drag your image here</p>
              <div>OR</div>
              <div class="file-input">
                <label for="file">Select a file</label>
                <input
                  type="file"
                  tabindex="11"
                  id="file"
                  @change="onInputChange"
                  multiple
                />
              </div>
            </div>

            <div class="image-preview" v-show="image.length">
              <div
                class="img-wrapper"
                v-for="(image, index) in image"
                :key="index"
              >
              <v-fade-transition>
                <v-overlay
                  v-if="hover"
                  absolute
                  color="#036358"
                >
                  <v-btn>See more info</v-btn>
                </v-overlay>
              </v-fade-transition>
                <v-card>
                  <img :src="image" style="object-fit: cover;" :alt="`Image Uplaoder ${index}`" />
                  <v-overlay v-if="index==0"
            
                  absolute
                  color="#036358"
                >
                  <v-btn x-small color="green">Cover</v-btn>
                </v-overlay>
                </v-card>
                <a href="javascript:void(0)" @click="removeimage(index)" style="color: red"
                  >Remove</a>
                 

                <div class="details">
                  <span class="name" v-text="files[index].name"></span>
                  <span
                    class="size"
                    v-text="getFileSize(files[index].size)"
                  ></span>
                  
                </div>
              </div>
            </div>
          </div>
          <div v-if="errors.image" class="invalid-feedback">
            {{ errors.image }}
          </div>
        </div>
      </v-col>
    </div>

    <v-col cols="12 pa-0 text-center ad-button-container">
      <v-btn
        tile
        large
        dark
        color="#2f3b59"
        class="create-ad-button"
        @click="submit"
      >
        <v-icon left>save</v-icon>
        Create</v-btn
      >
    </v-col>
  </v-form>
</div>
</template>
<script>
import imageMixins from "../../../../../mixins/common";
export default {
  mixins: [imageMixins],
  data() {
    return {
      sub: [],
    };
  },

  methods: {
    getSub() {
      axios
        .get(`/other/sub/${this.$route.params.slug}`)
        .then((response) => {
          this.sub = response.data;
        })
        .catch();
    },
  },
  mounted() {
    this.getSub();
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
