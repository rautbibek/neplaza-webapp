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
            class="textfield"
            v-model="status"
            color="#19916B"
            :items="scat.status"
            tabindex="2"
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
          md="12"
         class="pa-0 "
          v-bind:class="scat.url !== 'land' "
        >
          <v-select
            class="textfield"
            v-model="filter_1_id"
            :items="scat.filter_1"
            :item-text="'name'"
            tabindex="3"
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
          xs="12"
          class="pa-0"
          v-bind:class="scat.url === 'land' && 'pl-3'"
          v-bind:md="scat.url !== 'land' ? '12' : '6'"
        >

        </v-col>
        <v-col
          cols="12"

          class="pa-0"
          v-bind:class="scat.url !== 'land' "
        >
        <p>Choose your area and unit:</p>
        <v-chip-group
          v-model="filter_3_id"
          mandatory
          column
        >
        <v-chip v-for="(s,i) in scat.filter_3" :key="i"
            filter
            :value="s.id"
            outlined
          >
            {{s.name}}
          </v-chip>
      </v-chip-group>
          <v-text-field
            type="number"
            v-model="property_3"
            color="#19916B"
            label="Builtup Area *"
            tabindex="4"
            :rules="[required('Builtup Area')]"
            outlined
            clearable
          ></v-text-field>
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
              color="#19916B"
              v-model="filter_2_id"
              tabindex="6"
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
              tabindex="7"
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
              tabindex="8"
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
              tabindex="9"
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
      <v-divider v-if="scat.features.length>0"></v-divider>

      <div v-if="scat.features.length>0">
        <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
          {{ "Amenities" }}
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
      <v-col class="p-0">
        <v-text-field
          color="#19916B"
          class="mb-1"
          v-model="title"
          label="Ad Title *"
          tabindex="10"
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
          tabindex="11"
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
      <div>
      <v-card-title class="font-weight-bold pa-0 mb-10" style="color: #19916b">
        {{ "Address" }}
      </v-card-title>

    <v-tabs
      v-model="tab"
      color="primary"
      right
      style="font-size:15px"

    >
      <v-tabs-slider></v-tabs-slider>

      <v-tab href="#manualaddress" small>
        <v-icon>mdi-map-marker</v-icon>
        Custom address
      </v-tab>

      <v-tab href="#myaddress" @click="newAddress">
        <v-icon left>mdi-account-circle</v-icon>
        my profile address

      </v-tab>


    </v-tabs >

    <v-tabs-items v-model="tab">

      <v-tab-item
        value="manualaddress"
        right
      >
        <v-col cols="12" class="p-0 mt-3">
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
      </v-tab-item>
      <v-tab-item
        value="myaddress"
      >

        <v-col cols="12" class="p-0 mt-5">
            <v-row>
                <v-col cols="12" md="2" lg="2" sm="12" xs="12" class="text-center" >

                    <v-avatar
                    size="150"
                    >
                     <img
                        :src="loginUser.cover"
                        alt="John"
                    >
                  </v-avatar>
                </v-col>
                <v-col cols="12" md="10" lg="10" sm="12" xs="12" >
                <v-row>
                    <v-col cols="12" md="6" lg="6" xl="6" sm="12" >
                    <v-autocomplete
                    ref="district"
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
                    >
                </v-autocomplete>
                    </v-col>
                    <v-col cols="12" md="6" lg="6" xl="6" sm="12" >
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
                    ref="nhood"
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
                    </v-col>
                </v-row>
                <v-text-field
                v-model="street"
                tabindex="9"
                label="Street *"
                color="#19916B"
                counter="100"
                :rules="[
                    required('Location/Area'),
                    maxLength('Location/Area', 100),
                ]"
                outlined
                clearable
                ></v-text-field>
                <div style="text-align:right" v-if="!addressUpdated">

              <span style="margin-right:20px; color:red">Your profile address is not updated yet. do you want to update it? </span>
              <v-btn
                :loading="loading"
                dark
                color="#2F3B59"
                @click.prevent="updateAddress"

              >
                update
                <template v-slot:loader>
                  <span>Loading...</span>
                </template>

              </v-btn>
                </div>
            </v-col>
            </v-row>


      </v-col>
      </v-tab-item>
    </v-tabs-items>


    </div>

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
          type="number"
          v-model="price"
          label="Price *"
          min="0"
          tabindex="15"
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
                  tabindex="16"
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
