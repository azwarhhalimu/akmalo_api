<?php

class SiteController extends Controller
{
		function actionData_kontak()
		{
			$query=query("SELECT * FROM kontak ORDER BY no DESC")->query();
			$data=array();
			foreach($query as $query):
				$kategori=query('SELECT * FROM kategori_kontak WHERE id_kategori_kontak="'.$query['id_kategori_kontak'].'"')->queryRow();
				$data[]=array(
					'id_kontak'=>$query['id_kontak'],
					'nomor_induk'=>$query['nim'],
					'nama'=>$query['nama'],
					'nomor_handphone'=>$query['no_handphone'],
					'kategori_kontak'=>$kategori['nama_kategori_kontak']
				);
			endforeach;
			echo json_encode(array(
				'data'=>$data
			));
		}
		function actionSimpan_kontak()
		{
			$id=rand(1000000000,9999999999);
			$model=new  KontakTbl();
			$model->id_kontak=$id;
			$model->nim=$_POST['nomor_induk'];
			$model->nama=$_POST['nama'];
			$model->no_handphone=$_POST['nomor_handphone'];
			$model->id_kategori_kontak=$_POST['id_kategori_kontak'];

			$x=$model->save();
			if($x)
			{
				echo json_encode(array(
					'status'=>'data_tersimpan'
				));
			}
			else{
				echo json_encode(array(
					'status'=>'data_gagal_tersimpan'
				));
			}
		}
		function actionEdit_kontak()
		{
			
			$model=  KontakTbl::model()->findByAttributes(array(
				'id_kontak'=>$_POST['id_kontak']
			));
			$model->nim=$_POST['nomor_induk'];
			$model->nama=$_POST['nama'];
			$model->no_handphone=$_POST['nomor_handphone'];
			$model->id_kategori_kontak=$_POST['id_kategori_kontak'];

			$x=$model->save();
			if($x)
			{
				echo json_encode(array(
					'status'=>'data_tersimpan'
				));
			}
			else{
				echo json_encode(array(
					'status'=>'data_gagal_tersimpan'
				));
			}
		}

		function actionHapus_kontak()
		{
			$query=query("DELETE FROM kontak WHERE id_kontak='".$_POST['id_kontak']."'")->execute();
			if($query)
			{
				echo json_encode(array(
					'status'=>'data_terhapus'
				));
			}
		}

		function actionGet_kontak()
		{
			$query=query("SELECT * FROM kontak WHERE id_kontak='".$_POST['id_kontak']."'")->queryRow();
			$kategori=query('SELECT * FROM kategori_kontak WHERE id_kategori_kontak="'.$query['id_kategori_kontak'].'"')->queryRow();
				
			echo json_encode(array(
				'id_kontak'=>$query['id_kontak'],
					'nomor_induk'=>$query['nim'],
					'nama'=>$query['nama'],
					'nomor_handphone'=>$query['no_handphone'],
					'kategori_kontak'=>$kategori['id_kategori_kontak']
			));
		}
		function actionKategori_kontak()
		{
			$query=query("SELECT * FROM kategori_kontak ORDER BY no desc")->query();
			$data=array();
			foreach($query as $query):
				$data[]=array(
					'id'=>rand(1000,9999),
					'id_kategori_kontak'=>$query['id_kategori_kontak'],
					'nama_kategori_kontak'=>$query['nama_kategori_kontak']
				);
			endforeach;
			echo json_encode(array(
				'data'=>$data
			));
		}

		function actionGet_kategori_kontak()
		{
			$query=query("SELECT * FROM kategori_kontak WHERE id_kategori_kontak='".$_POST['id_kategori_kontak']."'")->queryRow();
			echo json_encode(array(
				'id_kategori_kontak'=>$query['id_kategori_kontak'],
				'nama_kategori_kontak'=>$query['nama_kategori_kontak']
			));
		}

		function actionSimpan_kategori_kontak()
		{
			$model=new Kategori_kontakTbl();
			$id=rand(1000000000,9999999999);
			$model->id_kategori_kontak=$id;
			$model->nama_kategori_kontak=$_POST['nama_kategori_kontak'];
			$x=$model->save();
			if($x)
			{
				echo json_encode(array(
					'status'=>'data_tersimpan'
				));
			}
		}
		function actionUpdate_kategori_kontak()
		{
			$model= Kategori_kontakTbl::model()->findByAttributes(array(
				'id_kategori_kontak'=>$_POST['id_kategori_kontak']
			));
			$model->nama_kategori_kontak=$_POST['nama_kategori_kontak'];
			$x=$model->save();
			if($x)
			{
				echo json_encode(array(
					'status'=>'data_update'
				));
			}
		}

		function actionHapus_kategori_kontak()
		{
			$id_kategori_kontak=$_POST['id_kategori_kontak'];
			$query=query("DELETE FROM kategori_kontak WHERE id_kategori_kontak='".$id_kategori_kontak."'")->execute();
			if($query)
			{
				echo json_encode(array(
					'status'=>'data_terhapus'
				));
			}
		}


		function actionPilih_kontak()
		{
			$kategori_kontak=array();
			$query=query("SELECT * FROM kategori_kontak ORDER BY no DESC")->query();
			foreach($query as $query):
				$kategori_kontak[]=array(
					'id_kategori_kontak'=>$query['id_kategori_kontak'],
					'nama_kategori_kontak'=>$query['nama_kategori_kontak']
				);
			endforeach;
			$ar_kontak=array();
			$kontak=query('SELECT * FROM kontak ORDER BY no DESC')->query();
			foreach($kontak as $kontak):
				$ar_kontak[]=array(
					'id_kontak'=>$kontak['id_kontak'],
					'nim'=>$kontak['nim'],
					'nama'=>$kontak['nama'],
					'no_handphone'=>$kontak['no_handphone']
				);
			endforeach;
			echo json_encode(array(
				'kategori_kontak'=>$kategori_kontak,
				'kontak'=>$ar_kontak
			));
		}


		
	
}