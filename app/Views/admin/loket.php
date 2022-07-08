<main class="container">
	<div class="columns" style="margin-top:2rem;">
		<div class="column is-12">
			<a class="button is-small is-primary js-modal-trigger" data-target="modalTambah" style="float:right; margin-right:1rem;">Tambah Loket</a>
		</div>
	</div>
	<div class="columns">
		<div class="column" style="margin-top:2rem;">
			<div style="overflow-x:auto;">
				<table id="tableLoket">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Pelayanan</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($loket as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><a href="/admin/antrian/panggil/<?= $row['id'];?>"><?= $row['nama'];?></a></td>
								<td><?= $row['keterangan'];?></td>
								<td><?= $row['nama_pelayanan'];?></td>
								<td>
									<button type="button" class="button is-small is-danger" style="background-color:#e74c3c" onclick="hapusLoket(<?= $row['id'];?>, '<?= $row['nama'];?>')">Hapus</button>
									<button type="button" class="button is-small is-warning js-modal-trigger" data-target="modalEdit" style="background-color:#f39c12" onclick="editLoket(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['keterangan'];?>', <?= $row['pelayanan_id'];?>)">Edit</button>
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
	<?= form_open('/admin/loket/tambah', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Tambah Loket</p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<div class="columns">
					<div class="column">
						<input type="text" class="input" id="nama" name="nama" value="<?= old('nama');?>" placeholder="Nama" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('nama');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<input type="text" class="input" id="keterangan" name="keterangan" value="<?= old('keterangan');?>" placeholder="Keterangan" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('keterangan');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="select is-small">
							<select name="pelayanan" id="pelayanan" required>
								<option value="">~~~Pilih Pelayanan~~~</option>
								<?php foreach($pelayanan as $row){?>
									<option value="<?= $row['id'];?>"><?= $row['nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="submit" class="button is-small is-success">Submit</button>
				<button type="reset" class="button is-small is-danger">Reset</button>
			</footer>
		</div>
	<?= form_close();?>
</div>


<!-- Modal Edit -->
<div class="modal" id="modalEdit">
	<div class="modal-background"></div>
	<?= form_open('/admin/loket/update', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Edit Loket <label id="titleEdit"></label></p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<input type="hidden" name="idEdit" id="idEdit" required>
				<div class="columns">
					<div class="column">
						<input id="namaEdit" name="namaEdit" type="text" class="input" value="<?= old('namaEdit');?>" placeholder="Nama" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('namaEdit');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<input id="keteranganEdit" name="keteranganEdit" type="text" class="input" value="<?= old('keteranganEdit');?>" placeholder="Keterangan" required>
						<span style="color:#e74c3c; font-size:small"><?= $validation->getError('keteranganEdit');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<div class="select is-small">
							<select name="pelayananEdit" id="pelayananEdit" required>
								<option value="">~~~Pilih Pelayanan~~~</option>
								<?php foreach($pelayanan as $row){?>
									<option value="<?= $row['id'];?>"><?= $row['nama'];?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="submit" class="button is-small is-success">Update</button>
				<button type="reset" class="button is-small is-danger">Reset</button>
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
		$('#tableLoket').DataTable();

		// Jika Form Terdapat Error
		if(errorForm){
			alert("Data gagal ditambah, silahkan cek form");
		}

		// Jika Form Edit Terdapat Error
		if(errorFormEdit){
			alert("Data gagal diupdate, silahkan cek form")
		}

	});

	function hapusLoket(id, loket){
		Swal.fire({
			title: `Hapus Loket?`,
			text: `Loket ${loket} akan terhapus permanent`,
			openDenyButton: true,
			confirmButtonText: `Hapus`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/loket/hapus/`,
					type: "POST",
					data: {
						id:id
					},
					success:function(kembali){
						if(kembali==1){
							alert("Loket Berhasil Dihapus");
						}else{
							alert("Loket Gagal Dihapus");
						}
						setTimeout( function(){ window.location.reload(); }, 600);
					}
				});
			}
		});
	}

	function editLoket(id, nama, keterangan, pelayanan){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#keteranganEdit').val(keterangan);
		$('#pelayananEdit').val(pelayanan)
		$('#titleEdit').html(nama);
	}
</script>