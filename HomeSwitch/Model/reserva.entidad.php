<?php
class Reserva
{
	private $numReserva;
	private $idResidencia;
	private $residencia;
	private $disponibilidadDesde;
	private $disponibilidadHasta;
	private $fechaInicio;
	private $estado;

// Constructor
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
}
?>