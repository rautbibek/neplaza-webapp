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
          Add new category
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
          <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="Category Name"
                    :rules="[required('Category Name')]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="icon" 
                    label="Icon"
                    counter="100"
                    :rules="[required('icon')]"
                    >

                    </v-text-field>
                    
                  </v-col>

                  <v-col cols="12" >
                    <v-text-field 
                    v-model="url" 
                    label="url"
                    counter="100"
                    :rules="[required('url')]"
                    >

                    </v-text-field>
                    
                  </v-col>
                  <v-col cols="12">
                    <v-file-input
                    type="file"
                    show-size 
                    v-model="image" 
                    accept="image/png, image/jpeg, image/bmp"
                    label="Image"
                    :rules="[select('image')]"
                    
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
            Save Category
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--edit dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit category
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="editDialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
          <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="Category Name"
                    :rules="[required('Category Name')]"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="icon" 
                    label="Icon"
                    counter="100"
                    :rules="[required('icon')]"
                    >

                    </v-text-field>
                    
                  </v-col>

                  <v-col cols="12" >
                    <v-text-field 
                    v-model="url" 
                    label="url"
                    counter="100"
                    :rules="[required('url')]"
                    >

                    </v-text-field>
                    
                  </v-col>

                  <v-col cols="12">
                    <v-select style="border-radius:0px; margin-bottom:20px"
                        v-model="show"
                        :items="visibility"
                        :item-text="'name'"
                        :item-value="'id'"
                        label="visibility "
                        
                    ></v-select>
                  </v-col>

                  <v-col cols="6">
                    <h4>Old Image</h4>
                    <v-img :src="'/storage/thumb/'+oldImage" aspect-ratio="1.7"></v-img>
                  </v-col>
                  <v-col cols="12">
                    <v-file-input
                    type="file"
                    show-size 
                    v-model="image" 
                    accept="image/png, image/jpeg, image/bmp"
                    label="Image"
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
            @click="update()"
          >
            Update Category
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Category Name</th>
            <th class="text-left">Total Product</th>
            <th class="text-left">Slug</th>
            <th class="text-left">Url</th>
            <th class="text-left">visibility main menu</th>
            <th class="text-left">view Count</th>
            <th class="text-left">Image</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{ item.name }}</td>
            <td><v-chip small
                    class="ma-2"
                    color="indigo"
                    text-color="white"
                    >
                    {{item.product_count}}
                </v-chip>
            </td>
            <td>{{ item.slug }}</td>
            <td>{{ item.url }}</td>
            <td>
              
              <v-chip v-if="item.visible == '1'" small
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                YES
               
            </v-chip>
            <v-chip v-else small
                class="ma-2"
                color="red"
                text-color="white"
                >
                Not visible
                
            </v-chip>
            </td>
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
              <v-img :src="'/storage/thumb/'+item.image" aspect-ratio="1.7"></v-img>
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
  <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    
    data: () => ({
      overlay:false,
      show:'',
      name:'',
      icon:'',
      image:[],
      visibility:[
        { name: 'show', id: 1 },
        { name:'hide',  id: 0  }
      ],
      editDialog:false,
      url:'',
      category_id:'',
      oldImage:'',
      dialog:false,
      valid: true,
      dialog: false,
      select(propertyType) {
          return value => !value || value.size < 2000000 || `${propertyType} size should be less than 2 MB!`
      },
      required(propertyType) {
          return value => value && value.length > 0 || `you must input a ${propertyType}`
      },
      desserts: [],      
    }),
    

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.overlay = true;
        axios.get(`/admin/category/create`)
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
          axios.delete(`/admin/category/`+id)
                .then(response=> {
                  this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.initialize();
                  this.overlay = false;
                })
                .catch(error =>{
                  this.$toast.success(error.response.data.errors.message, 'error', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.overlay = false;
                });
          }
      },

      edit(item){
        this.name = item.name,
        this.icon = item.icons,
        this.url= item.url,
        this.show = item.visible;
        this.oldImage= item.image;
        this.category_id = item.id;
        this.editDialog=true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
                const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                //category subcategory data
                formData.append('name', this.name);
                formData.append('icon', this.icon);
                formData.append('image', this.image);
                formData.append('url', this.url);
                axios.post(`/admin/category`, formData, config)
                    .then(response => {
                        this.overlay = false;
                        
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
                        this.$refs.form.reset();
                        this.close();

                    })
                    .catch(error => {
                        
                        if (error.response.status === 422) {
                          if (error.response.data.errors.name.length>0) {
                              console.log('hello world')
                                this.$toast.error(error.response.data.errors.name[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                
                            }
                          if (error.response.data.errors.image.length>0) {
                                this.$toast.error(error.response.data.errors.image[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                return

                            }
                            
                            this.$toast.error('Invalid data please check your form again','error' , {
                                timeout: 3000,
                                position: 'topRight',
                            });

                        }
                    });
                return;
            }
            this.$toast.error('Invalid data please check your form again', 'error', {
                timeout: 3000,
                position: 'topRight',
            });
            
        
      },
      update() {
            if (this.$refs.form.validate()) {
                const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                
                //category subcategory data
                formData.append("_method", "put");
                formData.append('name', this.name);
                formData.append('icon', this.icon);
                formData.append('show', this.show);
                formData.append('image', this.image);
            
                formData.append('url', this.url);
                
                axios.post(`/admin/category/`+this.category_id, formData, config)
                    .then(response => {
                        this.overlay = false;
                        
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
                        this.$refs.form.reset();
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
                          if (error.response.data.errors.image.length>0) {
                                this.$toast.error(error.response.data.errors.image[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                return

                            }
                            
                            this.$toast.error('Invalid data please check your form again','error' , {
                                timeout: 3000,
                                position: 'topRight',
                            });

                        }
                    });
                return;
            }
            this.$toast.error('Invalid data please check your form again', 'error', {
                timeout: 3000,
                position: 'topRight',
            });
            
        
      },
    },
  }
</script>