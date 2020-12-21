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
      <v-card-text class="text-center">
        <v-btn small text> follow us :</v-btn>
        <v-btn small fab
          v-for="icon in icons"
          :key="icon"
          class="white--text"
          icon
        >
          <v-icon>{{ icon }}</v-icon>
        </v-btn>
      </v-card-text>
      <v-divider></v-divider>
              <div class="container">
                <div class="row">

                  <div class="col-6 col-md text-left ">
                    <div >
                      <h5 class="ml-5 text-muted">NEPLAZA</h5>
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
                        <li><a class="text-light" href="#">Facebook</a></li>
                        <li><a class="text-light" href="#">Instagram</a></li>
                        <li><a class="text-light" href="#">Twitter</a></li>
                        <li><a class="text-light" href="#">Linked In</a></li>
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
                          <p class="footer-link">

                            <a style="color:white" class="underline" href="mailto:rautbibek47@gmail.com">rautbibek47@gmail.com</a>
                          </p>
                          <p class="footer-head">
                              REGISTERED OFFICE ADDRESS
                          </p>
                          <p class="footer-link">Naya Basti,Boudha, Kathmandu, Nepal</p>
                          <p class="footer-head">
                            CONTACT NUMBER
                          </p>
                          <p class="footer-head">
                              <a style="color:white" href="tel:9863756278">+977-9863756278</a>&nbsp;,&nbsp;<a style="color:white" href="tel:9813074153">+977-9813074153</a>
                          </p>
                      </div>

                    </div>
                  </div>

                  <div class="col-12 col-md">
                    <h5 class="text-muted">FACEBOOK PAGE</h5>
                    <div class="ml-5">
                    <div class="fb-page"
                    data-href="https://www.facebook.com/btgroup.pvt"
                    data-width="290px"
                    data-hide-cover="false"
                    data-show-facepile="true"></div>
                    </div>
                  </div>
                </div>
              </div>


      <v-divider></v-divider>

      <v-card-text class="white--text text-center">
        &#9400; 2020-{{ new Date().getFullYear() }} - <strong>Neplaza</strong> All rights reservd
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
</style>
