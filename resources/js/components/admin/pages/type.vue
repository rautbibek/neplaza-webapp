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
          Add Type
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
                    label="type name"
                    :rules="[required('type name')]"
                    ></v-text-field>
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
            Save type
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--edit dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit Type
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
                    label="type name"
                    :rules="[required('type name')]"
                    ></v-text-field>
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
            update type
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <v-col cols="6" >
        <v-autocomplete @change="getType"
        outlined
        dense
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
            <th class="text-left">Type</th>
            
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in type" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{ item.name}}</td>
            
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
      scat_id:1,
      type:{},
      type_id:'',
      editDialog:false,
      overlay:false,
      name:'',
      dialog:false,
      valid: true,
      required(propertyType) {
          return value => value && value.length > 0 || `you must input a ${propertyType}`
      },
      
      select(propertyType) {
          return v => !!v || `you must select a ${propertyType}`
      },
      desserts: [],      
    }),
    

    created () {
      this.initialize()
      this.getType();
    },

    methods: {
      getType(){
        axios.get(`/admin/type/${this.scat_id}`)
             .then(response =>{
               this.type = response.data;
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
          axios.delete(`/admin/type/`+id)
                .then(response=> {
                  this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.getType();
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
        this.name = item.name;
        this.type_id = item.id;
        this.editDialog = true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
              this.overlay = true;  
                axios.post(`/admin/type`,{
                    name: this.name,
                    scategory_id: this.scat_id,
                })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.getType();
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
                axios.put(`/admin/type/`+this.type_id,{
                    name: this.name,
                    scategory_id: this.scat_id,
                })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.getType();
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