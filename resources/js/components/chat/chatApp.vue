<template>
<div> 
    <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Messages</li>
            </ol>
        </nav>

<div class="pa-5">
    <v-card style="border-radius:0px " >
        <!-- <v-toolbar style="border-radius:0px"
        color="indigo"
        dark
        >
        <v-toolbar-title>Neplaza Messanger</v-toolbar-title>

        <v-spacer></v-spacer>

        <v-btn icon>
            <v-icon>mdi-magnify</v-icon>
        </v-btn>
        </v-toolbar> -->
        <v-row no-gutters>
             <v-col cols="12" md="9" sm="6" xs="12">
                 <v-overlay :value="overlay">
                    <v-progress-circular indeterminate size="64"></v-progress-circular>
                 </v-overlay>
                 <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
             </v-col>
             <v-col cols="12" md="3" sm="6" xs="12" class="border-left">
                 <ContactList :contacts="contacts" @selected="startConversationWith" />
             </v-col>
        </v-row>
    </v-card>
</div>
</div>
</template>
<script>
import Conversation from './Conversation';
import ContactList from './ContactList'
    export default{
        props:{
            user:{
                type:Object,
                require:true,
            }
        },
        components:{
             Conversation,
             ContactList
         },
        data(){
            return{
                selectedContact:null,
                messages:[],
                contacts:[],
                dialog:false,
                overlay: false,
            }
        },

        mounted(){
             if(!this.loggedIn){
                 EventBus.$emit('changeDialog', true);
                 this.$router.push("/");
                 return;
              }

            window.Echo.private(`messages`)
                .listen('NewMessage',(e)=>{
                    alert("hello");
                    this.handleIncoming(e.message);
                })
            this.getContacts();

        },
        methods:{
            getContacts(){
              this.overlay = true;
                axios.get(`/chat/contacts`)
                     .then(response=>{
                         this.contacts = response.data;
                         this.overlay = false;
                     })
                     .catch();
            },
            startConversationWith(contact){
                this.overlay = true;

                   axios.get(`/chat/conversation/${contact.id}`)
                     .then(response=>{
                         this.messages = response.data;
                         this.selectedContact = contact;
                         this.overlay=false;
                     })
                     .catch();
                     this.updateUnreadCount(contact, true);
                     EventBus.$emit('updateMessageNotification', true);
            },
            saveNewMessage(message){
                this.messages.push(message);

            },
            handleIncoming(message){
                if(this.selectedContact && message.from_id == this.selectedContact.id){
                    this.saveNewMessages(message)
                    return;
                }
                this.updateUnreadCount(message.from_contact, false);
            },
            updateUnreadCount(contact, reset) {
                this.contacts = this.contacts.map((single) => {
                    if (single.id !== contact.id) {
                        return single;
                    }
                    if (reset)
                        single.unread = 0;
                    else
                        single.unread += 1;
                    return single;
                })
            }


        },
    }
</script>
