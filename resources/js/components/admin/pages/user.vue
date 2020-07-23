<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">
    
    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <!-- dialog component -->
    <v-dialog v-model="dialog" persistent  max-width="450">
      <v-card>
        <v-card-title class="text-right">
          Change User Role
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-select
                      v-model="role_id" 
                      :items='roles'
                      :item-text="'name'"
                      :item-value="'id'"
                      label="Role"
                      
                      clearable
                      >
                      </v-select>
                  </v-col>
              </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          
          <v-btn
            color="green darken-1"
            dark
            tile
            @click="changeRole"
          >
            update user
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
   <v-row no-gutters class="mt-3">
       <v-spacer></v-spacer>
       <v-col cols="12" xs="9" md="5" sm="8">
       <v-text-field
            label="search by username or email"
            v-model="search"
            dense
            clearable
            clerable
        ></v-text-field>
     </v-col>
     <v-col cols="12" xs="3" md="3" sm="4">
       <v-btn text color="green" @click="search_user">
         <v-icon>search</v-icon>
       </v-btn>
      </v-col>
     </v-row>
    <!-- table componsent -->
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Name</th>
            <th class="text-left">Email</th>
            <th class="text-left">Username</th>
            <th class="text-left">Total Ads</th>
            <th class="text-left">Account Status</th>
            <th class="text-left">Block By Admin</th>
            <th class="text-left">Role</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td> <a :href="'/admin/user/'+item.id">{{ item.name }}</a></td>
            <td>{{ item.email }}</td>
            <td>{{ item.username }}</td>
            <td>
              <v-chip small
                class="ma-2"
                color="blue"
                text-color="white"
                >
                {{ item.product_count }}
               
            </v-chip>
              </td>
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
              <v-btn x-small v-if="item.block_by_admin" color="red" @click="block_user(item.id,false,'ublock')" dark>unblock</v-btn>
              <v-btn x-small v-else color="success" @click="block_user(item.id,true,'block')" dark>block</v-btn>
            </td>
            <td>
              <v-chip small v-if="item.role.id==1"
                class="ma-2"
                color="purple darken-2"
                text-color="white"
                >
                {{item.role.name}}
                
              </v-chip>
              <v-chip small v-else
                class="ma-2"
                :color="item.role.id==2?'indigo':'teal'"
                text-color="white"
                >
                {{item.role.name}}
                
              </v-chip>
              
            </td>
            <td>
              <v-btn x-small text @click="edit(item)">
                <v-icon small>mdi-pencil</v-icon>
              </v-btn>
              <v-btn x-small text @click="del(item.id,item)">
                <v-icon small>mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </tbody>
      </template>
    </v-simple-table>
    <div class="text-center mb-5" v-if="nextUrl">
        <v-btn :loading="loading" outlined tile color="#2F3B59" class="" @click.prevent="more(nextUrl)">
            Load More
            <template v-slot:loader>
                <span>Loading...</span>
            </template>
            <v-icon right>cached</v-icon>
        </v-btn>
    </div>
  </v-container>
  <dialog-component></dialog-component>
  </v-app>
</template>

<script>
  export default {
    
    data: () => ({
      search:'',
      role_id:'',
      user_id:'',
      block_by_admin:'',
      dialog:false,
      loading:false,
      blocked: true,
      nextUrl : null,
      overlay:false,
      valid: true,
      desserts: [], 
      roles:[
        {'id':1,'name':'Admin'},
        {'id':2,'name':'Seller'},
        {'id':3,'name':'User'}
      ]     
    }),
    

    created () {
      //this.initialize()
      this.fetch(`/admin/user/create`);
    },

    methods: {
      search_user(){
        this.fetch(`/admin/user/create`);
      },
      fetch(url){
          this.overlay=true;
          axios.get(url,{
              params:{
                search: this.search,
              }
            })
               .then(({data}) =>{
                     this.desserts = data.data;
                     this.nextUrl = data.next_page_url
                     this.overlay= false;
            })
      },
      more(nextUrl){
        this.loading=true;
        axios.get(nextUrl)
             .then(({data}) =>{
                this.desserts.push(...data.data);
                this.nextUrl = data.next_page_url
                this.loading = false;
            })
      },
      
      edit(item){
        this.role_id = item.role.id;
        this.block_by_admin = item.block_by_admin;
        this.user_id =  item.id;
        this.dialog = true;
      },
      
      block_user(user_id,value,val){
        if(confirm('are your sure to wnat to '+ val +' this user')){
          this.overlay = true;
          axios.put(`/admin/user/`+user_id,{
            block:value
          })
               .then(response=>{
                 this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                  });
                  this.fetch(`/admin/user/create`);
                  this.overlay= false;
               })
               .catch(error=>{
                 this.$toast.success(error.response.data.message, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                  });
                });
        }

      },
      changeRole(){
        if(confirm('are your sure to wnat to change this user role')){
          this.overlay = true;
          axios.put(`/admin/user/`+this.user_id,{
            block:this.block_by_admin,
            role_id: this.role_id,
          })
               .then(response=>{
                 this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                  });
                  this.fetch(`/admin/user/create`);
                  this.overlay= false;
                  this.dialog = false;
               })
               .catch(error=>{
                 this.$toast.success(error.response.data.message, 'error', {
                      timeout: 3000,
                      position: 'topRight',
                  });
                });
        }
      },
       del(id,item){
        if(confirm('are you sure to wnat to delete this user')){
          this.overlay = true;
          axios.delete(`/admin/user/`+id)
             
             .then(response=>{
               
               this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
                if(item.product_count == 0){
                  this.desserts.splice(this.desserts.indexOf(item), 1);
                }
                
             })
             .catch();
        }
      }

      
    },
   
  }
</script>