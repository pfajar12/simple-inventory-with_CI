<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="<?php echo base_url('css/style.css')?>"/>
		<link rel="stylesheet" href="<?php echo base_url('css/font-awesome.min.css')?>"/>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    	<title><?= $title ?></title>
    </head>
    <body>
		<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
			<a class="navbar-brand" href="#">Batam Book Store</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarsExampleDefault">
				<ul class="navbar-nav mr-auto">
					<?php
						if($this->session->userdata('role')==1){
					?>
						<li <?= $page=='home' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="./">Home</a>
						</li>
						<li <?= $page=='admin' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?= base_url('admin'); ?>">Admin</a>
						</li>
						<li <?= $page=='category' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?= base_url('category'); ?>">Category</a>
						</li>
						<li <?= $page=='warehouse' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?= base_url('warehouse') ?>">Warehouse</a>
						</li>
						<li <?= $page=='publisher' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?= base_url('publisher') ?>">Publisher</a>
						</li>
						<li <?= $page=='book' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?= base_url('book') ?>">Book</a>
						</li>
						<li <?= $page=='stock' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?=base_url('stock')?>">Stock</a>
						</li>
						<li <?= $page=='stockcard' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
							<a class="nav-link" href="<?=base_url('stockcard')?>">Stockcard</a>
						</li>
					<?php
						}
						else{
							if($this->session->userdata('warehouse_id')==1){
					?>
							<li <?= $page=='inventory' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
								<a class="nav-link" href="<?=base_url('inventory')?>">Inventory</a>
							</li>
							<li <?= $page=='distribute_item' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
								<a class="nav-link" href="<?=base_url('distribute')?>">Distribute Item</a>
							</li>
							<li <?= $page=='stock' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
								<a class="nav-link" href="<?=base_url('stock')?>">Stock</a>
							</li>
					<?php
							}
							else{
					?>
								<li <?= $page=='stock' ? 'class="nav-item active"' : 'class="nav-item"' ?>>
									<a class="nav-link" href="<?=base_url('stock')?>">Stock</a>
								</li>
					<?php
							}
						}
					?>
				</ul>
				<a class="btn btn-outline-light my-2 my-sm-0 text-white" href="<?=base_url('login/logout'); ?>">
					<i class="fa fa-cog"></i> Logout
				</a>
			</div>
		</nav>
