<template>
  <div id="#comment">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card color="#00000000">
      <v-card-title class="pl-0 no-comment" v-if="ad_comments.length === 0"
        >Be the First to Comment</v-card-title
      >
      <v-card-title class="pl-0" v-else
        >Comments
        <span class="ml-1 count">({{ ad_comments.length }})</span></v-card-title
      >
      <v-card-text class="pl-0">
        <v-textarea
          @keydown.enter="postComment"
          v-model="comment"
          auto-grow
          color="#2f3b59"
          clear-icon="mdi-close-circle"
          prepend-icon="mdi-account-circle"
          append-outer-icon="mdi-send"
          outlined
          clearable
          label="Enter your comment"
          type="text"
          rows="4"
          @click:append-outer="postComment"
        >
        </v-textarea>
      </v-card-text>
      <v-card-text class="pa-0">
        <v-row no-gutters v-for="(comments, index) in ad_comments" :key="index">
          <div class="d-flex">
            <v-avatar color="indigo" size="36">
              <img :src="comments.user.cover" :alt="comments.user.name" />
            </v-avatar>
            <div class="d-flex flex-column ml-5">
              <h6 style="color: black; font-size: 15px">{{ comments.body }}</h6>
              <span style="font-size: 13px"
                >{{ comments.user.name }} - {{ comments.created }}</span
              >
              <p class="pt-2" v-if="loggedIn">
                <v-btn
                  x-small
                  text
                  class="actions mr-4"
                  color="red"
                  v-if="loginUser.id == comments.user_id"
                  @click="deleteComment(comments)"
                  >Delete</v-btn
                >
                <v-btn
                  x-small
                  text
                  color="success"
                  @click="showReplies(comments.id)"
                  >Reply ({{ comments.replies.length }})</v-btn
                >
              </p>
              <p class="pt-2" v-if="!loggedIn">
                <v-btn
                  x-small
                  class="actions"
                  text
                  color="success"
                  @click="showReplies(comments.id)"
                  >reply ({{ comments.replies.length }})</v-btn
                >
              </p>

              <comment-reply
                transition="fab-transition"
                :cmt_id="comments.id"
                :product_id="comments.product_id"
                v-if="show == comments.id"
                :replies="comments.replies"
              ></comment-reply>
            </div>
          </div>
        </v-row>
      </v-card-text>
    </v-card>
  </div>
</template>
<script>
import commentReply from  './reply';
export default {
 components:{
   'comment-reply': commentReply,
 },
  data() {
    return {
      loading: false,
      overlay: false,
      ad_comments: [],
      show: "",
      comment: "",
    };
  },
  methods: {
    showReplies(id) {
      this.show = id;
    },
    deleteComment(comment) {
      if (confirm("are you sure ?")) {
        this.overlay = true;
        axios
          .delete(`/delete/comment/${comment.id}`)
          .then((response) => {
            this.$toast.info(response.data, "message", {
              timeout: 3000,
              position: "topRight",
            });
            this.ad_comments.splice(this.ad_comments.indexOf(comment), 1);

            this.overlay = false;
          })
          .catch();
      }
    },
    fetch(url) {
      axios.get(url).then((response) => {
        this.ad_comments = response.data;
      });
    },

    postComment() {
      if (!this.loggedIn) {
        EventBus.$emit("changeDialog", true);
        return;
      }
      this.overlay = true;
      axios
        .post(`/user/comment`, {
          product_id: this.$route.params.id,
          comment: this.comment,
        })
        .then((response) => {
          this.$toast.success(response.data, "success", {
            timeout: 3000,
            position: "topRight",
          });

          this.fetch(`/ad/comment/${this.$route.params.id}`);
          this.comment = "";
          this.overlay = false;
        })
        .catch((error) => {
          this.$toast.error("Invalid data ", "error", {
            timeout: 3000,
            position: "topRight",
          });
          this.overlay = false;
        });
    },
  },

  created() {
    EventBus.$on("getComment", (data) => {
      this.fetch(`/ad/comment/${this.$route.params.id}`);
    });
    this.fetch(`/ad/comment/${this.$route.params.id}`);
  },
};
</script>
<style scoped>
.v-card {
  box-shadow: none !important;
}
.actions {
  padding: 0px !important;
}
.no-comment {
  font-size: 15px;
  color: #757575;
}
.count {
  font-size: 16px;
  color: #757575;
}
.d-flex {
  flex: 1;
}
</style>