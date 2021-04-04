<template>
 
    <v-container>
      <div class="center" style="background:#251f1f; color:white">
        <v-card-title>Trust And Safety </v-card-title>
      </div>
     
      <div style="min-height: 470px">
        <v-card-text class="subtitle-2"
          >Bikribazzar.com provide you with portal to visit and search for the
          seller products and services desired by you and sold by the registered
          user in the website. However, since we do not take part in the
          transaction made between you and the seller and in no aspect we
          supervise the quality of the products, we advise you the following,
          for your own safeguard and safety from any damages be that may of
          financial or other nature caused by entering into such transaction
          form within the site:
        </v-card-text>
          <div class="ml-5">
            <v-timeline dense>
          <v-slide-x-reverse-transition group hide-on-leave>
            <v-timeline-item
              v-for="(item,index) in items"
              :key="index"
              color="red lighten-2"
              small
              fill-dot
            >
             
              <v-card class="elevation-2">
                <v-card-title class="headline"> Tip-{{index+1}} </v-card-title>
                <v-card-text>
                  {{item.content}}
                </v-card-text>
              </v-card>
            </v-timeline-item>
          </v-slide-x-reverse-transition>
        </v-timeline>
          </div>
      </div>
    </v-container>
  
</template>
<script>
export default {
  data() {
    return {
      items: [
        {
          content:
            "While buying high value items, be ensure that the seller is legitimate and fulfilment of any legal or statutory requirement that may be attached within such transaction by any rules and regulations for the time being in force, applicable to such transaction.",
        },
        {
          content:
            "Always Inspect goods after delivery and before the payment to ensure that the product you are delivered is the one desired and ordered by you and are upto the specifications as listed in the website.",
        },
        {
          content:'Please avoid paying online or advance payments in order to protect yourselves from any damages such as undelivered purchase for which no refund is made. In other words, we advise you to make payment as Cash on Delivery only. Be careful when paying online - do it safely - do not use the instant cash transfer services to pay for your purchase.'
        },
        {
          content:'In case the seller requires you to pay the shipping charges in advance, we advise you to do the same only if it’s a trusted seller or the seller you frequently purchases form.'
        },
        {
          content:'If any seller require you to provide any of your personal information expect those required for delivery of the goods (such as bank information etc.), do not enter into transaction with those sellers. '
        },
        {
          content:'Before placing an order do inquire about the shipping charges or any other charges as required in excess of the listed price in the website and the time period of delivery so you can receive your delivery in expected time. '
        },
        {
          content:'Be aware of the unusual/suspicious requests.'
        },
        {
          content:'For any underpriced items please read the description of the good before placing an order and inspect the same have been delivered to you or received by you.',
        }
      ],
    };
  },
};
</script>