<template>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="6" class="pa-0 pr-3">
        <v-autocomplete
          v-model="brand_id"
          :items="scat.brand"
          tabindex="1"
          :item-text="'name'"
          :item-value="'id'"
          label="Brand *"
          color="#19916B"
          :rules="[select('Brand')]"
          outlined
          clearable
        ></v-autocomplete>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="pa-0 pl-3">
        <v-select
          v-model="status"
          :items="scat.status"
          tabindex="2"
          :item-text="'title'"
          color="#19916B"
          :item-value="'id'"
          label="Status *"
          :rules="[select('Status')]"
          outlined
          clearable
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="pa-0 pr-3">
        <v-select
          v-model="type"
          tabindex="3"
          :items="scat.type"
          :item-text="'name'"
          :item-value="'id'"
          color="#19916B"
          :label="label"
          :rules="[select('Type')]"
          outlined
          clearable
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="pa-0 pl-3">
        <v-text-field
          type="number"
          tabindex="4"
          v-model="property_2"
          color="#19916B"
          label="Lot Number *"
          :rules="[required('Lot Number')]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
      <v-col cols="12" class="pa-0">
        <v-text-field
          type="number"
          v-model="property_1"
          tabindex="5"
          color="#19916B"
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
        v-model="title"
        label="Ad Title *"
        tabindex="6"
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
        color="#19916B"
        label="Ad description *"
        tabindex="7"
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
        v-model="district"
        :items="city"
        tabindex="8"
        :item-text="'name'"
        color="#19916B"
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
        tabindex="9"
        :item-text="'name'"
        :item-value="'id'"
        label="Metro/Municipility/VDC *"
        :rules="[select('Metro/Municipility/VDC')]"
        outlined
        clearable
        :loading="loading"
      ></v-autocomplete>

      <v-text-field
        v-model="street"
        label="Street Address *"
        tabindex="10"
        color="#19916B"
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
        type="number"
        tabindex="11"
        v-model="price"
        color="#19916B"
        label="Price *"
        :rules="[required('Price'), priceVlidate('Price')]"
        outlined
        clearable
      ></v-text-field>
    </v-col>
    <v-divider></v-divider>
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
                tabindex="12"
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
              <img :src="image" :alt="`Image Uplaoder ${index}`" />
              <div class="details">
                <span class="name" v-text="files[index].name"></span>
                <span
                  class="size"
                  v-text="getFileSize(files[index].size)"
                ></span>
                <a
                  class="hover"
                  href="javascript:void(0)"
                  @click="removeimage(index)"
                  style="color: red"
                  >remove</a
                >
              </div>
            </div>
          </div>
        </div>
        <div v-if="errors.image" class="invalid-feedback">
          {{ errors.image }}
        </div>
      </div>
    </v-col>

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
</template>
<script>
import imageMixins from "../../../../../mixins/common";
export default {
  mixins: [imageMixins],

  computed: {
    label() {
      return this.scat.url === "bike" ? "Type *" : "Fuel Type *";
    },
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