<html>
<head>
	<title>Presensi Cloud</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Nunito" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
	<!-- Nucleo Icons -->
	<link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
	<link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
	<!-- Font Awesome Icons -->
	<link href="./assets/css/font-awesome.css" rel="stylesheet" />
	<link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
	<!-- CSS Files -->
	<link href="./assets/css/argon-design-system.css?v=1.2.2" rel="stylesheet" />
</head>
<style>
		html,p,b,u,a,i,h1,h2,h3,h4,h5,h6{
			font-family: 'Nunito', sans-serif;
		}
		body{
			background: #f0f0f0;
		}
		#customs{
			margin : 2% 0%;
		}
		.form-control{
			width:20%;
			height:4%;
			display:inline;
			margin : 0% 1%;
		}
		.card{
			margin :1% 2%;
			padding: 2%;
			border-radius: 1%;
			background: white;
			display:block;
			height:95%;
			box-shadow: 0 10px 10px 0 rgba(0,0,0,0.2);
		}
</style>
<body>
	<div class="card">
		<h2>Multi Schema Cloud</h2>
		<?php 
			include('connectdb.php');
			$mysqli = konek('localhost', 'root', '');
			if($mysqli->connect_errno) {
				echo "<h3 style='color: red; font-weight: bold'>Error Connect... ".$mysqli->connect_errno."\n</h3>";
				die();
			}else{
				echo "<h3 style='color: green; font-weight: bold'>Success... ".$mysqli->host_info."\n</h3>";
			}
			?>
		<form method="POST" enctype="multipart/form-data" action="simpan.php">
			<label>Nama Universitas : </label><input class="form-control" required type="text" name="nama"/><br><br>
			<div id="customs">
				<label>Custom Field </label><br><label>Nama : </label>
				<select name="entity[]" selected="Fakultas">
					<option value="fakultass">Fakultas</option>
					<option value="jadwals">Jadwal</option>
					<option value="jurusanss">Jurusan</option>
					<option value="kehadirans">Kehadiran</option>
					<option value="mahasiswas">Mahasiswa</option>
					<option value="matakuliahs">Mata Kuliah</option>
					<option value="matakuliahs_buka">Mata Kuliah Yang Buka</option>
					<option value="matakuliahs_kp">Kelas Pararel Mata Kuliah</option>
				</select>
				<label> &nbsp; Field : </label><input class="form-control" required type="text" name="field[]"/>
				<label> &nbsp; Tipe : </label>
				<select id='datatipe' name="typee[]" selected="Varchar / String Text">
					<option value="varchar(45)">Varchar / String Text</option>
					<option value="int">Integer / Number</option>
					<option value="datetime">Datetime</option>
					<option value="double">Double / Decimal Number</option>
				</select>
			</div>
			<div style="margin: -63px 0 0 67%;">
				<input class="btn btn-sm btn-outline-default btn-round" type="button" value="Add More Custom Field" id="addcustom"/>
				<input class="btn btn-sm btn-primary" type="submit" value="Daftar"/>
			</div>
		</form>
		<script type="text/javascript">
			$("#addcustom").click(function(){
				$("#customs").append("<div><label>Nama :&nbsp;</label>"+
				"<select  name='entity[]' selected='Fakultas'>"+
					"<option value='fakultass'>Fakultas</option>"+
					"<option value='jadwals'>Jadwal</option>"+
					"<option value='jurusanss'>Jurusan</option>"+
					"<option value='kehadirans'>Kehadiran</option>"+
					"<option value='mahasiswas'>Mahasiswa</option>"+
					"<option value='matakuliahs'>Mata Kuliah</option>"+
					"<option value='matakuliahs_buka'>Mata Kuliah Yang Buka</option>"+
					"<option value='matakuliahs_kp'>Kelas Pararel Mata Kuliah</option>"+
				"</select>"+
				"<label> &nbsp; &nbsp;Field :&nbsp; </label><input class='form-control' required type='text' name='field[]'/>"+
				"<label> &nbsp; Tipe :&nbsp; </label>"+
				"<select  name='typee[]' selected='Varchar / String Text'>"+
					"<option value='varchar'>Varchar / String Text</option>"+
					"<option value='int'>Integer / Number</option>"+
					"<option value='datetime'>Datetime</option>"+
					"<option value='double'>Double / Decimal Number</option>"+
				"</select> &nbsp;<input class='btn btn-sm btn-danger' type='button' value='Hapus' id='deletecustom'/></div>");
			});
			$('body').on('click', '#deletecustom', function(){
				$(this).parent().remove();
			});
		</script>
	</div>
</body>
</html>