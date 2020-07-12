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
          Add new subcategory
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-select
                    v-model="category_id" 
                    :items='desserts'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="Category"
                    clearable
                    :rules="[select('category')]"
                    >
                    </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    clerable
                    label="Subcategory Name"
                    :rules="[required('subcategory Name')]"
                    ></v-text-field>
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
            Save subcategory
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!--edit dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit subcategory
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="editDialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-select
                    v-model="category_id" 
                    :items='desserts'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="Category"
                    clearable
                    :rules="[select('category')]"
                    >
                    </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    clerable
                    label="Subcategory Name"
                    :rules="[required('subcategory Name')]"
                    ></v-text-field>
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
            Update Subcategory
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <div class="p-5" v-for="(category,index) in desserts" :key="index">
      <h5 class="border-bottom" :class="category.visible?'':'text-danger'" ><i :class="category.icons"></i> {{category.name}}</h5>
      <v-simple-table >
        <template v-slot:default>
          <thead>
            <tr>
              <th class="text-left">#ID</th>
              <th class="text-left">Subcategory Name</th>
              <th class="text-left">Slug</th>
              <th class="text-left">Url</th>
              <th class="text-left">view Count</th>
              <th class="text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item,index) in category.scategory" :key="index">
              <td>{{ index+1 }}</td>
              <td>{{ item.name }}</td>
              <td>{{ item.slug }}</td>
              <td>{{ item.url }}</td>
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
    </div>
  </v-container>
  <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    
    data: () => ({
      overlay:false,
      name:'',
      subcategory_id:'',
      category_id:'',
      url:'',
      editDialog:false,
      dialog:false,
      valid: true,
      dialog: false,
      select(propertyType) {
          return v => !!v || `you must select a ${propertyType}`
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
          axios.delete(`/admin/subcategory/`+id)
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
        this.category_id = item.category_id;
        this.name = item.name;
        this.url = item.url;
        this.subcategory_id = item.id;
        this.editDialog = true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
                axios.post(`/admin/subcategory`, {
                  category_id : this.category_id,
                  name: this.name,
                  url: this.url,
                })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
                        this.$refs.form.reset()
                        this.close();

                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                          if (error.response.data.errors.name.length>0) {
                                this.$toast.error(error.response.data.errors.name[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                return;
                            }
                            this.$toast.error('Invalid data please check your form again','error' , {
                                timeout: 3000,
                                position: 'topRight',
                            });
                        }
                    });
                return;
            }
      },
      update () {
            if (this.$refs.form.validate()) {
                axios.put(`/admin/subcategory/`+this.subcategory_id, {
                  category_id : this.category_id,
                  name: this.name,
                  url: this.url,
                })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
                        this.$refs.form.reset()
                        this.editDialog = false;

                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                          if (error.response.data.errors.name.length>0) {
                                this.$toast.error(error.response.data.errors.name[0],'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });
                                return;
                            }
                            this.$toast.error('Invalid data please check your form again','error' , {
                                timeout: 3000,
                                position: 'topRight',
                            });
                        }
                    });
                return;
            }
      },
    },
  }
</script>