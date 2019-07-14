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
	if (isset($_GET['user'])) {
		$usu = $home->obtenerAdmin($_GET['user']);
	} else {
		$usu = new admin();
	}
	
	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include('navbar.html');
			include('regadmin.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';

	if (isset($_POST['cerrar'])){
		$adm->cerrarSesion();
	}

	if (isset($_POST['altaUsuario'])) {
		if ($home->existeUsuario($_POST['nick'])){
			echo "<script languaje= 'javascript'>";
			echo "alert ('El nombre de usuario ya esta ocupado');";
			echo "</script>";
		}else{
			$usu->__SET('username', $_POST['nick']);
			$usu->__SET('nombre', $_POST['nombre']);
			$usu->__SET('apellido', $_POST['apellido']);
			$usu->__SET('email', $_POST['mail']);
			$usu->__SET('contraseña', $_POST['contraseña']);
			$home->agregarAdmin($usu);
			echo "<script languaje= 'javascript'>";
			echo "alert ('Se registro el administrador correctamente');";
			echo "window.location='listadoAdmins.php';";
			echo "</script>";
		}	
	}

	if (isset($_POST['modUsuario'])) {
		$usu->__SET('username', $_POST['nick']);
		$usu->__SET('nombre', $_POST['nombre']);
		$usu->__SET('apellido', $_POST['apellido']);
		$usu->__SET('email', $_POST['mail']);
		$usu->__SET('contraseña', $_POST['contraseña']);
		if (!(strcmp($_POST['usuarioViejo'], $_POST['nick']) == 0)){
			if($home->existeAdmin($_POST['nick'])){
				echo "<script languaje= 'javascript'>";
				echo "alert ('El username se encuentra ocupado');";
				echo "window.location='regadmin.php?user=".$_POST['usuarioViejo']."';";
				echo "</script>";
			} else{
				$home->modificarAdmin($usu , $_POST['usuarioViejo']);
				$_SESSION['usu'] = $_POST['nick'];
				echo "<script languaje= 'javascript'>";
				echo "alert ('Se modifico correctamente');";
				echo "window.location='listadoAdmins.php';";
				echo "</script>";
			}
		} else {
			$home->modificarAdmin($usu , $_POST['usuarioViejo']);
			$_SESSION['usu'] = $_POST['nick'];
			echo "<script languaje= 'javascript'>";
			echo "alert ('Se modifico correctamente');";
			echo "window.location='listadoAdmins.php';";
			echo "</script>";
		}	
	}
?>