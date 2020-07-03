export default {
    props: ['scat'],
    data() {
        return {

            //loading and display
            loading: false,
            valid: true,
            overlay: false,
            nhood_display: false,

            hasContact: '',
            errors: {},
            //image propeerty
            isDragging: false,
            dragCount: 0,
            files: [],
            image: [],

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
                return v => !!v || `you must select a ${propertyType}`
            },
            required(propertyType) {
                return v => v && v.length > 0 || `you must input a ${propertyType}`
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
        OnDragEnter(e) {
            e.preventDefault();

            this.dragCount++;
            this.isDragging = true;
            return false;
        },
        OnDragLeave(e) {
            e.preventDefault();
            this.dragCount--;
            if (this.dragCount <= 0)
                this.isDragging = false;
        },
        onInputChange(e) {
            const files = e.target.files;
            Array.from(files).forEach(file => this.addImage(file));
        },
        onDrop(e) {
            e.preventDefault();
            e.stopPropagation();
            this.isDragging = false;
            const files = e.dataTransfer.files;
            Array.from(files).forEach(file => this.addImage(file));
        },
        addImage(file) {
            if (!file.type.match('image.*')) {
                this.$toastr.e(`${file.name} is not an image`);
                return;
            }
            this.files.push(file);
            const img = new Image(),
                reader = new FileReader();
            reader.onload = (e) => this.image.push(e.target.result);
            reader.readAsDataURL(file);
        },
        getFileSize(size) {
            const fSExt = ['Bytes', 'KB', 'MB', 'GB'];
            let i = 0;
            while (size > 900) {
                size /= 1024;
                i++;
            }
            return `${(Math.round(size * 100) / 100)} ${fSExt[i]}`;
        },
        removeimage(index) {
            this.image.splice(index, 1);
            this.files.splice(index, 1);
        },


        submit() {

            this.category_id = this.scat.category.id;
            this.scategory_id = this.scat.id;
            this.url = this.scat.url;
            this.overlay = true;
            if (this.$refs.form.validate()) {
                if (!this.hasContact) {

                    EventBus.$emit('profileForm', true);
                    this.overlay = false;
                    return;
                }
                const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };

                //category subcategory data
                formData.append('category_id', this.category_id);
                formData.append('scategory_id', this.scategory_id);
                formData.append('url', this.url);

                //static data
                formData.append('property_1', this.property_1);
                formData.append('property_2', this.property_2);
                formData.append('property_3', this.property_3);
                formData.append('maxprice', this.maxprice);

                //dynamic filter data
                formData.append('type_id', this.type);
                formData.append('status_id', this.status);
                formData.append('brand_id', this.brand_id);
                formData.append('model_id', this.model_id);
                formData.append('filter_id', this.filter_id);
                formData.append('filter_1_id', this.filter_1_id);
                formData.append('filter_2_id', this.filter_2_id);
                formData.append('filter_3_id', this.filter_3_id);

                //common form data
                formData.append('title', this.title);
                formData.append('description', this.description);
                formData.append('city_id', this.district);
                formData.append('nhood_id', this.nhood);
                formData.append('price', this.price);
                formData.append('address', this.street);
                formData.append('join', this.url);
                this.files.forEach(file => {
                    formData.append('image[]', file, file.name);
                });
                axios.post(`/user/add/product`, formData, config)
                    .then(response => {
                        this.overlay = false;
                        this.$router.push('/user/myads');
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });

                    })
                    .catch(error => {

                        if (error.response.status === 422) {
                            this.$toast.error('Invalid data please check your form again', 'error', {
                                timeout: 3000,
                                position: 'topRight',
                            });

                            if (this.errors.image) {
                                this.$toast.error('Image size can`t be grater than 12MB', 'error', {
                                    timeout: 3000,
                                    position: 'topRight',
                                });

                            }
                            this.overlay = false;
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
        EventBus.$on('contactUpdated', (data) => {
            this.hasContact = data;
            this.submit();
        })
        this.getCity();
        this.hasContact = this.loginUser.phone;
    }
}