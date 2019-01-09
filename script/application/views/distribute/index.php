    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div id="notice-line" class="my-2 col-12"></div>

                <div class="col-6">
                    <div class="form-group">
                        <label>Warehouse</label>
                        <select id="warehouse" class="form-control">
                            <option value="">-</option>
                            <optgroup label="Pick One"></optgroup>
                            <?php foreach ($warehouse as $data): ?>
                                <option value="<?= $data->id ?>"><?= $data->name ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="warehouse-error" class="d-none text-danger font-weight-bold">
                            *warehouse must not empty
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Book</label>
                        <select id="book" class="form-control">
                            <option value="">-</option>
                            <optgroup label="Pick One"></optgroup>
                            <?php foreach ($book as $data): ?>
                                <option value="<?= $data->id ?>"><?= $data->book_code.' '.$data->book_name ?></option>
                            <?php endforeach ?>
                        </select>
                        <div id="book-error" class="d-none text-danger font-weight-bold">
                            *book must not empty
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Qty</label>
                        <input type="text" id="qty" class="form-control" onkeypress="return onlyNumber(event)">
                        <div id="qty-error" class="d-none text-danger font-weight-bold">
                            *qty must not empty and minus
                        </div>
                    </div>

                    <button class="btn btn-primary pull-right" id="btnDistribute" onclick="checkInput()">Send</button>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">
        function checkInput() {
            var warehouse = $('#warehouse').val();
            var book = $('#book').val();
            var qty = $('#qty').val();

            if(warehouse==''){
                $('#warehouse-error').removeClass('d-none');
                $('#warehouse-error').addClass('d-block');
            }
            else{
                $('#warehouse-error').removeClass('d-block');
                $('#warehouse-error').addClass('d-none');
            }

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

            if(warehouse!='' && book!='' && qty!='' && qty>0){
                checkQtyFromWarehouse();
            }
        }

        function checkQtyFromWarehouse() {
            var book        = $('#book').val();
            var qty         = $('#qty').val();
            var destination = $('#warehouse').val();
            var sender      = <?= $this->session->userdata('warehouse_id') ?>;

            $('#notice-line').empty();

            $.ajax({
                url: '<?= base_url('distribute/check_qty') ?>',
                type: 'POST',
                data: {book: book, qty: qty, warehouse_id: sender},
                beforeSend: function(){
                    $('#btnDistribute').attr('disabled', 'disabled');
                    $('#btnDistribute').text('Please wait...');
                },
                success: function(param){
                    $('#btnDistribute').removeAttr('disabled');
                    $('#btnDistribute').text('Send');

                    if(param<0){
                        $('#notice-line').html('\
                            <div class="alert alert-danger mt-3" role="alert">\
                                Failed to distribute the books. Only '+(parseInt(param) + parseInt(qty))+' in stock\
                            </div>\
                        ');
                    }
                    else{
                        books_distributing(book, qty, destination, sender);
                    }
                    console.log(param)
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function books_distributing(book, qty, destination, sender) {
                $.ajax({
                    url: '<?= base_url('distribute/books_distributing') ?>',
                    type: 'POST',
                    data: {book: book, qty: qty, sender: sender, destination: destination},
                    beforeSend: function(){
                    },
                    success: function(param){
                        if(param=='success'){
                            $('#notice-line').html('\
                                <div class="alert alert-success mt-3" role="alert">\
                                    Books distributed successfully\
                                </div>\
                            ');
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
        }

        function onlyNumber(evt){
            var charCode=(evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57 ))
            return false;
            return true;
        }

    </script>
</html>