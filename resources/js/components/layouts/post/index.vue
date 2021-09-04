<template>
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-option d-flex justify-content-between align-items-center pb-2">
                                        <div class="navbar-tab-search d-flex align-items-start justify-content-between">
                                            <div class="wrap-select d-flex align-items-center">
                                                <div class="form-group mb-0">
                                                    <Select2 v-model="search.page_size" :options="options" :settings="{ minimumResultsForSearch: Infinity }" @select="mySelectEvent($event)" />
                                                </div>
                                                <div class="ml-2">
                                                    <form class="mt-0 mb-0 form-search">
                                                        <input class="form-control" v-model="search.keywords" autocomplete="off" placeholder="Enter keywords search...">
                                                        <button class="btn btn-default" @click="searchForm" type="button"><i class="cil-search"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <router-link :to="{ name: 'FormPost' }" class="btn btn-primary mt-3 mt-sm-0 ml-0 ml-sm-auto float-right min-w-100 btn-flex"><i class="cil-plus"></i>Register</router-link >
                                            <button @click="deletePost" class="btn btn-danger mt-3 mt-sm-0 ml-0 ml-sm-auto float-right mr-2 min-w-100 btn-flex"><i class="cil-trash"></i>Delete</button>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-click-tab">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="90px">
                                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                                <input id="checkedAll" :disabled="post.data && post.data.length <= 0" @click="selectAllViaCheckBox" v-model="select_all" type="checkbox" class="custom-control-input change-status" autocomplete="off">
                                                                <label class="custom-control-label" for="checkedAll"></label>
                                                            </div>
                                                        </th>
                                                        <th class="text-center" width="90px">No</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Slug</th>
                                                        <th class="text-center">Category</th>
                                                        <th class="text-center" width="200px">Created At</th>
                                                        <th class="text-center" width="100px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <div v-if="loading" class="loadding-table">
                                                       <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                    </div>
                                                    <tr v-for="item in post.data" :key="item.id" >
                                                        <td align="center" class="no-click">
                                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                                <input type="checkbox" v-bind:id="`${item.id}_e`" v-model="items" :value="`${item.id}`" class="check custom-control-input change-status">
                                                                <label class="custom-control-label" v-bind:for="`${item.id}_e`"></label>
                                                            </div>
                                                        </td>
                                                        <td align="center">{{item.no}}</td>
                                                        <td align="center">{{item.name}}</td>
                                                        <td align="center">{{item.slug}}</td>
                                                        <td align="center">{{item.category.name}}</td>
                                                        <td align="center">{{item.created_at}}</td>
                                                        <td align="center">
                                                            <router-link  class="btn btn-primary btn-small" :to="{ name: 'UpdatePost', params: { id: item.id }}"><i class="cil-pencil"></i></router-link>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="post.data && post.data.length===0"><td class="text-center" colspan="7">Data empty, comming soon....</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <pagination v-if="post.total"
                                            :total-pages="post.last_page"
                                            :total="post.total"
                                            :per-page="search.page_size"
                                            :current-page="search.page"
                                            @pagechanged="onPageChange"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { index, postDelete } from '../../../helpers/post';
    import { PAGE_SIZE } from '../../../constants';

    export default {
        name: "IndexPost",
        data () {
            return {
                search: {
                    page: 1,
                    page_size: 10
                },
                options: PAGE_SIZE,
                select_all: false,
                items: []
            };
        },
        created: function(){
            this.getLists(this.search);
        },
        methods: {
            getLists(search){ 
                this.$store.commit("LOAD_POST");
                index(search)
                    .then(res => {
                        this.$store.commit("POST_LIST", res);
                    })
                    .catch(error => {
                        this.$store.commit("LOAD_POST_FAIL");
                        this.$toast.error(error);
                    })
            },
            onPageChange(page) { 
                this.search = {
                    ...this.search,
                    page: page
                };
                this.getLists(this.search);
            },
            resetPage() {
                this.search = {
                    ...this.search,
                    page: 1
                };
                this.select_all = false;
                this.items = [];
            },
            mySelectEvent(option){
                this.search = {
                    ...this.search,
                    page: 1,
                    page_size: option.id
                };
                this.getLists(this.search);
            },
            searchForm() {
                this.resetPage();
                this.getLists(this.search);
            },
            selectAllViaCheckBox() {
                if(this.select_all == false){
                    this.select_all = true
                    this.post.data.forEach(post => {
                      this.items.push(post.id)
                    });
                }else{
                    this.resetPage();
                }
            },
            deletePost() {
                if(this.items.length <= 0) {
                    this.$toast.error('PLease choose item want to delete!');
                } else {
                    this.$store.commit("LOAD_POST");
                    postDelete(this.items)
                        .then(res => {
                            this.resetPage();
                            this.getLists(this.search);
                            this.$toast.success('Delete post successfully!');
                        })
                        .catch(error => {
                            this.$store.commit("LOAD_POST_FAIL");
                            this.$toast.error(error);
                        })
                }
            }
        },
        computed: {
            loading() {
                return this.$store.getters.IS_LOADING_POST;
            },
            post () {
                return this.$store.getters.POST_LIST
            }
        }
    };
</script>
