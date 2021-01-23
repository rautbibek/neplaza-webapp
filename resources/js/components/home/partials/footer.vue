<template>
  <v-footer
    dark
    padless
    
    
  >
    <v-card width="100%"
      flat
      tile
      class="lighten-1 white--text" style="background-color:#2F3B59"
    >
      <div class="d-none d-sm-flex">
        <v-card-text class="text-center " >
        <v-btn small text> follow us :</v-btn>
        <v-btn small fab
          v-for="icon in icons"
          :key="icon"
          router to="https://www.facebook.com/Bikri-bazzar-106546471305792"
          class="white--text"
          icon
        >
          <v-icon>{{ icon }}</v-icon>
        </v-btn>
      </v-card-text>
      </div>
      <v-divider class="d-none d-sm-flex"></v-divider>
      <div class="d-none d-sm-flex">
       <div class="container">
                <div class="row">

                  <div class="col-6 col-md text-left ">
                    <div >
                      <h5 class="ml-5 text-muted">BIKRIBAZZAR</h5>
                      <ul class="list-unstyled text-small">
                        <li><router-link class="text-light" to="/contact/us" >Contact Us</router-link></li>
                        <li><router-link class="text-light" to="/about/us" >About Us</router-link></li>
                        <li><a class="text-light" href="#">Careers</a></li>
                        <li><router-link class="text-light" to="/FAQ" >FAQ</router-link></li>
                        <li><router-link class="text-light" to="/terms/condition" >Terms & Condition</router-link></li>
                        <li><router-link class="text-light" to="/privacyPolicy" >Privacy Policy</router-link></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-6 col-md">
                    <div class="ml-5">
                      <h5 class="ml-5 text-muted">SOCIAL</h5>
                      <ul class="list-unstyled text-small">
                        <li><a class="text-light" href="https://www.facebook.com/Bikri-bazzar-106546471305792">Facebook</a></li>
                        <li><a class="text-light" href="https://www.facebook.com/Bikri-bazzar-106546471305792">Instagram</a></li>
                        <li><a class="text-light" href="https://www.facebook.com/Bikri-bazzar-106546471305792">Twitter</a></li>
                        <li><a class="text-light" href="https://www.facebook.com/Bikri-bazzar-106546471305792">Linked In</a></li>
                      </ul>
                    </div>
                  </div>
                  <div class="col-10 ml-5  col-md ">
                    <div  >
                        <h5 class="text-muted">CONTACT US</h5>
                        <div style="font-size:13px;">
                          <p class="footer-head">
                              MAIL US
                          </p>
                          
                          
                          <p class="footer-link">Naya Basti,Boudha, Kathmandu, Nepal</p>
                          <p class="footer-head">
                             CALL OR EMAIL US
                          </p>
                          <p class="footer-head">
                              <a style="color:white" href="tel:9863756278">+977-9863756278</a>&nbsp;,&nbsp;<a style="color:white" href="tel:9813074153">+977-9813074153</a>
                          </p>
                          <p class="footer-link">

                            <a style="color:white" class="underline" href="mailto:bikribazzar@gmail.com">bikribazzar@gmail.com</a>
                          </p>
                      </div>

                    </div>
                  </div>

                  <div class="col-12 col-md">
                    <h5 class="text-muted">ABOUT</h5>
                    <p>
                      <strong>BIKRI BAZZAR </strong> is a classified website in <strong>Nepal</strong> where you can buy and sell locally. 
                      Find the latest classified ads for realestate, jobs, cars, bikes, furniture, fashion, 
                      mobiles and more for sale in <strong>Nepal</strong>. Find buyers and sellers that suit your need.
                    </p>
                  </div>
                </div>
       </div>
      
      </div>
      <v-divider class="d-none d-sm-flex"></v-divider>

      <v-card-text class="white--text text-center">
        &#9400; 2020-{{ new Date().getFullYear() }} - <strong>Bikribazzar</strong> All rights reservd
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
  export default {
    data: () => ({
      icons: [
        'mdi-facebook',
        'mdi-twitter',
        'mdi-linkedin',
        'mdi-instagram',
      ],
    }),
  }
</script>
<style scoped>
  li{
    padding-top:5px;
    font-size:13px;
  }
  .footer {  
    position: fixed;  
    bottom: 0;  
    z-index: 100;  
}
</style>
