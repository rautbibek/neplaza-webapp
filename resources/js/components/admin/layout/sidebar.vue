<template>
    <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app>
      <v-list dense>
        <v-list-item-group color="primary">
        <v-list-item
          v-for="(item, i) in items"
          :key="i"
          :href="item.url"
        >
          <v-list-item-icon>
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.text"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
      </v-list>
    </v-navigation-drawer>
    <v-app-bar
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">Admin Dashboard</span>
      </v-toolbar-title>
      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down"
      ></v-text-field>
      <v-spacer></v-spacer>
      <v-btn icon>
        <v-icon>mdi-apps</v-icon>
      </v-btn>
      <v-btn icon>
        <v-icon>mdi-bell</v-icon>
      </v-btn>
      <v-btn icon @click="logout">
        <v-icon>logout</v-icon>
      </v-btn>
    </v-app-bar>
    </div>
</template>
<script>
export default {
  
     data: () => ({
      
      drawer: false,
      items: [
        { icon: 'dashboard', text: 'Dashboard', url:'/admin/dashboard' },
        { icon: 'list', text: 'Category', url:'/admin/category' },
        { icon: 'receipt', text: 'Subcategory', url:'/admin/subcategory'},
        { icon: 'mdi-city', text: 'District', url:'/admin/city'},
        { icon: 'home_work', text: 'Metor/VDC', url:'/admin/neighbourhood'},
        { icon: 'mdi-facebook', text: 'Brand', url:'/admin/brand'},
        { icon: 'class', text: 'Type',url:'/admin/type' },
        { icon: 'assignment', text: 'Status',url:'/admin/status' },
        { icon: 'mdi-account-circle', text: 'Users',url:'/admin/user' },
        { icon: 'shop', text: 'Product',url:'/admin/product' },
        { icon: 'report', text: 'Report',url:'/admin/report' },
        { icon: 'assignment_ind', text: 'Contact',url:'/admin/contact' },
      ],
    }),
    methods:{
      logout(){
        axios.post(`/admin/logout`)
             .then(response=>{
               console.log(response.data);
               window.location.href = '/admin/login';
          });
      },
    },
}
</script>