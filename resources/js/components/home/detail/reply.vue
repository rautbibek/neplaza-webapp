<template>
    <div transition="fab-transition">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-card-text class="ml-5">
            <v-row no-gutters v-for="(reply,index) in replies" :key="index">
                <v-col cols="3" sm="3" xs="3" lg="3" md="3">
                    <v-avatar color="indigo" size="25">
                        <img
                            :src="reply.user.cover"
                            :alt="reply.user.name"
                        >
                    </v-avatar>
                </v-col>
                <v-col cols="9" lg="9" md="9" sm="9" xs="9" class="px-2">
                    <h6 style="color:black">{{reply.user.name}}</h6>
                        {{reply.body}}
                    <p class="pt-2" v-if="loggedIn">
                        <v-btn x-small text color="red" v-if="loginUser.id == reply.user_id" @click="deleteComment(reply.id)">delete</v-btn>
                    </p>
                    <p class="text-left border"><small>{{reply.created}}</small></p>
                    
                </v-col>
                
            </v-row>
            <v-col cols="12" lg="12" v-if="loggedIn">
                <v-textarea 
                    v-model="comment"
                    clear-icon="mdi-close-circle"
                    prepend-icon="mdi-account-circle"
                    append-outer-icon="mdi-send"
                    clearable
                    label="Reply Comment"
                    type="text"
                    rows="1"
                    @click:append-outer="replyComment"
                >
                </v-textarea>
            </v-col>
        </v-card-text>
    </div>
</template>
<script>
export default {
    props:['replies','cmt_id','product_id'],
    data(){
        return{
            comment:'',
            overlay:false,
        }
    },

    methods:{
        deleteComment(id){
        if(confirm('are you sure ?')){
            this.overlay = true;
            axios.delete(`/delete/comment/${id}`)
                 .then(response =>{
                     this.$toast.info(response.data,'message', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    EventBus.$emit('loadComment',true);
                    this.overlay = false;
                 })
                 .catch(error=>{
                     this.overlay = false;
                 });
            }
        },
        replyComment(){
            this.overlay = true;
            axios.post(`/reply/ad/comment`,{
                product_id: this.product_id,
                comment_id: this.cmt_id,
                comment : this.comment,
            })
                 .then(response=>{
                     this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    EventBus.$emit('loadComment',true);
                    this.comment="";
                    this.overlay = false;
                 })
                 .catch(error=>{
                     this.$toast.error('Invalid data ', 'error', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.overlay = false;
                    }
                 )
        }
    }
}
</script>