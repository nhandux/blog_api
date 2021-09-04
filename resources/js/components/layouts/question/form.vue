<template>
    <div class="container-fluid">
        <div class="fade-in">
            <form method="POST" id="botble-question-forms" @submit="submitForm">
                <input name="_token" type="hidden" value="cy8fULHVex5eIIFpM9dXDTZ7J3qewk4oiH1vIgZJ" />
                <div class="row">
                    <div class="col-md-9">
                        <div class="main-form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="control-label required" aria-required="true">Name</label>
                                    <input type="hidden" v-model="form.id" name="id"/>
                                    <input class="form-control" autocomplete="off" name="title" :maxlength="max_length" v-model="form.title" placeholder="Title" type="text" id="name" />
                                    <small class="charcounter">({{form.title ? max_length - form.title.length : max_length}}) character(s) remain)</small>
                                </div>
                                <div class="form-group">
                                    <label for="Parent" class="control-label required" aria-required="true">Slug</label>
                                    <input class="form-control" autocomplete="off" v-model="form.slug" placeholder="Slug" name="slug" type="text" id="slug" />
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
                                    <router-link :to="{ name: 'Question' }" class="btn btn-success btn-icon"><i class="cil-spreadsheet"></i> List Question</router-link>
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
    import { detail, questionCreate, questionUpdate } from '../../../helpers/question';
    import { VueEditor } from "vue2-editor";

    export default {
        name: "FormQuestion",
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
            if(this.$route.params.id) {
                this.getDetailQuestion(this.$route.params.id);
            }
        },
        methods: {
            getDetailQuestion(id) {
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
                let form = document.getElementById('botble-question-forms');
                let formData = new FormData(form);
                event.preventDefault();
                formData.append('content', this.form.content);

                if(this.$route.params.id) {
                    formData.append('_method', 'PUT');
                    questionUpdate(formData, this.$route.params.id)
                        .then(res => {
                            this.$toast.success('Update question successfully!');
                            this.$router.push({name: 'Question'});
                        })
                        .catch(error => {
                            this.$toast.error(error);
                    });
                } else {
                    questionCreate(formData)
                        .then(res => {
                            this.$toast.success('Register question successfully!');
                            this.$router.push({name: 'Question'});
                        })
                        .catch(error => {
                            this.$toast.error(error);
                    });
                }
            }
        },
        computed: {
            loading() {
                return this.$store.getters.IS_LOADING_QUESTION;
            },
            form() {
                return this.$route.params.id ? this.$store.getters.QUESTION : {
                    status: 0
                };
            }
        }
    };
</script>
