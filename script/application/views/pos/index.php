    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-8 books-content">
                    <div class="row">
                        <div class="col-9">
                            <select name="book" id="book" class="form-control" onchange="get_stock_available()">
                                <optgroup label="Select One"></optgroup>
                                <option value="">Choose Books</option>
                                <?php
                                    foreach ($data_list as $data) {
                                ?>
                                    <option value="<?= $data->id ?>"><?= $data->book_code.' - '.$data->name ?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            <span class="d-none text-danger" id="qty_book"></span>
                        </div>
                        <div class="col-3">
                            <input type="text" name="qty" id="qty" placeholder="QTY" onkeypress="return onlyNumber(event)" class="form-control">
                            <button class="btn btn-primary form-control mt-3" id="add-item">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-4 price-total-content bg-dark text-white">
                    <h1>Total</h1>
                    <h3 class="pull-right">Rp 0</h3>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">
        function onlyNumber(evt){
            var charCode=(evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57 ))
            return false;
            return true;
        }

        function get_stock_available() {
                $.ajax({
                url: '<?= base_url('pos/get_stock_available') ?>',
                type: 'POST',
                dataType: 'json',
                data: {book: $('#book').val()},
                async: true,
                beforeSend: function(){
                    $('#qty_book').removeClass('d-none');
                    $('#qty_book').addClass('d-block');
                    $('#qty_book').html('please wait...');
                },
                success: function(param){
                    $('#qty_book').html('in stock : '+param);
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        $('#add-item').click(function() {
            var book = $('#book').val();
            var qty  = $('#qty').val();

            if(book=='' || qty==''){
                $('#qty_book').removeClass('d-none');
                $('#qty_book').addClass('d-block');
                $('#qty_book').html('book and qty must not empty')
            }
            else{
                
            }
        });
    </script>
</html>