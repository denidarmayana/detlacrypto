<?php $this->load->view('element/head');?>
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pelanggan
                <small>Penambahan Limit</small>
            </h1>
        </section>
        <section class="content">
        	<div class="row">
        		<div class="col-md-4">
        			<div class="box box-success">
        				<div class="box-header">
        					<h3 class="box-title">Tambah Limit</h3>
        				</div>
        				<div class="box-body">
        					<?=$this->session->flashdata("pesan") ?>
        					<form method="post" class="form-horizontal" action="<?=base_url('pelanggan/tambah_limit') ?>">
        						<div class="form-group">
        							<div class="col-md-12">
        								<input type="text" placeholder="Kode Pelanggan atau No. Kartu" name="customers" class="form-control" required>
        							</div>
        						</div>
        						<div class="form-group">
        							<div class="col-md-12">
        								<input type="text" placeholder="Jumlah Limit" class="form-control" name="limit" required>
        							</div>
        						</div>
        						<div class="form-group">
        							<div class="col-md-12">
        								<button class="btn btn-block btn-primary">Simpan</button>
        							</div>
        						</div>
        					</form>
        				</div>
        			</div>
        		</div>
        		<div class="col-md-8">
        			<div class="box box-success">
        				<div class="box-header">
        					<h3 class="box-title">Riwayat Penambahan Limit</h3>
        				</div>
        				<div class="box-body">
        					<table class="table table-bordered table-striped">
        						<thead>
        							<tr><th>No</th><th>Tanggal</th><th>Pelanggan</th><th>NominL</th></tr>
        						</thead>
        						<tbody>
        							<?php
        							$no=0;
        							foreach ($data as $key) { $no++;
        								echo "<tr><td>".$no."</td><td>".$key->created_at."</td><td>".$key->customer_name."</td><td>Rp. ".number_format($key->limit,0,',','.')."</td></tr>";
        							} ?>
        						</tbody>
        					</table>
        				</div>
        			</div>
        		</div>
        	</div>
        </section>
    </div>
<?php $this->load->view('element/footer');?>