<main class="container">
	<div class="columns" style="margin-top:3rem;">
			<div class="column is-12" style="text-align:center">
				<div class="card">
					<header class="card-header">
						<p class="card-header-title">Panggilan Antrian</p>
					</header>
					<div class="card-content">
						<div class="content" style="font-size:30px; font-weight:700;">
							<?= ($panggilTerakhir->getNumRows()<1)?"Tidak Ada":$panggilTerakhir->getRowArray()['kode']."-".$panggilTerakhir->getRowArray()['no_antrian'];?>
						</div>
					</div>
					<?php if($panggilTerakhir->getNumRows()>0){?>
						<footer class="card-footer">
							<p class="card-footer-item"><?= $panggilTerakhir->getRowArray()['nama_loket'];?></p>
						</footer>
					<?php } ?>
				</div>
		</div>
	</div>

	<!-- Daftar Loket & Nomor Antrian Aktif -->
	<div class="columns is-desktop">
		<?php foreach ($detailLoket as $row) {?>
			<div class="column" style="text-align:center;">
				<div class="card">
					<div class="card-content">
						<div class="content" style="font-size:24px; font-weight:700;">
						<?= loketLayani($row['id'], $row['kode']);?>
						</div>
					</div>
					<?php if($panggilTerakhir->getNumRows()>0){?>
						<footer class="card-footer">
							<p class="card-footer-item"><?= $row['nama'];?></p>
						</footer>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<!-- END Daftar Loket & Nomor Antrian Aktif -->

</main>