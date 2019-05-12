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
		$resi = new Residencia();

		$resi->__SET('nombre', $_POST['nombre']);
		$resi->__SET('direccion', $_POST['direccion']);
		$resi->__SET('ciudad', $_POST['ciudad']);
		$resi->__SET('pais', $_POST['pais']);
		$resi->__SET('descripcion', $_POST['descripcion']);
		$resi->__SET('cantpersonas', $_POST['cantpersonas']);

		$resi = $adm->agregarResidencia($resi);

		$resi->cargarImagen($_FILES['imagen1'], 1);
		$resi->cargarImagen($_FILES['imagen2'], 2);
		$resi->cargarImagen($_FILES['imagen3'], 3);
	}

	if (isset($_POST['guardarresidencia'])) {

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
	}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}

?>