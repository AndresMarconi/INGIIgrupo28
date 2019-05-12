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

//Constructor
	public function __CONSTRUCT()
	{
		$this->residencias = new residenciaModel();
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
		echo "alert('entro');";
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

	public function obtenerResidencia($idresi){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}

	public function agregarResidencia($resi){
		$resi->__SET('idresidencia', $this->residencias->sigId());
		$this->residencias->Registrar($resi);
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
   // fin de planes
}