<template>
<div >
     <v-list-item v-if="contact">
       <v-list-item-avatar>
         <v-img :src="contact.cover"></v-img>
       </v-list-item-avatar>
       <v-list-item-content>
         <v-list-item-title>{{contact.name}}</v-list-item-title>
       </v-list-item-content>
       <v-btn icon @click="show_dialog">
        <v-icon large>recent_actors</v-icon>
      </v-btn>

     </v-list-item>
     <v-list-item v-else>
       <v-list-item-icon >
         <v-icon>message</v-icon>
       </v-list-item-icon>
       <v-list-item-content>
         <v-list-item-title>Messenger</v-list-item-title>
       </v-list-item-content>
       <v-list-item-icon @click="show_dialog" class="d-flex d-sm-none">
          <v-icon>recent_actors</v-icon>
        </v-list-item-icon>
     </v-list-item>
     <v-col class="message-feed">
        <MessagesFeed :contact="contact" :messages="messages"/>
     </v-col>
     <div class="mt-3">
        <MessageComposer @send="sendMessage"/>
     </div>
</div>
</template>

<script>
import MessagesFeed from './MessagesFeed'
import MessageComposer from './MessageComposer'
export default {
    components:{
        MessageComposer,
        MessagesFeed,
    },
    props:{
        contact:{
            type:Object,
            default:null,
        },
        messages:{
            type:Array,
            default:[]
        }
    },
    data(){
        return{
            //
        }
    },
    methods:{
        sendMessage(text){
            if(!this.contact){
              return;
            }
            axios.post(`/chat/send/message`,{
              contact_id : this.contact.id,
              text : text,
            }).then(response=>{
              this.$emit('new',response.data);
            })
              .catch()
        },
        show_dialog(){
          EventBus.$emit('showDialog', true);
        }
    },
    mounted(){

    }
}
</script>
<style scoped>
    .message-feed{
        background-color:#b8babf36;
        }
</style>
