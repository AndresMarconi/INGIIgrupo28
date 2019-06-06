<?php
class usuario
{
	private $dni;
	private $nombre;
	private $apellido;
	private $contra;
	private $username;
	private $ciudad;
	private $direccion;
	private $email;
	private $telefono;
	private $nroTarjeta;
	private $codSeg;
	private $vencimiento;

// Constructor
	public function __CONSTRUCT(){}

	public function armar($datos){
		$this->dni = $datos[0];
		$this->nombre = $datos[1];
		$this->apellido = $datos[2];
		$this->username = $datos[3];
		$this->contra = $datos[4];
		$this->direccion = $datos[5];
		$this->email = $datos[6];
		$this->telefono = $datos[7];
		$this->nroTarjeta = $datos[8];
		$this->vencimiento = $datos[9];
		$this->codSeg = $datos[10];
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

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

//Chat
	public function iniciarChat(){
		$this->chat = new chat($this->nombre());
	}

	public function leerChat(){
		$this->chat->leerChat();
	}

	public function escribir($mensaje){
		$txt = "<p class='lead text-right border rounded' style='background-color: #0bf114;padding: 10px;'>".$mensaje."</p>\n";
		$this->chat->escribir($txt);
	}

//otros
	public function nombre(){ return $str=($this->nombre.$this->apellido); }

	public function miplan(){
		return $this->plan->miEstado();
	}

	public function asignarPlan($nroplan){
		$this->plan->__SET('nroplan', $nroplan);
		$this->plan->__SET('actual', 1);
		$this->plan->__SET('estado', 'activo');	
	}

	public function asignarRutina($nrorut){
		$this->rutina->__SET('nrorutina', $nrorut);
		$this->rutina->__SET('actual', 1);
		$this->rutina->__SET('estado', 'activo');	
	}

}