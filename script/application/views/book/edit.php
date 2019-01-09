    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Book Code</label>
                        <input type="text" id="bookcode" class="form-control" value="<?= $data_count>0 ? $data->book_code : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="bookcode-error">*book code must not empty</span>
                    </div>

                    <div class="form-group">
                        <label>Category</label>
                        <select class="form-control" id="category">
                            <optgroup label="Select One">
                                <option value="<?= $data_count>0 ? $data->category : '' ?>">
                                    <?= $data_count>0 ? $data->category_name : 'No data' ?>
                                </option>
                                <?php
                                    foreach ($category as $category) {
                                ?>
                                    <option value="<?= $category->id ?>"><?= $category->name ?></option>
                                <?php
                                    }
                                ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Book Name</label>
                        <input type="text" id="bookname" class="form-control" value="<?= $data_count>0 ? $data->book_name : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="bookname-error">*book name must not empty</span>
                    </div>

                    <div class="form-group">
                        <label>Publisher</label>
                        <select class="form-control" id="publisher">
                            <optgroup label="Select One">
                                <option value="<?= $data_count>0 ? $data->publisher : '' ?>">
                                    <?= $data_count>0 ? $data->publisher_name : 'No data' ?>
                                </option>
                                <?php
                                    foreach ($publisher as $publisher) {
                                ?>
                                    <option value="<?= $publisher->id ?>"><?= $publisher->name ?></option>
                                <?php
                                    }
                                ?>
                            </optgroup>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Price</label>
                        <input type="text" id="price" class="form-control" value="<?= $data_count>0 ? $data->price : 'No data' ?>">
                        <span class="text-danger font-weight-bold d-none" id="price-error">*price must not empty and minus value</span>
                    </div>

                    <div class="form-group">
                        <a href="<?= base_url('book')?>"><button class="btn btn-danger">Back</button></a>
                        <button class="btn btn-primary pull-right" onclick="checkForm(<?= $data->id; ?>)" id="btnEditData">Save</button>
                    </div>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">

        function checkForm(id) {
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
                editData(id);
            }
        }
        
        function editData(id) {
            var bookcode = $('#bookcode').val();
            var category = $('#category').val();
            var bookname = $('#bookname').val();
            var publisher = $('#publisher').val();
            var price = $('#price').val();

            $.ajax({
                url: '<?= base_url('book/check_exist_foredit') ?>',
                type: 'POST',
                data: {bookcode: bookcode, category: category, bookname: bookname, publisher: publisher, price: price, id: '<?= $data->id?>'},
                beforeSend: function(){
                    $('#btnEditData').attr('disabled', 'disabled');
                    $('#btnEditData').text('Please wait...');
                },
                success: function(param){
                    $('#btnEditData').removeAttr('disabled')
                    $('#btnEditData').text('Save');
                    
                    if(param=='exist'){
                        $('#bookcode-error').empty();
                        $('#bookcode-error').html('*Book code exist');
                        $('#bookcode-error').removeClass('d-none');
                        $('#bookcode-error').addClass('d-block');
                    }
                    else{
                        updateData(id);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function updateData(id) {
            var bookcode = $('#bookcode').val();
            var category = $('#category').val();
            var bookname = $('#bookname').val();
            var publisher = $('#publisher').val();
            var price = $('#price').val();

            $.ajax({
                url: '<?= base_url('book/update') ?>',
                type: 'POST',
                data: {bookcode: bookcode, category: category, bookname: bookname, publisher: publisher, price: price, id: id},
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
                            location.assign("<?= base_url('book') ?>");
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