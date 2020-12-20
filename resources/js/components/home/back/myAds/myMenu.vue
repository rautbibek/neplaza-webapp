<template>
  <div class="menu-box">
    <v-card>
      <v-list dense class="p-0">
        <v-list-item-group v-model="item" color="primary">
          <v-list-item
            v-for="(item, i) in items"
            :key="i"
            router
            :to="item.url"
          >
            <v-tooltip left>
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-icon v-bind="attrs" v-on="on">
                  <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
              </template>
              <span>{{ item.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-item-group>
      </v-list>
    </v-card>
  </div>
</template>

<script>
export default {
  data: () => ({
    item: 1,
    items: [
      {
        text: "Active Products",
        icon: "mdi-clock",
        url: "/user/myads",
      },
      {
        text: "Deleted Products",
        icon: "delete",
        url: "/myads/deleted",
      },

      {
        text: "Feature Products",
        icon: "star",
        url: "/myads/feature",
      },
      {
        text: "Sold Products",
        icon: "money",
        url: "/myads/soldout",
      },

      {
        text: "Urgent Products",
        icon: "mdi-alert-circle",
        url: "/myads/urgent",
      },
    ],
  }),
};
</script>