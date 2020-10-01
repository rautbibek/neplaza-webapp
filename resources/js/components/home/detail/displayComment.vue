<template>
    <div id="#comment">
        <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
        </v-overlay>
        <v-card tile>
            <v-card-title>Comments {{ad_comments.length}}</v-card-title>
              <v-card-text>
                <v-textarea @keydown.enter="postComment"
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
                    <v-row no-gutters v-for="(comments,index) in ad_comments" :key="index">
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
                                        <v-btn x-small text color="red" v-if="loginUser.id == comments.user_id" @click="deleteComment(comments)">delete</v-btn>
                                        <v-btn x-small text color="success" @click="showReplies(comments.id)">reply ({{comments.replies.length}})</v-btn>
                                    </p>
                                    <p class="pt-2" v-if="!loggedIn">
                                        <v-btn x-small text color="success" @click="showReplies(comments.id)">reply ({{comments.replies.length}})</v-btn>
                                    </p>
                                    <p class="text-right"><small>{{comments.created}}</small></p>
                                </v-col>

                    <comment-reply class="ml-5" transition="fab-transition" :cmt_id="comments.id" :product_id="comments.product_id" v-if="show == comments.id" :replies="comments.replies"></comment-reply>
               </v-row>

              </v-card-text>

        </v-card>

    </div>
</template>
<script>
export default {
    //props:['ad_comments'],
    data(){
        return{
            loading:false,
            overlay:false,
            ad_comments:[],
            show:"",
            comment:'',

        }
    },
    methods:{
        showReplies(id){
            this.show= id;
        },
        deleteComment(comment){

            if(confirm('are you sure ?')){
            this.overlay= true;
            axios.delete(`/delete/comment/${comment.id}`)
                 .then(response =>{
                     this.$toast.info(response.data,'message', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    this.ad_comments.splice(this.ad_comments.indexOf(comment), 1);

                    this.overlay= false;
                 })
                 .catch();
            }
        },
        fetch(url){

            axios.get(url)
                 .then(response  =>{
                     this.ad_comments= response.data;
                 })
        },


        postComment(){
            if(!this.loggedIn){
                EventBus.$emit('changeDialog', true);
                return;
             }
            this.overlay = true;
            axios.post(`/user/comment`,{
                product_id : this.$route.params.id,
                comment : this.comment,
            })
                 .then(response=>{

                     this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });

                    this.fetch(`/ad/comment/${this.$route.params.id}`);
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
        EventBus.$on('getComment',(data)=>{
         this.fetch(`/ad/comment/${this.$route.params.id}`);
        })
        this.fetch(`/ad/comment/${this.$route.params.id}`);
    }

}
</script>
