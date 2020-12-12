<template>
    <div>
        <v-container class="scroll-y">
            <v-layout align-center justify-center>
                <v-flex xs12>
                    <v-btn
                        v-scroll="onScroll"
                        v-show="fab"
                        small
                        fab
                        dark
                        fixed
                        bottom
                        right
                        color="primary"
                        @click="toTop">
                        <v-icon>keyboard_arrow_up</v-icon>
                    </v-btn>
                </v-flex>
            </v-layout>
      </v-container>
    </div>
</template>
<script>
export default {
   data(){
       return{
           fab:false,
       }
   },

  methods: {
    onScroll (e) {
      if (typeof window === 'undefined') return
      const top = window.pageYOffset ||   e.target.scrollTop || 0
      this.fab = top > 20
    },
    toTop () {
      this.$vuetify.goTo(0)
    }
  }
}
</script>