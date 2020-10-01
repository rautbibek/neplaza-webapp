<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent  max-width="380">
      <v-card>
        <v-card-title class="text-right">
          Create your account 
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
          <v-carousel  hide-delimiter-background hide-delimiters
          height="150" cycle>
              <v-carousel-item
                v-for="(item,i) in items"
                :key="i"
                :src="item.src"
              >
              </v-carousel-item>
              <v-overlay absolute opacity=".6"><h3> Create your account </h3></v-overlay>
          </v-carousel>
        </v-card-text>
        <v-card-text>
          <v-btn dark href="/register" large color="indigo" class="my-1" style="width:100%">
            <v-icon>phone</v-icon>
             &nbsp; login with Number
           </v-btn>
           <v-btn href="/login/facebook" large color="primary" class="my-1" style="width:100%">
            <v-icon>mdi-facebook</v-icon>
             &nbsp;login with Facebook
           </v-btn>
           <v-btn href="/login/google" dark large color="#d93025" class="my-1" style="width:100%">
            <v-icon>mdi-google-plus</v-icon>
             &nbsp; login with Gmail
           </v-btn>

           <!-- <v-btn href="/login/yahoo"  large dark color="#6001d2" class="my-1" style="width:100%">
            <v-icon>mdi-email</v-icon>
             &nbsp; Email
           </v-btn> -->

           <v-btn large href="/login/twitter" color="primary" class="my-1" style="width:100%">
            <v-icon>mdi-twitter</v-icon>
             &nbsp;login with twitter
           </v-btn>
        </v-card-text>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

  export default {
    data () {
      return {
        dialog: false,
        items: [
          {
            src: '/image/back.jpg',
          },
        ],
      }
    },
    created(){
      EventBus.$on('signUp',(data)=>{
        this.dialog = data;
      })
    }
  }
</script>
