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
			$dto = new DateTime();
  			$dto->setISODate($año, $semana);
  			$fecha = $dto->format('Y-m-d');
			$datetime1 = new DateTime('today');
			$interval = $datetime1->diff(new DateTime($fecha));

			if (($interval->format('%a'))>180) {
				if (isset($_POST['residencia'])) {
					if (!$adm->existeReserva($_POST['residencia'], $semana, $año)) {
						$sub = new directa();
						$sub->__SET('idResidencia', $_POST['residencia']);
						$sub->__SET('año', $año);
						$sub->__SET('semana', $semana);
						$sub->__SET('precioBase', $_POST['precioBase']);
						$adm->agregarDirecta($sub);
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
				echo "alert ('La fecha de inicio de reserva debe ser como minimo 6 meses posterior al dia de hoy');";
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
		$dto = new DateTime();
  		$dto->setISODate($año, $semana);
  		$fecha = $dto->format('Y-m-d');
		$datetime1 = new DateTime('today');
		$interval = $datetime1->diff(new DateTime($fecha));

		echo "<script languaje= 'javascript'>";
		echo "alert ('Ingrese ".$interval->format('%a')." Precio base');";
		echo "</script>";

	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
	
?>