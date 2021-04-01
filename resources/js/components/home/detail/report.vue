<template>
  <div>
    <v-list-item @click="report"><v-icon color="red" >report</v-icon> Report  </v-list-item>
    <v-row justify="center">
      <v-dialog v-model="dialog" persistent width="450">
        <v-card>
          <v-card-title class="text-right text-light bg-blue" >
          Report this AD
          <v-spacer></v-spacer>
          <v-btn x-small icon @click="close">
            <v-icon color="#fff">close</v-icon>
          </v-btn>
        </v-card-title>
            <v-col cols="12" >
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-text>
                  <v-col cols="12" style="padding:0px">
                    <v-select
                      dense
                      v-model="reason"
                      outlined
                      :items="item"
                      :item-text="'title'"
                      :item-value="'title'"
                      :rules="[select('reason')]"
                      label="Select Reason For Reporting"
                      clearable
                    ></v-select>
                  </v-col>
                  <v-col cols="12" style="padding:0px">
                    <v-textarea
                      auto-grow
                      rows="3"
                      outlined
                      dense
                      v-model="description"
                      label="Describe the reason"
                      :rules="[
                        required('description'),
                        maxLength('description', 400),
                      ]"
                      counter="400"
                      clearable
                    ></v-textarea>
                  </v-col>
                  <v-col cols="12" class="text-right">
                    <v-btn
                      dark
                      color="indigo"
                      @click="postReport"
                      v-if="!loading"
                    >
                      <v-icon small left>report</v-icon>
                      Report
                    </v-btn>
                    <p v-else>
                      Please Wait A Moment, Notifying The Ad Owner ....
                    </p>
                  </v-col>
                </v-card-text>
              </v-form>
            </v-col>
        </v-card>
      </v-dialog>
    </v-row>
  </div>
</template>

<script>
export default {
  props: ["ads"],
  data() {
    return {
      loading: false,
      product_id: "",
      user_id: "",
      valid: true,
      email: "",
      reason: "",
      description: "",
      dialog: false,
      select(propertyType) {
        return (v) => !!v || `you must select a ${propertyType}`;
      },
      required(propertyType) {
        return (v) => (v && v.length > 0) || `you must input a ${propertyType}`;
      },
      minLength(propertyType, length) {
        return (v) =>
          (v && v.length >= length) ||
          `${propertyType} must be at least ${length} characters`;
      },
      maxLength(propertyType, length) {
        return (v) =>
          (v && v.length <= length) ||
          `${propertyType} must be less than ${length} characters`;
      },
      item: [
        {
          title: "Fake user",
        },
        {
          title: "Fake product",
        },
        {
          title: "Offensive Content",
        },
        {
          title: "Product Already Sold",
        },
        {
          title: "Other",
        },
      ],
    };
  },
  methods: {
    close() {
      this.dialog = false;
      this.$refs.form.reset();
    },
    report() {
      if (!this.loggedIn) {
        EventBus.$emit("changeDialog", true);
        return;
      }
     return this.dialog = true;
    },
    postReport() {
      if (this.$refs.form.validate()) {
        this.loading = true;
        axios
          .post(`/post/ad/report`, {
            product_id: this.ads.id,
            user_id: this.ads.user.id,
            reason: this.reason,
            description: this.description,
          })
          .then((response) => {
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });

            this.$refs.form.reset();
            this.dialog = false;
            this.loading = false;
          })
          .catch((error) => {
            this.$toast.error(error.response.data.message, "Failled", {
              timeout: 3000,
              position: "topRight",
            });
            this.loading = false;
          });
      }
    },
  },
  created() {
    //
  },
};
</script>