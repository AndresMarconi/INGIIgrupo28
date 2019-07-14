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
	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
	}
	$dir = $home->obtenerReserva($_REQUEST['dir']);
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
			$monto = $_POST['monto'];
			$home->reservar($dir,$usu,$monto);
			echo "<script languaje= 'javascript'>";
			echo "alert ('Su reserva se realizo con exito');";
			echo "window.location='verreservas.php';";
			echo "</script>";
		} else{
		echo "<script languaje= 'javascript'>";
		echo "alert ('Ya agoto sus reservas');";
		echo "</script>";
		}
	}

	if (isset($_POST['pujar'])) {
	$dir = $home->obtenerSubasta($_REQUEST['dir']);
	if ($_POST['monto'] > $dir->pujaMaxima()) {
		$dir->pujar($_POST['monto'], $usu->__GET('username'));
		echo "<script languaje= 'javascript'>";
		echo "alert('La puja se realizo correctamente');";
		echo "window.location='directa.php?dir=".$dir->__GET('numReserva')."';";
		echo "</script>";
	} else {
		echo "<script languaje= 'javascript'>";
		echo "alert('La puja debe ser mayor a la puja mayor');";
		echo "window.location='directa.php?dir=".$dir->__GET('numReserva')."';";
		echo "</script>";
		}	
	}

	if(isset($_POST['cancelar'])){
		$home->cancelarReserva($dir, $usu);
		echo "<script languaje= 'javascript'>";
		echo "alert ('La reserva se cancelo con exito');";
		echo "window.location='verreservas.php';";
		echo "</script>";
	}

	if(isset($_POST['rechazar'])){
		$dir->cancelarSubasta($usu);
		echo "<script languaje= 'javascript'>";
		echo "alert ('La reserva se cancelo con exito');";
		echo "window.location='verreservas.php';";
		echo "</script>";
	}	

	if (isset($_REQUEST['solicito'])){
		$home->solicitoPremium($usu->__GET('username'));
		echo "<script languaje= 'javascript'>";
		echo "alert ('Se Registro tu solicitud');";
		echo "window.location='index.php';";
		echo "</script>";
	}
?>