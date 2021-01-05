<template>
  <div>
    <v-overlay :value="overlay">
      <v-progress-circular indeterminate size="64"></v-progress-circular>
    </v-overlay>

    <v-form ref="form" v-model="valid" lazy-validation>
      <v-flex class="d-flex">
        <div class="image-wrapper">
          <div class="change-profile" @click="dialog = true">
            <v-icon color="#fff" class="mr-1" small>mdi-camera</v-icon>Change
          </div>
          <v-responsive>
            <v-avatar size="120">
              <img :src="userData.cover" :alt="userData.name" />
            </v-avatar>
          </v-responsive>
        </div>
        <div class="name-wrapper">
          <v-card-subtitle class="pa-0 pb-2 font-weight-bold">
            Name
          </v-card-subtitle>
          <v-text-field
            v-model="name"
            placeholder="Enter your name"
            counter="20"
            :rules="[
              required('name'),
              minLength('name', 5),
              maxLength('name', 20),
            ]"
            outlined
            clearable
          ></v-text-field>
        </div>
      </v-flex>
      <v-card-subtitle
        class="font-weight-bold pa-0 pt-9 pb-2 alignCenter contact-label"
      >
        Contact Number
        <div v-if="userData.phone">
          <v-tooltip bottom>
            <template v-slot:activator="{ on, attrs }">
              <v-icon
                v-bind="attrs"
                :color="userData.phone_verified ? '#00a2f0' : '#b65454'"
                class="ml-2"
                small
                v-on="on"
                >{{ userData.phone_verified ? "mdi-check-decagram" : "error" }}
              </v-icon>
            </template>
            <span>
              {{
                userData.phone_verified
                  ? "Verified Phone Number"
                  : "Phone Number not Verified"
              }}</span
            >
          </v-tooltip>
        </div>
        <v-btn class="edit" small text router to="/user/setting">
          <v-icon class="mr-1" small>
            {{ userData.phone ? "edit" : "add" }}
          </v-icon>
          {{ userData.phone ? "Edit" : "Add" }}
        </v-btn>
      </v-card-subtitle>
      <v-text-field
        @click="addContact"
        type="number"
        placeholder="Contact Number"
        counter="20"
        :value="userData.phone"
        readonly
        outlined
      ></v-text-field>
      <v-card-subtitle class="font-weight-bold pa-0 pt-5 pb-2 alignCenter">
        Email Address
        <v-tooltip bottom>
          <template v-slot:activator="{ on, attrs }">
            <v-icon
              v-bind="attrs"
              :color="userData.email_verified_at ? '#00a2f0' : '#b65454'"
              class="ml-2"
              small
              v-on="on"
              >{{ userData.email_verified_at ? "mdi-check-decagram" : "error" }}
            </v-icon>
          </template>
          <span>
            {{
              userData.email_verified_at
                ? "Verified Email Address"
                : "Email Address not Verified"
            }}</span
          >
        </v-tooltip>
        <v-btn class="edit" small text router to="/user/email/setting">
          <v-icon class="mr-1" small>
            {{ userData.phone ? "edit" : "add" }}
          </v-icon>
          {{ userData.phone ? "Edit" : "Add" }}
        </v-btn>
      </v-card-subtitle>
      <v-text-field
        placeholder="Email"
        counter="30"
        :value="userData.valid_email"
        readonly
        disabled
        outlined
      ></v-text-field>
      <v-card-subtitle class="font-weight-bold pa-0 pt-5 pb-2">
        Address
      </v-card-subtitle>
      <v-row no-gutters>
        <v-col cols="12" md="6" sm="12" class="pr-2">
          <v-autocomplete
            v-model="district"
            :items="city"
            :item-text="'name'"
            :item-value="'id'"
            :rules="[(v) => !!v || 'District is required']"
            placeholder="District"
            clearable
            outlined
            @change="getNhood"
          ></v-autocomplete>
        </v-col>

        <v-col cols="12" md="6" sm="12" class="pl-2">
          <v-autocomplete
            v-model="nhood"
            :items="localArea"
            :item-text="'name'"
            :item-value="'id'"
            :rules="[(v) => !!v || 'Metro/Municipility/VDC is required']"
            placeholder="Metro/Municipility/VDC"
            clearable
            outlined
            :loading="loading"
          >
          </v-autocomplete>
        </v-col>
        <v-col class="text-center">
          <v-btn
            class="ml-auto mr-auto mt-8 update"
            dark
            color="#2f3b59"
            @click="submit"
          >
            Update
          </v-btn>
        </v-col>
      </v-row>
    </v-form>
    <!-- dialog -->
    <v-dialog v-model="dialog" persistent max-width="450">
      <v-card>
        <v-card-title class="modal-title text-right">
          Select Profile Picture
          <v-spacer></v-spacer>
          <v-btn x-small icon @click="dialog = false">
            <v-icon color="#fff">close</v-icon>
          </v-btn>
        </v-card-title>

        <v-form class="px-3" ref="form" v-model="valid" lazy-validation>
          <v-col class="text-center">
            <v-avatar class="border" v-if="url" size="100">
              <img :src="url" :alt="url" />
            </v-avatar>
          </v-col>

          <v-col cols="12">
            <v-file-input
              @change="getImage"
              type="file"
              show-size
              v-model="image"
              prepend-icon="mdi-camera"
              accept="image/png, image/jpeg, image/bmp"
              label="Select Profile Picture"
              :rules="[select('image')]"
            ></v-file-input>
          </v-col>
        </v-form>
        <v-spacer></v-spacer>
        <v-col cols="12" class="text-center">
          <v-btn color="#19916B" class="upload" dark tile @click="save">
            update
          </v-btn>
        </v-col>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
export default {
  props: ["userData"],
  data() {
    return {
      loading: false,
      valid: true,
      url: "",
      dialog: false,
      valid: true,
      image: [],
      show: true,
      profile: {},
      overlay: false,
      select(propertyType) {
        return (value) =>
          !value ||
          value.size < 5000000 ||
          `${propertyType} size should be less than 2 MB!`;
      },

      district: this.loginUser.city_id,
      name: this.loginUser.name,
      email: this.loginUser.valid_email,
      contact: this.loginUser.phone,
      about: this.loginUser.about,
      nhood: this.loginUser.nhood_id,
      city: [],
      localArea: [],
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
    };
  },
  methods: {
    getImage(e) {
      let file = e;
      this.url = URL.createObjectURL(file);
    },
    save() {
      if (this.$refs.form.validate()) {
        this.overlay = true;
        const formData = new FormData();
        let config = {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        };
        formData.append("_method", "put");
        formData.append("image", this.image);
        axios
          .post(`/update/cover`, formData, config)
          .then((response) => {
            this.overlay = false;
            this.dialog = false;
            this.form.reset();
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });
            this.freshUser();

          })
          .catch((error) => {
            if (error.response.status === 422) {
              this.overlay = false;
              if (error.response.data.errors.image.length > 0) {
                this.$toast.error(
                  error.response.data.errors.image[0],
                  "error",
                  {
                    timeout: 3000,
                    position: "topRight",
                  }
                );
                return;
              }
            }
            this.overlay = false;
          });
      }
      this.overlay = false;
    },
    addContact() {
      EventBus.$emit("profileForm", true);
    },
    submit() {
      if (this.$refs.form.validate()) {
        this.overlay = true;
        axios
          .put(`/update/profile`, {
            name: this.name,
            nhood: this.nhood,
            district: this.district,
          })
          .then((response) => {
            this.overlay = false;
            this.$toast.success(response.data, "success", {
              timeout: 3000,
              position: "topRight",
            });
            EventBus.$emit("updateUser", true);

            EventBus.$emit("loadUser");
          })
          .catch((error) => {
            if (error.response.status == 422) {
              this.overlay = false;
              this.$toast.error(error.response.data.errors.email[0], "error", {
                timeout: 3000,
                position: "topRight",
              });
            }
          });
      }
    },

    getCity() {
      axios
        .get(`/all/city`)
        .then((response) => {
          this.city = response.data;

          this.getNhood();
        })
        .catch();
    },
    freshUser(){
      EventBus.$emit("profileChanged", true);
    },

    getNhood() {
      this.loading = true;
      axios
        .get(`/get/nhood/${this.district}`)
        .then((response) => {
          this.localArea = response.data;
          this.loading = false;
        })
        .catch();
    },
  },
  created() {
    return this.getCity();
  },
};
</script>
<style scoped>
.container {
  margin-top: -50px;
}
.image-wrapper {
  position: relative;
  margin-right: 40px;
}
.change-profile {
  position: absolute;
  height: 120px;
  width: 120px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  z-index: 1;
  color: #fff;
  background: #2f3b594f;
  align-items: center;
  justify-content: center;
}
.name-wrapper {
  flex: 1;
}
.edit {
  color: #19916b;
  text-transform: none;
  font-size: 0.875rem;
  font-weight: bold;
}
.update {
  min-width: 200px !important;
  min-height: 40px !important;
}
.modal-title {
  background: #2f3b59;
  color: #fff;
  font-size: 17px !important;
}
.upload {
  margin-bottom: 14px;
  min-width: 180px !important;
  min-height: 40px;
  border-radius: 4px;
}
@media screen and (max-width: 959px) {
  .pl-2 {
    padding-left: 0px !important;
  }
  .pr-2 {
    padding-right: 0px !important;
  }
}
@media screen and (max-width: 768px) {
  .d-flex {
    flex-direction: column;
    align-items: center;
  }
  .name-wrapper {
    width: 100%;
    margin-top: 12px;
  }
  .contact-label {
    padding-top: 18px !important;
  }
}
</style>
