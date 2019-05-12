<?php
	session_start();
	include('objetos.php');
	$home = new HomeSwitch();
	$adm = $home->obtenerAdmin($_SESSION['usu']);

	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
				include('index.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_REQUEST['idElimRes'])) {
		$adm->eliminarResidencia($_REQUEST['idElimRes']);
		echo "<script languaje= 'javascript'>";
		echo "alert ('Residencia Eliminada');";
		echo "window.location='index.php';";
		echo "</script>";
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
?>