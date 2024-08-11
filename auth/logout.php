<?php
	session_start();
	unset($_SESSION['id_pegawai']);
	unset($_SESSION['jabatan_user']);
	session_destroy();
	header('location:../');
?>