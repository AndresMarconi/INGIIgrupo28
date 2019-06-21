<?php
class HotSale extends Reserva
{

// Constructor
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function tipo(){
		if (!$this->estado) {
			$str = 'reserva realizada';
		} else {
			$str = 'Hot Sale';
		}
		
		return $str;
	}

	public function boton(){
		return "<p><a class='btn btn-primary' role='button' href='#'>VE Y APROVECHA EL HOTSALE</a></p>";
	}
}
?>