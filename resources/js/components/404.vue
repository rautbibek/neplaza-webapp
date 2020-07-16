<template>
    <div>
        <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">404 page not found</li>
            </ol>
        </nav>
        <v-container>
            <div class="container">
                
                    <v-card dense tile flat 
                        max-width="344"
                        class="mx-auto"
                        
                    >
                        <h4  class="text-center" style="font-size:50px; color:indigo">Oops !</h4>
                        <p class="text-center mt-3" style=" font-size:20px">
                           We can't seem to find the page your are looking for.
                        </p>
                        <!-- <v-img
                            src="/storage/404.png"
                            height="194"
                        ></v-img> -->

                        <div class="text-center" >
                            <v-btn router to="/"
                                dark
                                tile
                                color="deep-purple accent-4"
                            >
                                Back to homepage
                            </v-btn>
                        </div>
                    </v-card>
                
            </div>
        </v-container>
    </div>
</template>