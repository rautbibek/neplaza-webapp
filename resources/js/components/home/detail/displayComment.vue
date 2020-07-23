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
            <div class="text-center p-3" v-if="nextUrl">
                      <v-btn :loading="loading" dark tile small color="#2F3B59" class="" @click.prevent="moreComment(nextUrl)">
                          Load More Comments
                          <template v-slot:loader>
                              <span>Loading...</span>
                          </template>
                          
                      </v-btn>
                  </div>
        </v-card>
        
    </div>
</template>
<script>
export default {
    props:['product_id'],
    data(){
        return{
            loading:false,
            overlay:false,
            nextUrl:'',
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
                    this.fetch(`/ad/comment/${this.$route.params.id}`);
                    this.overlay= false;
                 })
                 .catch();
            }
        },
        fetch(url){
            axios.get(url)
                 .then(({data}) =>{
                     this.all_comments = data.data;
                     this.nextUrl = data.next_page_url
                 })
        },
        moreComment(nextUrl){
            this.loading=true;
            axios.get(nextUrl)
             .then(({data}) =>{
                this.all_comments.push(...data.data);
                this.nextUrl = data.next_page_url
                this.loading = false;
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
        EventBus.$on('loadComment',(data)=>{
            this.fetch(`/ad/comment/${this.$route.params.id}`);
        })
        this.fetch(`/ad/comment/${this.$route.params.id}`);
    }
}
</script>