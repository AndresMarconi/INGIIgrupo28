<?php
	include('objetos.php');
	$home = new HomeSwitch();
	$resi = $home->obtenerResidencia($_REQUEST['idres']);
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
			include('verresidencia.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
	}
?>