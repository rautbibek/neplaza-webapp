<template>
  <v-footer dark padless>
    <v-card
      width="100%"
      flat
      tile
      class="lighten-1 white--text"
      style="background-color: #2f3b59"
    >
      <div class="d-none d-sm-flex">
        <v-card-text class="text-center">
          <v-btn small text> follow us :</v-btn>
          <v-btn
            small
            fab
            v-for="(icon, index) in icons"
            :key="index"
            :href="icon.link"
            target="_blank"
            class="white--text"
            icon
          >
            <v-icon>{{ icon.icon }}</v-icon>
          </v-btn>
        </v-card-text>
      </div>
      <v-divider class="d-none d-sm-flex"></v-divider>
      <div class="d-none d-sm-flex">
        <div class="container">
          <div class="row">
            <div class="col-6 col-md text-left">
              <div>
                <h5 class="ml-5 text-muted">BIKRIBAZZAR</h5>
                <ul class="list-unstyled text-small">
                  <li>
                    <a class="text-light" target="_blank" href="/support"
                      >Help & Support</a
                    >
                  </li>
                  <li>
                    <a class="text-light" target="_blank" href="/contact"
                      >Contact Us</a
                    >
                  </li>
                  <li>
                    <a class="text-light" target="_blank" href="/aboutUs"
                      >About Us</a
                    >
                  </li>
                  <li>
                    <a class="text-light" target="_blank" href="/faq">FAQ</a>
                  </li>
                  <li>
                    <a class="text-light" target="_blank" href="/trust&safety"
                      >Trust & Safety</a
                    >
                  </li>
                  <li>
                    <a class="text-light" target="_blank" href="/policy"
                      >Privacy Policy</a
                    >
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-6 col-md">
              <div class="ml-5">
                <h5 class="ml-5 text-muted">SOCIAL</h5>
                <ul class="list-unstyled text-small">
                  <li
                    v-for="(icon, index) in icons"
                    :key="index"
                    class="white--text"
                    icon
                  >
                    <a class="text-light" target="_blank" :href="icon.link">{{
                      icon.name
                    }}</a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-10 ml-5 col-md">
              <div>
                <h5 class="text-muted">CONTACT US</h5>
                <div style="font-size: 13px">
                  <p class="footer-head">MAIL US</p>

                  <p class="footer-link">Naya Basti,Boudha, Kathmandu, Nepal</p>
                  <p class="footer-head">CALL OR EMAIL US</p>
                  <p class="footer-head">
                    <a style="color: white" href="tel:9863756278"
                      >+977-9863756278</a
                    >&nbsp;,&nbsp;<a style="color: white" href="tel:9813074153"
                      >+977-9813074153</a
                    >
                  </p>
                  <p class="footer-link">
                    <a
                      style="color: white"
                      class="underline"
                      href="mailto:bikribazzar@gmail.com"
                      >bikribazzar@gmail.com</a
                    >
                  </p>
                </div>
              </div>
            </div>

            <div class="col-12 col-md">
              <h5 class="text-muted">ABOUT</h5>
              <p>
                <strong>BIKRI BAZZAR </strong> is a classified website in
                <strong>Nepal</strong> where you can buy and sell locally. Find
                the latest classified ads for realestate, jobs, cars, bikes,
                furniture, fashion, mobiles and more for sale in
                <strong>Nepal</strong>. Find buyers and sellers that suit your
                need.
              </p>
            </div>
          </div>
        </div>
      </div>
      <v-divider class="d-none d-sm-flex"></v-divider>

      <v-card-text class="white--text text-center">
        &#9400; 2020-{{ new Date().getFullYear() }} -
        <strong>Bikribazzar</strong> All rights reserved
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<script>
export default {
  data: () => ({
    icons: [
      {
        link: "https://www.facebook.com/bikribazzar/",
        icon: "mdi-facebook",
        name: "Facebook",
      },
      { link: "#", icon: "mdi-twitter", name: "Twitter" },
      { link: "#", icon: "mdi-linkedin", name: "LinkedIn" },
      { link: "#", icon: "mdi-instagram", name: "Instagram" },
    ],
  }),
};
</script>
<style scoped>
li {
  padding-top: 5px;
  font-size: 13px;
}
.footer {
  position: fixed;
  bottom: 0;
  z-index: 100;
}
</style>
