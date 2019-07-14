<?php
	session_start();
	include('objetos.php');
	$home = new HomeSwitch();

	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('login.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	// pregunta de logeo
		if (isset($_POST['logeo'])){
		 	if ($_POST['nombre_usuario'] != "" and $_POST['password'] != ""){
		 		if ($_POST['tipo'] == 'usuario') {
		 			$usu = $home->obtenerUsu($_POST['nombre_usuario']);
		 			if($usu->acceso($_POST['password'])){
						$_SESSION['usu']= $_POST["nombre_usuario"];
						$_SESSION['dia']= date('Y-m-d');
						$home->checkday();
						$usu->login();
					} else {
						echo "<script languaje= 'javascript'>";
						echo "window.location='login.php';";
						echo "alert ('Datos de usuario incorrectos')";
						echo "</script>";
					}
		 		} else {
		 			$usu = $home->obtenerAdmin($_POST['nombre_usuario']);
		 			if($usu->acceso($_POST['password'])){
						$_SESSION['usu']=$_POST["nombre_usuario"];
						$_SESSION['dia']= date('Y-m-d');
						$home->checkday();
						$usu->login();
					} else {
						echo "<script languaje= 'javascript'>";
						echo "window.location='login.php';";
						echo "alert ('Datos de usuario incorrectos')";
						echo "</script>";
					}
		 		}
			} else {
				echo "<script languaje= 'javascript'>";
				echo "window.location='login.php';";
				echo "alert ('Complete todos los campos')";
				echo "</script>";
			}
		}
?>