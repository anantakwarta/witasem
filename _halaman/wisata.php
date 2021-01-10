<?php
  $title="Wisata";
  $judul=$title;
  $url='wisata';
if(isset($_POST['simpan'])){
	$file=upload('img','img');
	if($file!=false){
		$data['img']=$file;
		if($_POST['id_wisata']!=''){
			// hapus file di dalam folder
			$db->where('id_wisata',$_GET['id']);
			$get=$db->ObjectBuilder()->getOne('t_wisata');
			$img=$get->img;
			unlink('assets/unggah/img/'.$img);
			// end hapus file di dalam folder
		}
	}
	$data['nama_wisata']=$_POST['nama_wisata'];
	$data['id_kecamatan']=$_POST['id_kecamatan'];
	$data['lokasi']=$_POST['lokasi'];
	$data['lat']=$_POST['lat'];
	$data['lng']=$_POST['lng'];
	$data['deskripsi']=$_POST['deskripsi'];
	if($_POST['id_wisata']==""){
		$exec=$db->insert("t_wisata",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses Ditambah </div>';
		
	}
	else{
		$db->where('id_wisata',$_POST['id_wisata']);
		$exec=$db->update("t_wisata",$data);
		$info='<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses diubah </div>';
	}

	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan
              </div>');
	}
	redirect(url($url));
}

if(isset($_GET['hapus'])){
	$setTemplate=false;
	$db->where("id_wisata",$_GET['id']);
	$exec=$db->delete("t_wisata");
	$info='<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Sukses!</h4> Data Sukses dihapus </div>';
	if($exec){
		$session->set('info',$info);
	}
	else{
      $session->set("info",'<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Error!</h4> Proses gagal dilakukan
              </div>');
	}
	redirect(url($url));
}

elseif(isset($_GET['tambah']) OR isset($_GET['ubah'])){
  $id_wisata="";
  $nama_wisata="";
  $id_kecamatan="";
  $lokasi="";
  $lat="";
  $lng="";
  $deskripsi="";
  if(isset($_GET['ubah']) AND isset($_GET['id'])){
  	$id=$_GET['id'];
  	$db->where('id_wisata',$id);
      $row=$db->ObjectBuilder()->getOne('t_wisata');
	if($db->count>0){
        $id_wisata=$row->id_wisata;
		$nama_wisata=$row->nama_wisata;
		$id_kecamatan=$row->id_kecamatan;
		$lokasi=$row->lokasi;
		$lat=$row->lat;
		$lng=$row->lng;
		$deskripsi=$row->deskripsi;
	}
  }
  ?>
<?=content_open('Form Hotspot')?>
<form method="post" enctype="multipart/form-data">
    <?=input_hidden('id_wisata',$id_wisata)?>
        <div class="form-group">
            <label>Nama Wisata</label>
            <div class="row">
                <div class="col-md-4">
                    <?=input_text('nama_wisata',$nama_wisata)?>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Lokasi</label>
    		<div class="row">
                <div class="col-md-4">
                    <?=input_text('lokasi',$lokasi)?>
		    	</div>
	    	</div>
    	</div>
    	<div class="form-group">
    		<label>Nama Kecamatan</label>
    		<div class="row">
	    		<div class="col-md-6">
	    			<?php
	    				$op['']='Pilih Kecamatan';
	    				foreach ($db->ObjectBuilder()->get('m_kecamatan') as $row) {
	    					$op[$row->id_kecamatan]=$row->nm_kecamatan;
	    				}
	    			?>
	    			<?=select('id_kecamatan',$op,$id_kecamatan)?>
	    		</div>
    		</div>
    	</div>
    	<div class="form-group">
            <label>Titik Koordinat</label> 
    		<div class="row">
                <div class="col-md-3">
                    <?=input_text('lat',$lat)?>
	    		</div>
	    		<div class="col-md-3">
                    <?=input_text('lng',$lng)?>
	    		</div>
    		</div>
    	</div>
        <div class="form-group">
            <label>Deskripsi</label>
            <div class="row">
                <div class="col-md-4">
                    <?=textarea('deskripsi',$deskripsi)?>
                </div>
            </div>
        </div>
    	<div class="form-group">
    		<label>Gambar</label>
    		<div class="row">
	    		<div class="col-md-4">
    				<?=input_file('img','')?>
    			</div>
    		</div>
    	</div>
    	<div class="form-group">
    		<button type="submit" name="simpan" class="btn btn-info"><i class="fa fa-save"></i> Simpan</button>
			<a href="<?=url($url)?>" class="btn btn-danger" ><i class="fa fa-reply"></i> Kembali</a>
    	</div>
    </form>
<?=content_close()?>

<?php  } else { ?>
<?=content_open('Data Hotspot')?>

<a href="<?=url($url.'&tambah')?>" class="btn btn-success" ><i class="fa fa-plus"></i> Tambah</a>
<hr>
<?=$session->pull("info")?>

<table class="table table-bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama Wisata</th>
			<th>Lokasi</th>
			<th>Nama Kecamatan</th>
			<th>Lat</th>
			<th>Lng</th>
			<th>Deskripsi</th>
			<th>Gambar</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$no=1;
			$db->join('m_kecamatan b','a.id_kecamatan=b.id_kecamatan','LEFT');
			$getdata=$db->ObjectBuilder()->get('t_wisata a');
			foreach ($getdata as $row) {
				?>
					<tr>
						<td><?=$no?></td>
						<td><?=$row->nama_wisata?></td>
						<td><?=$row->lokasi?></td>
						<td><?=$row->nm_kecamatan?></td>
						<td><?=$row->lat?></td>
						<td><?=$row->lng?></td>
						<td><?=$row->deskripsi?></td>
						<td class="text-center"><?=($row->img==''?'-':'<img src="'.assets('unggah/img/'.$row->img).'" width="40px">')?></td>
						<td>
							<a href="<?=url($url.'&ubah&id='.$row->id_wisata)?>" class="btn btn-info"><i class="fa fa-edit"></i> Ubah</a>
							<a href="<?=url($url.'&hapus&id='.$row->id_wisata)?>" class="btn btn-danger" onclick="return confirm('Hapus data?')"><i class="fa fa-trash"></i> Hapus</a>
						</td>
					</tr>
				<?php
				$no++;
			}

		?>
	</tbody>
</table>
<?=content_close()?>
<?php } ?>