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
	$sub = $home->obtenerSubasta($_REQUEST['sub']);
	$resi = $sub->__GET('idResidencia');
	$navbar = "navbar".$usu->tipo().".html";
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include($navbar);
			include('subasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['pujar'])) {
	$sub = $home->obtenerSubasta($_REQUEST['sub']);
	if ($_POST['monto'] > $sub->pujaMaxima()) {
		$sub->pujar($_POST['monto'], $usu->__GET('username'));
		echo "<script languaje= 'javascript'>";
		echo "alert('La puja se realizo correctamente');";
		echo "window.location='subasta.php?sub=".$sub->__GET('numReserva')."';";
		echo "</script>";
	} else {
		echo "<script languaje= 'javascript'>";
		echo "alert('La puja debe ser mayor a la puja mayor');";
		echo "window.location='subasta.php?sub=".$sub->__GET('numReserva')."';";
		echo "</script>";
		}	
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