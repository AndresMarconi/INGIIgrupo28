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
	$index = "index".$usu->tipo().".html";
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include($navbar);
				include($index);
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';
		
	if ($home->solicitudPendiente($usu)){
		$sol = $home->consultarEstadoSolicitud($usu->__GET('username'));
		if($sol->__GET('estado') == "aceptado"){
			echo "<script languaje= 'javascript'>";
			echo "alert ('Felicitaciones ".$usu->__GET('username')." ya sos premium!');";
			echo "</script>";
			$home->terminarSolicitud($usu->__GET('username'));
		}
		if($sol->__GET('estado') == "rechazado"){
			echo "<script languaje= 'javascript'>";
			echo "alert ('Su solicitud de plan premium fue rechazada');";
			echo "window.location='index.php';";
			echo "</script>";
			$home->terminarSolicitud($usu->__GET('username'));
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