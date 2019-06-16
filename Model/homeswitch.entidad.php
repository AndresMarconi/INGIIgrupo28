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

	public function obtenerAdmin($idu){
		$adm = $this->admins->ObtenerAdmin($idu);
		if(($adm->__GET('dni') != " ")){
			return $adm;
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

	public function listarSubastas(){
		return $this->reservas->listar('subasta');
	}

	public function listarSubastasAbiertas(){
		return $this->reservas->listarAbiertas('subasta');
	}

	public function obtenerSubasta($id){
		return $this->reservas->obtener($id, 'subasta');
	}

	public function tieneReservas($id){
		return $this->reservas->tieneReservas($id);
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

	public function obtenerResidencia($idresi){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}

	public function listarResidencias(){
		return $this->residencias->listar();
	}
	public function solicitoPremium($usu){
		$this->solicitudes->registrarSolicitud($usu);

	}
	public function solicitudPendiente($usu){
		return $this->solicitudes->tienePendiente($usu->__GET('username'));

	}

	public function listarSolicitudes(){
		return $this->solicitudes->listar();
	}

}