    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="warehousename" class="form-control" value="<?= $count_data>0 ? $warehouse_data->name : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="warehousename-error"></span>
                    </div>

                    <div class="form-group">
                        <a href="<?= base_url('warehouse')?>"><button class="btn btn-danger">Back</button></a>
                        <button class="btn btn-primary pull-right" onclick="checkForm(<?= $warehouse_data->id; ?>)" id="btnEditData">Save</button>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">

        function checkForm(id) {
            var warehousename = $('#warehousename').val();

            if(warehousename==''){
                $('#warehousename-error').empty();
                $('#warehousename-error').append('*Warehouse name must not null');
                $('#warehousename-error').removeClass('d-none');
                $('#warehousename-error').addClass('d-block');
            }
            else{
                $('#warehousename-error').removeClass('d-block');
                $('#warehousename-error').addClass('d-none');
                editData(id);
            }
        }
        
        function editData(id) {
            var warehousename = $('#warehousename').val();

            $.ajax({
                url: '<?= base_url('warehouse/check_exist') ?>',
                type: 'POST',
                data: {warehousename: warehousename},
                beforeSend: function(){
                    $('#btnEditData').attr('disabled', 'disabled');
                    $('#btnEditData').text('Please wait...');
                },
                success: function(param){
                    $('#btnEditData').removeAttr('disabled')
                    $('#btnEditData').text('Save');
                    
                    if(param=='exist'){
                        $('#warehousename-error').empty();
                        $('#warehousename-error').append('*Warehouse name exist');
                        $('#warehousename-error').removeClass('d-none');
                        $('#warehousename-error').addClass('d-block');
                    }
                    else{
                        updateData(id, warehousename);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function updateData(id, warehousename) {
            $.ajax({
                url: '<?= base_url('warehouse/update') ?>',
                type: 'POST',
                data: {warehousename: warehousename, id: id},
                beforeSend: function(){
                    $('#btnEditData').attr('disabled', 'disabled');
                    $('#btnEditData').text('Please wait...');
                },
                success: function(param){
                    if(param='success'){
                        swal({
                            title: "Success!",
                            text: "Data updated successfully",
                            icon: "success",
                            button: "Ok",
                            closeOnClickOutside: false,
                            closeOnEsc: false,
                        })
                        .then(() => {
                            location.assign("<?= base_url('warehouse') ?>");
                        });
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