    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Warehouse</th>
                                <!-- <th>Action</th> -->
                            </tr>
                        </thead>
                        <tbody>
<?php
if($data_count<1){
?>
                            <tr>
                                <td colspan="6">No records</td>
                            </tr>
<?php
}
else{
foreach ($data as $data):
?>
                            <tr>
                                <td><?= $data->username; ?></td>
                                <td><?= $data->warehouse_name; ?></td>
                            </tr>
<?php endforeach; } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </body>
</html>