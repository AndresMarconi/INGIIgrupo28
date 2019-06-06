<?php
class admin
{
	private $dni;
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
		return $this->reservas->listarSubastas();
	}

	public function obtenerSubasta($idreserva){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}

	public function agregarSubasta($sub){
		$sub->__SET('numReserva', $this->reservas->sigId());
		$this->reservas->RegistrarSubasta($sub);
		echo "<script languaje= 'javascript'>";
		echo "alert ('Subasta Registrada');";
		echo "window.location='index.php';";
		echo "</script>";
		return $sub;
	}

	public function cerrarSubasta($idreserva){
		$this->reservas->cerrar($idreserva);
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