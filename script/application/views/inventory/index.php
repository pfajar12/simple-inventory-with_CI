    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="table-responsive">
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
                                <th>Book Name</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-item-get">
                        <?php
                        if($data_count<1){
                        ?>
                            <tr>
                                <td colspan="3">No records</td>
                            </tr>
                        <?php
                        }
                        else{
                        foreach ($data as $data):
                        ?>
                            <tr>
                                <td><?= $data->book_code; ?></td>
                                <td><?= $data->book_name; ?></td>
                                <td><?= $data->qty; ?></td>
                            </tr>

                        <?php
                        endforeach;
                        }
                        ?>
                        </tbody>
                    </table>
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
                            <label>Book</label>
                            <select class="form-control" id="book">
                                <optgroup label="Select One">
                                    <option value="">-</option>
                                    <?php
                                        foreach ($book as $data) {
                                    ?>
                                        <option value="<?= $data->id ?>"><?= $data->book_code.' - '.$data->book_name ?></option>
                                    <?php
                                        }
                                    ?>
                                </optgroup>
                            </select>
                            <span class="text-danger font-weight-bold d-none" id="book-error">
                                *book must not empty
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Qty</label>
                            <input type="text" name="qty" id="qty" onkeypress="return onlyNumber(event)" class="form-control">
                            <span class="text-danger font-weight-bold d-none" id="qty-error">
                                *qty must not empty and minus
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="checkInput()" id="btnAddBook" class="btn btn-primary">Save</button>
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
            var book = $('#book').val();
            var qty = $('#qty').val();

            if(book==''){
                $('#book-error').removeClass('d-none');
                $('#book-error').addClass('d-block');
            }
            else{
                $('#book-error').removeClass('d-block');
                $('#book-error').addClass('d-none');
            }

            if(qty==''){
                $('#qty-error').removeClass('d-none');
                $('#qty-error').addClass('d-block');
            }
            else{
                $('#qty-error').removeClass('d-block');
                $('#qty-error').addClass('d-none');
            }

            if(qty<0){
                $('#qty-error').removeClass('d-none');
                $('#qty-error').addClass('d-block');
            }

            if(book!='' && qty!='' && qty>0){
                saveNewData();
            }
        }

        function saveNewData() {
            var book = $('#book').val();
            var qty = $('#qty').val();

            $.ajax({
                url: '<?= base_url('inventory/check_exist') ?>',
                type: 'POST',
                data: {book: book, qty: qty, warehouse_id: <?= $this->session->userdata('warehouse_id') ?>},
                beforeSend: function(){
                    $('#btnAddBook').attr('disabled', 'disabled');
                    $('#btnAddBook').text('Please wait...');
                },
                success: function(param){
                    if(param=='success'){
                        $('#notice-line').html('\
                            <div class="alert alert-success mt-3" role="alert">\
                                Add new book success\
                            </div>\
                        ');

                        $('#addNewDataModal').modal('hide');
                        $('#book').val('');
                        $('#qty').val('');
                        loadData();
                    }
                    else{
                        console.log('problem occured')
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });

            $('#btnAddBook').removeAttr('disabled');
            $('#btnAddBook').text('Save');
        }

        function loadData() {
            $('#tbody-item-get').empty();

            $.ajax({
                url: '<?= base_url('inventory/get_data') ?>',
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
                                <td colspan=3>No records</td>\
                            </tr>\
                        ');
                    }
                    else{
                        for(var i=0; i<data.length; i++){
                            $('#tbody-item-get').append('\
                                <tr>\
                                    <td>'+data[i].book_code+'</td>\
                                    <td>'+data[i].book_name+'</td>\
                                    <td>'+data[i].qty+'</td>\
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

        function onlyNumber(evt){
            var charCode=(evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57 ))
            return false;
            return true;
        }

    </script>
</html>