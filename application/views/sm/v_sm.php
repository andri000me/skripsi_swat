<head>
	<link href="<?=base_url().'assets/'?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<link href="<?=base_url().'assets/'?>vendor/datatables/buttons.dataTables.min.css" rel="stylesheet">
</head>

<div class="container">
	<div class="row">
		<div class="col-xl-12">
			<a href="<?=base_url().'sm/tambah'?>" class="float-right d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data(Belum Bernomor)</a>
			<a href="<?=base_url().'sm/tambah_bernomor'?>" class="float-right d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mb-3  mr-2"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Data(Sudah Bernomor)</a>
		</div>	
	</div>
	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
				  <h6 class="m-0 font-weight-bold text-primary">Tabel Data Surat Masuk</h6>
				</div>
				<div class="card-body">
				  <div class="table-responsive">
				    <table class="table table-bordered" id="tabel" width="100%" cellspacing="0">
				    	<thead>
					      	<tr>
						        <th>No</th>
						        <th>Tanggal</th>
						        <th>Hal</th>
						        <th>Isi</th>
						        <th>Dari</th>
						        <th>Nomor Surat</th>
						        <th>Diarsipkan</th>
						        <th>Diteruskan</th>
						        <th>Catatan</th>
						        <th>Tindakan</th>
						        <th>Hapus</th>
					        </tr>
					    </thead>
					    <tbody>
				      	<?php 
				      	foreach($sm->result() as $value)
						{ 
						?>
					        <tr>
						          <td><?=$value->nomor?></td>
						          <td><?=$value->tahun.'-'.$value->bulan.'-'.$value->tanggal?></td>
						          <td><?=$value->hal?></td>
						          <td><?=$value->isi?></td>
						          <td><?=$value->dari?></td>
						          <td><?=$value->nomor_surat?></td>
						          <td><?=$value->tgl_diarsipkan?></td>
						          <td><?=$value->tgl_diteruskan?></td>
						          <td><?=$value->catatan?></td>
						          <td>
						          	<a href="<?=base_url().'sm/arsipkan/'.$value->id?>" class="btn btn-success btn-circle" onclick="return confirm('Surat <?=$value->nomor?> Benar Telah Diarsipkan?');">
						          		<i class="fas fa-archive"></i>
					                </a>
					                <a href="<?=base_url().'sm/teruskan/'.$value->id?>" class="btn btn-info btn-circle" onclick="return confirm('Surat <?=$value->nomor?> Benar Telah Diteruskan?');">
						          		<i class="fas fa-share"></i>
					                </a>
					            </td>
					            <td>
					                <a href="#" class="btn btn-danger btn-circle" onclick="confirm_dialog('<?=$value->id?>','<?=$value->nomor?>')">
					          			<i class="fas fa-trash"></i>
				                	</a>
						        </td>
					        </tr>
					    <?php
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
	    // Setup - add a text input to each footer cell
	    $('#tabel thead tr').clone(true).appendTo( '#tabel thead' );
	    $('#tabel thead tr:eq(1) th').each( function (i) {
	        var title = $(this).text();
	        $(this).html( '<input type="text" placeholder="Cari '+title+'" />' );
	 
	        $( 'input', this ).on( 'keyup change', function () {
	            if ( table.column(i).search() !== this.value ) {
	                table
	                    .column(i)
	                    .search( this.value )
	                    .draw();
	            }
	        } );
	    } );
	 
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
		    content: 'Apakah anda yakin ingin menghapus Surat Masuk '+ teks + ' ?',
		    buttons: {
		        konfirmasi: function () {
		            window.location.href = "<?=base_url()?>sm/hapus/"+id;
		        },
		         batal: function () {
		        }
		    }
		});
	}
</script>