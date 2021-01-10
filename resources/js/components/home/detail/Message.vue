<template>
 <div >
    <v-menu transition="slide-x-transition" absolute :disabled="disable" :close-on-click="closeOnClick" :close-on-content-click="closeOnClick"
      top offset-y
      >
      <template v-slot:activator="{ on, attrs }" >
            <v-btn v-show="show"
              elevation="25"
              fab
              fixed
              dark
              small
              center
              bottom
              @click="getMessage"
              color="pink"
              v-bind="attrs"
              v-on="on"
            >
              <v-icon >mdi-message</v-icon>
             
            </v-btn>
          </template>
              <v-card
                width="330px"
              >
              <v-list>
                <v-list-item >
                  <v-list-item-avatar size="30" color="grey">
                    <v-img :src="seller.cover"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title>{{seller.name}}</v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon >
                    <v-icon @click="closeChat">mdi-close</v-icon>
                  </v-list-item-icon>
                </v-list-item>
                </v-list>
                <div style="height:250px; overflow-y:scroll; background-color:#a2a9aa29" ref="feed">
                  <ul v-if="seller">
                      <li v-for="message in messages" :key="message.id" class="message" :class="(message.to_id == seller.id)?'sent':'received'">
                          <div class="text" style="p-2">
                              {{message.text}}
                          <small style="color:#dee2e6">&nbsp; &nbsp;{{message.message_at}}</small>
                          </div>
                      </li>
                  </ul>
                </div>
                <v-card-actions class="py-3">
                  <textarea v-model="text" name="text" id="text" style="height:40px"  class="form-control" @keydown.enter="send"></textarea>
                  <v-btn icon @click="send">
                    <v-icon>mdi-send</v-icon>
                  </v-btn>
                </v-card-actions>
              </v-card>
    </v-menu>
      <div class="text-center ma-2">

        <v-snackbar
          color="cyan"
          v-model="snackbar"
          bottom right
          success
          shaped
          multi-line
        >
          {{ snack_text }}

          <template v-slot:action="{ attrs }">
            <v-btn
              color="pink"
              text
              v-bind="attrs"
              @click="snackbar = false"
            >
              Close
            </v-btn>
          </template>
        </v-snackbar>
      </div>
  </div>
</template>

<script>
  export default {
    props:['seller'],
    data: () => ({
      messages:[],
      text:'',
      disable:false,
      closeOnClick: false,
      show:true,
      snackbar: false,
      snack_text: '',

    }),
    methods:{
      closeChat(){
        this.closeOnClick = true;
        this.show= true;

      },
      scrollToBottom(){
            setTimeout(()=>{
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            },50)

        },
      getMessage(){
        if(!this.loggedIn){
          this.disable = true;
          this.snack_text ="You Need To Login First."
          this.snackbar = true;
          return;
        }
        this.disabled = false;
        this.show = false;
        this.closeOnClick = false;
        axios.get(`/chat/conversation/${this.seller.id}`)
                     .then(response=>{
                         this.messages = response.data;
                     })
                     .catch();
      },
      send(e){
            e.preventDefault();
            if(this.text == ''){
                return;
            }

            axios.post(`/chat/send/message`,{
              contact_id : this.seller.id,
              text : this.text,
            }).then(response=>{
              this.messages.push(response.data);
            })
              .catch()
            this.text="";
        },

    },
    mounted(){
      if(this.loggedIn){
        if(this.loginUser.id == this.seller.id){
          this.show= false;
        }
      }
    },
    watch:{
        messages(messages){
            this.scrollToBottom();
        }
    }
  }
</script>

<style scoped lang="scss">

    ul{
        list-style-type: none;
        padding: 5px;

        li{
          &.message{
            margin:10px 0;
            width:100%;
            .text{
                max-width: 250px;
                border-radius: 5px;
                padding: 12px;
                display: inline-block;
            }
            &.received{
                text-align:right;
                .text{
                    background:#c0c0c4;
                }
            }
            &.sent{
                text-align:left;
                .text{

                    background:#95c0f5;
                }
            }
          }
        }
    }
</style>
