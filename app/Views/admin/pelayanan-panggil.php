<main class="container">
	
	<div class="column" style="margin-top:2rem;">
		<div class="column" style="text-align:center;">
			<h2 style="font-size:24px;">Pelayanan <?= $detailLoket['nama'];?> (<?= $detailLoket['nama_pelayanan'];?>)</h2>
		</div>
	</div>

	<div class="columns">
		<!-- Tampilan Sedang Dilayani -->
		<div class="column" style="text-align:center;">
			<div class="card" style="background-color:#ecf0f1">
				<div class="card-content">
					<div class="content">
						<span>Sedang Dilayani</span>
						<h4><?= loketLayani(service('uri')->getSegment(4), $detailLoket['kode']);?></h4>
					</div>
				</div>
			</div>
			<br>
			<?php if(loketLayani(service('uri')->getSegment(4), $detailLoket['kode'])!="Tidak Ada"){?>
				<button type="button" class="button is-success" onclick="selesaiLayan(<?= service('uri')->getSegment(4);?>)">Selesai</button>
			<?php }?>
		</div>

		<!-- Daftar Antrian Selanjutnya -->
		<div class="column">
			<div>
				<h6 style="font-weight:500">Daftar Antrian Selanjutnya</h6>
			</div>
			<br>
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Antrian</th>
						<th scope="col">Panggil</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($antrian->getResultArray() as $row){?> 
						<tr>
							<th scope="row"><?= $row['kode'];?>-<?= $row['no_antrian'];?></th>
							<td>
								<?php if($row['status']==0){?>
									<button type="button" class="button is-small is-success" onclick="panggilAntrian(<?= $row['id'];?>, <?= service('uri')->getSegment(4);?>, '<?= $row['kode'];?>-<?= $row['no_antrian'];?>')">Panggil</button>
								<?php }else{?>
									<button type="button" class="button is-small is-warning" onclick="panggilLagi(<?= $row['id'];?>, '<?= $row['kode'];?>-<?= $row['no_antrian'];?>')">Panggil Lagi</button>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>

</main>

<script>
	var base_url = "<?= base_url();?>";

	$('#loket').addClass('active');

	// Memanggil nomor antrian baru
	function panggilAntrian(id, loketId, noAntrian) {
		$.ajax({
			url: base_url+"/admin/antrian/panggil-antrian",
			type: "POST",
			data: {
				id: id,
				loketId: loketId,
			},
			success:function(kembali){
				if(kembali==1){
					alert("Panggilan Nomor Antrian "+ noAntrian)
				}else{
					alert("Gagal Memanggil");
				}
				setTimeout( function(){ window.location.reload(); }, 1000);
			}
		});
	}

	// Memanggil Lagi Nomor Antrian yang sedang dilayani
	function panggilLagi(id, noAntrian) {
		alert("Panggilan Nomor Antrian "+ noAntrian)
	}

	function selesaiLayan(loketId) {
		Swal.fire({
			title: `Selesai?`,
			showDenyButton: true,
			confirmButtonText: `Iya`,
			denyButtonText: `Batal`,
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					url: base_url+`/admin/antrian/panggil/selesai`,
					type: "POST",
					data: {
						loketId: loketId
					},
					success:function(kembali){
						if(kembali==1){
							alert("Berhasil, silahkan layani antrian selanjutnya");
						}else{
							alert("Gagal, silahkan ulangi lagi")
						}
						setTimeout( function(){ window.location.reload(); }, 600);
					}
				});
			}
		})
	}
</script>