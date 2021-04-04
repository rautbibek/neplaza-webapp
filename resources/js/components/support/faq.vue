<template>
    <v-card>
      <v-container>
        
        <v-col class="text-center"><h3>FAQ</h3></v-col>
        <v-col cols="12" style="padding-bottom:0px; margin-bottom:0px">
          <v-text-field
            prepend-inner-icon="search"
            v-model="search"
            label="search"
            outlined

          ></v-text-field>

        </v-col>
         <v-col class="text-center">

           <v-btn dark color="green" @click="sell">seller faq</v-btn>
           <v-btn dark @click="buy">buyer faq</v-btn>
          </v-col>
         <v-col>

            <div v-if="sellers">
              <v-alert v-for="(seller,index) in faq" :key="index" style="background:#80808017">
                <v-card-title>{{index+1}}. {{seller.question}}</v-card-title>
                <v-card-subtitle>{{seller.answer}}</v-card-subtitle>
              </v-alert>
            </div>

            <div v-if="buyers">
              <v-alert v-for="(buyer,index) in faq" :key="index" style="background:#80808017">
                <v-card-title>{{index+1}}. {{buyer.question}}</v-card-title>
                <v-card-subtitle>{{buyer.answer}}</v-card-subtitle>
              </v-alert>
            </div>
          </v-col>

      </v-container>
    </v-card>
</template>


<script>
  export default {
    data () {
      return {
        sellers:true,
        buyers:false,
        search:'',
        seller_faq:[
          {
            question:"What is bikribazzar.com ?",
            answer:"BikriBazzar is an online trading Platform where you can sell products/services to wider range of customers."
          },

           {
            question:"How do I register myself as a seller in BikriBazzar.com?",
            answer:"To register yourself as a seller, Click in signup option in the homepage and select the option “as a seller” and proceed with the details as required thereunder."
          },
           {
            question:"Do I need to pay to avail the services of BikriBazzar.com?",
            answer:"BikriBazzar.com is developed with the view to provide small scale sellers/occasional sellers with a platform to sell their products and the services are free of cost upto a predetermined value/transactions."
          },
           {
            question:"If I register myself as a seller without any cost do I have to pay any penalty/fine if I choose to rescind my registration?",
            answer:"No. You can unregister yourself at your will, free of cost."
          },
           {
            question:"Do I have to pay any commission to BikriBazzar.com if I sell a product using the Platform?",
            answer:"No. BikriBazzar doesn’t charge any commission on transaction basis for sale of product."
          },
           {
            question:"Will BikriBazzar.com always be a free Platform?",
            answer:"Currently, BikriBazzar is not charging any fee. However, keeping in view of the amount of transaction done by a particular seller in a specified period of time, BikriBazzar.com may charge nominal fee on a periodic basis."
          },
           {
            question:"What are urgent and featured listings?",
            answer:"Urgent and featured listings are the listing that are done in the homepage of the Platform. This helps to reach more buyers on the platform."
          },
           {
            question:"Are Urgent and Featured listings free of cost too?",
            answer:"No. Urgent and featured listings are listed on the website after charging a premium form seller. "
          },

           {
            question:"How can I list my Product as Urgent and Featured Listing?",
            answer:"To list your Product in Featured and Urgent Listings upload the information of your product and click in “Sell Faster.”"
          },

           {
            question:"How can I check/verify whether my Featured/Urgent Listing ads?",
            answer:"To check validity of you ads, please go under ‘My Ads’ option of your profile. Your ads, if any, will be listed there."
          },


           {
            question:"Does BikriBazzar.com provide delivery services for the goods sold by me?",
            answer:"No. Delivery of the product is the responsibility of the seller. And on the basis of agreement between the seller and buyer."
          },

           {
            question:"I do not want my Phone Number to be displayed under my name?",
            answer:"To hide your number please select that “hide my number” option in you Profile"
          },

           {
            question:"How will I get my orders on BikriBazzar,com?",
            answer:"Currently, you orders are received directly from the buyers using the contact information provided in your Profile/Product. BikriBazzar.com is working on making order processing less tedious."
          },

           {
            question:"I wish to sell my previously owned/used product through your website. How can I do that?",
            answer:"You need to register yourself as a user/seller and list the product. While providing the details of the product, select used product."
          },

           {
            question:"How long can I list my previously owned/used product in the website?",
            answer:"Listings of previously owned/used products will expire in 180 days."
          },

           {
            question:"If I couldn’t make sale of the product(previously owned/used)in 180 days what options do I have?",
            answer:"After the expiry of 180 days you need to renew your listing by visiting the website with your registered username."
          },

        ],
        buyer_faq:[
          {
            question:'Do I need to register myself as a buyer/customer in BikriBazzar.com?',
            answer:'No. you need not register yourself as a buyer/customer in order to place your order.',
          },
          {
            question:'Do I need to pay to avail the services of BikriBazzar.com?',
            answer:'BikriBazzar.com is developed with the view to provide small scale sellers/occasional sellers with a platform to sell their products and the services are free of cost.',
          },
          {
            question:'Is there different payment mode in BikriBazzar.com?',
            answer:'Currently we have not included various method of online payment. Thus the mode of payment is to be determined with mutual understanding between buyer and seller.',
          },
          {
            question:'Does Bikribazzar.com ensures the quality of product and services listed in the website?',
            answer:'The responsibility of ensuring the quality of product and services listed in the website is of the user/seller as per the terms of use.',
          },
          {
            question:'Is there any return policy on products of BikriBazzar.com?',
            answer:'The return policy of the products is as per the discretion of seller on product by product basis. In the present scenario there is not return policy on the sale made through our website.',
          },
          {
            question:'What do I do if I received damaged products?',
            answer:'As per terms of use BikriBazzar is merely a Platform for seller and buyers to sell and buy product. Thus, it shall be the responsibility of buyer to ensuring the quality of goods and services purchased by them before approving the delivery of order or payment for such goods and services. We advise not to accept the product if the goods are damaged.',
          },
          {
            question:'Does BikriBazzar.com provide the warranty for the product sold on the Platform/Website?',
            answer:'No. Since BikriBazzar.com only provides the platform for sale of product/servies in order for business to reach larger customer base and vice versa and is in no way a party to the contract entered between the buyer and seller.',
          },
        ]
      }
    },
    methods:{
      sell(){
        this.sellers = true;
        this.buyers = false;
      },
      buy(){
        this.sellers = false;
        this.buyers = true;
      }
    },
    computed:{
      faq(){
        if(this.sellers ==true){
          return this.seller_faq.filter((data)=>{
            return data.question.toLowerCase().match(this.search);
          })
        }else{
          return this.buyer_faq.filter((data)=>{
            return data.question.toLowerCase().match(this.search);
          })
        }
      }
    }
  }
</script>
<style scoped>
/* Helper classes */
.basil {
  background-color: #dddddd !important;
}
.basil--text {
  color: #356859 !important;
}
</style>
