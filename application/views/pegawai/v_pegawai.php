<head>
	<link href="<?=base_url().'assets/'?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="<?=base_url().'assets/'?>vendor/datatables/buttons.dataTables.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="row">
		<div class="col-xl-10">
		</div>
		<div class="col-xl-2">
			<a href="<?=base_url('pegawai/tambah')?>" class="float-right d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data</a>		
		</div>
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
				  	<h6 class="m-0 font-weight-bold text-primary">Tabel Data Pegawai</h6>
				</div>
				<div class="card-body">
				  <div class="table-responsive">
				    <table class="table table-bordered" id="tabel" width="100%" cellspacing="0">
				      <thead>
				        <tr>
				          <th>No</th>
				          <th>Devisi</th>
				          <th>NIK</th>
				          <th>Nama</th>
				          <th>No KK</th>
				          <th>BPJS Ketenagakerjaan</th>
				          <th>BPJS Kesehatan</th>
				          <th>No NPWP</th>
				          <th>Alamat</th>
				          <th>Telp</th>
				          <th>Tindakan</th>
				        </tr>
				      </thead>
				      <tbody>
				      	<?php
				      	$nomor = 1;
				      	foreach($data->result() as $value)
						{ 
						?>
					        <tr>
					          <td><?=$nomor?></td>
					          <td><?=$value->devisi_nama?></td>
					          <td><?=$value->nik?></td>
					          <td><?=$value->nama?></td>
					          <td><?=$value->no_kk?></td>
					          <td><?=$value->no_bpjs_ketenagakerjaan?></td>
					          <td><?=$value->no_bpjs_kesehatan?></td>
					          <td><?=$value->no_npwp?></td>
					          <td><?=$value->alamat?></td>
					          <td><?=$value->telp?></td>
					          <td>
				                <a href="<?=base_url('pegawai/ubah/'.$value->nik)?>" class="btn btn-primary btn-circle">
					          		<i class="fas fa-edit"></i>
				                </a>
				                <a href="#" class="btn btn-danger btn-circle" onclick="confirm_dialog('<?=$value->nik?>', '<?=$value->nama?>')">
					          		<i class="fas fa-trash"></i>
				                </a>
					          </td>
					        </tr>
					    <?php
					    	$nomor++;
					    }
					    ?>
				      </tbody>
				    </table>
				  </div>
				</div>
			</div>
		</div>		
	</div>
</div>


<!-- Page level plugins -->
<script src="<?=base_url().'assets/'?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/dataTables.buttons.min.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/jszip.min.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/pdfmake.min.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/vfs_fonts.js"></script>
<script src="<?=base_url().'assets/'?>vendor/datatables/buttons.html5.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?=base_url().'assets/'?>js/demo/datatables-demo.js"></script>

<script>
	$(document).ready(function() {
	 
	    var table = $('#tabel').DataTable( {
	        orderCellsTop: true,
	        fixedHeader: true,
	        dom: 'Bfrtip',
	        buttons: [
	            'copyHtml5',
	            'excelHtml5',
	            'csvHtml5',
	            'pdfHtml5'
	        ]
	    } );
	} );

	function confirm_dialog(id, teks){
		$.confirm({
		    title: 'Hapus Data',
		    content: 'Apakah anda yakin ingin menghapus data Pegawai '+ teks + ' ?',
		    buttons: {
		        konfirmasi: function () {
		            window.location.href = "<?=base_url()?>pegawai/hapus/"+id;
		        },
		         batal: function () {
		        }
		    }
		});
	}
</script>