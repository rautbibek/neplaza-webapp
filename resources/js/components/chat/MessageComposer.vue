<template>
<div class="message-composer px-3 pb-4">
    
                <v-textarea @keydown.enter="send"
                    v-model="message"
                    clear-icon="mdi-close-circle"
                    append-outer-icon="mdi-send"
                    outlined
                    clearable
                    label="Message"
                    type="text"
                    rows="2"
                    @click:append-outer="send"
                 >
                 </v-textarea>
                  
</div>
</template>
<script>
let message = new Audio('http://localhost:8000/audio/notification.mp3');
export default {
    data(){
        return{
            message:'',
        }
    },
    methods:{
        send(e){
            e.preventDefault();
            if(this.message == ''){
                return;
            }
            message.play();
            this.$emit('send',this.message);
            
            this.message="";
            //message.pause();
        }
    }
}
</script>
