    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="table-responsive">
                    <!-- TABS -->
                    <div class="mb-5">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Book</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Non-active Book</a>
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

                            <div id="notice-line" class="my-2"></div>

                            <?php 
                                if($this->session->flashdata('msg')!=''){
                            ?>
                                <div class="alert alert-success mt-3" role="alert">
                                    <?php echo $this->session->flashdata('msg');?>
                                </div>
                            <?php
                                }
                            ?>
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Book Code</th>
                                        <th>Category</th>
                                        <th>Book Name</th>
                                        <th>Publisher</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-item-get">
                                <?php
                                if($data_count<1){
                                ?>
                                    <tr>
                                        <td colspan="6">No records</td>
                                    </tr>
                                <?php
                                }
                                else{
                                foreach ($data_list as $data):
                                ?>
                                    <tr>
                                        <td><?= $data->book_code; ?></td>
                                        <td><?= $data->category_name; ?></td>
                                        <td><?= $data->book_name; ?></td>
                                        <td><?= $data->publisher_name; ?></td>
                                        <td><?= $data->price; ?></td>
                                        <td>
                                            <a href="<?= base_url('book/edit/'.$data->id);?>">
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
                                        <th>Book Code</th>
                                        <th>Category</th>
                                        <th>Book Name</th>
                                        <th>Publisher</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-item-get-nonactive">
                                <?php
                                if($data_count_nonactive<1){
                                ?>
                                    <tr>
                                        <td colspan="6">No records</td>
                                    </tr>
                                <?php
                                }
                                else{
                                foreach ($data_list_nonactive as $data):
                                ?>
                                    <tr>
                                        <td><?= $data->book_code; ?></td>
                                        <td><?= $data->category_name; ?></td>
                                        <td><?= $data->book_name; ?></td>
                                        <td><?= $data->publisher_name; ?></td>
                                        <td><?= $data->price; ?></td>
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
                        <h5 class="modal-title" id="exampleModalLabel">Add New Book</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Book Code</label>
                            <input type="text" name="bookcode" id="bookcode" class="form-control">
                            <span class="text-danger font-weight-bold d-none" id="bookcode-error">
                                *book code name must not empty
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Category</label>
                            <select class="form-control" id="category">
                                <optgroup label="Select One">
                                    <option value="">-</option>
                                    <?php
                                        foreach ($category as $data) {
                                    ?>
                                        <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                            </select>
                            <span class="text-danger font-weight-bold d-none" id="category-error">
                                *category must not empty
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Book Name</label>
                            <input type="text" name="bookname" id="bookname" class="form-control">
                            <span class="text-danger font-weight-bold d-none" id="bookname-error">
                                *book name must not empty
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Publisher</label>
                            <select class="form-control" id="publisher">
                                <optgroup label="Select One">
                                    <option value="">-</option>
                                    <?php
                                        foreach ($publisher as $data) {
                                    ?>
                                        <option value="<?= $data->id ?>"><?= $data->name ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                            </select>
                            <span class="text-danger font-weight-bold d-none" id="publisher-error">
                                *publisher must not empty
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" id="price" class="form-control">
                            <span class="text-danger font-weight-bold d-none" id="price-error">
                                *price must not empty and minus value
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
            var bookcode = $('#bookcode').val();
            var category = $('#category').val();
            var bookname = $('#bookname').val();
            var publisher = $('#publisher').val();
            var price = $('#price').val();

            if(bookcode==''){
                $('#bookcode-error').removeClass('d-none');
                $('#bookcode-error').addClass('d-block');
            }
            else{
                $('#bookcode-error').removeClass('d-block');
                $('#bookcode-error').addClass('d-none');
            }

            if(category==''){
                $('#category-error').removeClass('d-none');
                $('#category-error').addClass('d-block');
            }
            else{
                $('#category-error').removeClass('d-block');
                $('#category-error').addClass('d-none');
            }

            if(bookname==''){
                $('#bookname-error').removeClass('d-none');
                $('#bookname-error').addClass('d-block');
            }
            else{
                $('#bookname-error').removeClass('d-block');
                $('#bookname-error').addClass('d-none');
            }

            if(publisher==''){
                $('#publisher-error').removeClass('d-none');
                $('#publisher-error').addClass('d-block');
            }
            else{
                $('#publisher-error').removeClass('d-block');
                $('#publisher-error').addClass('d-none');
            }

            if(price==''){
                $('#price-error').removeClass('d-none');
                $('#price-error').addClass('d-block');
            }
            else{
                $('#price-error').removeClass('d-block');
                $('#price-error').addClass('d-none');
            }

            if(price<0){
                $('#price-error').removeClass('d-none');
                $('#price-error').addClass('d-block');
            }

            if(bookcode!=''&& category!='' && bookname!='' && publisher!='' && price!='' && price>0){
                saveNewData(bookcode);
            }
        }

        function saveNewData(bookcode) {
            $.ajax({
                url: '<?= base_url('book/check_exist') ?>',
                type: 'POST',
                data: {bookcode: bookcode},
                beforeSend: function(){
                    $('#btnAddCategory').attr('disabled', 'disabled');
                    $('#btnAddCategory').text('Please wait...');
                },
                success: function(param){
                    if(param=='exist'){
                        $('#notice-line').html('\
                            <div class="alert alert-danger mt-3" role="alert">\
                                Book code exist\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                    }
                    else{
                        createNewData()
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

        function createNewData() {
            var bookcode = $('#bookcode').val();
            var category = $('#category').val();
            var bookname = $('#bookname').val();
            var publisher = $('#publisher').val();
            var price = $('#price').val();

            $.ajax({
                url: '<?= base_url('book/create') ?>',
                type: 'POST',
                data: {bookcode: bookcode, category: category, bookname: bookname, publisher:publisher, price: price},
                beforeSend: function(){
                },
                success: function(param){
                    if(param=='success'){
                        $('#notice-line').html('\
                            <div class="alert alert-success mt-3" role="alert">\
                                Add new book success\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                        loadData();
                    }
                    else{
                        $('#notice-line').html('\
                            <div class="alert alert-danger mt-3" role="alert">\
                                Add new book fail\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
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
                        url: '<?= base_url('book/delete') ?>',
                        type: 'POST',
                        data: {id: id},
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
                url: '<?= base_url('book/restore') ?>',
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
                url: '<?= base_url('book/get_data') ?>',
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
                                <td colspan=6>No records</td>\
                            </tr>\
                        ');
                    }
                    else{
                        for(var i=0; i<data.length; i++){
                            $('#tbody-item-get').append('\
                                <tr>\
                                    <td>'+data[i].book_code+'</td>\
                                    <td>'+data[i].category_name+'</td>\
                                    <td>'+data[i].book_name+'</td>\
                                    <td>'+data[i].publisher_name+'</td>\
                                    <td>'+data[i].price+'</td>\
                                    <td>\
                                        <a href="<?= base_url("book/edit/'+data[i].id+'");?>">\
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
                url: '<?= base_url('book/get_data_nonactive') ?>',
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
                                <td colspan=6>No records</td>\
                            </tr>\
                        ');
                    }
                    else{
                        for(var i=0; i<data.length; i++){
                            $('#tbody-item-get-nonactive').append('\
                                <tr>\
                                    <td>'+data[i].book_code+'</td>\
                                    <td>'+data[i].category_name+'</td>\
                                    <td>'+data[i].book_name+'</td>\
                                    <td>'+data[i].publisher_name+'</td>\
                                    <td>'+data[i].price+'</td>\
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