<template>
  <v-card 
    class="mx-auto"
    
    tile
  >
    <v-list rounded>
      <v-subheader class="d-none d-sm-flex">MYADS MENU</v-subheader>
      <v-list-item-group v-model="item" color="primary">
        
          
        <v-list-item
            v-for="(item, i) in items"
            :key="i"
            router :to="item.url" 
        >
          <v-tooltip left>
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-icon v-bind="attrs"
                v-on="on">
                  <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
                </template>
                <span>{{item.text}}</span>
            </v-tooltip>
          </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-card>
</template>

<script>
  export default {
    data: () => ({
      item: 1,
      items: [
        { 
            text: 'All My Ads', 
            icon: 'mdi-clock',
            url : '/user/myads' 
        },
        { 
            text: 'Deleted Ads', 
            icon: 'delete',
            url : '/myads/deleted' 
        },

        { 
            text: 'Feature Ads', 
            icon: 'star',
            url : '/myads/feature' 
        },
        { 
            text: 'Sold Ads', 
            icon: 'money',
            url : '/myads/soldout'  
        },

        { 
            text: 'Urgent Sell Ads', 
            icon: 'mdi-clock',
            url : '/myads/urgent'  
        },

      ],
    }),
  }
</script>