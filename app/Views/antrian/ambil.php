<main class="container">
	<div class="columns">
		<div class="column is-12">
			<h2 style="text-align:center; font-size:24px; font-weight:700">Pilih Antrian</h2>
		</div>
	</div>

	<div class="columns">
		<?php foreach ($pelayanan as $row) {?>
			<div class="column" style="text-align:center">
				<div class="card">
					<header class="card-header">
						<p class="card-header-title"><?= $row['nama'];?></p>
					</header>
					<div class="card-content">
						<div class="content">
							<?= $row['keterangan'];?>
							<br>
							<button style="margin-top:1rem;" class="button is-small is-success" onclick="ambilAntrian(<?= $row['id'];?>)">Ambil Antrian</button>
						</div>
					</div>
					<footer class="card-footer">
						<p class="card-footer-item"><?= getTotalAntrian($row['id']);?> Antrian</p>
					</footer>
				</div>
			</div>
		<?php } ?>
	</div>
</main>

<script>
	var base_url = "<?= base_url();?>";
	function ambilAntrian(id){
		$.ajax({
			url: base_url+`/ambil-antrian`,
			type: "POST",
			data: {id:id},
			success:function(dataReturn){
				var responseData = $.parseJSON(dataReturn);
				if(responseData.status=='1'){
					alert('Berhasil, anda antrian ke '+responseData.noAntrian)
				}else{
					alert('Gagal,silahkan ulangi lagi '+responseData.noAntrian)
				}
				setTimeout( function(){ window.location.reload(); }, 500);
			}
		});
	}
</script>