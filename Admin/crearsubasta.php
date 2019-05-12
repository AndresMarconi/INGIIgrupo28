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
				include('crearsubasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['crearsubasta'])) {
		
		if (isset($_POST['residencia'])) {
			echo "<script languaje= 'javascript'>";
			echo "alert ('".$_POST['residencia']."');";
			echo "</script>";
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('seleccione una residencia');";
			echo "</script>";
		}

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}

	/*
		$resi = new Residencia();
		$resi->__SET('nombre', $_POST['nombre']);
		$resi->__SET('direccion', $_POST['direccion']);
		$resi->__SET('ciudad', $_POST['ciudad']);
		$resi->__SET('pais', $_POST['pais']);
		$resi->__SET('descripcion', $_POST['descripcion']);
		$resi->__SET('cantpersonas', $_POST['cantpersonas']);
		$adm->agregarResidencia($resi);
	*/
	}
?>