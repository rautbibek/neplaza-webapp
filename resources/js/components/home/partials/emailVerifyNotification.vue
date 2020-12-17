<template>
  <div class="text-center">
    <v-snackbar
      timeout="-1"
      v-model="snackbar"
      right
      :vertical="vertical"
    >
      {{ text }}

      <template v-slot:action="{ attrs }">
        <v-btn
          to="/user/email/setting"
          color="indigo"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Ok
        </v-btn>
      </template>

    </v-snackbar>
  </div>
</template>
<script>
  export default {
    data: () => ({
      snackbar: false,
      text: 'Verify your email address',
      vertical: true,
    }),
    mounted(){
      if(!this.loginUser.email_verified_at){
        this.snackbar = true;
      }
    }
  }
</script>
