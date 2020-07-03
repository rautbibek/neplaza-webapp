<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Setting</li>
            </ol>
        </nav>
      <div class="py-5">
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
        <v-container>
            <div class="container my-5 border">
                <div class="row">
                    <div class="col-md-9 col-sm-6">
                        <h5 class="mt-2">Hide Contact Number</h5>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <v-switch v-model="contact_status" :label="label" @change="change_contact_status">Hidden for all </v-switch>
                    </div>
                </div>
                <hr class="mb-5">
                <div class="row">
                    <div class="col-md-9 col-sm-6">
                        <h5>Deactivate Account</h5>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <v-btn tile color="primary" @click="deactivate">Deactivate account</v-btn>
                    </div>
                </div>
            </div>
        </v-container>
      </div>
    </div>
</template>
<script>

export default {
    data(){
      return{
        user_id:'',
        contact_status:false,
        overlay:false
      }
    },
    methods:{
        user(){
            if(!this.loggedIn){
                this.$router.push("/");
                EventBus.$emit('changeDialog', true);
                return;
            }
            //this.user = loginUser;
            this.user_id = this.loginUser.id;
            this.contact_status = this.loginUser.hide_contact;
        },
        change_contact_status(){
            this.overlay= true;
            axios.put(`/user/contact/status`,{
                status: this.contact_status,
            })
                 .then(response=>{
                     this.overlay= false;
                 })
                 .catch();
        },
        deactivate(){
            
            if(confirm('are you sure to want do deactivate your account')){
            this.overlay= true;
            axios.put(`/user/deactivate/account`)
                 .then(response =>{
                     this.overlay= false;
                     return this.logout();
                 }).catch();
                  this.overlay= false;
            }
           
        },
        logout(){
            axios.post(`/logout`)
                 .then(response =>{
                     location.reload();
                 })
        }
        

    },
    computed:{
        label(){
            return this.contact_status ? "Hidden for all ": "Visible for all";
        },
        
    },
    created(){
        return this.user();
    }


}
</script>