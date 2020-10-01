<template>
 <v-app >
  <admin-sidebar></admin-sidebar>
  <v-container class="mt-5">

    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>


    <!-- table componsent -->
    <p>Total Report : {{total}}</p>
    <v-simple-table class="p-5">
      <template v-slot:default>
        <thead>
          <tr>
            <th class="text-left">#ID</th>
            <th class="text-left">To Product Id</th>
            <th class="text-left">Reported By Email</th>
            <th class="text-left">Product User</th>

            <th class="text-left">Report Reason</th>
            <th class="text-left">Report Description</th>
            <th class="text-left">Reportd At</th>
            <th class="text-left">Action</th>

          </tr>
        </thead>
        <tbody>

          <tr v-for="(item,index) in desserts" :key="index">
            <td>{{ index+1 }}</td>
            <td><a :href="'/admin/product/'+item.product_id">{{ item.product.title }}</a></td>
            <td>{{ item.reported_by }}</td>
            <td><a :href="'/admin/user/'+item.user_id">{{ item.user.name }}</a></td>
            <td>{{ item.reason_for_report }}</td>
            <td>{{ item.description }}</td>
            <td>{{ item.created }}</td>
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
    props:['total'],
    data: () => ({
      desserts: [],
      nextUrl:'',
    }),


    created () {
      //this.initialize()
      this.fetch(`/admin/report/record`);
    },

    methods: {
      remove(report){
        if(confirm('are you sure to wnat to delete this report')){
        this.overlay = true;
        axios.delete(`/admin/report/delete/`+report.id)
             .then(response=>{
                this.$toast.success(response.data, 'success', {
                      timeout: 3000,
                      position: 'topRight',
                });
                this.overlay = false;
                this.desserts.splice(this.desserts.indexOf(report), 1);
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
