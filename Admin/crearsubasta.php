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
			$año = substr($_POST['fechaInicio'], 0, 4);
			$semana = substr($_POST['fechaInicio'], 6, 2);
			$currentWeek=date('W'); $currentYear=date('Y');
			if (($año > $currentYear)||(($año=$currentYear)&&($semana>$currentWeek))) {
				if (isset($_POST['residencia'])) {
					if (!$adm->existeReserva($_POST['residencia'], $semana, $año)) {
						$sub = new Subasta();
						$sub->__SET('idResidencia', $_POST['residencia']);
						$sub->__SET('año', $año);
						$sub->__SET('semana', $semana);
						$sub->__SET('precioBase', $_POST['precioBase']);
						$adm->agregarSubasta($sub);
					} else {
						echo "<script languaje= 'javascript'>";
						echo "alert ('ya existe reserva para esta propiedad en esa fecha');";
						echo "</script>";
					}
				} else {
					echo "<script languaje= 'javascript'>";
					echo "alert ('Debe elegir una residencia');";
					echo "</script>";	
				}
			} else {
				echo "<script languaje= 'javascript'>";
				echo "alert ('La semana debe ser posterior a la actual');";
				echo "</script>";	
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('Ingrese Precio base');";
			echo "</script>";
		}
	}

	if (isset($_POST['prueba'])) {
		$año = substr($_POST['fechaInicio'], 0, 4);
		$semana = substr($_POST['fechaInicio'], 6, 2);
		$currentWeek=date('W'); $currentYear=date('Y');
		if (($año > $currentYear)||(($año=$currentYear)&&($semana>$currentWeek))) {
			if (!$adm->existeReserva($_POST['residencia'], $semana, $año)) {
				echo "<script languaje= 'javascript'>";
				echo "alert ('la semana no existe');";
				echo "</script>";
			} else {
				echo "<script languaje= 'javascript'>";
				echo "alert ('reserva ya existe');";
				echo "</script>";
			}
		}	else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('La semana debe ser posterior a la actual');";
			echo "alert ('".$año.$semana."current".date('W').date('Y')."');";
			echo "</script>";	
		}
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
	
?>