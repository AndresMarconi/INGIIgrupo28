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
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
				include('listadoAdmins.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}

	if (isset($_REQUEST['eliminar'])){
		$home->eliminarAdmin($_REQUEST['eliminar']);
		echo "<script languaje= 'javascript'>";
		echo "alert ('Administrador eliminado correctamente');";
		echo "window.location='listadoAdmins.php';";
		echo "</script>";
	}
?>