export default {
    
    props: ['scat'],
    data() {
        return {
            //loading and display
            product: [],
            loading: false,
            valid: true,
            overlay: false,
            nhood_display: false,
            errors: {},
            //fetching city and loacal area
            city: [],
            localArea: [],

            //brand and model
            brand_id: '',
            model_id: '',

            //filter property
            filter_1_id: '',
            filter_2_id: '',
            filter_3_id: '',
            status: '',
            type: '',
            filter_id: '',

            //common property
            price: '',
            maxprice: '',
            title: '',
            description: '',
            category_id: '',
            scategory_id: '',
            url: '',
            district: '',
            street: '',
            nhood: '',

            //non filter static data
            property_1: '',
            property_2: '',
            property_3: '',



            select(propertyType) {
                return v => !!v || `${propertyType} field is mendatory.`
            },

            required(propertyType) {
                return v => v && v.length > 0 || `${propertyType} field is mendatory. `
            },

            priceVlidate(propertyType) {
                return v => v && v > 99 || `${propertyType} must be grater than or equal to 100.`
            },

            minLength(propertyType, length) {
                return v => v && v.length >= length || `${propertyType} must be at least ${length} characters`
            },

            maxLength(propertyType, length) {
                return v => v && v.length <= length || `${propertyType} must be less than ${length} characters`
            }
        }
    },
    methods: {

        getCity() {
            axios.get(`/all/city`)
                .then(response => {
                    this.city = response.data;
                    if (this.nhood != '') {
                        this.getNhood();
                    }
                })
                .catch();
        },

        getNhood() {
            this.loading = true;
            this.nhood_display = false;
            axios.get(`/get/nhood/${this.district}`)
                .then(response => {
                    this.localArea = response.data;
                    this.loading = false;
                    this.nhood_display = true;

                })
                .catch()
        },

        submit() {
            console.log(this.$route.params.id);
            this.overlay = true;
            if (this.$refs.form.validate()) {
                axios.put(`/user/add/product/${this.$route.params.id}`, {

                        'type_id': this.type,
                        'status_id': this.status,
                        'filter_id': this.filter_id,
                        'filter_1_id': this.filter_1_id,
                        'filter_2_id': this.filter_2_id,
                        'filter_3_id': this.filter_3_id,
                        'property_1': this.property_1,
                        'property_2': this.property_2,
                        'property_3': this.property_3,
                        'brand_id': this.brand_id,
                        'url': this.url,
                        'title': this.title,
                        'description': this.description,
                        'price': this.price,
                        'maxprice': this.maxprice,
                        'city_id': this.district,
                        'nhood_id': this.nhood,
                        'address': this.street,

                    })
                    .then(response => {
                        this.overlay = false;
                        this.$router.push({ name: 'myads' });
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });

                    })
                    .catch(error => {
                        this.errors = error.response.data.errors;
                        if (error.response.status === 422) {
                            this.$toast.error('Invalid data please check your form again', 'error', {
                                timeout: 3000,
                                position: 'topRight',
                            });

                            if (error.response.data.errors.image) {
                                this.$toast.error('Image size can`t be grater than 12MB', 'error', {
                                    timeout: 15000,
                                    position: 'topRight',
                                });
                            }
                            
                            this.overlay = false;
                        }
                        if(error.response.status === 403){
                          this.$toast.error(error.response.data.message +' This ad does`t belongs to you', 'error', {
                              timeout: 3000,
                              position: 'topRight',
                          });
                          
                          this.overlay = false;
                          this.$router.push({ name: 'myads' });
                        }

                        this.overlay = false;
                    });
                return;
            }
            this.$toast.error('Invalid data please check your form again', 'error', {
                timeout: 3000,
                position: 'topRight',
            });
            this.overlay = false;
        }
    },
    created() {
        this.getCity();
    },
    
}
