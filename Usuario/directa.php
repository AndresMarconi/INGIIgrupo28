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
	$dir = $home->obtenerDirecta($_REQUEST['dir']);
	$resi = $dir->__GET('idResidencia');
	$navbar = "navbar".$usu->tipo().".html";
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include($navbar);
			include('directa.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if(isset($_POST['reservar'])){
		if($usu->tieneTokensSuficientes()){
			$home->reservarDirecta($dir,$usu);
			echo "<script languaje= 'javascript'>";
			echo "alert ('Su reserva se realizo con exito');";
			echo "window.location='listadoResidencias.php';";
			echo "</script>";
		}
		else{
		echo "<script languaje= 'javascript'>";
		echo "alert ('Ya agoto sus reservas');";
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