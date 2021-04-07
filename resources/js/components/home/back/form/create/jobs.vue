<template>
<div>
  <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
  <v-form ref="form" v-model="valid" lazy-validation>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="6" class="p-0 pr-3">
        <v-select
          v-model="type"
          :items="scat.type"
          :item-text="'name'"
          tabindex="1"
          :item-value="'id'"
          color="#19916B"
          label="Job Type"
          :rules="[select('Job type')]"
          outlined
          clearable
        ></v-select>
      </v-col>
      <v-col cols="12" sm="12" md="6" class="p-0 pl-3">
        <v-select
          v-model="filter_id"
          :items="scat.filter"
          tabindex="2"
          :item-text="'name'"
          color="#19916B"
          :item-value="'id'"
          label="Salary Period"
          :rules="[select('Salary Period')]"
          outlined
          clearable
        ></v-select>
      </v-col>
    </v-row>
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
        tabindex="3"
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
        tabindex="4"
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
        color="#19916B"
        tabindex="5"
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
        v-show="nhood_display && district"
        v-model="nhood"
        :items="localArea"
        :item-text="'name'"
        tabindex="6"
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
        tabindex="7"
        counter="100"
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
      Offerred Salary
      <v-chip
        v-if="price > 99"
        class="ma-2"
        small
        color="#2f3b59"
        text-color="white"
      >
        Rs. {{ Number(price).toLocaleString() }} - {{ Number(maxprice).toLocaleString()}}
      </v-chip>
    </v-card-title>
    <v-row no-gutters>
      <v-col cols="12" sm="12" md="6" xs="12" class="p-0 pr-3">
        <v-text-field
          type="number"
          v-model="price"
          min="0"
          label="From *"
          tabindex="8"
          color="#19916B"
          :rules="[
            required('From'),
            (v) => (v && v > 0) || `Salary from is invalid.`,
          ]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
      <v-col cols="12" sm="12" md="6" xs="12" class="p-0 pl-3">
        <v-text-field
          type="number"
          v-model="maxprice"
          label="To *"
          min="0"
          tabindex="9"
          color="#19916B"
          :rules="[
            required('To'),
            (v) => (v && v > 0) || `Salary to is invalid.`,
          ]"
          outlined
          clearable
        ></v-text-field>
      </v-col>
    </v-row>
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
                tabindex="10"
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
