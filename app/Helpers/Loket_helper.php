<?php
	// Load Model
	$GLOBALS['model'] = new \App\Models\AntrianProsesModel;

	function loketLayani($loketId, $kode){
		$kondisi = [
			'status'  => 1,
			'loket_id'=> $loketId
		];

		$antrian = $GLOBALS['model']->select('no_antrian')->where($kondisi)->orderBY('id', 'DESC')->limit(1)->get();
		if($antrian->getNumRows()<1){
			return "Tidak Ada";
		}else{
			$antrian = $antrian->getRowArray();
			return $kode."-".$antrian['no_antrian'];
		}
	}

	function getTotalAntrian($id){
		$kondisi = [
			'status'  => 0,
			'pelayanan_id' => $id
		];
		$tgl = date("Y-m-d");

		return $GLOBALS['model']->select('COUNT(id) as jumlah')->where($kondisi)->like('tanggal', $tgl)->get()->getRowArray()['jumlah'];
	}