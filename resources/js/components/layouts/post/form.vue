<template>
    <div class="container-fluid">
        <div class="fade-in">
            <form method="POST" id="botble-blog-forms-post-form" @submit="submitForm">
                <input name="_token" type="hidden" value="cy8fULHVex5eIIFpM9dXDTZ7J3qewk4oiH1vIgZJ" />
                <div class="row">
                    <div class="col-md-9">
                        <div class="main-form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="control-label required" aria-required="true">Name</label>
                                    <input type="hidden" v-model="form.id" name="id"/>
                                    <input class="form-control" autocomplete="off" name="name" :maxlength="max_length" v-model="form.name" placeholder="Name" type="text" id="name" />
                                    <small class="charcounter">({{form.name ? max_length - form.name.length : max_length}}) character(s) remain)</small>
                                </div>
                                <div class="form-group">
                                    <label for="Parent" class="control-label required" aria-required="true">Slug</label>
                                    <input class="form-control" autocomplete="off" v-model="form.slug" placeholder="Slug" name="slug" type="text" id="slug" />
                                </div>
                                <div class="form-group">
                                    <label for="Parent" class="control-label required" aria-required="true">Category</label>
                                    <Select2 name="category_id" v-model="form.category_id" :options="category" :settings="{ placeholder: 'Category' }"/>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea class="form-control" autocomplete="off" v-model="form.description" name="description" rows="4" id="description" placeholder="Description" cols="50"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label">Content</label>
                                    <vue-editor v-model="form.content"></vue-editor>
                                </div>
                            </div>
                        </div>
                        <div id="advanced-sortables" class="meta-box-sortables">
                            <div id="seo_wrap" class="widget meta-boxes">
                                <div class="widget-title">
                                    <h4><span>Search Engine Optimize</span></h4>
                                </div>
                                <div class="widget-body">
                                    <div class="seo-edit-section hidden">
                                        <div class="form-group">
                                            <label for="seo_title" class="control-label">SEO Title</label>
                                            <input class="form-control" autocomplete="off" v-model="form.seo_title" id="seo_title" placeholder="SEO Title" name="seo_title" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label for="seo_description" class="control-label">SEO description</label>
                                            <textarea class="form-control" autocomplete="off" v-model="form.seo_description" name="seo_description" rows="4" id="seo_description" placeholder="SEO description" cols="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 right-sidebar">
                        <div class="widget meta-boxes">
                            <div class="widget-title">
                                <h4><label for="image" class="control-label">Image</label></h4>
                            </div>
                            <div class="widget-body">
                                <div class="image-box">
                                    <div class="preview-image-wrapper">
                                        <img v-if="image_show && form.image_show != ''" :src="image_show" alt="Preview image" width="150" class="preview_image" />
                                        <span v-else>
                                            <img v-if="!form.image" src="https://kalles.botble.com/vendor/core/core/base/images/placeholder.png" alt="Preview image" width="150" class="preview_image" />
                                            <img v-else :src="form.image" alt="Preview image" width="150" class="preview_image" />
                                        </span>
                                        <a title="Remove image" class="btn_remove_image"><i class="fa fa-times"></i></a>
                                    </div>
                                    <div class="image-box-actions">
                                        <a href="#" data-result="image" data-action="select-image" class="btn_gallery">
                                            <input type="file" name="image" accept="image/*" @change="onImageChange"/>
                                            Choose image
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget meta-boxes">
                            <div class="widget-title">
                                <h4><label for="tag" class="control-label">Tags</label></h4>
                            </div>
                            <div class="widget-body">
                                <input type="text" v-model="form.tags" name="tags" class="form-control" autocomplete="off"/>
                            </div>
                        </div>
                         <div class="widget meta-boxes form-actions form-actions-default action-horizontal">
                            <div class="widget-title">
                                <h4>
                                    <span>Publish</span>
                                </h4>
                            </div>
                            <div class="widget-body">
                                <div class="form-group">
                                    <label for="status_on" class="mr-4"><input v-model="form.status" type="radio" name="status" value="1" id="status_on" /> Show</label> 
                                    <label for="status_of"><input type="radio" v-model="form.status" name="status" value="0" id="status_of" /> Hidden</label>
                                </div>
                                <div class="btn-set">
                                    <button type="submit" class="btn btn-primary btn-icon"><i class="cil-save"></i> Save</button>
                                    &nbsp;
                                    <router-link :to="{ name: 'Post' }" class="btn btn-success btn-icon"><i class="cil-spreadsheet"></i> List Post</router-link>
                                </div>
                            </div>
                        </div>
                        <div id="waypoint">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import { detail, postCreate, postUpdate } from '../../../helpers/post';
    import { index as indexCategory } from '../../../helpers/category';
    import { VueEditor } from "vue2-editor";

    export default {
        name: "FormPost",
        components: {
            VueEditor
        },
        data () {   
            return {
                searh: {},
                image_show: '',
                max_length: 120,
            }
        },
        created: function() {
            this.getListCategory(this.search);
            
            if(this.$route.params.id) {
                this.getDetailPost(this.$route.params.id);
            }
        },
        methods: {
            getListCategory(search) { 
                indexCategory(search)
                    .then(res => {
                        this.$store.commit("CATEGORY_LIST", res);
                    })
                    .catch(error => {
                        this.$toast.error(error);
                    })
            },
            getDetailPost(id) {
                detail(id)
                    .then(res => {
                        this.$store.commit("POST_DETAIL", res);
                    })
                    .catch(error => {
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
                    this.image_show =  e.target.result
                };
                reader.readAsDataURL(file);
            },
            submitForm(event) {
                let form = document.getElementById('botble-blog-forms-post-form');
                let formData = new FormData(form);
                event.preventDefault(); 
                console.log(this.form.content);
                formData.append('content', this.form.content);

                if(this.$route.params.id) {
                    formData.append('_method', 'PUT');
                    postUpdate(formData, this.$route.params.id)
                        .then(res => {
                            this.$toast.success('Update post successfully!');
                            this.$router.push({name: 'Post'});
                        })
                        .catch(error => {
                            this.$toast.error(error);
                    });
                } else {
                    postCreate(formData)
                        .then(res => {
                            this.$toast.success('Register post successfully!');
                            this.$router.push({name: 'Post'});
                        })
                        .catch(error => {
                            this.$toast.error(error);
                    });
                }
            }
        },
        computed: {
            loading() {
                return this.$store.getters.IS_LOADING_POST;
            },
            form() {
                return this.$route.params.id ? this.$store.getters.POST : {
                    status: 0
                };
            },
            category () {
                const list = [{id: '', text: 'Choose Category'}]; 
                if(this.$store.getters.CATEGORY_LIST.length > 0) {
                    this.$store.getters.CATEGORY_LIST.map((item, key) => {
                        let childrent = [];
                        if(Number(item.parents.length) > 0) {
                            item.parents.map((parent) => {
                                childrent.push({
                                    id: parent.id,
                                    text: parent.name
                                });
                            });
                        }
                        
                        list.push({
                            text: item.name,
                            children: childrent
                        });
                    })
                } 
                return list;
            }
        }
    };
</script>
