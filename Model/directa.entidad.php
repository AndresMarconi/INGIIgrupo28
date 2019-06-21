<?php
class Directa extends Reserva
{
	private $limite;
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
			$str = 'Directa';
		}
		return $str;
	}

	public function boton($usu){
		if ($usu->tipo() == 'Premium') {
			return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VE Y RESERVALA</a></p>";
		} else {
			return "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>VE Y RESERVALA
        </button>";
		}
		
	}

	public function reservar($usu){
		$this->historial->registrarPuja($this->numReserva, 1 ,$usu->__GET('username'));
	}

	public function ganador(){
		return $this->historial->ObtenerGanador($this->numReserva, 1);
	}
}
?>