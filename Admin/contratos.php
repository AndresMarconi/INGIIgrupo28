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
			include('contratos.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['actualizar'])) {
		if (($_POST['basico'] > 0)&&($_POST['premiun'] > 0)) {
			$home->actualizarPrecios($_POST['basico'], $_POST['premiun']);
			echo "<script languaje= 'javascript'>";
			echo "alert ('Precios actualizados correctamente');";
			echo "window.location='index.php';";
			echo "</script>";
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('Debe ingresar valores positivos');";
			echo "</script>";
		}
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
?>