<template>
  <div class="row no-gutters">
    <v-btn color="#2F3B59" depressed outlined router :to="`/user/create/ads`">
      <span>Sell</span>
    </v-btn>
    <notification></notification>
    <v-badge
      :content="unread_message_count"
      :value="unread_message_count"
      color="red"
      overlap
    >
      <v-btn fab x-small depressed router :to="`/message`" class="ml-3">
        <v-icon color="#2F3B59">mdi-message</v-icon>
      </v-btn>
    </v-badge>
    <div>
      <v-menu
        offset-y
        nudge-bottom="15"
        open-on-click
        close-on-content-click
        transition="scale-transition"
      >
        <template v-slot:activator="{ on }">
          <v-avatar size="32" class="profile grey ml-3 pointer" v-on="on">
            <img :src="loginUser.cover" :alt="loginUser.name" />
          </v-avatar>
          <v-icon v-on="on" class="pointer">keyboard_arrow_down</v-icon>
        </template>
        <v-card min-width="300" max-height="500">
          <div class="bg-blue">
            <v-row align="end" class="lightbox white--text pa-2 fill-height">
              <v-col class="text-center">
                <v-avatar size="70" class="grey">
                  <img :src="loginUser.cover" :alt="loginUser.name" />
                </v-avatar>
                <v-card-subtitle
                  style="color: white; padding-bottom: 2px"
                  class="subheading"
                  >{{ loginUser.name }}
                  <v-icon color="#00a2f0" small v-if="loginUser.phone_verified"
                    >mdi-check-decagram</v-icon
                  >
                </v-card-subtitle>
                <small>{{ loginUser.valid_email }}</small>
              </v-col>
            </v-row>
          </div>
          <v-list dense nav>
            <v-list-item-group>
              <v-list-item
                class="list-item"
                v-for="(item, i) in items"
                :key="i"
                router
                :to="item.url"
              >
                <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
                </v-list-item-content>
                <hr />
              </v-list-item>

              <v-list-item @click="logout">
                <v-list-item-icon>
                  <v-icon>logout</v-icon>
                </v-list-item-icon>
                <v-list-item-content>
                  <v-list-item-title>Logout</v-list-item-title>
                </v-list-item-content>
              </v-list-item>
            </v-list-item-group>
          </v-list>
        </v-card>
      </v-menu>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      unread_message_count: null,
      items: [
        {
          icon: "library_add",
          text: "Create New Ads",
          url: "/user/create/ads",
        },

        {
          icon: "mdi-inbox",
          text: "My Ads",
          url: "/user/myads",
        },
        {
          icon: "mdi-heart",
          text: "Favorite Ads",
          url: "/user/favorite",
        },
        {
          icon: "mdi-account-circle",
          text: "Profile",
          url: "/user/profile",
        },
        {
          icon: "settings",
          text: "Settings",
          url: "/user/setting",
        },
        {
          icon: "help",
          text: "Help & Support",
          url: "/help",
        },
      ],
    };
  },
  methods: {
    logout() {
      axios.post(`/logout`).then((response) => {
        location.reload();
      });
    },
    total_unread_count() {
      axios
        .get(`/total/unread/message`)
        .then((response) => {
          this.unread_message_count = response.data;
        })
        .catch();
    },
  },
  mounted() {
    this.total_unread_count();
  },
  created() {
    EventBus.$on("updateMessageNotification", (data) => {
      this.total_unread_count();
    });
  },
};
</script>
<style scoped>
.row {
  flex-direction: row;
}
.list-item .v-list-item__title {
  font-size: 14px;
}
.v-item--active {
  color: #19916b !important;
}
.subheading {
  font-size: 16px;
}
a:before {
  opacity: 0 !important;
}
</style>
