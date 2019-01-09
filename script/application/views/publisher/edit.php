    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="publishername" class="form-control" value="<?= $data_count>0 ? $data->name : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="publishername-error"></span>
                    </div>

                    <div class="form-group">
                        <a href="<?= base_url('publisher')?>"><button class="btn btn-danger">Back</button></a>
                        <button class="btn btn-primary pull-right" onclick="checkForm(<?= $data->id; ?>)" id="btnEditData">Save</button>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">

        function checkForm(id) {
            var publishername = $('#publishername').val();

            if(publishername==''){
                $('#publishername-error').empty();
                $('#publishername-error').append('*Publisher name must not null');
                $('#publishername-error').removeClass('d-none');
                $('#publishername-error').addClass('d-block');
            }
            else{
                $('#publishername-error').removeClass('d-block');
                $('#publishername-error').addClass('d-none');
                editData(id);
            }
        }
        
        function editData(id) {
            var publishername = $('#publishername').val();

            $.ajax({
                url: '<?= base_url('publisher/check_exist') ?>',
                type: 'POST',
                data: {publishername: publishername},
                beforeSend: function(){
                    $('#btnEditData').attr('disabled', 'disabled');
                    $('#btnEditData').text('Please wait...');
                },
                success: function(param){
                    $('#btnEditData').removeAttr('disabled')
                    $('#btnEditData').text('Save');
                    
                    if(param=='exist'){
                        $('#publishername-error').empty();
                        $('#publishername-error').append('*Publisher name exist');
                        $('#publishername-error').removeClass('d-none');
                        $('#publishername-error').addClass('d-block');
                    }
                    else{
                        updateData(id, publishername);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function updateData(id, publishername) {
            $.ajax({
                url: '<?= base_url('publisher/update') ?>',
                type: 'POST',
                data: {publishername: publishername, id: id},
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
                            location.assign("<?= base_url('publisher') ?>");
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