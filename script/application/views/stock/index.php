    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Book Code</th>
                                <th>Book Name</th>
                                <th>Qty</th>
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
            $.ajax({
                url: '<?= base_url('stock/get_stock_per_warehouse') ?>',
                type: 'POST',
                async: true,
                dataType : 'json',
                data : {warehouse_id: <?= $this->session->userdata('warehouse_id') ?>},
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
        });

    </script>
</html>