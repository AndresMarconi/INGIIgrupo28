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
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
			include('versubasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['pujar'])) {
		$sub = $home->obtenerSubasta($_REQUEST['num']);
		if ($_POST['monto'] > $sub->pujaMaxima()) {
			$sub->pujar($_POST['monto'], $usu->__GET('username'));
			echo "<script languaje= 'javascript'>";
			echo "alert('La puja se realizo correctamente');";
			echo "window.location='versubasta.php';";
			echo "</script>";
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert('La puja debe ser mayor a la puja mayor');";
			echo "window.location='versubasta.php';";
			echo "</script>";
		}	
	}

	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
	}
?>