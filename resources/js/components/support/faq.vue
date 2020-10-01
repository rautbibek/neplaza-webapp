<template>
    <div>
      <nav aria-label="breadcrumb ">
          <ol class="breadcrumb ">
              <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
              <li class="breadcrumb-item active" aria-current="page">FAQ</li>
          </ol>
      </nav>

      <div class="container">
        <div class="buyer">
          <v-container>
            <v-subheader> BUYERS FAQ</v-subheader>

            <v-card tile>
              <div>
                <v-expansion-panels style="border-radius:0px"
                    v-model="panel"
                    multiple
                  >
                    <v-expansion-panel
                      v-for="(item,i) in items"
                      :key="i"
                    >
                      <v-expansion-panel-header>Header {{ item }}</v-expansion-panel-header>
                      <v-expansion-panel-content>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                  </v-expansion-panels>
              </div>
            </v-card>
          </v-container>
        </div>
        <div class="seller">
          <v-container>
            <v-subheader>SELLERS FAQ</v-subheader>

            <v-card tile>
              <div>
                <v-expansion-panels
                    v-model="panel"
                    multiple
                  >
                    <v-expansion-panel
                      v-for="(item,i) in items"
                      :key="i"
                    >
                      <v-expansion-panel-header>Header {{ item }}</v-expansion-panel-header>
                      <v-expansion-panel-content>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                      </v-expansion-panel-content>
                    </v-expansion-panel>
                  </v-expansion-panels>
              </div>
            </v-card>
          </v-container>
        </div>
      </div>

    </div>
</template>

<script>
  export default {
    data () {
      return {

        panel: [],
        items: 5,
      }
    },
    methods: {
      // Create an array the length of our items
      // with all values as true
      all () {
        this.panel = [...Array(this.items).keys()].map((k, i) => i)
      },
      // Reset the panel
      none () {
        this.panel = []
      },
    },
    mounted(){

    }
  }
</script>
