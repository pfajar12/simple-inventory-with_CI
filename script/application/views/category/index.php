    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="table-responsive">
                    <!-- TABS -->
                    <div class="mb-5">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Category</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Non-active Category</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">
                        <!-- TAB 1 -->
                        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
                            <div class="mb-3">
                                <button class="btn btn-info" onclick="openModal()">
                                    <i class="fa fa-plus"></i> Add new data
                                </button>
                            </div>

                            <div id="notice-line" class="my-2">
                                <?php 
                                    if($this->session->flashdata('msg')!=''){
                                ?>
                                    <div class="alert alert-success mt-3" role="alert">
                                        <?php echo $this->session->flashdata('msg');?>
                                    </div>
                                <?php
                                    }
                                ?>
                            </div>

                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-item-get">
                                <?php
                                if($data_count<1){
                                ?>
                                    <tr>
                                        <td colspan="2">No records</td>
                                    </tr>
                                <?php
                                }
                                else{
                                foreach ($data_list as $data):
                                ?>
                                    <tr>
                                        <td><?= $data->name; ?></td>
                                        <td>
                                            <a href="<?= base_url('category/edit/'.$data->id);?>">
                                                <button class="btn btn-warning text-white btn-sm">Edit</button>
                                            </a>
                                            <button class="btn btn-danger btn-sm" onclick="deleteData(<?=$data->id?>)">Delete</button>
                                        </td>
                                    </tr>

                                <?php
                                endforeach;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- TAB 2 -->
                        <div class="tab-pane fade" id="panel2" role="tabpanel">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-item-get-nonactive">
                                <?php
                                if($data_count_nonactive<1){
                                ?>
                                    <tr>
                                        <td colspan="2">No records</td>
                                    </tr>
                                <?php
                                }
                                else{
                                foreach ($data_list_nonactive as $data):
                                ?>
                                    <tr>
                                        <td><?= $data->name; ?></td>
                                        <td>
                                            <button onclick="restoredata(<?= $data->id ?>)" class="btn btn-secondary btn-sm">Restore</button>
                                        </td>
                                    </tr>

                                <?php
                                endforeach;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- MODAL -->
        <div class="modal fade" id="addNewDataModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Category Name</label>
                            <input type="text" name="categoryname" id="categoryname" class="form-control">
                            <span class="text-danger font-weight-bold d-none" id="categoryname-error">
                                *category name must not empty
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="checkInput()" id="btnAddCategory" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </body>

    <script type="text/javascript">

        function openModal() {
            $('#addNewDataModal').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

        function checkInput() {
            var categoryname = $('#categoryname').val();

            if(categoryname==''){
                $('#categoryname-error').removeClass('d-none');
                $('#categoryname-error').addClass('d-block');
            }
            else{
                $('#categoryname-error').removeClass('d-block');
                $('#categoryname-error').addClass('d-none');

                saveNewData(categoryname);
            }
        }

        function saveNewData(categoryname) {
            $.ajax({
                url: '<?= base_url('category/check_exist') ?>',
                type: 'POST',
                async: true,
                data: {categoryname: categoryname},
                beforeSend: function(){
                    $('#btnAddCategory').attr('disabled', 'disabled');
                    $('#btnAddCategory').text('Please wait...');
                },
                success: function(param){
                    if(param=='exist'){
                        $('#notice-line').html('\
                            <div class="alert alert-danger mt-3" role="alert">\
                                Category name exist\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                        $('#categoryname').val('');
                    }
                    else{
                        createNewData(categoryname)
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });

            $('#btnAddCategory').removeAttr('disabled');
            $('#btnAddCategory').text('Save');
        }

        function createNewData(categoryname) {
            $.ajax({
                url: '<?= base_url('category/create') ?>',
                type: 'POST',
                async: true,
                data: {categoryname: categoryname},
                beforeSend: function(){
                },
                success: function(param){
                    if(param=='success'){
                        $('#notice-line').html('\
                            <div class="alert alert-success mt-3" role="alert">\
                                Add new category success\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                        $('#categoryname').val('');
                        loadData();
                    }
                    else{
                        $('#notice-line').html('\
                            <div class="alert alert-danger mt-3" role="alert">\
                                Add new category fail\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                        $('#categoryname').val('');
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function loadData() {
            $('#tbody-item-get').empty();
            $('#tbody-item-get-nonactive').empty();

            reloadActiveData();
            reloadNonActiveData();
        }

        function deleteData(id) {
            swal({
                title: "Are you sure?",
                text: "This data will be deleted",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '<?= base_url('category/delete') ?>',
                        type: 'POST',
                        data: {id: id},
                        async: true,
                        beforeSend: function(){
                            swal({
                                title: "Please Wait",
                                text: "Processing data...",
                                icon: "warning",
                                buttons: false,
                                closeOnClickOutside: false,
                                closeOnEsc: false,
                            });
                        },
                        success: function(param){
                            if(param=="success"){
                                swal({
                                   title: "Success",
                                   text: "Data successfully deleted",
                                   icon: "success"
                                })
                                .then(() => {
                                    loadData()
                                });
                            }
                        },
                        error: function() {
                            swal.close();
                        }
                    });
                }
            });
        }

        function restoredata(id) {
            $.ajax({
                url: '<?= base_url('category/restore') ?>',
                type: 'POST',
                async: true,
                data : {id: id},
                beforeSend: function(){
                },
                success: function(param){
                    if(param=="success"){
                        swal({
                           title: "Success",
                           text: "Data successfully restored",
                           icon: "success"
                        })
                        .then(() => {
                            loadData()
                        });
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function reloadActiveData() {
            $.ajax({
                url: '<?= base_url('category/get_data') ?>',
                type: 'GET',
                async: true,
                dataType : 'json',
                beforeSend: function(){
                },
                success: function(param){
                    var data = param.items;
                    
                    if(data.length<1){
                        $('#tbody-item-get').append('\
                            <tr>\
                                <td colspan=2>No records</td>\
                            </tr>\
                        ');
                    }
                    else{
                        for(var i=0; i<data.length; i++){
                            $('#tbody-item-get').append('\
                                <tr>\
                                    <td>'+data[i].name+'</td>\
                                    <td>\
                                        <a href="<?= base_url("category/edit/'+data[i].id+'");?>">\
                                            <button class="btn btn-warning text-white btn-sm">Edit</button>\
                                        </a>\
                                        <button class="btn btn-danger btn-sm" onclick="deleteData('+data[i].id+')">Delete</button>\
                                    </td>\
                                </tr>\
                            ')
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function reloadNonActiveData() {
            $.ajax({
                url: '<?= base_url('category/get_data_nonactive') ?>',
                type: 'GET',
                async: true,
                dataType : 'json',
                beforeSend: function(){
                },
                success: function(param){
                    var data = param.items;
                    
                    if(data.length<1){
                        $('#tbody-item-get-nonactive').append('\
                            <tr>\
                                <td colspan=2>No records</td>\
                            </tr>\
                        ');
                    }
                    else{
                        for(var i=0; i<data.length; i++){
                            $('#tbody-item-get-nonactive').append('\
                                <tr>\
                                    <td>'+data[i].name+'</td>\
                                    <td>\
                                        <button onclick="restoredata('+data[i].id+')" class="btn btn-secondary btn-sm">Restore</button>\
                                    </td>\
                                </tr>\
                            ')
                        }
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

    </script>
</html>