<template>
<div>
  <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="6" class="p-0 pr-3">
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
      <v-col cols="12" sm="12" md="6" class="p-0 pl-3">
        <v-select
          v-model="filter_1_id"
          :items="scat.filter_1"
          :item-text="'name'"
          tabindex="2"
          :item-value="'id'"
          label="RAM *"
          color="#19916B"
          :rules="[select('RAM')]"
          outlined
          clearable
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="p-0 pr-3">
        <v-select
          v-model="filter_2_id"
          :items="scat.filter_2"
          :item-text="'name'"
          :item-value="'id'"
          tabindex="3"
          label="Storage *"
          color="#19916B"
          :rules="[select('Storage')]"
          outlined
          clearable
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="p-0 pl-3">
        <v-select
          v-model="status"
          :items="scat.status"
          :item-text="'title'"
          :item-value="'id'"
          tabindex="4"
          label="Status *"
          color="#19916B"
          :rules="[select('Status')]"
          outlined
          clearable
        ></v-select>
      </v-col>
    </v-row>

    <v-col cols="12" v-if="scat.type.length>0" class="p-0">
      <v-select
          v-model="type"
          :items="scat.type"
          :item-text="'name'"
          :item-value="'id'"
          tabindex="4"
          label="Storage Type *"
          color="#19916B"
          :rules="[select('Storage type')]"
          outlined
          clearable
        ></v-select>
    </v-col>
    <v-col cols="12" class="p-0">
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
    <v-divider v-if="scat.features.length>0"></v-divider>
    <div v-if="scat.features.length>0">
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Features" }}
      </v-card-title>

        <v-chip-group
          v-model="product_features"
          column
          multiple
        >
            <v-chip v-for="feature in scat.features" :key="feature.id" class="ma-3 pa-2"
              filter
              label
              color="indigo darken-3"
              outlined
              :value="feature.id"
            >
              {{feature.name}}
            </v-chip>
        </v-chip-group>
      </div>
    <v-divider></v-divider>
    <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
      {{ "Title & Description" }}
    </v-card-title>

    <v-col cols="12" class="p-0">
      <v-text-field
        v-model="title"
        label="Ad Title *"
        color="#19916B"
        tabindex="5"
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
        color="#19916B"
        tabindex="6"
        :rules="[
          required('Ad Description'),
          minLength('description', 20),
          maxLength('description', 4000),
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
        tabindex="7"
        :item-text="'name'"
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
        :items="localArea"
        tabindex="8"
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
        label="Street Address *"
        color="#19916B"
        counter="100"
        tabindex="9"
        :rules="[
          required('Location/Area'),
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
        v-model="price"
        label="Price *"
        min="0"
        tabindex="10"
        color="#19916B"
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
                id="file"
                tabindex="11"
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
