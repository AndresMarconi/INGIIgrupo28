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
	$usu = $home->obtenerUsu($_SESSION['usu']);
	$navbar = "navbar".$usu->tipo().".html";

	if (isset($_REQUEST['pa'])) {
		$pag = $_REQUEST['pa'];
	} else {
		$pag = 1;
	}

	$filtro=" ";
	if (isset($_POST['buscar'])) {
		$_REQUEST['unFil'] = null;
		if (!empty($_POST['tipo'])) {
			$add = " AND tipo = '".$_POST['tipo']."'";
			$filtro .= $add;
		}
		if (!empty($_POST['semana'])) {
			$año = substr($_POST['semana'], 0, 4);
			$semana = substr($_POST['semana'], 6, 2);
			$add = " AND año = ".$año." AND semana = ".$semana;
			$filtro .= $add;
		}
		if (!empty($_POST['pais'])) {
			$add = " AND pais = '".$_POST['pais']."'";
			$filtro .= $add;
		}
		if (!empty($_POST['ciudad'])) {
			$add = " AND ciudad = '".$_POST['ciudad']."'";
			$filtro .= $add;
		}
		if (!empty($_POST['habi'])) {
			$add = " AND cantpersonas = ".$_POST['habi'];
			$filtro .= $add;
		}
	}
	if ((isset($_REQUEST['unFil'])) && (!is_null($_REQUEST['unFil']))) {
		$filtro = $_REQUEST['unFil'];
	}
	$fil2 = $filtro;
	$ofset = $pag - 1;
	$pags = ceil($home->cantidadDePaginas($fil2));
	$filtro .= "LIMIT ".(5*$pag)." OFFSET ".(5*$ofset);

	echo '<!DOCTYPE html>'."\n";
	echo '<html>'."\n";
		include('head.html');
		echo '<body>'."\n";
			include($navbar);
			include('versubasta.html');
			include('footer.html');
		echo "\n".'</body>'."\n";
	echo '</html>';
	if (isset($_POST['limpiar'])){
		echo "<script languaje= 'javascript'>";
		echo "window.location='versubasta.php?p=1';";
		echo "</script>";
	}
	if (isset($_REQUEST['cerrar'])){
		$usu->cerrarSesion();
	}
	if (isset($_REQUEST['solicito'])){
		$home->solicitoPremium($usu->__GET('username'));
		echo "<script languaje= 'javascript'>";
		echo "alert ('Se Registro tu solicitud');";
		echo "window.location='index.php';";
		echo "</script>";
	}
?>