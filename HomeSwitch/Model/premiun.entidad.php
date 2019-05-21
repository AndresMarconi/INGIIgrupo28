<?php
class Premiun extends Usuario
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
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
?>