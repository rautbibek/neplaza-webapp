<template>
    <div>
        
    <div class="support-image">
      <h3 class="text-center">Welcome to our support center</h3>
    <p style="color:white; text-align:center"><a style="color:white" href="/">Home</a> > Help & Support </p>
    </div>
        <v-container class="cover-container create-ad mb-5">
            <v-row>
                <v-col v-for="(item,index) in items" :key="index" cols="12" md="4" sm="6" lg="4">
                    <v-card
                        :color="item.color"
                        dark
                        :href="item.url"
                    >
                        <v-card-title class="headline mb-3">
                          <v-btn outlined
                            class="mr-3"
                            fab
                            dark
                            small
                            color="white"
                            >
                            <v-icon dark>
                                {{item.icon}}
                            </v-icon>
                            </v-btn> {{item.text}}
                        </v-card-title>
                        <v-card-subtitle>{{item.description}}</v-card-subtitle>
                        <v-card-actions>
                        
                        </v-card-actions>
                    </v-card>
                </v-col>

            </v-row>  
        </v-container>
         
    </div>
    
</template>
<script>

export default {
    data(){
        return{
            n:1,
            items: [
               
                {
                    icon: "help_outline",
                    text: "FAQ",
                    url: "/faq",
                    color:"#1F7087",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                {
                    icon: "lightbulb",
                    text: "Trust & Safety",
                    url: "/trust&safety",
                    color:"#3eb54b",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },

                {
                    icon: "pan_tool",
                    text: "Legal & Policy info.",
                    url: "/policy",
                    color:"#111796",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                {
                    icon: "cases",
                    text: "Career",
                    url: "/career",
                    color:"deep-purple lighten-1",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                 {
                    icon: "phone",
                    text: "Contact Us",
                    url: "/contact",
                    color:'#385F73',
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },

                {
                    icon: "call_to_action",
                    text: "About Us",
                    url: "/aboutUs",
                    color:"#952175",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                
            ],
        }
    }
}
</script>