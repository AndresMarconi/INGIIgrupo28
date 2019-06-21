<?php
session_start(); 
include('objetos.php');
$home = new homeSwitch();
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			if (isset($_REQUEST['username'])) {
				$usu = $home->obtenerUsu($_REQUEST['username']);
				$usuViejo = $_REQUEST['username'];
				$navbar = "navbar".$usu->tipo().".html";
				include($navbar);
				include('Usuario/modusuario.html');
			} else {
				include('navbar.html');
				include('registrarse.html');
			}
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	function convertirMes($mes){
		$año = substr($mes, 0, 4);
		$month = substr($mes, 6, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $month, 1);
		return date_format($fecha, 'Y-m-d');
	}

	function convertirAMes($mes){
		$año = substr($mes, 0, 4);
		$month = substr($mes, 5, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $month, 1);
		return date_format($fecha, 'Y-m');
	}

	function mesActual(){
		$date = new DateTime('today');
		return date_format($date, 'Y-m');
	}

	if (isset($_POST['prueba'])) {
		echo "<script languaje= 'javascript'>";
		echo "alert ('".convertirMes($_POST['vencimiento'])."');";
		echo "</script>";
	}

	if (isset($_POST['altaUsuario'])) {
		$datos = array($_POST['nombre'], $_POST['apellido'], $_POST['nick'], $_POST['contraseña'], $_POST['direccion'], $_POST['mail'], $_POST['telefono'], $_POST['nroTarjeta'], convertirMes($_POST['vencimiento']), $_POST['codSeg']);
		$completo = true;
		foreach ($datos as $key):
			if (empty($key)) {
				$completo = false;
			}
		endforeach;
		if ($completo) {
			if ($home->existeUsuario($_POST['nick'])){
				echo "<script languaje= 'javascript'>";
				echo "alert ('El nombre de usuario ya esta ocupado');";
				echo "</script>";
			}else{
				$usu = new usuario();
				$usu->armar($datos);
				$home->agregarUsu($usu);
				$_SESSION['usu']=$_POST["nick"];
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
		$datos = array($_POST['nombre'], $_POST['apellido'], $_POST['nick'], $_POST['contraseña'], $_POST['direccion'], $_POST['mail'], $_POST['telefono'], $_POST['nroTarjeta'], convertirMes($_POST['vencimiento']), $_POST['codSeg']);
		$usu->armar($datos);
		$completo = true;
		foreach ($datos as $key):
			if (empty($key)) {
				$completo = false;
			}
		endforeach;
		if ($completo) {
			if (!(strcmp($_POST['usuarioViejo'], $_POST['nick']) == 0)){
				if($home->existeUsuario($_POST['nick'])){
					echo "<script languaje= 'javascript'>";
					echo "alert ('El username se encuentra ocupado');";
					echo "window.location='registrarse.php?username=".$_POST['usuarioViejo']."';";
					echo "</script>";
				}else{
					$home->modificarUsuario($usu , $_POST['usuarioViejo']);
					$_SESSION['usu'] = $_POST['nick'];
					echo "<script languaje= 'javascript'>";
					echo "alert ('Se modifico correctamente');";
					echo "window.location='Usuario/perfil.php';";
					echo "</script>";
				}
			}
			else {
				$home->modificarUsuario($usu , $_POST['usuarioViejo']);
				$_SESSION['usu'] = $_POST['nick'];
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

	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
		echo "<script languaje= 'javascript'>";
		echo "window.location='index.php';";
		echo "</script>";
	}
?>