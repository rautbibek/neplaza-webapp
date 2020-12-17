<template>
  <div transition="fab-transition">
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-card-text class="pa-0">
      <v-list three-line class="pa-0">
        <v-list-item v-for="(reply, index) in replies" :key="index">
          <v-list-item-avatar color="grey" size="25">
            <v-img :src="reply.user.cover"></v-img>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title class="text-capitalize">{{
              reply.body
            }}</v-list-item-title>
            <v-list-item-subtitle
              ><small
                >{{ reply.user.name }} - {{ reply.created }}</small
              ></v-list-item-subtitle
            >

            <v-card-actions v-if="loggedIn" class="pa-0">
              <v-btn
                x-small
                text
                class="pa-0"
                color="red"
                v-if="loginUser.id == reply.user_id"
                @click="deleteComment(reply)"
                >delete</v-btn
              >
            </v-card-actions>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-col cols="12" lg="12" class="pa-0">
        <v-textarea
          @keydown.enter="replyComment"
          v-model="comment"
          clear-icon="mdi-close-circle"
          prepend-icon="mdi-account-circle"
          append-outer-icon="mdi-send"
          clearable
          auto-grow
          color="#2f3b59"
          label="Reply Comment"
          type="text"
          class="pt-0 pl-4"
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
  props: ["replies", "cmt_id", "product_id"],
  data() {
    return {
      comment: "",
      overlay: false,
    };
  },

  methods: {
    deleteComment(reply) {
      if (confirm("are you sure ?")) {
        this.overlay = true;
        axios
          .delete(`/delete/comment/${reply.id}`)
          .then((response) => {
            this.$toast.info(response.data, "message", {
              timeout: 3000,
              position: "topRight",
            });
            this.replies.splice(this.replies.indexOf(reply), 1);
            this.overlay = false;
          })
          .catch((error) => {
            this.overlay = false;
          });
      }
    },
    replyComment() {
      if (!this.loggedIn) {
        EventBus.$emit("changeDialog", true);
        return;
      }
      this.overlay = true;
      axios
        .post(`/reply/ad/comment`, {
          product_id: this.product_id,
          comment_id: this.cmt_id,
          comment: this.comment,
        })
        .then((response) => {
          this.$toast.success(response.data, "success", {
            timeout: 3000,
            position: "topRight",
          });
          EventBus.$emit("getComment", true);
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
};
</script>