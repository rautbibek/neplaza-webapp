<template>
    <div>
      <v-btn @click="toggle"
         class="mt-3 ml-3"
         absolute
         x-small
         dark
         fab
         right
        :color="background"
        >
        <v-icon :color="color">mdi-heart</v-icon>
      </v-btn>
    </div>
</template>
<script>

    export default {
        props:['is_favorite','product_id'],
        data(){
            return{
                fav : this.is_favorite,
                id:this.product_id,
                
            }
        },
        methods:{
            toggle(){
             if(!this.loggedIn){
                this.$toast.error('Please Login First','Login',{
                         timeout:3000,
                         position: 'topRight',
                    });
                //EventBus.$emit('changeDialog', true);
                return;
             }
            this.fav? this.destroy() : this.create();
            },

            create(){
                this.fav = true;
               axios.post(this.url)
                    .then(response => {
                        this.fav = true;
                    })
                    .catch();
            },

            destroy(){
                this.fav = false;
                axios.post(this.url)
                    .then(response => {
                        this.fav = false;
                    })
                    .catch();
            }
        },

        computed:{
            color(){
                return this.fav ? 'red':'white';
            },
            background(){
                return this.fav ? 'white':'#270f0ea1';
            },
            url(){
                return `/favorite/${this.id}/add`;
            },

        },
    }
</script>