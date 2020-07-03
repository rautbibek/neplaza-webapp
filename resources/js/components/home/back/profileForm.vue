<template>
  <v-row justify="center">
    <v-overlay :value="overlay">
        <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>
    <v-dialog v-model="dialog" persistent  max-width="380">
      <v-card>
          <v-card-title class="text-right">
            Provide your contact number
          <v-spacer></v-spacer>
          <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
          </v-card-title>
          <v-divider></v-divider>
          <v-form ref="form" v-model="valid" lazy-validation>
              <v-col cols="12">
                <v-text-field
                    type="number"
                    v-model="contact"
                    label="Contact Number"
                    counter="10"
                    
                    outlined
                    clearable
                ></v-text-field>
              </v-col>
            <v-divider></v-divider>
            <v-col cols="12">
                <v-btn tile small color="primary"  @click="submit">save</v-btn>
            </v-col>
          </v-form>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>
  export default {
    data () {
      return {
        overlay:false,
        contact:'',
        loading : false,
        valid:true,
        overlay:false,
        dialog: false,
        required(propertyType){
               return v => v && v.length > 0 || `you must input a ${propertyType}`
            },
            minLength(propertyType,length){
               return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            maxLength(propertyType,length){
               return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            },
        items: [
          {
            src: '/image/back.jpg',
          },
        ],
      }
    },
    methods:{
        submit(){
          this.overlay= true
            axios.put(`/update/contact`,{
              contact : this.contact,
            }).then(response =>{
               this.overlay = false;
               EventBus.$emit('contactUpdated', this.contact);
               this.dialog = false;
            })
              .catch(error=>{
                  this.overlay = false;
                  if (error.response.status === 422) {
                  this.$toast.error(error.response.data.errors.contact[0],'error',{
                    timeout:3000,
                    position: 'topRight',
                  });
                }
              });
        }
    },
    created(){
      EventBus.$on('profileForm',(data)=>{
        this.dialog = data;
      })
    }
  }
</script>