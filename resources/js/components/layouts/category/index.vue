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
                                            <router-link :to="{ name: 'FormCategory' }" class="btn btn-primary mt-3 mt-sm-0 ml-0 ml-sm-auto float-right min-w-100 btn-flex"><i class="cil-plus"></i>Register</router-link >
                                            <button @click="deleteCategory" class="btn btn-danger mt-3 mt-sm-0 ml-0 ml-sm-auto float-right mr-2 min-w-100 btn-flex"><i class="cil-trash"></i>Delete</button>
                                        </div>
                                    </div>
                                    <div class="mb-0">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-click-tab">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="90px">
                                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                                <input id="checkedAll" :disabled="category.data && category.data.length <= 0" @click="selectAllViaCheckBox" v-model="select_all" type="checkbox" class="custom-control-input change-status" autocomplete="off">
                                                                <label class="custom-control-label" for="checkedAll"></label>
                                                            </div>
                                                        </th>
                                                        <th class="text-center" width="90px">No.</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Slug</th>
                                                        <th class="text-center" width="200px">Created At</th>
                                                        <th class="text-center" width="100px">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <div v-if="loading" class="loadding-table">
                                                       <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
                                                    </div>
                                                    <tr v-for="item in category.data" :key="item.id" >
                                                        <td align="center" class="no-click">
                                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                                <input type="checkbox" v-bind:id="`${item.id}_e`" v-model="items" :value="`${item.id}`" class="check custom-control-input change-status">
                                                                <label class="custom-control-label" v-bind:for="`${item.id}_e`"></label>
                                                            </div>
                                                        </td>
                                                        <td align="center">{{item.no}}</td>
                                                        <td align="center">{{item.name}}</td>
                                                        <td align="center">{{item.slug}}</td>
                                                        <td align="center">{{item.created_at}}</td>
                                                        <td align="center">
                                                            <router-link  class="btn btn-primary btn-small" :to="{ name: 'UpdateCategory', params: { id: item.id }}"><i class="cil-pencil"></i></router-link>
                                                        </td>
                                                    </tr>
                                                    <tr v-if="category.data && category.data.length===0"><td class="text-center" colspan="6">Data empty, comming soon....</td></tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <pagination v-if="category.total"
                                            :total-pages="category.last_page"
                                            :total="category.total"
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
    import { index, categoryDelete } from '../../../helpers/category';
    import { PAGE_SIZE } from '../../../constants';

    export default {
        name: "IndexCategory",
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
            this.getListCategory(this.search);
        },
        methods: {
            getListCategory(search){ 
                this.$store.commit("LOAD_CATEGORY");
                index(search)
                    .then(res => {
                        this.$store.commit("CATEGORY_LIST", res);
                    })
                    .catch(error => {
                        this.$store.commit("LOAD_CATEGORY_FAIL");
                        this.$toast.error(error);
                    })
            },
            onPageChange(page) { 
                this.search = {
                    ...this.search,
                    page: page
                };
                this.getListCategory(this.search);
            },
            resetPage() {
                this.search = {
                    ...this.search,
                    page: 1
                }
            },
            mySelectEvent(option){
                this.search = {
                    ...this.search,
                    page: 1,
                    page_size: option.id
                };
                this.getListCategory(this.search);
            },
            searchForm() {
                this.resetPage();
                this.getListCategory(this.search);
            },
            selectAllViaCheckBox() {
                if(this.select_all == false){
                    this.select_all = true
                    this.category.data.forEach(category => {
                      this.items.push(category.id)
                    });
                }else{
                    this.select_all = false
                    this.items = []
                }
            },
            deleteCategory() {
                if(this.items.length <= 0) {
                    this.$toast.error('PLease choose item want to delete!');
                } else {
                    this.$store.commit("LOAD_CATEGORY");
                    categoryDelete(this.items)
                        .then(res => {
                            this.select_all = false;
                            this.items = [];
                            this.getListCategory(this.search);
                            this.$toast.success('Delete category successfully!');
                        })
                        .catch(error => {
                            this.$store.commit("LOAD_CATEGORY_FAIL");
                            this.$toast.error(error);
                        })
                }
            }
        },
        computed: {
            loading() {
                return this.$store.getters.IS_LOADING_CATEGORY;
            },
            category () {
                return this.$store.getters.CATEGORY_LIST
            }
        }
    };
</script>
