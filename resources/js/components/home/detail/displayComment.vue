<template>
    <div id="#comment">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-card tile>
            <v-card-title>Comments {{all_comments.length}}</v-card-title>
            <v-card-text>
                <v-textarea
                    v-model="comment"
                    clear-icon="mdi-close-circle"
                    prepend-icon="mdi-account-circle"
                    append-outer-icon="mdi-send"
                    outlined
                    clearable
                    label="Comment"
                    type="text"
                    rows="2"
                    @click:append-outer="postComment"
                >
                </v-textarea>
               </v-card-text>
                <v-card-text>
                            <v-row no-gutters v-for="(comments,index) in all_comments" :key="index">
                                <v-col cols="2" sm="2" xs="2" lg="1" md="1">
                                    <v-avatar color="indigo" size="36">
                                        <img
                                            :src="comments.user.cover"
                                            :alt="comments.user.name"
                                        >
                                    </v-avatar>
                                </v-col>
                                <v-col cols="10" lg="11" md="11" sm="10" xs="9">
                                    <h6 style="color:black">{{comments.user.name}}</h6>
                                {{comments.body}}
                                    <p class="pt-2" v-if="loggedIn">
                                        <v-btn x-small text color="red" v-if="loginUser.id == comments.user_id" @click="deleteComment(comments.id)">delete</v-btn>
                                        <v-btn x-small text color="success" @click="showReplies(comments.id)">reply ({{comments.replies.length}})</v-btn>
                                    </p>
                                    <p class="pt-2" v-if="!loggedIn">
                                        <v-btn x-small text color="success" @click="showReplies(comments.id)">reply ({{comments.replies.length}})</v-btn>
                                    </p>
                                    <p class="text-right"><small>{{comments.created}}</small></p>
                                </v-col>
                                
                    <comment-reply transition="fab-transition" :cmt_id="comments.id" :product_id="comments.product_id" v-if="show == comments.id" :replies="comments.replies"></comment-reply>
               </v-row>
            </v-card-text>
        </v-card>
    </div>
</template>
<script>
export default {
    props:['product_id'],
    data(){
        return{
            overlay:false,
            show:"",
            comment:'',
            all_comments:[],
        }
    },
    methods:{
        showReplies(id){
            this.show= id;
        },
        deleteComment(id){
            
            if(confirm('are you sure ?')){
            this.overlay= true;
            axios.delete(`/delete/comment/${id}`)
                 .then(response =>{
                     this.$toast.info(response.data,'message', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    this.getComment();
                    this.overlay= false;
                 })
                 .catch();
            }
        },
        getComment(){
            axios.get(`/ad/comment/${this.$route.params.id}`)
                 .then(response =>{
                     this.all_comments = response.data;
                 })
        },
        postComment(){
            if(!this.loggedIn){
                EventBus.$emit('changeDialog', true);
                return;
             }
            this.overlay = true;
            axios.post(`/user/comment`,{
                product_id : this.product_id,
                comment : this.comment,
            })
                 .then(response=>{
                     this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    this.getComment();
                    this.comment="";
                    this.overlay= false;
                 })
                 .catch(error=>{
                     this.$toast.error('Invalid data ', 'error', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.overlay= false;
                    }
                 )
        }
    },
    created(){
        EventBus.$on('loadComment',(data)=>{
            this.getComment();
        })
        this.getComment();
    }
}
</script>