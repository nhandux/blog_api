<template>
    <div class="container-fluid">
        <div class="fade-in">
            <form method="POST" id="botble-setting-forms">
                <input name="_token" type="hidden" value="cy8fULHVex5eIIFpM9dXDTZ7J3qewk4oiH1vIgZJ" />
                <div class="row">
                    <div class="col-md-9">
                        <div class="main-form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label for="name" class="control-label required" aria-required="true">Name</label>
                                    <input class="form-control" autocomplete="off" placeholder="Name" name="name" type="text" id="name" />
                                </div>
                                <div class="form-group">
                                    <label for="Parent" class="control-label required" aria-required="true">Slug</label>
                                    <input class="form-control" autocomplete="off" placeholder="Name" name="name" type="text" id="name" />
                                </div>
                                <div class="form-group">
                                    <label for="Parent" class="control-label required" aria-required="true">Parent</label>
                                    <input class="form-control" autocomplete="off" placeholder="Name" name="name" type="text" id="name" />
                                </div>
                                <div class="form-group">
                                    <label for="description" class="control-label">Description</label>
                                    <textarea class="form-control" rows="4" placeholder="Short description" name="description" cols="50" id="description"></textarea>
                                </div>
                                <div class="form-group mb-1">
                                    <div class="btn-set">
                                        <button type="submit" class="btn btn-primary btn-icon"><i class="cil-save"></i> Save</button>
                                        &nbsp;
                                        <router-link :to="{ name: 'Category' }" class="btn btn-success btn-icon"><i class="cil-spreadsheet"></i> Reset setting</router-link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Setting"
    };
</script>
