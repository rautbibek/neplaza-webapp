<template>
    <div>
    <nav aria-label="breadcrumb ">
            <ol class="breadcrumb ">
                <li class="breadcrumb-item pull-right"><router-link :to="`/`">Home</router-link></li>
                <li class="breadcrumb-item pull-right"><router-link :to="`/user/myAds`">My Ads</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">Edit & Delete Ad Image</li>
            </ol>
        </nav>
    <div class="pb-3">
            <div class="text-center p-4 ">
                <h4 class="font-weight-bold text-uppercase">{{existing_images.ad_title}}</h4>
            </div>
            <v-overlay :value="overlay">
                <v-progress-circular indeterminate size="64"></v-progress-circular>
            </v-overlay>
           <v-row justify="center" no-gutters>
               
               <v-col cols="12" lg="10" md="10" sm="12" xs="12" class="custom-border">
                    <v-card tile>
                         <div class="m-2">
                             <v-card-title class="font-weight-bold">
                                Old Images
                             </v-card-title>
                             <v-card-subtitle>
                                click to delete the old image
                            </v-card-subtitle>
                                <v-col v-if="!existing_images.product_image">
                                    <div class="text-center p-2 ">
                                        <h4 class="font-weight-bold text-uppercase text-danger" >Empty Old Images</h4>
                                    </div>
                                </v-col>
                                <v-col cols="12" lg="9" md="10" sm="12" xs="12" v-else >
                                    <v-card>
                                        <v-container fluid>
                                        <v-row>
                                            <v-col
                                            v-for="(productImg,index) in existing_images.product_image" 
                                            :key="index"
                                            class="d-flex child-flex"
                                            cols="4"
                                            sm="3" md="3" xs="6" lg="3"
                                            >
                                            
                                                <v-card flat tile class="d-flex border">
                                                    <v-hover >
                                                    <v-img
                                                    :src="'/storage/thumb/'+productImg.image"
                                                    :lazy-src="'/storage/thumb/'+productImg.image"
                                                    aspect-ratio="1"
                                                    class="grey lighten-2"
                                                    >
                                                    <template v-slot:placeholder>
                                                        <v-row
                                                        class="fill-height ma-0"
                                                        align="center"
                                                        justify="center"
                                                        >
                                                        <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                                        </v-row>
                                                    </template>
                                                    <v-fade-transition>
                                                        <v-overlay
                                                            overlay="hover"
                                                            absolute
                                                            
                                                        >
                                                            <v-btn class="" @click="confirm(productImg.id)" fab dark x-small color="red">
                                                                <v-icon dark>delete</v-icon>
                                                            </v-btn>
                                                        </v-overlay>
                                                    </v-fade-transition>
                                                    </v-img>
                                                    </v-hover>
                                                    </v-card>
                                            </v-col>
                                            
                                        
                                        </v-row>
                                        </v-container>
                                    </v-card>
                                </v-col> 
                                
                          </div>
                          <div style="border-top:0.5px solid black"></div>
                          <div class="m-2">
                              <v-card-title class="font-weight-bold">
                                    SELECT OR DRAG AD IMAGE
                                </v-card-title>
                                  <v-col cols="12" sm="12" md="8" xs="12" class="p-4">
                                    <div class="form-group">
                                        <div class="uploader"
                                            @dragenter="OnDragEnter"
                                            @dragleave="OnDragLeave"
                                            @dragover.prevent
                                            @drop="onDrop"
                                            :class="{ dragging: isDragging }">

                                            <div class="upload-control" v-show="image.length">
                                                <label for="file">Select a file</label>
                                            </div>


                                            <div v-show="!image.length">
                                                <i class="fa fa-cloud-upload"></i>
                                                <p>Drag your image here</p>
                                                <div>OR</div>
                                                <div class="file-input">
                                                    <label for="file">Select a file</label>
                                                    <input type="file" id="file" @change="onInputChange" multiple>
                                                </div>
                                            </div>

                                            <div class="image-preview" v-show="image.length">
                                                <div class="img-wrapper" v-for="(image, index) in image" :key="index">
                                                    <img :src="image" :alt="`Image Uplaoder ${index}`">
                                                    <div class="details">
                                                        <span class="name" v-text="files[index].name"></span>
                                                        <span class="size" v-text="getFileSize(files[index].size)"></span>
                                                        <a class="hover" href="javascript:void(0)" @click="removeimage(index)" style="color:red" >remove</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="errors.image" class="invalid-feedback">
                                        {{errors.image}}
                                        </div>
                                    </div>
                                </v-col>
                                
                          </div>
                          <div style="border-top:0.5px solid black">
                                    <v-col cols="8 py-4 ml-4">
                                    <v-btn tile large color="primary"  @click="submit">
                                        <v-icon left>save</v-icon>
                                        save images
                                        </v-btn>
                                </v-col>
                            </div>
                        
                    </v-card>
               </v-col>
            </v-row>
        <!-- dialogue for conformation -->

          <v-row justify="center">
            <v-dialog v-model="dialog" persistent max-width="290">
            <v-card>
                <v-card-title
                    class="grey lighten-2"
                    primary-title
                    >
                    Confirm
                </v-card-title>
                <v-card-text class="mt-3">Are you suer to want to delete this image ?</v-card-text>
                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="green darken-1" text @click="dialog = false">Cancel</v-btn>
                <v-btn color="green darken-1" text @click="remove">Delete</v-btn>
                </v-card-actions>
            </v-card>
            </v-dialog>
        </v-row>
    </div>

    </div>
</template>
<script>
    export default {
    data() {
        return {
            dialog:false,
            hover:false,
            overlay: false,
            errors: [],
            isDragging: false,
            dragCount: 0,
            files: [],
            image: [],
            image_id:'',
            product_id:this.$route.params.id,
            existing_images:[],
        }
    },
    methods: {
        
        confirm(id){
            this.dialog = true;
            this.image_id = id; 
        },
        remove(){
            this.dialog= false;
            this.overlay = true;
            axios.delete(`/delete/image/${this.image_id}`)
                 .then(response =>{
                     this.getImage()
                     this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        this.overlay = false;
                 })
                 .catch(error=>{
                     this.overlay= false;
                     console.log(error.response);
                     this.$toast.error(error.response.data.message, 'unauthorized action', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                        
                 });
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
        getImage(){
            axios.get(`/user/add/product/${this.$route.params.id}`)
                 .then(response =>{
                     this.existing_images = response.data;
                 })
                 .catch(error=>{
                     if(error.response.status === 403){
                         this.$router.push('/');
                     }
                 });
        },
        submit() {
                this.overlay= true;
                const formData = new FormData();
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                };
                formData.append('product_id', this.product_id);
                this.files.forEach(file => {
                    formData.append('image[]', file, file.name);
                });
                axios.post(`/save/image/${this.product_id}`, formData, config)
                    .then(response => {
                        this.getImage();
                        console.log(response.data);
                        this.$router.push('/user/myads');
                        this.$toast.success(response.data, 'success', {
                            timeout: 3000,
                            position: 'topRight',
                        });
                     this.overlay = false;
                    })
                    .catch(error => {
                        this.overlay = false;
                        
                         console.log(error.response.status)
                         
                        if (error.response.status === 422) {

                            this.$toast.error(error.response.data.message, 'error', {
                                timeout: 6000,
                                position: 'topRight',
                            });
                            this.overlay = false;
                        }

                        this.overlay = false;
                    });
                return;
            this.overlay = false;
        }
    },
    created() {
        this.getImage()
    }
}
</script>