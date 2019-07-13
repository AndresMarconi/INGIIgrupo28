<?php
class StateReserva
{
	private $limite;
	private $historial;
	private $numReserva;

// Constructor
	public function __CONSTRUCT($num){
		$this->historial = new HistorialPujasModel();
		$this->numReserva = $num;
	}
//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function tipo(){
		return 'StateReserva';
	}

	public function boton($usu){
		return 'StateReserva';
	}

	public function fechaFinPublicacion($fechainicio){ //Tiempo que falta para cambio de estado
		return date_create('today');
	}

	public function pujaMaxima($p){ //Tiempo que falta para cambio de estado
		return 0;
	}

	public function ganador($p){ //Tiempo que falta para cambio de estado
		return 0;
	}

	public function vistaResi($estado){
		if ($estado) {
			return "Para poner en Hot Sale";
		} else {
			return " ";
		}
	}
}
?>