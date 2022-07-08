<main class="container">
	<div class="columns" style="margin-top:2rem;">
		<div class="column">
			<a class="button is-small is-primary js-modal-trigger" data-target="modalTambah" style="float:right;margin-right:1rem;">Tambah Pelayanan</a>
		</div>
	</div>
	<div class="columns" style="margin-top:1rem;">
		<div class="column">
			<div style="overflow-x:auto;">
				<table id="tablePelayanan">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Kode</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($pelayanan as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><?= $row['nama'];?></td>
								<td><?= $row['keterangan'];?></td>
								<td><?= $row['kode'];?></td>
								<td>
									<button type="button" class="button is-small is-danger" onclick="hapusPelayanan(<?= $row['id'];?>, '<?= $row['nama'];?>')">Hapus</button>
									<button type="button" class="button is-small is-warning js-modal-trigger" data-target="modalEdit" onclick="editPelayanan(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['keterangan'];?>', '<?= $row['kode'];?>')">Edit</button>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</main>

<!-- Modal Tambah -->
<div class="modal" id="modalTambah">
	<div class="modal-background"></div>
	<?= form_open('/admin/pelayanan/tambah', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Tambah Pelayanan</p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<div class="columns">
					<div class="column">
						<label for="keterangan">Nama</label>
						<input id="nama" name="nama" type="text" class="input" value="<?= old('nama');?>" placeholder="Nama" required>
						<span style="color:#e74c3c; font-size:small"><?= $validation->getError('nama');?></span>
					</div>
					<div class="column">
						<label for="keterangan">Kode</label>
						<input type="text" class="input" id="kode" name="kode" value="<?= old('kode');?>" placeholder="Kode" required>
						<span class="form-text" style="color:#e74c3c;"><?= $validation->getError('kode');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<label for="keterangan">Keterangan</label>
						<input type="text" class="input" id="keterangan" name="keterangan" value="<?= old('keterangan');?>" placeholder="Keterangan" required>
						<span style="color:#e74c3c; font-size:small"><?= $validation->getError('keterangan');?></span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="submit" class="button is-small is-success" >Submit</button>
				<button type="reset" class="button is-small is-danger" >Reset</button>
			</footer>
		</div>
	<?= form_close();?>
</div>

<!-- Modal Edit -->
<div class="modal" id="modalEdit">
	<div class="modal-background"></div>
	<?= form_open('/admin/pelayanan/update', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Edit Pelayanan <label id="titleEdit"></label></p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<input type="hidden" id="idEdit" name="idEdit" required>
				<div class="columns">
					<div class="column">
						<label for="namaEdit">Nama</label>
						<input type="text" class="input" id="namaEdit" name="namaEdit" value="<?= old('namaEdit');?>" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('namaEdit');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
					<label for="keterangan">Keterangan</label>
						<input type="text" class="input" id="keteranganEdit" name="keteranganEdit" value="<?= old('keteranganEdit');?>" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('keteranganEdit');?></span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="reset" class="button is-small is-danger">Reset</button>
				<button type="submit" class="button is-small is-success">Update</button>
			</footer>
		</div>
	<?= form_close();?>
</div>

<!-- Script Untuk Modal Supaya Berfungsi -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Functions to open and close a modal
  function openModal($el) {
    $el.classList.add('is-active');
  }

  function closeModal($el) {
    $el.classList.remove('is-active');
  }

  function closeAllModals() {
    (document.querySelectorAll('.modal') || []).forEach(($modal) => {
      closeModal($modal);
    });
  }

  // Add a click event on buttons to open a specific modal
  (document.querySelectorAll('.js-modal-trigger') || []).forEach(($trigger) => {
    const modal = $trigger.dataset.target;
    const $target = document.getElementById(modal);

    $trigger.addEventListener('click', () => {
      openModal($target);
    });
  });

  // Add a click event on various child elements to close the parent modal
  (document.querySelectorAll('.modal-background, .modal-close, .modal-card-head .delete, .modal-card-foot .button') || []).forEach(($close) => {
    const $target = $close.closest('.modal');

    $close.addEventListener('click', () => {
      closeModal($target);
    });
  });

  // Add a keyboard event to close all modals
  document.addEventListener('keydown', (event) => {
    const e = event || window.event;

    if (e.keyCode === 27) { // Escape key
      closeAllModals();
    }
  });
});
</script>

<!-- Script -->
<script>
	var base_url  = "<?= base_url();?>";
	var errorForm = "<?= session()->getFlashdata('errorForm');?>";
	var errorFormEdit = "<?= session()->getFlashdata('errorFormEdit');?>";


	$(document).ready(function(){
		// Membuat DataTable
		$('#tablePelayanan').DataTable();

		if(errorForm){
			alert("Data gagal ditambah, silahkan cek form");
		}

		if(errorFormEdit){
			alert("Data gagal diupdate, silahkan cek form")
		}
	});

	function hapusPelayanan(id, pelayanan){
		Swal.fire({
			title: 'Hapus Pelayanan?',
			text: 'Pelayanan '+pelayanan+' akan terhapus permanent',
			showDenyButton: true,
			confirmButtonText: 'Hapus',
			denyButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+'/admin/pelayanan/hapus/',
					type: "POST",
					data: {
						id:id
					},
					success:function(kembali){
						if(kembali==1){
							alert("Pelayanan Berhasil Dihapus");
						}else{
							alert("Pelayanan Gagal Dihapus");
						}
						setTimeout( function(){ window.location.reload(); }, 600);
					}
				});
			}
		});
	}

	function editPelayanan(id, nama, keterangan, kode){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#keteranganEdit').val(keterangan);
		$('#kodeEdit').val(kode);
		$('#titleEdit').html(nama);
	}
</script>