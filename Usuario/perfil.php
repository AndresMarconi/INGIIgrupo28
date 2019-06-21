<?php
	session_start();
	include('objetos.php');
	$home = new HomeSwitch();
	if (!isset($_SESSION['usu'])) {
		echo "<script languaje= 'javascript'>";
		echo "alert ('Debe iniciar sesion');";
		echo "window.location='../login.php';";
		echo "</script>";
	}
	$usu = $home->obtenerUsu($_SESSION['usu']);
	$navbar = "navbar".$usu->tipo().".html";
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include($navbar);
			include('perfil.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	function convertirAMes($mes){
		$año = substr($mes, 0, 4);
		$month = substr($mes, 5, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $month, 1);
		return date_format($fecha, 'Y-m');
	}

	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
	}

	if (isset($_REQUEST['solicito'])){
		$home->solicitoPremium($usu->__GET('username'));
		echo "<script languaje= 'javascript'>";
		echo "alert ('Se Registro tu solicitud');";
		echo "window.location='index.php';";
		echo "</script>";
	}

?>