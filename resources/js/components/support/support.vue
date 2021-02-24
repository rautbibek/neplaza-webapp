<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Help and support</li>
                
            </ol>
        </nav>
        <div class="cover-image">
      <h3 class="text-center">Welcome to our support center</h3>
    </div>
        <v-container class="cover-container create-ad mb-5">
            <v-row>
                <v-col v-for="(item,index) in items" :key="index" cols="12" md="3" sm="6" lg="3">
                    <v-card
                        :color="item.color"
                        dark
                        router :to="item.url"
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
         <!-- Your Chat Plugin code -->
         <div class="fb-customerchat"
             attribution="setup_tool"
             page_id="106546471305792">
         </div>
    </div>
    
</template>
<script>

export default {
    data(){
        return{
            n:1,
            items: [
                {
                    icon: "phone",
                    text: "Contact Us",
                    url: "/",
                    color:'#385F73',
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },

                {
                    icon: "call_to_action",
                    text: "About Us",
                    url: "/",
                    color:"#952175",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                {
                    icon: "help_outline",
                    text: "FAQ",
                    url: "/",
                    color:"#1F7087",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
                {
                    icon: "cases",
                    text: "Career",
                    url: "/",
                    color:"deep-purple lighten-1",
                    description:"Listen to your favorite artists and albums whenever and wherever, online and offline.",
                },
            ],
        }
    }
}
</script>