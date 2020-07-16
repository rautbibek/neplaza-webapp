<template> 
    <v-card  tile>
      <div class="container p-3">
          <v-overlay :value="overlay">
            <v-progress-circular indeterminate size="64"></v-progress-circular>
          </v-overlay>
          <v-card-title>USER PROFILE </v-card-title>
          <hr>
          
          <v-form ref="form" v-model="valid" lazy-validation>
              <v-col cols="12">
                <v-text-field
                    v-model="name"
                    label="Name"
                    counter="20"
                    :rules="[required('name'),minLength('name',5),maxLength('name',20)]"
                    outlined
                    clearable
                ></v-text-field>
              </v-col>

              <v-col cols="12" >
                <v-text-field
                    v-model="email"
                    label="Email"
                    counter="40"
                    :rules="[required('email'),minLength('name',5),maxLength('name',40)]"
                    outlined
                    clearable
                ></v-text-field>
              </v-col>

              <v-col cols="12">
                <v-text-field
                    type="number"
                    v-model="contact"
                    label="Contact Number"
                    counter="10"
                    :rules="[required('contact Number'),minLength('Contact Number',8),maxLength('contact Number',10)]"
                    outlined
                    clearable
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-textarea
                    v-model="about"
                    label="About (optional) "
                    outlined
                    clearable
                ></v-textarea>
              </v-col>
              <v-col cols="12">
                <v-select 
                v-model="district"
                :items='city'
                :item-text="'name'"
                :item-value="'id'"
                :rules="[v => !!v || 'District is required']"
                label="District"
                clearable
                outlined
                @change="getNhood"
                ></v-select>
              </v-col>

              <v-col cols="12">
                <v-select
                v-model="nhood"
                :items='localArea'
                :item-text="'name'"
                :item-value="'id'"
                :rules="[v => !!v || 'Metro/Municipility/VDC is required']"
                label="Metro/Municipility/VDC"
                clearable
                outlined
                :loading ="loading"
                >
                </v-select>
              </v-col>
              

            <v-col cols="12">
                <v-btn tile outlined large color="primary"  @click="submit">Update PROFILE</v-btn>
            </v-col>
          </v-form>
      </div>
</v-card>
</template>
<script>
export default {
    data(){
        return{
            loading : false,
            valid:true,
            overlay:false,
            district:this.loginUser.city_id,
            name : this.loginUser.name,
            email : this.loginUser.valid_email,
            contact: this.loginUser.phone,
            about:this.loginUser.about,
            nhood:this.loginUser.nhood_id,
            city:[],
            localArea:[],
            required(propertyType){
               return v => v && v.length > 0 || `you must input a ${propertyType}`
            },
            minLength(propertyType,length){
               return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            maxLength(propertyType,length){
               return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            },
            

        }
    },
    methods:{
        submit(){
            if(this.$refs.form.validate()){
                this.overlay = true;
                axios.put(`/update/profile`,{
                    name : this.name,
                    email:this.email,
                    contact: this.contact,
                    about:this.about,
                    nhood:this.nhood,
                    district: this.district,
                })
                     .then(response =>{
                         this.overlay = false;
                         this.$toast.success(response.data,'success',{
                         timeout:3000,
                         position: 'topRight',
                         });
                         EventBus.$emit('updateUser',true);
                         
                         EventBus.$emit('loadUser');
                     })
                     .catch(error=>{
                         if(error.response.status == 422){
                             this.overlay= false;
                             this.$toast.error(error.response.data.errors.email[0],'error',{
                                timeout:3000,
                                position: 'topRight',
                            });
                         }
                         
                     });
            }
        },

        getCity(){
            axios.get( `/all/city`)
                 .then(response =>{
                     this.city = response.data;
                     
                     this.getNhood();
                 })
                 .catch();
        },

        getNhood(){
            this.loading= true;
            axios.get(`/get/nhood/${this.district}`)
                 .then(response => {
                     this.localArea = response.data;
                     this.loading= false;
                     
                 })
                 .catch()
        },
        
    },
    created(){
        return this.getCity();
    }
}
</script>