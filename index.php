<!-- Nama Kelompok:
1. Jackly Christanto Perdana (160418027)
2. Helen Hadi (160418084) -->
<?php
	session_start();
	if (!isset($_SESSION['username']) && !isset($_SESSION['nama']) && !isset($_SESSION['jabatan'])) {
		header("location: login.php");
	}else{
		header("location: dashboard.php");
	}
?>