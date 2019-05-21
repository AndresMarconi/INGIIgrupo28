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
				include('crearsubasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['crearsubasta'])) {
		if ((isset($_POST['precioBase'])) && ($_POST['precioBase'] > 0)) {
			if ($_POST['fechaInicio'] > date('Y-m-d')) {
				if (isset($_POST['residencia'])) {
					$sub = new Subasta();
					$sub->__SET('idResidencia', $_POST['residencia']);
					$sub->__SET('fechaInicio', $_POST['fechaInicio']);
					$sub->__SET('precioBase', $_POST['precioBase']);
					$adm->agregarSubasta($sub);
				} else {
					echo "<script languaje= 'javascript'>";
					echo "alert ('Debe elegir una residencia');";
					echo "</script>";	
				}
			} else {
				echo "<script languaje= 'javascript'>";
				echo "alert ('La fecha debe ser posterior al dia de hoy');";
				echo "</script>";	
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('Ingrese Precio base');";
			echo "</script>";
		}
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
	
?>