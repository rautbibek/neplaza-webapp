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
          Add new District
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>

            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-text-field
                    v-model="name"
                    label="District Name"
                    :rules="[required('District Name')]"
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
            Save District
          </v-btn>

        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- dialog component -->
    <v-dialog v-model="editDialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Edit District
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="editDialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>

            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-text-field
                    v-model="name"
                    label="District Name"
                    :rules="[required('District Name')]"
                    ></v-text-field>
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
            Update District
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
            <th class="text-left">District Name</th>
            <th class="text-left">Product Count</th>
            <th class="text-left">Slug</th>
            <th class="text-left">Display</th>
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
            <td>

            <v-chip v-if="item.show" small
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                true

            </v-chip>
            <v-chip v-else small
                class="ma-2"
                color="red"
                text-color="white"
                >
                false

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

  </v-container>

  </v-app>
</template>

<script>
  export default {

    data: () => ({
      overlay:false,
      name:'',
      city_id:'',
      editDialog:false,
      show:'',
      visibility:[
        { name: 'show', id: 1 },
        { name:'hide',  id: 0  }
      ],
      dialog:false,
      valid: true,
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
          axios.delete(`/admin/city/`+id)
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
        this.name = item.name;
        this.city_id = item.id;
        this.show = item.show,

        this.editDialog = true;
      },
      close(){
        this.dialog= false;
      },

      save () {
            if (this.$refs.form.validate()) {
                    axios.post(`/admin/city`,{
                      name: this.name
                    })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
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
      update() {
            if (this.$refs.form.validate()) {
                    axios.put(`/admin/city/`+this.city_id,{
                      name: this.name,
                      show:this.show,
                    })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.initialize();
                        this.editDialog= false;

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
