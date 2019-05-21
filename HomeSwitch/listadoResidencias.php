<?php
	include('objetos.php');
	$home = new HomeSwitch();
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
				include('listadoResidencias.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';
?>