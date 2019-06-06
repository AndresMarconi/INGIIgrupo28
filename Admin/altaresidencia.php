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
				if (isset($_REQUEST['idres'])) {
					$resi = $adm->obtenerResidencia($_REQUEST['idres']);
					include('modiresidencia.html');
				} else {
					include('altaresidencia.html');
				}
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['altaresidencia'])) {
		if (!empty($_POST['nombre'])&&!empty($_POST['direccion'])&&!empty($_POST['ciudad'])&&!empty($_POST['pais'])&&!empty($_POST['descripcion'])&&!empty($_POST['cantpersonas'])) {
			$resi = new Residencia();
			$resi->__SET('nombre', $_POST['nombre']);
			$resi->__SET('direccion', $_POST['direccion']);
			$resi->__SET('ciudad', $_POST['ciudad']);
			$resi->__SET('pais', $_POST['pais']);
			$resi->__SET('descripcion', $_POST['descripcion']);
			$resi->__SET('cantpersonas', $_POST['cantpersonas']);
			if (!$adm->existeResi($resi)) {
				$resi = $adm->agregarResidencia($resi);
				$resi->cargarImagen($_FILES['imagen1'], 1);
				$resi->cargarImagen($_FILES['imagen2'], 2);
				$resi->cargarImagen($_FILES['imagen3'], 3);
			} else {
				echo "<script languaje= 'javascript'>";
				echo "alert ('La residencia que esta intentando cargar ya existe');";
				echo "</script>";	
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('Debe completar todos los campos');";
			echo "</script>";
		}
	}

	if (isset($_POST['guardarresidencia'])) {
		if (!empty($_POST['nombre'])&&!empty($_POST['direccion'])&&!empty($_POST['ciudad'])&&!empty($_POST['pais'])&&!empty($_POST['descripcion'])&&!empty($_POST['cantpersonas'])) {
			if ((strcmp($resi->__GET('nombre'), $_POST['nombre']) == 0) && (strcmp($resi->__GET('direccion'), $_POST['direccion'])== 0)) {
				$resi->__SET('nombre', $_POST['nombre']);
				$resi->__SET('direccion', $_POST['direccion']);
				$resi->__SET('ciudad', $_POST['ciudad']);
				$resi->__SET('pais', $_POST['pais']);
				$resi->__SET('descripcion', $_POST['descripcion']);
				$resi->__SET('cantpersonas', $_POST['cantpersonas']);
				
				$resi->cargarImagen($_FILES['imagen1'], 1);
				$resi->cargarImagen($_FILES['imagen2'], 2);
				$resi->cargarImagen($_FILES['imagen3'], 3);
				$adm->guardarResidencia($resi);
			} else {
				$resi->__SET('nombre', $_POST['nombre']);
				$resi->__SET('direccion', $_POST['direccion']);
				$resi->__SET('ciudad', $_POST['ciudad']);
				$resi->__SET('pais', $_POST['pais']);
				$resi->__SET('descripcion', $_POST['descripcion']);
				$resi->__SET('cantpersonas', $_POST['cantpersonas']);
				if (!$adm->existeResi($resi)) {
					
					$resi->cargarImagen($_FILES['imagen1'], 1);
					$resi->cargarImagen($_FILES['imagen2'], 2);
					$resi->cargarImagen($_FILES['imagen3'], 3);
					$adm->guardarResidencia($resi);
				} else {
					echo "<script languaje= 'javascript'>";
					echo "alert ('La residencia que esta intentando cargar ya existe');";
					echo "</script>";	
				}
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('Debe completar todos los campos');";
			echo "</script>";
		}
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}
?>