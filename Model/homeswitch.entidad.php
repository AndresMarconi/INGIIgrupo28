<?php
class HomeSwitch
{
	private $usuarios;
	private $admins;
	private $residencias;
	private $reservas;
	private $solicitudes;

	public function __CONSTRUCT()
	{
		$this->usuarios = new UsuarioModel();
		$this->admins = new AdminModel();
		$this->residencias = new residenciaModel();
		$this->reservas = new reservaModel();
		$this->solicitudes = new SolicitudesPremiumModel();
	}

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function checkday() {
		foreach ($this->listarReservasAbiertas() as $res):
			if($res->finDePublicacion() || $res->cambioDeEstado()){ // Devolver true-false y cambiar estado interno de $res
				$this->reservas->Actualizar($res);
			}
		endforeach;
	}
	
//ADMINS
	public function obtenerAdmin($idu){
		$adm = $this->admins->ObtenerAdmin($idu);
		if(($adm->__GET('username') != " ")){
			return $adm;
		} else {
			echo "<script languaje= 'javascript'>";
			echo "window.location='login.php';";
			echo "alert ('DNI Incorrecto')";
			echo "</script>";
		}
	}

	public function agregarAdmin($adm){
		$this->admins->Registrar($adm);
	}

	public function listarAdmins(){
		return $this->admins->listar();
	}

	public function existeAdmin($adm){
		return $this->admins->existe($adm);
	}

	public function modificarAdmin($adm , $admViejo){
		return $this->admins->Actualizar($adm , $admViejo);
	}

	public function EliminarAdmin($adm){
		return $this->admins->Eliminar($adm);
	}	

	public function actualizarPrecios($basico, $premiun){
		$this->admins->cambiarPrecios($basico, $premiun);
	}

	public function obtenerPrecioBasico(){
		return $this->admins->precioBasico();
	}

	public function obtenerPrecioPremium(){
		return $this->admins->precioPremium();
	}
//FIN ADMINS

//USUARIOS
	public function obtenerUsu($idu){
		$usu = $this->usuarios->Obtener($idu);
		if(($usu->__GET('dni') != " ")){
			return $usu;
		} else {
			echo "<script languaje= 'javascript'>";
			echo "window.location='login.php';";
			echo "alert ('DNI Incorrecto')";
			echo "</script>";
		}
	}

	public function agregarUsu($usu){
		$this->usuarios->Registrar($usu);
		echo "<script languaje= 'javascript'>";
		echo "alert ('Usuario Registrado')";
		echo "</script>";
	}

	public function listaUsuarios(){
		return $this->usuarios->listar();
	}

		public function existeUsuario($usu){
		return $this->usuarios->existe($usu);
	}

	public function modificarUsuario($usu , $usuViejo){
		return $this->usuarios->Actualizar($usu , $usuViejo);
	}
//FIN USUARIOS

//RESIDENCIAS
	public function obtenerResidencia($idresi){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}
	public function listarResidencias(){
		return $this->residencias->listar();
	}
//FIN DE RESIDENCIAS

//SOLICITUDES
	public function solicitoPremium($usu){
		$this->solicitudes->registrarSolicitud($usu);
	}
	public function solicitudPendiente($usu){
		return $this->solicitudes->tienePendiente($usu->__GET('username'));
	}
	public function listarSolicitudes(){
		return $this->solicitudes->listar();
	}
	public function aceptarPremium($usu){
		$this->solicitudes->contestarSolicitud($usu , "aceptado");
		$this->usuarios->ascenderPremium($usu);
	}
	public function rechazarPremium($usu){
		$this->solicitudes->contestarSolicitud($usu , "rechazado");
	}
	public function terminarSolicitud($usu){
		$this->solicitudes->terminarSolicitud($usu);
	}
	public function consultarEstadoSolicitud($usu){
		return $this->solicitudes->consultar($usu);
	}
//FIN SOLICITUDES

//RESERVAS
	public function obtenerSubasta($id){
		return $this->reservas->obtener($id, 'subasta');
	}

	public function obtenerDirecta($id){
		return $this->reservas->obtener($id, 'directa');
	}

	public function obtenerReserva($idreserva){
		return $this->reservas->ObtenerRes($idreserva);
	}

	public function tieneReservas($id){
		return $this->reservas->tieneReservas($id);
	}

	public function cantidadDePaginas($filtro){
		$aux=$this->reservas->cantidadDePublicaciones($filtro);
		return $aux/5;
	}

	public function laHizo($id, $usu){
		return $this->reservas->hizoReserva($id, $usu->__GET('username'));
	}

	public function reservar($dir, $usu, $monto){
		$dir->reservar($usu, $monto);
		$this->reservas->cerrar($dir->__GET('numReserva'));
		$this->usuarios->restarToken($usu->__GET('tokens') , $usu->__GET('username'));
	}

	public function cancelarReserva($dir,$usu){
		$dir->cancelarReserva($usu);
		$this->reservas->Actualizar($dir);
		$this->usuarios->sumarToken($usu->__GET('tokens') , $usu->__GET('username'));
	}

//LISTAR RESERVAS CON FILTRO
	public function listarSubastas(){
		$filtro = " tipo = 'subasta'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarReservasAbiertas(){
		$filtro = " estado = 1 ";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarReservasDeUsuario($usu){
		return $this->reservas->listarReservasUsuario($usu->__GET('username'));
	}

	public function listarSubastasAbiertas(){
		$filtro = " estado = 1 AND tipo = 'subasta'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarReservasAbiertasFiltro($filtro){
		$filtro = " estado = 1 AND tipo != 'StateReserva' ".$filtro;
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function reservasDeResidenciaBasico($idresi){
		$filtro = "(tipo != 'directa') AND (idresidencia = ".$idres.")AND((año > ".date('Y').") OR ((semana >= ".date('w').")AND(año = ".date('Y').")))";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function reservasDeResidenciaBasicoAbiertas($idresi){
		$filtro = "(estado = 1) AND (r.idresidencia = ".$idresi.")AND((año > ".date('Y').") OR ((semana >= ".date('w').")AND(año = ".date('Y').")))";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function reservasDeResidenciaPremiunAbiertas($idresi){
		$filtro = "(estado = 1) AND (r.idresidencia = ".$idresi.")AND((año > ".date('Y').") OR ((semana >= ".date('w').")AND(año = ".date('Y').")))";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}
//FIN DE LISTAR RESERVAS CON FILTRO
//FIN RESERVAS
}