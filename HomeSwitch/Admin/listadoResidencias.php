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
				include('listadoResidencias.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_REQUEST['idElimRes'])) {
		if ($home->tieneReservas($_REQUEST['idElimRes'])) {
			$adm->eliminarResidencia($_REQUEST['idElimRes']);
			echo "<script languaje= 'javascript'>";
			echo "alert ('Residencia Eliminada');";
			echo "window.location='index.php';";
			echo "</script>";
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('No puede eliminar la residencia por que posee reservas abiertas');";
			echo "window.location='index.php';";
			echo "</script>";
		}
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
?>