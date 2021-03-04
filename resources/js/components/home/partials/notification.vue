<template>
  <div>
    <v-badge :content="count" :value="count" color="red" overlap>
      <v-menu
        offset-y
        nudge-bottom="10"
        open-on-click
        close-on-content-click
        transition="scale-transition"
      >
        <template v-slot:activator="{ on, attrs }">
          <v-btn v-bind="attrs" v-on="on" fab x-small depressed class="ml-3">
            <v-icon color="#2F3B59" small>mdi-bell</v-icon>
          </v-btn>
        </template>

        <v-card max-width="340" max-height="400" class="overflow-y-auto">
          <v-list subheader dense nav>
            <v-subheader style="width: 300px">
              <span v-if="count == 0">No &nbsp; </span>
              New Notifications
            </v-subheader>

            <v-list-item
              href="comment"
              @click="markAsRead(item.id)"
              v-for="(item, index) in notification"
              :key="index"
              router
              :to="`/ad/detail/${item.data['ad']['productid']}/${item.data['ad']['slug']}`"
            >
              <v-list-item-avatar color="grey">
                <v-img color="grey" :src="item.data['ad']['cover']"></v-img>
              </v-list-item-avatar>

              <v-list-item-content>
                <v-list-item-title>{{
                  item.data["ad"]["user"]
                }}</v-list-item-title>
                <v-list-item-subtitle>{{
                  item.data["ad"]["message"]
                }}</v-list-item-subtitle>
              </v-list-item-content>

              <v-list-item-icon>
                <v-icon color="deep-purple accent-4">chat_bubble</v-icon>
              </v-list-item-icon>
            </v-list-item>
          </v-list>

          <!-- <v-list subheader v-if="readCount >0">
                    <v-divider></v-divider>
                    <v-subheader>
                         Old Notifications
                        </v-subheader>

                    <v-list-item
                        v-for="(item,index) in read"
                        :key="index"
                        router :to="`/ad/detail/${item.data['ad']['productid']}/${item.data['ad']['slug']}`"

                    >
                        <v-list-item-avatar>
                        <v-img :src="item.data['ad']['cover']"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content >
                        <v-list-item-title>{{item.data['ad']['user']}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.data['ad']['message']}}</v-list-item-subtitle>
                        <v-list-item-subtitle>5 min ago</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-icon>
                        <v-icon>chat_bubble</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                    </v-list> -->
          <p class="text-center px-5">
            <v-btn @click="markAllAsRead" x-small text>
              <v-icon left small>remove</v-icon> Clear notification
            </v-btn>
          </p>
        </v-card>
      </v-menu>
    </v-badge>
  </div>
</template>
<script>
let notification = new Audio(window.URL+'/audio/message.mp3');
export default {
  data() {
    return {
      notification: {},
      count: 0,
      read: {},
      readCount: 0,
    };
  },
  methods: {
    markAsRead(id) {
      axios
        .get(`/markAsRead/` + id)
        .then((response) => {
          this.getNotification();
          //this.raadNotification();
          
        })
        .catch();
    },
    getNotification() {
      axios
        .get(`/get/notification`)
        .then((response) => {
          this.notification = response.data;
          this.count = this.notification.length;
          if(this.count > 0){
            notification.play();
          }
          //audio.pause();
        })
        .catch();
    },
    markAllAsRead() {
      axios
        .delete(`/read/all/notification`)
        .then((response) => {
          this.getNotification();
        })
        .catch();
    },
  },
  created() {
    this.getNotification();
  },
};
</script>
