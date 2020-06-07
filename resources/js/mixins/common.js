export default {
    data() {
        return {
            city: [],
            localArea: [],
            district: null,
            slug: '',
            isDragging: false,
            dragCount: 0,
            files: [],
            image: [],
            errors: {},
            price: '',
            street: '',
            nhood: null,
            description: '',
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
                    console.log(response.data);
                    this.getNhood();
                })
                .catch();
        },

        getNhood() {
            this.loading = true;
            axios.get(`/get/nhood/${this.district}`)
                .then(response => {
                    this.localArea = response.data;
                    this.loading = false;

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
    },
    mounted() {
        return this.getCity();
    }
}