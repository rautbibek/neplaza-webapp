<template>
  <div class="">

    <div class="d-none d-sm-flex" style="width:100%">
    <v-list subheader class="flow" width="100%">
      <v-subheader>Recent chat </v-subheader>
        <v-list-item-group v-model="selected" v-if="sortedContacts.length > 0" color="primary">
          <v-list-item
            v-for="contact in sortedContacts"
            :key="contact.id"
            @click="selectedContact(contact)" >
            <v-list-item-avatar>
              <v-img :src="contact.cover"></v-img>
            </v-list-item-avatar>
            <v-list-item-content>
              <v-list-item-title> &nbsp;
                {{contact.name}}

              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-icon>
              <v-badge v-if="contact.unread"
                  color="indigo"
                  :content="contact.unread"
                  inline
                >
                </v-badge>
            </v-list-item-icon>
          </v-list-item>
        </v-list-item-group>
        <div class="text-center mt-5" v-else>
          <p style="color:grey">Empty chat user list</p>
          <p style="color:grey">No conversation yet</p>
          <v-icon>sentiment_dissatisfied</v-icon>
        </div>
    </v-list>
    </div>
     <v-row justify="center" class="d-flex d-sm-none">

      <v-dialog v-model="dialog" persistent  :fullscreen="$vuetify.breakpoint.mobile" hide-overlay transition="dialog-bottom-transition">
        <v-card>
          <v-toolbar style="border-radius:0px"
            color="indigo"
            dark
            >
            <v-toolbar-title>Contact List</v-toolbar-title>

            <v-spacer></v-spacer>

            <v-btn icon @click="dialog = false">
                <v-icon>mdi-close</v-icon>
            </v-btn>
          </v-toolbar>
          <v-list subheader>
            <v-subheader>Recent chat</v-subheader>
              <v-list-item-group v-model="selected" color="primary" v-if="sortedContacts.length > 0">
                <v-list-item
                  v-for="contact in sortedContacts"
                  :key="contact.id"
                  @click="selectedContact(contact)" >
                  <v-list-item-avatar>
                    <v-img :src="contact.cover"></v-img>
                  </v-list-item-avatar>
                  <v-list-item-content>
                    <v-list-item-title> &nbsp;
                      {{contact.name}}

                    </v-list-item-title>
                  </v-list-item-content>
                  <v-list-item-icon>
                    <v-badge v-if="contact.unread"
                        color="indigo"
                        :content="contact.unread"
                        inline
                      >
                      </v-badge>
                  </v-list-item-icon>
                </v-list-item>
              </v-list-item-group>
              <div class="text-center mt-5" v-else>
                <p style="color:grey">Empty chat user list</p>
                <p style="color:grey">No conversation yet</p>
                <v-icon>sentiment_dissatisfied</v-icon>
              </div>
          </v-list>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>
<script>
    export default{
        props:{
            contacts:{
                type:Array,
                default:[],
            }
        },
        data(){
            return {
                dialog:true,
                selected:this.contacts.length ? this.contacts[0] : null,
            }
        },

        methods:{
            selectedContact(contact){
                this.selected = contact;
                this.$emit('selected',contact);
                this.dialog = false;
            }
        },
        mounted(){
            if(window.innerWidth < 600){
              this.dialog = true
            }else{
              this.dialog = false;
            }
        },
        created(){

          EventBus.$on('showDialog',(data)=>{
              this.dialog = data;
          })
        },
        computed:{
          sortedContacts(){
             return _.sortBy(this.contacts,[(contact)=>{
                if (contact == this.selected) {
                    return Infinity;
                }
                return contact.unread;
             }]).reverse();
          }
        }
    }
</script>
<style scped>
    .flow{
        height: 100vh;/* or any height you want */
        overflow-y:auto
        }
</style>
