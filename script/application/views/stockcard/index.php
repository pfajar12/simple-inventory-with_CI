    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <select class="form-control" id="warehouselist">
                            <option value="">Choose Warehouse</option>
                            <optgroup label="Pick One"></optgroup>
                            <?php foreach ($data_list_warehouse as $data): ?>
                                <option value="<?= $data->id ?>"><?= $data->name ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Book</th>
                                <th>Qty In</th>
                                <th>Qty Out</th>
                                <th>Admin Actor</th>
                                <th>Note</th>
                                <th>Time</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-item-get">

                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </body>

    <script type="text/javascript">
        
        $(document).ready(function() {
            $('#warehouselist').change(function() {
                var warehouse = $(this).val();

                $.ajax({
                    url: '<?= base_url('stockcard/get_stockcard_per_warehouse') ?>',
                    type: 'POST',
                    async: true,
                    dataType : 'json',
                    data : {warehouse_id: warehouse},
                    beforeSend: function(){
                        $('#tbody-item-get').empty();
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
                                        <td>'+data[i].book_code+'- '+data[i].book_name+'</td>\
                                        <td>'+data[i].qty_in+'</td>\
                                        <td>'+data[i].qty_out+'</td>\
                                        <td>'+data[i].username+'</td>\
                                        <td>'+data[i].note+'</td>\
                                        <td>'+data[i].date+'</td>\
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
            });
        });

    </script>
</html>