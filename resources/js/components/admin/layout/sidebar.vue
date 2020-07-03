<template>
    <div>
    <v-navigation-drawer
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app>
      <v-list dense>
        <template v-for="item in items">
          <v-list-item
            
            :key="item.text"
            router :to="item.url"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
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
          <v-icon>mdi-bell</v-icon>
        </v-btn>
        <v-btn
          icon
          large
        >
          <v-avatar
            size="32px"
            item
          >
            <v-img
              src="https://cdn.vuetifyjs.com/images/logos/logo.svg"
              alt="Vuetify"
            ></v-img></v-avatar>
        </v-btn>
        <v-btn icon @click="logout">
          <v-icon>mdi-logout</v-icon>
        </v-btn>
    </v-app-bar>
    </div>
</template>
<script>
export default {
    props: {
      source: String,
    },
     data: () => ({
      
      drawer: null,
      items: [
        { icon: 'dashboard', text: 'Dashboard', url:'/admin/dashboard' },
        { icon: 'mdi-contacts', text: 'Category', url:'/admin/category' },
        { icon: 'mdi-history', text: 'Frequently contacted', url:'/admin/subcategory'},
        { icon: 'mdi-content-copy', text: 'Duplicates', url:'/admin/city'},
        { icon: 'mdi-cog', text: 'Settings', url:'/admin/neighbourhood'},
        { icon: 'mdi-message', text: 'Send feedback', url:'/admin/brand'},
        { icon: 'mdi-help-circle', text: 'Help',url:'/admin/model' },
        { icon: 'mdi-cellphone-link', text: 'App downloads',url:'/admin/type' },
        { icon: 'mdi-keyboard', text: 'Go to the old version',url:'/admin/status' },
      ],
    }),
    methods:{
      logout(){
        axios.post(`/logout`)
             .then(response=>{
               location.reload();
          });
      },
    },
}
</script>