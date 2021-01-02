<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li v-for="message in messages" :key="message.id" class="message" :class="(message.to_id == contact.id)?'sent':'received'">
                <div class="text" style="p-2">
                    {{message.text}}
                <small style="color:#dee2e6">&nbsp; &nbsp;{{message.message_at}}</small>
                </div>
                
            </li>
        </ul>
        <ul v-else class="mt-5">
            <div class="text-center mt-5">
            <v-chip
                class="ma-2"
                color="indigo darken-3"
                outlined
                >
                
                Select A Contact To start Conversation 
                </v-chip>
            </div>
        </ul>
    </div>
</template>
<script>
export default {
    props:{
        contact:{
            type:Object,
        },
        messages:{
            type:Array,
            required:true,
        }
    },
    data(){
        return{
            //
        }
    },
    methods:{
        scrollToBottom(){
            setTimeout(()=>{
                this.$refs.feed.scrollTop = this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            },50)
            
        }
    },
    watch:{
        contact(contact){
            this.scrollToBottom();
        },
        messages(messages){
            this.scrollToBottom();
        }
    }
}
</script>
<style scoped lang="scss">
    .feed{
        min-height: 300px;
        max-height: 300px;/* or any height you want */
        overflow-y:auto;
        //background-color:#b8babf36;
        }
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