    <body>
        <main role="main" class="container mt-5 pt-5">
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Admin">Admin</h5>
                            <p class="card-text"><?= $total_admin; ?> records</p>
                            <a href="<?= base_url('admin'); ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Category">Category</h5>
                            <p class="card-text"><?= $total_category; ?> records</p>
                            <a href="<?= base_url('category'); ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Warehouse">Warehouse</h5>
                            <p class="card-text"><?= $total_warehouse; ?> records</p>
                            <a href="<?= base_url('warehouse') ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Publisher">Publisher</h5>
                            <p class="card-text"><?= $total_publisher; ?> records</p>
                            <a href="<?= base_url('publisher') ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Book">Book</h5>
                            <p class="card-text"><?= $total_book; ?> records</p>
                            <a href="<?= base_url('book') ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Stock">Stock</h5>
                            <p class="card-text"><?= $total_stock; ?> records</p>
                            <a href="<?= base_url('stock') ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-6 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title text-truncate" title="Stockcard">Stockcard</h5>
                            <p class="card-text"><?= $total_stockcard; ?> records</p>
                            <a href="<?= base_url('stockcard') ?>" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>