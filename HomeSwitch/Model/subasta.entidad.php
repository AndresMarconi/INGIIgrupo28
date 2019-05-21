<?php
class Subasta extends Reserva
{
	private $precioBase;
	private $historial;

// Constructor
	public function __CONSTRUCT(){
		$this->historial = new HistorialPujasModel();
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function pujaMaxima(){
		$res = $this->historial->ObtenerPujaMaxima($this->numReserva);
		if (is_null($res)) {
			$res = $this->precioBase;
		}
		return $res;
	}

	public function ganador($max){
		$res = $this->historial->ObtenerGanador($this->numReserva, $max);
		if (is_null($res)) {
			$res = 'Aun no tiene';
		}
		return $res;
	}

	public function pujar($monto, $mail){
		$this->historial->registrarPuja($this->numReserva, $monto, $mail);
	}
}
?>