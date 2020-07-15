<?php
	$host  = "localhost";
	$user = "root";
	$pass = "";
	$db = "arkademy";

	$conn = mysqli_connect($host, $user, $pass, $db) or die ('Database Not Connected');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Arkademy CRUD</title>
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
	<div class="container"><br>
		<h1> CRUD Arkademy </h1><hr>
		<button class="btn btn-primary" data-toggle="modal" data-target="#insert">Insert</button><br><br>
		<table class="table table-bordered table-stripped">
			<thead>
				<tr>
					<th>Nama Produk</th>
					<th>Keterangan</th>
					<th>Harga</th>
					<th>Jumlah</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
		<?php
			$sql = mysqli_query($conn, "SELECT * FROM produk");
			if(mysqli_num_rows($sql) > 0){
				while($data = mysqli_fetch_array($sql)){ ?>
					<tr>
						<td><?= $data['nama_produk']; ?></td>
						<td><?= $data['keterangan']; ?></td>
						<td>Rp. <?= number_format($data['harga'], 2, ',', '.'); ?></td>
						<td><?= $data['jumlah']; ?> Pcs</td>
						<td class="text-center">
							<button class="btn btn-success" data-toggle="modal" data-target="#update<?= str_replace(' ', '', $data['nama_produk']); ?>">Edit</button>
							<button class="btn btn-danger" data-toggle="modal" data-target="#delete<?= str_replace(' ', '', $data['nama_produk']); ?>">Delete</button>
						</td>
					</tr>
					<!-- Modal Update -->
					<form method="POST">
					<div class="modal fade" id="update<?= str_replace(' ', '', $data['nama_produk']); ?>" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog modal-lg">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Update</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					      	 <div class="form-group row">
							    <label for="nama_produk" class="col-sm-2 col-form-label"><b>Nama Produk</b></label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" name="nama_produk" value="<?= $data['nama_produk']; ?>" readonly>
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="keterangan" class="col-sm-2 col-form-label"><b>Keterangan</b></label>
							    <div class="col-sm-10">
							      <input type="text" class="form-control" name="keterangan" value="<?= $data['keterangan']; ?>">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="harga" class="col-sm-2 col-form-label"><b>Harga</b></label>
							    <div class="col-sm-10">
							      <input type="number" class="form-control" name="harga" value="<?= $data['harga']; ?>">
							    </div>
							  </div>
							  <div class="form-group row">
							    <label for="jumlah" class="col-sm-2 col-form-label"><b>Jumlah</b></label>
							    <div class="col-sm-10">
							      <input type="number" class="form-control" name="jumlah" value="<?= $data['jumlah']; ?>">
							    </div>
							  </div>
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					        <button type="submit" name="update" class="btn btn-primary">Save</button>
					      </div>
					    </div>
					  </div>
					</div>
				</form>

				<!-- Modal Hapus -->
				<form method="POST">
					<div class="modal fade" tabindex="-1" id="delete<?= str_replace(' ', '', $data['nama_produk']); ?>" role="dialog">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title">Delete</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <div class="modal-body">
					        <p><b>Delete <?= $data['nama_produk']; ?> ?</b></p>
					        <input type="hidden" name="nama_produk" value="<?= $data['nama_produk']; ?>">
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					        <button type="submit" name="delete" class="btn btn-primary">Yes</button>
					      </div>
					    </div>
					  </div>
					</div>	
				</form>

				<?php } ?>
				<tr>
					<td colspan="5" class="text-right"><b> Total Produk : <?= mysqli_num_rows($sql); ?></b></td>
				</tr>
			<?php }else{ ?>
				<tr>
					<td colspan="5"><b>Data Tidak Tersedia.</b></td>
				</tr>
			<?php } ?>
		</table>
		<?php
			//insert
			if(isset($_POST['insert'])){

				$nama_produk = $_POST['nama_produk'];
				$keterangan = $_POST['keterangan'];
				$harga = $_POST['harga'];
				$jumlah = $_POST['jumlah'];

				$a = mysqli_query($conn, "INSERT INTO produk(nama_produk,keterangan,harga,jumlah) VALUES ('$nama_produk','$keterangan','$harga','$jumlah')");

				if($a){ ?>
					<script type="text/javascript">
						window.location.href='index.php';
					</script>
				<?php }else{ ?>
					<div class="alert alert-danger" role="alert">
					  <b> Insert </b> Failed. Try Again!
					</div>
				<?php }

			}

			//update
			if(isset($_POST['update'])){

				$nama_produk = $_POST['nama_produk'];
				$keterangan = $_POST['keterangan'];
				$harga = $_POST['harga'];
				$jumlah = $_POST['jumlah'];

				$b = mysqli_query($conn, "UPDATE produk SET keterangan='$keterangan', harga='$harga', jumlah='$jumlah' WHERE nama_produk='$nama_produk'");

				if($b){ ?>
					<script type="text/javascript">
						window.location.href='index.php';
					</script>
				<?php }else{ ?>
					<div class="alert alert-danger" role="alert">
					  <b> Update </b> Failed. Try Again!
					</div>
				<?php }

			}

			//Delete
			if(isset($_POST['delete'])){
				$nama_produk = $_POST['nama_produk'];
				$c = mysqli_query($conn, "DELETE FROM produk WHERE nama_produk='$nama_produk'");
				if($c){ ?>
					<script type="text/javascript">
						window.location.href='index.php';
					</script>
				<?php }else{ ?>
					<div class="alert alert-danger" role="alert">
					  <b> Delete</b> Failed. Try Again!
					</div>
				<?php }
			}
		?>
	</div>
	<!-- Modal insert -->
	<form method="POST">
	<div class="modal fade" id="insert" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Insert</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	 <div class="form-group row">
			    <label for="nama_produk" class="col-sm-2 col-form-label"><b>Nama Produk</b></label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="nama_produk">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="keterangan" class="col-sm-2 col-form-label"><b>Keterangan</b></label>
			    <div class="col-sm-10">
			      <input type="text" class="form-control" name="keterangan">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="harga" class="col-sm-2 col-form-label"><b>Harga</b></label>
			    <div class="col-sm-10">
			      <input type="number" class="form-control" name="harga">
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="jumlah" class="col-sm-2 col-form-label"><b>Jumlah</b></label>
			    <div class="col-sm-10">
			      <input type="number" class="form-control" name="jumlah">
			    </div>
			  </div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	        <button type="submit" name="insert" class="btn btn-primary">Save</button>
	      </div>
	    </div>
	  </div>
	</div>
	</form>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>