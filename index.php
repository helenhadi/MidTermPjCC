<html>
<head>
	<title>Presensi Cloud</title>
	<script type="text/javascript" src="jquery-2.1.4.min.js"></script>
</head>
<body>
	<h2>Multi Schema Cloud</h2>
	<h3 style="color: red; font-weight: bold">
		<?php 
		include('connectdb.php');
		$mysqli = konek('localhost', 'root', '');
		echo "Success... ".$mysqli->host_info."\n";
		?>
	</h3>
	<form method="POST" enctype="multipart/form-data" action="simpan.php">
		<label>Nama Universitas </label><input type="text" name="nama"/><br><br>
		<div id="customs">
			<label>Custom Field </label><label>Entity: </label>
			<select  name="entity[]">
				<option value="fakultass">Fakultas</option>
				<option value="jadwals">Jadwal</option>
				<option value="jurusanss">Jurusan</option>
				<option value="kehadirans">Kehadiran</option>
				<option value="mahasiswas">Mahasiswa</option>
				<option value="matakuliahs">Mata Kuliah</option>
				<option value="matakuliahs_buka">Mata Kuliah Yang Buka</option>
				<option value="matakuliahs_kp">Kelas Pararel Mata Kuliah</option>
			</select>
			<label> Field: </label><input type="text" name="field[]"/>

		</div>
		<div style="margin-left: 25%;">
			<input type="button" value="Add More Custom Field" id="addcustom"/><br>
		</div>
		<div style="margin-left: 15%;">
			<input type="submit" value="Daftar"/>
		</div>
	</form>
	<script type="text/javascript">
		$("#addcustom").click(function(){
			$("#customs").append("<div style='margin-left: 6%;''><label>Entity: </label><select  name='entity[]'><option value='fakultass'>Fakultas</option><option value='jurusanss'>Jurusan</option><option value='kehadirans'>Kehadiran</option><option value='mahasiswas'>Mahasiswa</option><option value='matakuliahs'>Mata Kuliah</option><option value='matakuliahs_buka'>Mata Kuliah Yang Buka</option><option value='matakuliahs_kp'>Kelas Pararel Mata Kuliah</option></select><label> Field: </label><input type='text' name='field[]'/>&nbsp;<input type='button' value='Hapus' id='deletecustom'/></div>");
		});
		$('body').on('click', '#deletecustom', function(){
			$(this).parent().remove();
		});
	</script>
</body>
</html>