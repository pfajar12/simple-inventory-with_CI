    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" id="categoryname" class="form-control" value="<?= $data_count>0 ? $data->name : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="categoryname-error"></span>
                    </div>

                    <div class="form-group">
                        <a href="<?= base_url('category')?>"><button class="btn btn-danger">Back</button></a>
                        <button class="btn btn-primary pull-right" onclick="checkForm(<?= $data->id; ?>)" id="btnEditData">Save</button>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">

        function checkForm(id) {
            var categoryname = $('#categoryname').val();

            if(categoryname==''){
                $('#categoryname-error').empty();
                $('#categoryname-error').append('*Category name must not null');
                $('#categoryname-error').removeClass('d-none');
                $('#categoryname-error').addClass('d-block');
            }
            else{
                $('#categoryname-error').removeClass('d-block');
                $('#categoryname-error').addClass('d-none');
                editData(id);
            }
        }
        
        function editData(id) {
            var categoryname = $('#categoryname').val();

            $.ajax({
                url: '<?= base_url('category/check_exist') ?>',
                type: 'POST',
                data: {categoryname: categoryname},
                beforeSend: function(){
                    $('#btnEditData').attr('disabled', 'disabled');
                    $('#btnEditData').text('Please wait...');
                },
                success: function(param){
                    $('#btnEditData').removeAttr('disabled')
                    $('#btnEditData').text('Save');
                    
                    if(param=='exist'){
                        $('#categoryname-error').empty();
                        $('#categoryname-error').append('*Category name exist');
                        $('#categoryname-error').removeClass('d-none');
                        $('#categoryname-error').addClass('d-block');
                    }
                    else{
                        updateData(id, categoryname);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function updateData(id, categoryname) {
            $.ajax({
                url: '<?= base_url('category/update') ?>',
                type: 'POST',
                data: {categoryname: categoryname, id: id},
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
                            location.assign("<?= base_url('category') ?>");
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