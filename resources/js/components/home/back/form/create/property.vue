<template>
    <div>
           <v-row justify="center" no-gutters>
               <div class="text-center p-3 ">
                    <h4 class="font-weight-bold text-uppercase">{{scat.name}}</h4>
                </div>
               <v-col cols="12" lg="10" md="10" sm="12" xs="12" class="custom-border">
                    <v-card tile>
                        <v-form ref="form" v-model="valid" lazy-validation>
                         <div class="m-2">
                             <v-card-title class="font-weight-bold">
                                INCLUDE SOME DETAILS
                             </v-card-title>
                             <v-card-subtitle>
                                * Fileld are mendatory
                            </v-card-subtitle>
                                <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="type"
                                        :items='scat.type'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Property type *"
                                        placeholder="Property type"
                                        :rules="[v => !!v || 'Property Type is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="bedroom"
                                        label="Bedroom *"
                                        placeholder="Bedroom"
                                        :rules="[v => !!v || 'Bedroom is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="bathroom"
                                        label="Bathroom *"
                                        placeholder="Bathroom"
                                        :rules="[v => !!v || 'Bathroom is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="furnishing"
                                        label="Furnishing *"
                                        placeholder="Furnishing"
                                        :rules="[v => !!v || 'Furnishing is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="status"
                                        :items='scat.status'
                                        :item-text="'title'"
                                        :item-value="'id'"
                                        label="Construction Status *"
                                        placeholder="Construction Status"
                                        :rules="[v => !!v || 'Construction Status is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="parking"
                                        label="Car Parking *"
                                        placeholder="Car parking"
                                        :rules="[v => !!v || 'Car Parking is required']"
                                        outlined
                                        clearable
                                    ></v-select>
                                </v-col>  

                          </div>
                          <div style="border-top:0.5px solid black"></div>
                          <div class="m-2">
                                <v-card-title class="font-weight-bold">
                                    MORE DETAILS
                                </v-card-title>
                                
                                <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="listed_by"
                                        :items='scat.filter_1'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Listed By *"
                                        placeholder="Listed By"
                                        :rules="[v => !!v || 'Listed By is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-row>
                                        <v-col cols="8">
                                            <v-text-field style="border-radius:0px; margin-bottom:20px"
                                                type="number"
                                                v-model="area"
                                                label="Builtup Area *"
                                                placeholder="Builtup Area"
                                                :rules="[required('Builtup Area')]"
                                                outlined
                                                clearable
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="4">
                                            <v-select style="border-radius:0px; margin-bottom:20px"
                                                v-model="unit"
                                                label="Builtup Area unit*"
                                                placeholder="Builtup Area unit"
                                                :rules="[v => !!v || 'unit is required']"
                                                outlined
                                                clearable
                                            ></v-select>
                                        </v-col>
                                    </v-row>

                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        v-model="title"
                                        label="Ad Title *"
                                        placeholder="Ad Title"
                                        counter="100"
                                        :rules="[required('title'),minLength('title',10),maxLength('name',100)]"
                                        outlined
                                        clearable
                                    ></v-text-field>

                                    <v-textarea style="border-radius:0px; margin-bottom:20px"
                                        v-model="description"
                                        label="Ad description *"
                                        placeholder="Ad Description "
                                        :rules="[required('Ad Description'),minLength('description',20),maxLength('description',4000)]"
                                        counter="4000"
                                        outlined
                                        clearable
                                    ></v-textarea>
                                </v-col>
                            </div>
                          <div style="border-top:0.5px solid black"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    LOCATION & ADDRESS
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="district"
                                        :items='city'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="District *"
                                        placeholder="District "
                                        :rules="[v => !!v || 'District is required']"
                                        outlined
                                        clearable
                                        @change="getNhood"
                                    ></v-select>

                                    <v-select style="border-radius:0px; margin-bottom:20px"
                                        v-model="nhood"
                                        :items='localArea'
                                        :item-text="'name'"
                                        :item-value="'id'"
                                        label="Metro/Municipility/VDC *"
                                        placeholder="Metro/Municipility/VDC "
                                        :rules="[v => !!v || 'Metro/Municipility/VDC is required']"
                                        outlined
                                        clearable
                                    ></v-select>

                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        v-model="street"
                                        label="Street *"
                                        placeholder="Address where customer can find you or your office"
                                        counter="100"
                                        :rules="[required('street'),minLength('street',10),maxLength('street',100)]"
                                        outlined
                                        clearable
                                    ></v-text-field>
                                </v-col>
                          </div>

                          <div style="border-top:0.5px solid black"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    SET A PRICE
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <v-text-field style="border-radius:0px; margin-bottom:20px"
                                        type="number"
                                        v-model="price"
                                        label="Price *"
                                        placeholder="Price"
                                        :rules="[required('price')]"
                                        outlined
                                        clearable
                                    ></v-text-field>
                                </v-col>
                          </div>
                          <div style="border-top:0.5px solid black"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    SELECT OR DRAG AD IMAGE
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <div class="form-group">
                                        <div class="uploader"
                                            @dragenter="OnDragEnter"
                                            @dragleave="OnDragLeave"
                                            @dragover.prevent
                                            @drop="onDrop"
                                            :class="{ dragging: isDragging }">

                                            <div class="upload-control" v-show="image.length">
                                                <label for="file">Select a file</label>
                                            </div>


                                            <div v-show="!image.length">
                                                <i class="fa fa-cloud-upload"></i>
                                                <p>Drag your image here</p>
                                                <div>OR</div>
                                                <div class="file-input">
                                                    <label for="file">Select a file</label>
                                                    <input type="file" id="file" @change="onInputChange" multiple>
                                                </div>
                                            </div>

                                            <div class="image-preview" v-show="image.length">
                                                <div class="img-wrapper" v-for="(image, index) in image" :key="index">
                                                    <img :src="image" :alt="`Image Uplaoder ${index}`">
                                                    <div class="details">
                                                        <span class="name" v-text="files[index].name"></span>
                                                        <span class="size" v-text="getFileSize(files[index].size)"></span>
                                                        <a class="hover" href="javascript:void(0)" @click="removeimage(index)" style="color:red" >remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="errors.image" class="invalid-feedback">
                                        {{errors.image}}
                                        </div>
                                    </div>
                                </v-col>
                          </div>
                          
                          <div style="border-top:0.5px solid black">
                                    <v-col cols="8 py-4">
                                    <v-btn tile large color="primary"  @click="submit">Post ad</v-btn>
                                </v-col>
                            </div>
                        </v-form>
                    </v-card>
               </v-col>
            </v-row>
    </div>
</template>
<script>
import imageMixins from "../../../../../mixins/common";
export default {
    props:['scat'],
    mixins:[imageMixins],
    data(){
        return{
            

            loading : false,
            valid:true,
            overlay:false,

            bedroom:null,
            bathroom:null,
            furnishing:null,
            status:null,
            parking:null,
            listed_by:null,
            title:'',
            unit:null,
            type:'',
            area:'',
            
        }
    },
    methods:{
        submit(){
            //
        }
    },
    
}
</script>