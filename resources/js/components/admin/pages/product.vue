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
          Change Ad property
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>

        <v-divider></v-divider>
        
            <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
                  <v-col cols="12" >
                    <v-select  
                    v-model="state_premium"
                    :items='state'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="featured"
                    >
                      </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-select  
                    v-model="state_deleted"
                    :items='state'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="deleted"
                    >
                    </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-select  
                    v-model="state_urgent"
                    :items='state'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="urgent sell"
                    >
                    </v-select>
                  </v-col>
                  <v-col cols="12" >
                    <v-select  
                    v-model="state_sold"
                    :items='state'
                    :item-text="'name'"
                    :item-value="'id'"
                    label="sold out"
                    >
                    </v-select>
                  </v-col>
              </v-form>
        <v-card-actions>
          <v-spacer></v-spacer>
          
          <v-btn
            @click="update"
            color="green darken-1"
            dark
            tile
            
          >
            update ads
          </v-btn>
          
        </v-card-actions>
      </v-card>
    </v-dialog>
     <!-- toolbar -->
        <v-toolbar dense flat class="mt-5">
            <v-spacer></v-spacer>
            <v-chip small
                
                
                class="ma-2"
                color="success"
                text-color="white">
                Total Ads : {{ all_ad }}
                
                <v-icon small right>shop</v-icon>
            </v-chip>
            <v-chip-group v-model="premium">
                <v-chip small
                    filter
                    value="1"
                    class="ma-2"
                    color="purple"
                    text-color="white">
                    Feature Ads : {{ feature_ad }}
                    <v-icon small right>mdi-account-circle</v-icon>
                </v-chip>
            </v-chip-group>
            <v-chip-group v-model="sold">
                <v-chip small
                    filter
                    value="1"
                    class="ma-2"
                    color="black"
                    text-color="white">
                    Sold Out Ads : {{sold_ad }}
                    <v-icon small right>mdi-account-circle</v-icon>
                </v-chip>
            </v-chip-group>
            <v-chip-group v-model="deleted">
                <v-chip small
                    filter
                    value="1"
                    class="ma-2"
                    color="red"
                    text-color="white">
                    Deleted Ads : {{ deleted_ad }}
                    <v-icon small right>mdi-delete-circle</v-icon>
                </v-chip>
            </v-chip-group>
            <v-chip-group v-model="urgent">
                <v-chip small
                    filter
                    value="1"
                    class="ma-2"
                    color="indigo"
                    text-color="white">
                    Urgent sell Ads : {{ urgent_ad }}
                    <v-icon small right>business</v-icon>
                </v-chip>
            </v-chip-group>
            
            <v-btn small color="green" dark @click="filter">apply filter</v-btn>
        </v-toolbar>
  
    <!-- table componsent -->
    <v-simple-table class="p-5">
        
      <template v-slot:default>
          
        <thead>
           
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Product Id</th>
            <th class="text-left">Product Title</th>
            <th class="text-left">Product User</th>
            
            <th class="text-left">Category </th>
            <th class="text-left">Premium</th>
            <th class="text-left">sold</th>
            <th class="text-left">urgent sell</th>
            <th class="text-left">deleted</th>
            <th class="text-left">Created Date</th>
            <th class="text-left">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{ item.productid }}</td>
            <td>{{ item.title }}</td>
            <td>{{ item.user.name }}</td>
            <td>{{ item.category.name }}</td>
            <td>
              <v-chip small v-if="item.premium"
                    class="ma-2"
                    color="yellow"
                    text-color="white"
                    >
                    premium
                </v-chip>
                <v-chip small v-else
                    class="ma-2"
                    color="secondary"
                    text-color="white"
                    >
                    no premium
                </v-chip>
              </td>
            <td>
              <v-chip small v-if="item.sold"
                    class="ma-2"
                    color="black"
                    text-color="white"
                    >
                    sold out
                </v-chip>
                <v-chip small v-else
                    class="ma-2"
                    color="voilet"
                    text-color="white"
                    >
                    available
                </v-chip>
              </td>
            <td>
              
              <v-chip v-if="item.emergency_sell" small
                class="ma-2"
                color="indigo"
                text-color="white"
                >
                yes
               
                </v-chip>
                <v-chip v-else small
                    class="ma-2"
                    color="blck"
                    text-color="white"
                    >
                    no
                    
                </v-chip>
            </td>
            <td>
              <v-chip small v-if="item.deleted"
                    class="ma-2"
                    color="red"
                    text-color="white"
                    >
                    deleted
                </v-chip>
                <v-chip small v-else
                    class="ma-2"
                    color="green"
                    text-color="white"
                    >
                    available
                </v-chip>
              </td>
              <td>
                  {{item.created_date}}
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
    props:['all_ad','feature_ad','deleted_ad','urgent_ad','sold_ad'],
    data: () => ({
      premium:'',
      urgent:'',
      deleted:'',
      sold:'',
      dialog:false,
      loading:false,

      state_premium:'',
      state_urgent:'',
      state_deleted:'',
      state_sold:'',
      product_id:'',
      nextUrl : null,
      overlay:false,
      valid: true,
      state:[
          {'name':'true','id':1},
          {'name':'false','id':0}
      ],
      desserts: [],      
    }),
    

    created () {
      this.fetch(`/admin/product/create`);
    },

    methods: {
      filter(){
          this.overlay=true;
          this.fetch(`/admin/product/create`);
      },
      fetch(url){
          this.overlay=true;
          axios.get(url,{
              params:{
                  premium:this.premium,
                  deleted:this.deleted,
                  sold:this.sold,
                  emergency_sell:this.urgent,
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
        this.product_id = item.id;
        this.state_sold = item.sold;
        this.state_premium = item.premium;
        this.state_deleted = item.deleted;
        this.state_urgent = item.emergency_sell;
        this.dialog= true;
      },
      
       del(id,item){
        if(confirm('are you sure to wnat to delete this user')){
          this.overlay = true;
          axios.delete(`/admin/product/`+id)
             
             .then(response=>{
               
               this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
                this.desserts.splice(this.desserts.indexOf(item), 1);
             })
             .catch();
        }
      },
      update () {
            if (this.$refs.form.validate()) {
                axios.put(`/admin/product/`+this.product_id, {
                  urgent : this.state_urgent,
                  sold : this.state_sold,
                  deleted: this.state_deleted,
                  premium: this.state_premium,
                })
                    .then(response => {
                        this.overlay = false;
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.fetch(`/admin/product/create`);
                        this.dialog = false;

                    })
                    .catch(error => {
                        if (error.response.status == 422) {
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