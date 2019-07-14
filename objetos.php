<?php
	date_default_timezone_set('America/Argentina/Buenos_Aires');

	require_once 'Model/homeswitch.entidad.php';
	require_once 'Model/usuario.entidad.php';
	require_once 'Model/basico.entidad.php';
	require_once 'Model/premiun.entidad.php';
	require_once 'Model/usuario.model.php';
	require_once 'Model/admin.entidad.php';
	require_once 'Model/admin.model.php';
	require_once 'Model/residencia.entidad.php';
	require_once 'Model/residencia.model.php';
	require_once 'Model/state.entidad.php';
	require_once 'Model/reserva.entidad.php';
	require_once 'Model/reserva.model.php';
	require_once 'Model/directa.entidad.php';
	require_once 'Model/subasta.entidad.php';
	require_once 'Model/hotsale.entidad.php';
	require_once 'Model/solicitudes.model.php';
	require_once 'Model/historial.model.php';
	require("Model/class.phpmailer.php");
	require("Model/class.smtp.php");
	require("Model/class.envio.php");
?>