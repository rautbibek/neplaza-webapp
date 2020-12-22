<template>
  <div class="form-wrapper">
    <h4 class="font-weight-bold text-center text-uppercase form-title">
      {{ scat.name }}
    </h4>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card class="no-shadow">
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
              class="textfield"
              v-model="status"
              color="#19916B"
              :items="scat.status"
              :item-text="'title'"
              :item-value="'id'"
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
              class="textfield"
              v-model="filter_1_id"
              :items="scat.filter_1"
              :item-text="'name'"
              :item-value="'id'"
              label="Listed By *"
              color="#19916B"
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
              class="textfield"
              v-model="filter_3_id"
              :items="scat.filter_3"
              :item-text="'name'"
              :item-value="'id'"
              label="Builtup Area Unit *"
              color="#19916B"
              :rules="[select('Builtup area unit')]"
              outlined
              clearable
            ></v-select>
          </v-col>
        </v-row>
        <v-divider></v-divider>
        <div v-if="scat.url !== 'land'">
          <v-card-title
            class="font-weight-bold pa-0 mb-10"
            style="color: #19916b"
          >
            More Details
          </v-card-title>
          <v-row no-gutters>
            <v-col cols="12" sm="12" md="6" class="p-0 pr-3">
              <v-select
                color="#19916B"
                v-model="filter_2_id"
                :items="scat.filter_2"
                :item-text="'name'"
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
                color="#19916B"
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
                color="#19916B"
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
                color="#19916B"
                :item-value="'id'"
                label="Furnishing *"
                :rules="[select('Furnishing')]"
                outlined
                clearable
              ></v-select>
            </v-col>
          </v-row>
        </div>
        <v-divider></v-divider>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
          {{ "Title & Description" }}
        </v-card-title>
        <v-col class="p-0">
          <v-text-field
            color="#19916B"
            class="mb-1"
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
            v-model="description"
            class="mb-1"
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
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
          {{ "Address" }}
        </v-card-title>
        <v-row no-gutters>
          <v-col cols="12" class="p-0">
            <v-autocomplete
              color="#19916B"
              v-model="district"
              :items="city"
              :item-text="'name'"
              :item-value="'id'"
              class="mb-1"
              label="District *"
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
              color="#19916B"
              v-show="nhood_display && district"
              v-model="nhood"
              class="mb-1"
              :items="localArea"
              :item-text="'name'"
              :item-value="'id'"
              label="Metro/Municipility/VDC *"
              :rules="[select('Metro/Municipility/VDC')]"
              outlined
              clearable
            ></v-autocomplete>
            <v-text-field
              color="#19916B"
              v-model="street"
              label="Street Address *"
              counter="100"
              class="mb-1"
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
            v-model="price"
            label="Price *"
            color="#19916B"
            placeholder="Price"
            :rules="[required('Price'), priceVlidate('Price')]"
            outlined
            clearable
          ></v-text-field>
        </v-col>
        <v-divider></v-divider>
        <v-card-title
          class="font-weight-bold pa-0 mb-10"
          style="color: #19916b"
        >
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
                      >Remove</a
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
    </v-card>
  </div>
</template>
<script>
import imageMixins from "../../../../../mixins/common";
export default {
  mixins: [imageMixins],
  data() {
    return {
      bedroom_items: ["1", "2", "3", "4", "5", "6+"],
      bathroom_items: ["1", "2", "3", "4+"],
    };
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