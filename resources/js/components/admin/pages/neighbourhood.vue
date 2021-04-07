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
          Add New Metro/VDC
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                      <v-select
                      v-model="city_id" 
                      :items='desserts'
                      :item-text="'name'"
                      :item-value="'id'"
                      label="District"
                      :rules="[select('district')]"
                      clearable
                      >
                      </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="Metro/VDC Name"
                    :rules="[required('metro/VDC')]"
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
            Save 
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!--edit dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit Metro/VDC
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="editDialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                      <v-select
                      v-model="city_id" 
                      :items='desserts'
                      :item-text="'name'"
                      :item-value="'id'"
                      label="District"
                      :rules="[select('district')]"
                      clearable
                      >
                      </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-text-field 
                    v-model="name" 
                    label="Metro/VDC Name"
                    :rules="[required('metro/VDC')]"
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
            update
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <v-col cols="4" >
        <v-autocomplete @change="nhood"
        v-model="city_id" 
        :items='desserts'
        :item-text="'name'"
        :item-value="'id'"
        label="District"
        clearable
        outlined
        small-chips
        dense
        >
        </v-autocomplete>
    </v-col>
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Metro/VDC Name</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in metro" :key="index">
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
      city_id:1,
      metro:{},
      nhood_id:'',
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
      this.nhood();
    },

    methods: {
      nhood(){
        this.overlay = true;
        axios.get(`/get/nhood/${this.city_id}`)
             .then(response =>{
               this.metro = response.data;
               this.overlay = false;
             })
             .catch();
      },
      initialize () {
        this.overlay = true;
        axios.get(`/admin/city/create`)
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
          axios.delete(`/admin/neighbourhood/`+id)
                .then(response=> {
                  this.$toast.success(response.data, 'success', {
                        timeout: 3000,
                        position: 'topRight',
                  });
                  this.nhood();
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
        this.nhood_id = item.id;
        this.name = item.name;
        this.editDialog = true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
                    axios.post(`/admin/neighbourhood`,{
                      name: this.name,
                      city_id: this.city_id
                    })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.nhood();
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
                        }
                    });
                return;
            }
      },
      update () {
            if (this.$refs.form.validate()) {
                    axios.put(`/admin/neighbourhood/`+this.nhood_id,{
                      name: this.name,
                      city_id: this.city_id
                    })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.nhood();
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
                        }
                    });
                return;
            }
      },
    },
  }
</script>