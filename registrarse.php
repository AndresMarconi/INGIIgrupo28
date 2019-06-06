<?php
session_start(); 
include('objetos.php');
$home = new homeSwitch();
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
			if (isset($_REQUEST['username'])) {
				$usu = $home->obtenerUsu($_REQUEST['username']);
				$usuViejo = $_REQUEST['username'];
				
					include('Usuario/modusuario.html');
				} else {
					include('registrarse.html');
				}
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['altaUsuario'])) {
		$datos = array($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['username'], $_POST['contraseña'], $_POST['direccion'], $_POST['mail'], $_POST['telefono'], $_POST['nroTarjeta'], $_POST['vencimiento'], $_POST['codSeg']);
		$completo = true;
		foreach ($datos as $key):
			if (empty($key)) {
				$completo = false;
			}
		endforeach;
		if ($completo) {
			if ($home->existeUsuario($_POST['username'])){
				echo "<script languaje= 'javascript'>";
				echo "alert ('El nombre de usuario ya esta ocupado');";
				echo "</script>";
			}else{
				$usu = new usuario();
				$usu->armar($datos);
				$home->agregarUsu($usu);
				$_SESSION['usu']=$_POST["nombre_usuario"];
				$usu->login();
				echo "<script languaje= 'javascript'>";
				echo "alert ('Se modifico correctamente');";
				echo "window.location='Usuario/perfil.php';";
				echo "</script>";
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('incompleto');";
			echo "</script>";
		}
		
		
	}


	if (isset($_POST['modUsuario'])) {
		$datos = array($_POST['dni'], $_POST['nombre'], $_POST['apellido'], $_POST['username'], $_POST['contraseña'], $_POST['direccion'], $_POST['mail'], $_POST['telefono'], $_POST['nroTarjeta'], $_POST['vencimiento'], $_POST['codSeg']);
		$usu->armar($datos);
		$completo = true;
		foreach ($datos as $key):
			if (empty($key)) {
				$completo = false;
			}
		endforeach;
		if ($completo) {
			if (!(strcmp($_POST['usuarioViejo'], $_POST['username']) == 0)){
				if($home->existeUsuario($_POST['username'])){
					echo "<script languaje= 'javascript'>";
					echo "alert ('El username se encuentra ocupado');";
					echo "window.location='registrarse.php?username=".$_POST['usuarioViejo']."';";
					echo "</script>";
				}else{
					$home->modificarUsuario($usu , $_POST['usuarioViejo']);
				$_SESSION['usu'] = $_POST['username'];
				echo "<script languaje= 'javascript'>";
				echo "alert ('Se modifico correctamente');";
				echo "window.location='Usuario/perfil.php';";
				echo "</script>";
				}

			}
			else {
			
				$home->modificarUsuario($usu , $_POST['usuarioViejo']);
				$_SESSION['usu'] = $_POST['username'];
				echo "<script languaje= 'javascript'>";
				echo "alert ('Se modifico correctamente');";
				echo "window.location='Usuario/perfil.php';";
				echo "</script>";
			}
		} else {
			echo "<script languaje= 'javascript'>";
			echo "alert ('incompleto');";
			echo "</script>";
		}	
	}
?>