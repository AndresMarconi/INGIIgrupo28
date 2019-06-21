<?php
class usuario
{
	private $dni;
	private $nombre;
	private $apellido;
	private $contra;
	private $username;
	private $direccion;
	private $email;
	private $telefono;
	private $nroTarjeta;
	private $codSeg;
	private $vencimiento;
	private $tokens;


// Constructor
	public function __CONSTRUCT(){}

	//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function armar($datos){
		$this->__SET('nombre', $datos[0]);
		$this->__SET('apellido', $datos[1]);
		$this->__SET('username', $datos[2]);
		$this->__SET('contra', $datos[3]);
		$this->__SET('direccion', $datos[4]);
		$this->__SET('email', $datos[5]);
		$this->__SET('telefono', $datos[6]);
		$this->__SET('nroTarjeta', $datos[7]);
		$this->__SET('vencimiento', $datos[8]);
		$this->__SET('codSeg', $datos[9]);
	}



//session	
	public function acceso($contra){
		if (($this->__GET('contra') == $contra)){
			return true;
		} else {
			return false;
		}
	}

	public function login(){
		echo "<script languaje= 'javascript'>";
		echo "window.location='usuario/index.php';";
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


	public function listarReservasResidencia($home, $idresi){
		return $home->reservasDeResidenciaBasico($idresi);
	}

	public function listarReservasResidenciaAbiertas($home, $idresi){
		return $home->reservasDeResidenciaBasicoAbiertas($idresi);
	}

	public function tieneTokensSuficientes(){
		if($this->__GET('tokens') == 0){
			return false;
		}
		else{
			return true;
		}
	}


}