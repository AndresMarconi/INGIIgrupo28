<?php
class admin
{
	private $username;
	private $nombre;
	private $apellido;
	private $contraseña;
	private $email;
	private $residencias;
	private $reservas;

//Constructor
	public function __CONSTRUCT()
	{
		$this->residencias = new residenciaModel();
		$this->reservas = new reservaModel();
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
	
//Sesion
	public function acceso($contra){
		if (($this->__GET('contraseña') == $contra)){
			return true;
		} else {
			return false;
		}
	}

	public function login(){
		echo "<script languaje= 'javascript'>";
		echo "window.location='Admin/index.php';";
		echo "</script>";
	}

	public function cerrarSesion() {
		session_start();
		session_unset();
		session_destroy();
		echo "<script languaje= 'javascript'>";
		echo "window.location='../index.php';";
		echo "</script>";
		exit;
	}

	public function soyyo($nom){
		$bol = false;
		if ($this->__GET('username') == $nom) {
			$bol = true;
		}
		return $bol;
	}

//Otros
	public function nombre(){ return $str=($this->nombre.$this->apellido); }


//Residencias
	public function listarResidencias(){
		return $this->residencias->listar();
	}

	public function existeResi($resi){
		return $this->residencias->existe($resi);
	}

	public function obtenerResidencia($idresi){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}

	public function agregarResidencia($resi){
		$this->residencias->Registrar($resi);
		$this->residencias->ObtenerPorNombre($resi);
		echo "<script languaje= 'javascript'>";
		echo "alert ('residencia Registrada');";
		echo "window.location='index.php';";
		echo "</script>";
		return $resi;
	}

	public function eliminarResidencia($idresi){
		$this->residencias->eliminar($idresi);
	}

	public function guardarResidencia($resi){
		$this->residencias->Actualizar($resi);
		echo "<script languaje= 'javascript'>";
		echo "alert ('residencia Actualizada');";
		echo "window.location='index.php';";
		echo "</script>";
	}
   // fin de residencias

	//Subasta
	public function listarSubastas(){
		$filtro = " tipo = 'subasta' AND estado='1'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}


	public function listarSubastasEnEspera(){
		$filtro = " tipo = 'subasta' AND estado='2'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarDirectas(){
		$filtro = " tipo = 'directa' AND estado='1'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarHotSale(){
		$filtro = " tipo = 'HotSale' AND estado='1'";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarForHotSale(){
		$filtro = " tipo = 'StateReserva' AND estado = 1";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function listarXresidencia($idres){
		$filtro = "(r.idresidencia = ".$idres.") ORDER BY año, semana"; //AND((año > ".date('Y').") OR ((semana >= ".date('w').")AND(año = ".date('Y').")))";
		return $this->reservas->ListarReservasConFiltro($filtro);
	}

	public function obtenerReserva($idreserva){
		return $this->reservas->ObtenerRes($idreserva);
	}

	public function agregarSubasta($sub){
		$sub->__SET('numReserva', $this->reservas->sigId());
		$this->reservas->Registrar($sub, 'subasta');
		echo "<script languaje= 'javascript'>";
		echo "alert ('Subasta Registrada');";
		echo "window.location='index.php';";
		echo "</script>";
		return $sub;
	}

	public function agregarDirecta($dir){
		$dir->__SET('numReserva', $this->reservas->sigId());
		$this->reservas->Registrar($dir, 'directa');
		echo "<script languaje= 'javascript'>";
		echo "alert ('Reserva Registrada');";
		echo "window.location='index.php';";
		echo "</script>";
		return $dir;
	}

	public function publicarHotSale($numReserva, $precio){
		$res = $this->reservas->ObtenerRes($numReserva);
		$res->ponerEnHotsale($precio, date('Y-m-d'));
		$this->reservas->Actualizar($res);
	}

	public function cerrarSubasta($idreserva){
		$this->reservas->cerrar($idreserva);
	}

	public function abrirSubasta($idreserva){
		$this->reservas->abrir($idreserva);
	}

	public function existeReserva($idres, $semana, $año){
		return $this->reservas->existeReserva($idres, $semana, $año);
	}

	public function guardarSubasta($sub){
		$this->residencias->Actualizar($resi);
		echo "<script languaje= 'javascript'>";
		echo "alert ('residencia Actualizada');";
		echo "window.location='index.php';";
		echo "</script>";
	}
	// fin de subasta	
}