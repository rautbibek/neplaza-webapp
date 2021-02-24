<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">

    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <!-- table componsent -->
    <v-row>
        <v-col><p>Total Contact  : {{contact}}</p></v-col>
        <v-col><p style="color:green">Seen : {{seen}}</p></v-col>
        <v-col><p style="color:red">Unseen : {{unseen}}</p></v-col>
    </v-row>
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">Name</th>
            <th class="text-left">Email</th>
            <th class="text-left">Subject</th>

            <th class="text-left">Message</th>
            <th class="text-left">Status</th>
            <th class="text-left">Sent At</th>
            <th class="text-left">Action</th>

          </tr>
        </thead>
        <tbody>

          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td>{{item.name}}</td>
            <td>{{item.email}}</td>
            <td>{{item.subject}}</td>
            <td>{{item.message}}</td>
            <td>
                <v-checkbox 
                    v-model="item.status"
                    :value="item.status"
                    label="Mark as seen"
                    color="green"
                    @click="checked(item.id)"
                    hide-details
                    ></v-checkbox>
            </td>
            <td>{{ item.created_date }}</td>
            <td>
              <v-btn x-small text >
                <v-icon small>mdi-reply</v-icon>
              </v-btn>
              <v-btn x-small text @click="remove(item)">
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
    props:['contact','seen','unseen'],
    data: () => ({
      desserts: [],
      nextUrl:'',
    }),


    created () {
      //this.initialize()
      this.fetch(`/admin/all/contact`);
    },

    methods: {
      checked(id){
          this.overlay = true;
          axios.put(`/admin/contact/update/`+id)
             .then(response=>{
                this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
                
             }).catch();
        },
      remove(contact){
        if(confirm('are you sure to wnat to delete this contact')){
        this.overlay = true;
        axios.delete(`/admin/contact/delete/`+contact.id)
             .then(response=>{
                this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
                this.desserts.splice(this.desserts.indexOf(contact), 1);
             }).catch();
        }
      },
      fetch(url){
          this.overlay=true;
          axios.get(url)
               .then(({data}) =>{

                     this.desserts = data.data;

                     this.nextUrl = data.next_page_url
                     this.overlay= false;
            }).catch();
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
    },

  }
</script>
