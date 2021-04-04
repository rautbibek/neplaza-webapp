<template>
<v-card>
  
  <v-container>
    <div class="center">
      <v-card-title>Privacy Policy</v-card-title>
   </div>
    <div style="min-height:470px">
      <v-card-text v-for="(policy,index) in policies" :key="index">{{policy.content}}</v-card-text>
    </div>
  </v-container>
</v-card>
</template>
<script>
export default {
  data(){
    return{
      policies:[
        {
          content:'Thank you for choosing to be a part of BikriBazzar.com. We are committed towards the protection and safeguard of the information provided to us. '
        },
        {
          content:'We collect the personal information voluntarily provided to us when you register with us, the extent of which depends on the activities that you are involved including the services and features you choose to use within the website. The extent of information collected by us includes personal information provided by you to us, social media login data (registration using your social media account, whereby you will be directed to the respective website of the social media site of your choice.). All Personal information provided by you must be true and any changes to such must be incorporated on the account details of your dashboard of the website. '
        },
        {
          content:' The information collected by us through the websites will only be used for the purpose of legitimate business activities for which prior approval have been received from you, such as display of your contact information on the website for easier communication from a perspective buyer of the product you are selling. We may further use the information provided to us for responses to inquires made by you or to inform you about the updates to the website and product listed therein or the information about any expiry of period of listings or any reports made on the listing of your product in violation with the terms of use of our website/platform.'
        },
        {
          content:'Your information will be shared only after you prior approval, or to comply with laws and regulations for the time being in force. '
        },
        {
          content:'We value your privacy and are keen to protect your information provide to us, however we shall not be responsible for the safety of information that you share with third parties whether or not affiliated with us. We have put in place an organizational and technical security measures in order to protect the information provided by you to us.'
        },
        {
          content:'It is informed to you that the information provided by you to us shall be kept at all time during which your registration is active within our website and on deactivation or removal of your registration with us your information shall be kept for a minimum of three months or in case required by any law such for such period required therein. '
        }
      ]
    }
  }
}
</script>
