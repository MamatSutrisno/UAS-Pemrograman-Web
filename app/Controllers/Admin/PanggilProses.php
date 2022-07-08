<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\AntrianProsesModel;

class PanggilProses extends BaseController{

	protected $antrianProsesModel;
	public function __construct(){
		$this->antrianProsesModel = new AntrianProsesModel();
	}
	
	public function panggil(){
		
		$validation = [
			'id'		=> [
				'label'	=> 'ID',
				'rules'	=> 'required|is_not_unique[antrian.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Id Tidak Ada' 
				]
			],
			'loketId'		=> [
				'label'	=> 'Loket Id',
				'rules'	=> 'required|is_not_unique[loket.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Loket Tidak Ada' 
				]
			],
		];

		if(!$this->validate($validation)){
			return redirect()->back()->withInput();
		}else{

			$id = $this->request->getPost('id');
			$loketId = $this->request->getPost('loketId');

			$kondisiCekLoketSibuk = [
				'status'	=> 1,
				'loket_id'=> $loketId
			];
			$cekLoketSibuk = $this->antrianProsesModel->select("*")->where($kondisiCekLoketSibuk)->get()->getNumRows();

			if($cekLoketSibuk>0){
				echo json_encode(0);
			}else{
				$detailAntrian = $this->antrianProsesModel->select("*")->where('id', $id)->get()->getRowArray();

				if($detailAntrian['status']==0){
					$dataUpdate = [
						'status' 				=> 1,
						'waktu_panggil'	=> date("Y-m-d H:i:s"),
						'loket_id'			=> $loketId,
					];

					$query = $this->antrianProsesModel->update($id, $dataUpdate);

					if($query){
						echo json_encode(1);
					}else{
						echo json_encode(0);
					}
				}else{
					echo json_encode(0);
				}
			}

		}
	}

	public function selesai(){
		// Rules Form Validation
		$validation = [
			'loketId'		=> [
				'label'	=> 'Loket Id',
				'rules'	=> 'required|is_not_unique[loket.id]',
				'errors'=> [
					'required' => 'Kolom Wajib Diisi',
					'is_not_unique' => 'Loket Tidak Ada' 
				]
			],
		];

		// Cek Validasi
		if(!$this->validate($validation)){
			
			// Jika Salah
			echo json_encode(0);
		}else{
			
			// Variabel From Form
			$loketId = $this->request->getPost('loketId');

			// Get Antrian terakhir yang dilayani loket dengan status=1
			$kondisi = [
				'status'	=> 1,
				'loket_id'=> $loketId
			];
			$getAntrianTerakhir = $this->antrianProsesModel->select("id")->where($kondisi)->orderBy('id', 'DESC')
			->limit(1)->get()->getRowArray();

			// Update status antrian ke 2 (selesai)
			$updateData = [
				'status'				=> 2,
				'waktu_selesai'	=> date("Y-m-d H:i:s"),
			];
			$kondisiUpdate = ['id'=>$getAntrianTerakhir['id']];
			$query = $this->antrianProsesModel->update($kondisiUpdate, $updateData);

			// Cek Eksekusi Query Update Berhasil
			if($query){
				echo json_encode(1);
			}else{
				echo json_encode(0);
			}
		}
	}
}
