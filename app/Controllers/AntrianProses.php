<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Models\AntrianProsesModel;
use App\Models\PelayananProsesModel;

class AntrianProses extends BaseController{

	protected $antrianProsesModel, $pelayananProsesModel;
	public function __construct(){
		$this->antrianProsesModel = new AntrianProsesModel();
		$this->pelayananProsesModel = new PelayananProsesModel();
	}

	public function ambilAntrian(){
		$validation = [
			'id'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required|is_not_unique[pelayanan.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique'	=> 'ID Tidak Tersedia', 
				]
			],
		];

		if(!$this->validate($validation)){
			echo json_encode(0);
		}else{
			$id = $this->request->getPost('id');

			$antrianTerakhir = $this->antrianProsesModel->select('*')->where('pelayanan_id', $id)->like('tanggal', date('Y-m-d'))->orderBy('id', 'DESC')->limit(1)->get();

			if($antrianTerakhir->getNumRows()<1){

				$noAntrian = 1;
			}else{


				$antrianTerakhir = $antrianTerakhir->getRowArray();

				$noAntrian = $antrianTerakhir['no_antrian']+1;
			}

			$dataDatabase = [
				'tanggal' => date("Y-m-d H:i:s"),
				'no_antrian'	=> $noAntrian,
				'status'	=> 0,
				'waktu_panggil' => null,
				'waktu_selesai'	=> null,
				'pelayanan_id'	=> $id,
				'loket_id'			=> null,
			];

			$query = $this->antrianProsesModel->insert($dataDatabase);
			
			if($query){

				$detailPelayanan = $this->pelayananProsesModel->select('kode')->where('id', $id)->get()->getRowArray();
				
				$dataKembali = [
					'noAntrian' => $detailPelayanan['kode']."-".$noAntrian,
					'status'		=> 1
				];

				echo json_encode($dataKembali);
			}else{
				echo json_encode(0);
			}
		}
	}
}
