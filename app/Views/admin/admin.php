<main class="container">
	<div class="columns" style="margin-top:2rem;">
		<div class="column is-12">
			<button class="button is-small is-primary js-modal-trigger" data-target="modalTambah" style="float:right;margin-right:1rem;">Tambah Admin</button>
		</div>
	</div>
	<div class="columns">
		<div class="column" style="margin-top:2rem;">
			<div style="overflow-x:auto;">
				<table id="tableAdmin">
					<thead>
						<tr>
							<th scope="col">No</th>
							<th scope="col">Nama</th>
							<th scope="col">Username</th>
							<th scope="col">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($admin as $row){?>
							<tr>
								<th scope="row"><?= $no++;?></th>
								<td><?= $row['nama'];?></td>
								<td><?= $row['username'];?></td>
								<td>
									<button type="button" class="button is-small is-danger" style="background-color:#e74c3c" onclick="hapusAdmin(<?= $row['id'];?>)">Hapus</button>
									<button type="button" class="button is-small is-warning js-modal-trigger" data-target="modalEdit" style="background-color:#f39c12" onclick="editAdmin(<?= $row['id'];?>, '<?= $row['nama'];?>', '<?= $row['password'];?>')">Edit</button>
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
	<?= form_open('/admin/tambah', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Tambah Admin</p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<div class="columns">
					<div class="column">
						<input id="nama" name="nama" type="text" class="input" value="<?= old('nama');?>" placeholder="Nama Admin" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('nama');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<input type="text" class="input" id="username" name="username" value="<?= old('username');?>" placeholder="Username" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('username');?></span>
					</div>
					<div class="column">
						<input type="password" class="input" id="password" name="password" value="<?= old('password');?>" placeholder="Password" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('password');?></span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button class="button is-small is-success" type="submit">Submit</button>
				<button class="button is-small is-danger" type="reset">Reset</button>
			</footer>
		</div>
	<?= form_close();?>
</div>

<!-- Modal Edit -->
<div class="modal" id="modalEdit">
	<div class="modal-background"></div>
	<?= form_open('/admin/update', 'autocomplate="off"'); ?>
		<div class="modal-card">
			<header class="modal-card-head">
				<p class="modal-card-title">Edit Admin <label id="titleEdit"></label></p>
				<button type="button" class="delete" aria-label="close"></button>
			</header>
			<section class="modal-card-body">
				<input type="hidden" id="idEdit" name="idEdit" required>
				<div class="columns">
					<div class="column">
						<input id="namaEdit" name="namaEdit" type="text" class="input" value="<?= old('namaEdit');?>" placeholder="Nama" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('namaEdit');?></span>
					</div>
				</div>
				<div class="columns">
					<div class="column">
						<input type="password" class="input" id="passwordEdit" name="passwordEdit" value="<?= old('passwordEdit');?>" placeholder="Password" required>
						<span style="color:#e74c3c; font-size:small;"><?= $validation->getError('passwordEdit');?></span>
					</div>
				</div>
			</section>
			<footer class="modal-card-foot">
				<button type="submit" class="button is-small is-success" style="background-color:#1abc9c">Update</button>
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

<script>
	var base_url  = "<?= base_url();?>";
	var errorForm = "<?= session()->getFlashdata('errorForm');?>";
	var errorFormEdit = "<?= session()->getFlashdata('errorFormEdit');?>";

	$(document).ready(function(){
		$('#tableAdmin').DataTable();

		if(errorForm){
			alert("Data Gagal Ditambahkan, silahkan cek form");
		}

		if(errorFormEdit){
			alert("Data gagal diupdate, silahkan cek form");
		}
	});

	function hapusAdmin(id){
		Swal.fire({
			title: 'Hapus Admin?',
			text: 'Admin akan terhapus permanent',
			showDenyButton: true,
			confirmButtonText: 'Hapus',
			denyButtonText: 'Batal',
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+'/admin/hapus/',
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
		})
	}

	function editAdmin(id, nama, password){
		$('#idEdit').val(id);
		$('#namaEdit').val(nama);
		$('#passwordEdit').val(password);
		$('#titleEdit').html(nama);
	}
</script>