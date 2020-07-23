<template>
    <div>
        <v-badge 
              color="grey"
              :content="count"
              overlap
            >
        <v-menu offset-y nudge-bottom="10" open-on-click close-on-content-click transition="scale-transition">
                <template v-slot:activator="{ on, attrs }">
                  <v-btn v-bind="attrs"
                v-on="on" fab small depressed>
                    <v-icon>mdi-bell</v-icon>
                  </v-btn>
                  </template>
                  
                <v-card max-width="340" style="max-height: 550px"
                      class="overflow-y-auto">
                    <v-list subheader >
                    <v-subheader>
                        <span v-if="count == 0">No &nbsp; </span>
                         New Notifications
                        </v-subheader>
                    
                    <v-list-item href="comment"
                        v-for="(item,index) in notification"
                        :key="index"
                        router :to="`/ad/detail/${item.data['ad']['productid']}/${item.data['ad']['slug']}`"
                        @click="markAsRead(item.id)"
                        
                    >
                        <v-list-item-avatar color="grey">
                        <v-img color="grey" :src="item.data['ad']['cover']"></v-img>
                        </v-list-item-avatar>

                        <v-list-item-content >
                        <v-list-item-title>{{item.data['ad']['user']}}</v-list-item-title>
                        <v-list-item-subtitle>{{item.data['ad']['message']}}</v-list-item-subtitle>
                        <v-list-item-subtitle class="mt-1">5 min ago</v-list-item-subtitle>
                        </v-list-item-content>

                        <v-list-item-icon>
                        <v-icon color="deep-purple accent-4">chat_bubble</v-icon>
                        </v-list-item-icon>
                    </v-list-item>
                    </v-list>

                    <v-list subheader v-if="readCount >0">
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
                    </v-list>
                </v-card>
        </v-menu>
        </v-badge> 
    </div>
</template>
<script>
  export default {
    data(){
        return {
            notification:{},
            count:0,
            read:{},
            readCount:0,
        }
    },
    methods:{
        markAsRead(id){
            
            axios.get(`/markAsRead/`+id)
                 .then(response =>{
                     this.getNotification();
                     this.raadNotification();
                 }).catch();
        },
        getNotification(){
            axios.get(`/get/notification`)
                 .then(response =>{
                     this.notification = response.data;
                     this.count = this.notification.length;

                 })
                 .catch();
        },

        raadNotification(){
            axios.get(`/read/notification`)
                 .then(response =>{
                     this.read = response.data;
                     this.readCount = this.read.length;
                 })
                 .catch();
        }
    },
    created(){
        this.getNotification();
        this.raadNotification();
    },
  }
</script>