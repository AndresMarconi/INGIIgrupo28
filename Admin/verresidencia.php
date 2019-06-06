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
	$adm = $home->obtenerAdmin($_SESSION['usu']);
	$resi = $home->obtenerResidencia($_REQUEST['idres']);
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
				include('verresidencia.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
?>