<template>
    <div class="container-fluid">
        <div class="fade-in">
            <ul class="nav nav-tabs natv-tabs-150-center">
                <li class="nav-item" @click="changeTab('image')">
                    <a class="nav-link active" data-toggle="tab" href="#image"><i class="cil-satelite"></i> Image</a>
                </li>
                <li class="nav-item" @click="changeTab('video')">
                    <a class="nav-link" data-toggle="tab" href="#video"><i class="cil-video"></i> Video</a>
                </li>
            </ul>
            <CoolLightBox 
                :items="items" 
                :index="index"
                @close="index = null"
            >
            </CoolLightBox>
            <div class="tab-content media-content">
                <div id="image" class="tab-pane active">
                    <div class="row row-item" style="position: relative">
                        <div v-if="loading_list" class="loadding-table">
                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        </div>
                        
                        <div v-for="(item, key) in medias" :key="key" class="col-md-2">
                            <div class="item" :style="`background-image: url(${item.file})`">
                                <div class="image_action_over">
                                    <span @click="deleteFile(item.id)"><i class="cil-trash"></i></span>
                                    <span @click="index=key"><i class="cil-filter-photo"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" v-if="!loading_list">
                            <div class="item">
                                <form class="form-upload-image mb-0" id="upload_image">
                                    <div class="upload-file">
                                        <div v-if="image_show" :style="`background-image:url('${image_show}')`" class="show-image">
                                            <div class="image_action_over_upload">
                                                <span @click="uploadImage">
                                                    <i v-if="loading_upload" class="cil-reload spin-animation"></i>
                                                    <i v-else class="cil-cloud-upload "></i>
                                                </span>
                                                <span @click="clearImage"><i class="cil-x"></i></span>
                                            </div>
                                        </div>
                                        <div v-else>
                                            <i class="cil-plus"></i><br/>
                                            <span>Choose upload file image...</span>
                                        </div>
                                        <input type="hidden" value="image" name="type" />
                                        <input type="file" name="file" ref="fileupload" accept="image/*" @change="onImageChange"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="video" class="tab-pane fade">
                    <div class="row row-item" style="position: relative;">
                        <div v-if="loading_list" class="loadding-table">
                            <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                        </div>
                        <div v-for="(item, key) in medias" :key="key" class="col-md-2">
                            <div class="item">
                                <img src="https://d2uolguxr56s4e.cloudfront.net/img/kartrapages/video_player_placeholder.gif" />
                                <div class="image_action_over">
                                    <span><i class="cil-trash" @click="deleteFile(item.id)"></i></span>
                                    <span @click="index=key"><i class="cil-filter-photo"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2" v-if="!loading_list">
                            <div class="item">
                                <form action="" class="form-group form-add-video mb-0" id="upload_video" @submit="uploadVideoUrl">
                                    <input type="hidden" name="type" value="video" />
                                    <input type="text" ref="url_youtube" name="file" placeholder="Enter youtube url" class="form-control mb-3"/>
                                    <button type="submit" class="btn btn-primary btn-icon">
                                        <i class="cil-save"></i>
                                        Save video
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CoolLightBox from 'vue-cool-lightbox'
    import 'vue-cool-lightbox/dist/vue-cool-lightbox.min.css'
    import { index, mediaDelete, mediaCreate } from '../../../helpers/media';

    export default {
        name: "Media",
        components: {
            CoolLightBox,
        },
        data() {
            return {
                tab: "image",
                image_show: '',
                index: null
            }
        },
        created: function() {
            this.loadMedia();
        },
        methods : {
            setIndex(file) {
                this.index = file;
            },
            loadMedia() {
                index({type: this.tab})
                    .then(res => {
                        this.$store.commit("MEDIA_LIST", res);
                    })
                    .catch(error => {
                        this.$store.commit("LOAD_MEDIA_FAIL");
                        this.$toast.error(error);
                })
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.image_show =  e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearImage () { 
                this.image_show = '';
                this.$refs.fileupload.value="";
            },
            deleteFile(id) {
                this.$store.commit('LOAD_MEDIA');
                mediaDelete(id)
                        .then(res => {
                            this.loadMedia();
                            this.$toast.success('Delete media successfully!');
                        })
                        .catch(error => {
                            this.$toast.error(error);
                })
            },
            uploadImage() {
                this.$store.commit('LOAD_MEDIA_UPLOAD');
                let formData = new FormData(document.getElementById('upload_image'));
                mediaCreate(formData)
                        .then(res => {
                            this.loadMedia();
                            this.image_show = '';
                            this.$toast.success('Register image successfully!');
                        })
                        .catch(error => {
                            this.$store.commit('LOAD_MEDIA_UPLOAD_FAIL');
                            this.$toast.error(error);
                });
            },
            uploadVideoUrl (event) {
                event.preventDefault();
                let formData = new FormData(document.getElementById('upload_video'));
                if(this.validURL(formData.get('file'))) {
                    mediaCreate(formData)
                            .then(res => {
                                this.loadMedia();
                                this.$toast.success('Register video successfully!');
                                this.$refs.url_youtube.value="";
                            })
                            .catch(error => {
                                this.$toast.error(error);
                    });
                } else {
                    this.$toast.error('Please enter youtube url');
                }
            },
            validURL(s) {
                var regexp = /^(ftp|http|https|chrome|:\/\/|\.|@){2,}(localhost|\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}|\S*:\w*@)*([a-zA-Z]|(\d{1,3}|\.){7}){1,}(\w|\.{2,}|\.[a-zA-Z]{2,3}|\/|\?|&|:\d|@|=|\/|\(.*\)|#|-|%)*$/gum
                return regexp.test(s);
            },
            async changeTab (tab) {
                if(tab !== this.tab) {
                    this.$store.commit('LOAD_MEDIA');
                    this.$store.commit('RESET_DATA_MEDIA');
                    await this.$helpers.default.sleep(1000);
                    this.tab = tab;
                    this.loadMedia();
                }
            }
        },
        computed: {
            loading_upload() {
                return this.$store.getters.IS_LOADING_MEDIA_UPLOAD;
            },
            loading_list () {
                return this.$store.getters.IS_LOADING_MEDIA;
            },
            medias () {
                return this.$store.getters.MEDIA_LIST
            },
            items() {
                let list = [];
                this.$store.getters.MEDIA_LIST.map((item) => {
                    list.push(this.tab == 'image' ? 'http://localhost:4000/' + item.file : item.file);
                })

                return list;
            }
        }
    };
</script>
