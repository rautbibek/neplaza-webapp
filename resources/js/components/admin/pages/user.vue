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
        
        
        <v-card-actions>
          <v-spacer></v-spacer>
          
           
        </v-card-actions>
      </v-card>
    </v-dialog>
    <!-- table componsent -->
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Name</th>
            <th class="text-left">Email</th>
            <th class="text-left">Username</th>
            <th class="text-left">Account Status</th>
            <th class="text-left">Block By Admin</th>
            <th class="text-left">Image</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{ item.name }}</td>
            <td>{{ item.email }}</td>
            <td>{{ item.username }}</td>
            <td>
              
              <v-chip v-if="!item.account_status" small
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                Active
               
            </v-chip>
            <v-chip v-else small
                class="ma-2"
                color="red"
                text-color="white"
                >
                Deactive
                
            </v-chip>
            </td>
            <td>
              <v-chip v-if="!item.block_by_admin" small
                    class="ma-2"
                    color="green"
                    text-color="white"
                    >
                    no
                    
                </v-chip>
                <v-chip v-else small
                    class="ma-2"
                    color="green"
                    text-color="white"
                    >
                    yes
                    
                </v-chip>
            </td>
            <td>
                <v-avatar>
                    <v-img :src="item.cover"></v-img>
                </v-avatar>
              
            </td>
            <td>
              <v-btn x-small text @click="edit(item.id)">
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
      dialog:false,
      dialog: false,
      desserts: [],      
    }),
    

    created () {
      this.initialize()
    },

    methods: {
      initialize () {
        this.overlay = true;
        axios.get(`/admin/user/create`)
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

      edit(id){
        alert(id);
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
    },
  }
</script>