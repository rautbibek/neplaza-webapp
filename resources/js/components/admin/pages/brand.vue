<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">
    
    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-col class="text-right px-5">
      <v-btn @click="dialog = true" small color="primary">
        <v-icon small left>mdi-plus-circle</v-icon>
        Add new 
        </v-btn>
    </v-col>
    <!-- dialog component -->
    <v-dialog v-model="dialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Add New Brand
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                      <v-select
                      v-model="scat_id" 
                      :items='desserts'
                      :item-text="'name'"
                      :item-value="'id'"
                      label="subcategory name"
                      :rules="[select('subcategory name')]"
                      clearable
                      >
                      </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="brand"
                    :rules="[required('brand')]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-file-input
                    type="file"
                    show-size 
                    v-model="logo" 
                    accept="image/png, image/jpeg, image/bmp"
                    label="logo"
                    
                    
                    ></v-file-input>
                  </v-col>
              </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            dark
            tile
            @click="$refs.form.reset()"
          >
            reset
          </v-btn>
          <v-btn
            color="green darken-1"
            dark
            tile
            @click="save"
          >
            Save brand
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!--edit dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit Brand
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="editDialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                      <v-select
                      v-model="scat_id" 
                      :items='desserts'
                      :item-text="'name'"
                      :item-value="'id'"
                      label="subcategory name"
                      :rules="[select('subcategory name')]"
                      clearable
                      >
                      </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="brand"
                    :rules="[required('brand')]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="6">
                    <h4>Old Logo</h4>
                    <v-img :src="'/storage/thumb/'+oldImage" aspect-ratio="1.7"></v-img>
                  </v-col>
                  <v-col cols="12">
                    <v-file-input
                    type="file"
                    show-size 
                    v-model="logo" 
                    accept="image/png, image/jpeg, image/bmp"
                    label="logo"
                    
                    
                    ></v-file-input>
                  </v-col>
              </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red darken-1"
            dark
            tile
            @click="$refs.form.reset()"
          >
            reset
          </v-btn>
          <v-btn
            color="green darken-1"
            dark
            tile
            @click="update"
          >
            update brand
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <v-col cols="6" >
        <v-autocomplete @change="getBrand"
        dense
        outlined
        small-chips
        v-model="scat_id" 
        :items='desserts'
        :item-text="'name'"
        :item-value="'id'"
        label="Subcategory"
        clearable
        
        >
        </v-autocomplete>
    </v-col>
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">brand</th>
            <th class="text-left">view count</th>
            <th class="text-left">Brand Logo</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in brand" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{ item.name}}</td>
            <td>
              <v-chip small
                class="ma-2"
                color="green"
                text-color="white"
                >
                {{item.view_count}}
                
            </v-chip>
            </td>
            <td>
              <v-img v-if="item.brand_logo" :src="'/storage/thumb/'+item.brand_logo" aspect-ratio="1.3"></v-img>
            </td>
            <td>
              <v-btn x-small text @click="edit(item)">
                <v-icon small>mdi-pencil</v-icon>
              </v-btn>
              <v-btn x-small text @click="del(item.id)">
                <v-icon small>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    
  </v-container>

  </v-app>
</template>

<script>
  export default {
    
    data: () => ({
      editDialog :false,
      scat_id:30,
      brand_id:'',
      oldImage:'',
      brand:{},
      logo:[],
      overlay:false,
      name:'',
      dialog:false,
      valid: true,
      required(propertyType) {
          return value => value && value.length > 0 || `you must input a ${propertyType}`
      },
      image(propertyType) {
          return value => !value || value.size < 2000000 || `${propertyType} size should be less than 2 MB!`
      },
      select(propertyType) {
          return v => !!v || `you must select a ${propertyType}`
      },
      desserts: [],      
    }),
    

    created () {
      this.initialize()
      this.getBrand();
    },

    methods: {
      getBrand(){
        axios.get(`/admin/brand/${this.scat_id}`)
             .then(response =>{
               this.brand = response.data;
             })
             .catch();
      },
      initialize () {
        this.overlay = true;
        axios.get(`/admin/subcategory/create`)
             .then(response =>{
               this.desserts = response.data;
               this.overlay = false;
               
             })
             .catch(error =>{
               this.$toast.success('server not responding refresh the page ', 'error', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
             });
      },
      del(id){
        
        if(confirm('are you sure to want to delete this category item')){
          this.overlay = true;
          axios.delete(`/admin/brand/`+id)
                .then(response=> {
                  this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.getBrand();
                  this.overlay = false;
                })
                .catch(error =>{
                  this.$toast.success(error.response.data.message, 'error', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.overlay = false;
                });
          }
      },

      edit(item){
        this.name = item.name;
        this.oldImage =item.brand_logo
        this.brand_id = item.id;
        this.editDialog = true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
              this.overlay = true;
              const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                //category subcategory data
                formData.append('name', this.name);
                formData.append('scategory_id', this.scat_id);
                formData.append('image', this.logo);
                
                axios.post(`/admin/brand`,formData, config)
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.getBrand();
                        this.close();

                    })
                    .catch(error => {
                        
                        if (error.response.status === 422) {
                          if (error.response.data.errors.name.length>0) {
                                this.$toast.error(error.response.data.errors.name[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                
                            }
                            this.$toast.error(error.response.data.errors.message,'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                              });
                        }
                        this.overlay= false;
                    });
                return;
            }
      },
      update () {
            if (this.$refs.form.validate()) {
              this.overlay = true;
              const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                //category subcategory data
                formData.append("_method", "put");
                formData.append('name', this.name);
                formData.append('scategory_id', this.scat_id);
                formData.append('image', this.logo);
                
                axios.post(`/admin/brand/`+this.brand_id,formData, config)
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.getBrand();
                        this.editDialog = false;

                    })
                    .catch(error => {
                        
                        if (error.response.status === 422) {
                          if (error.response.data.errors.name.length>0) {
                                this.$toast.error(error.response.data.errors.name[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                
                            }
                            this.$toast.error(error.response.data.errors.message,'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                              });
                        }
                        this.overlay= false;
                    });
                return;
            }
      },
    },
  }
</script>