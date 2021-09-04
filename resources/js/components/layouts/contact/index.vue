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
                                                    <select class="form-control ">
                                                        <option value="10">10 record</option>
                                                        <option value="20">20 record</option>
                                                        <option value="50">50 record</option>
                                                        <option value="100">100 record</option>
                                                    </select>
                                                </div>
                                                <div class="ml-2">
                                                    <form class="mt-0 mb-0 form-search">
                                                        <input class="form-control" name="keywords" autocomplete="off" placeholder="Enter keywords search...">
                                                        <button class="btn btn-default"><i class="cil-search"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            <router-link :to="{ name: 'FormCategory' }" class="btn btn-primary mt-3 mt-sm-0 ml-0 ml-sm-auto float-right min-w-100 btn-flex"><i class="cil-plus"></i>Register</router-link >
                                            <button class="btn btn-danger mt-3 mt-sm-0 ml-0 ml-sm-auto float-right mr-2 min-w-100 btn-flex"><i class="cil-trash"></i>Delete</button>
                                        </div>
                                    </div>
                                    <form wire:submit.prevent="delete(Object.fromEntries(new FormData($event.target)))">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover table-click-tab">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="90px">
                                                            <div class="custom-control custom-checkbox d-flex justify-content-center">
                                                                <input id="checkedAll" type="checkbox" class="custom-control-input change-status" autocomplete="off">
                                                                <label class="custom-control-label" for="checkedAll"></label>
                                                            </div>
                                                        </th>
                                                        <th class="text-center" width="90px">No</th>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Slug</th>
                                                        <th class="text-center" width="200px">Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-id="63">
                                                        <td class="text-center" colspan="5">Data empty, comming soon ...</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
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
    export default {
        name: "Contact"
    };
</script>
