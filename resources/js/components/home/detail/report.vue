<template>
  <div>
    <v-btn color="red" @click="report" text >Report ad</v-btn>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent  width="700">
        <v-card>
            <v-card-title class="text-right">
            Report This Ad
            <v-spacer></v-spacer>
            <v-btn x-small fab @click="dialog = false"><v-icon>close</v-icon></v-btn>
            </v-card-title>
            <v-divider></v-divider>
            <v-row>
                <v-col cols="12" xs="12" md="6">
                    <v-card-text>
                          <v-card
                            class="mx-auto"
                            max-width="400"
                        >
                            <v-img
                            class="white--text align-end"
                            height="200px"
                            :src="ads.product_cover"
                            >
                            </v-img>
                            <v-card-subtitle class="pb-0">{{ads.ad_title}}</v-card-subtitle>
                            <v-card-actions>
                            <v-btn
                                color="orange"
                                text
                            >
                            <v-icon left>mdi-account-circle</v-icon>
                                {{ads.user.name}}
                            </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-card-text>
                </v-col>
                <v-col cols="12" xs="12" md="6">
                    <v-form ref="form" v-model="valid" lazy-validation>
                    <v-card-text>
                        <v-col cols="12" >
                            <v-text-field
                                v-model="email"
                                label=" Your Email"
                                counter="40"
                                dense
                                :rules="[required('email'),minLength('email',5),maxLength('email',40)]"
                                clearable
                            ></v-text-field>
                        </v-col>
                        <v-col cols="12">
                            <v-select 
                            dense
                            v-model="reason"
                            :items='item'
                            :item-text="'title'"
                            :item-value="'title'"
                            :rules="[select('reason')]"
                            label="reason for reporting"
                            clearable
                            
                            
                            ></v-select>
                        </v-col>
                        <v-col cols="12">
                            <v-textarea
                                auto-grow
                                rows="3"
                                dense
                                v-model="description"
                                label="Description"
                                :rules="[required('description'),maxLength('description',400)]"
                                counter="400"
                                clearable
                            ></v-textarea>
                        </v-col>
                        <v-col cols="12" class="text-right">
                            
                            <v-btn dark color="indigo" @click="postReport">
                                <v-icon small left>report</v-icon>
                                Report
                            </v-btn>
                        </v-col>
                    </v-card-text>
                    </v-form>
                </v-col>
            </v-row>
        </v-card>
        </v-dialog>
    </v-row>
  </div>
</template>

<script>

  export default {
    props:['ads'],
    data () {
      return {
        product_id:'',
        product:'',
        user_id:'',
        valid:true,
        email:'',
        reason:'',
        description:'',
        dialog: false,
           select(propertyType) {
                return v => !!v || `you must select a ${propertyType}`
            },
            required(propertyType) {
                return v => v && v.length > 0 || `you must input a ${propertyType}`
            },
            minLength(propertyType, length) {
                return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },
            maxLength(propertyType, length) {
                return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            },
        item: [
          {
            title:'Fake user'
          },
          {
            title:'Fake product'
          },
          {
            title:'Fake product'
          },
        ],
      }
    },
    methods:{
        report(){
            this.dialog = true;
           
            
        },
        postReport(){
            if(this.$refs.form.validate()){
            axios.post(`/post/ad/report`,{
                product_id:this.ads.id,
                product : this.ads.productid,
                user_id: this.ads.user.id,
                email:this.email,
                reason: this.reason,
                description:this.description,
            })
                
                 .then(response=>{
                     this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                    
                    this.$refs.form.reset()
                    this.dialog = false;
                 })
                 .catch(error=>{
                     this.$toast.error(error.response.data.message, 'Failled', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                 });
            }
        }

    },
    created(){
      //
    }
  }
</script>