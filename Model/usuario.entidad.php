<?php
class usuario
{
	private $dni;
	private $nombre;
	private $apellido;
	private $contra;
	private $idciudad;
	private $ciudad;
	private $direccion;
	private $email;
	private $ntel;
	private $chat;
	private $plan;
	private $rutina;


// Constructor
	public function __CONSTRUCT()
	{
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

	public function cerrarSesion() {
		session_start();
		session_unset();
		session_destroy();
		echo "<script languaje= 'javascript'>";
		echo "window.location='index.html';";
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