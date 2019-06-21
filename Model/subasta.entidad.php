<?php
class Subasta extends Reserva
{
	private $historial;

// Constructor
	public function __CONSTRUCT(){
		$this->historial = new HistorialPujasModel();
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function tipo(){
		if (!$this->estado) {
			$str = 'reserva realizada';
		} else {
			$str = 'Subasta';
		}
		
		return $str;
	}

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

	public function pujar($monto, $usu){
		$this->historial->registrarPuja($this->numReserva, $monto, $usu);
	}

	public function boton(){
		return "<p><a class='btn btn-primary' role='button' href='subasta.php?sub=".$this->numReserva."'>VE A PUJAR</a></p>";
	}
}
?>