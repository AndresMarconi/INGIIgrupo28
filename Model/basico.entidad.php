<?php
class Basico extends Usuario
{
	private $estado;


// Constructor
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
		public function tipo(){
		return "Basico";
	}

	public function verReservas($home){
		return $home->listarSubastasAbiertas();
	}
}
?>