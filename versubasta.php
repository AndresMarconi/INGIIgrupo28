<?php
	include('objetos.php');
	$home = new HomeSwitch();

	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
			include('versubasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['pujar'])) {
		if (empty($_POST['email'.$_REQUEST['num']])) {
			echo "<script languaje= 'javascript'>";
			echo "alert('Debe ingresar un mail');";
			echo "window.location='versubasta.php';";
			echo "</script>";
		} else {
			$sub = $home->obtenerSubasta($_REQUEST['num']);
			if ($_POST['monto'] > $sub->pujaMaxima()) {
				$sub->pujar($_POST['monto'], $_POST['email'.$_REQUEST['num']]);
				echo "<script languaje= 'javascript'>";
				echo "alert('La puja se realizo correctamente');";
				echo "window.location='versubasta.php';";
				echo "</script>";
			} else {
				echo "<script languaje= 'javascript'>";
				echo "alert('La puja debe ser mayor a la puja mayor');";
				echo "window.location='versubasta.php';";
				echo "</script>";
			}	
		}
	}
?>