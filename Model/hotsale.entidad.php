<?php
class HotSale extends StateReserva
{

// Constructor
	public function __CONSTRUCT($num){
		$this->historial = new HistorialPujasModel();
		$this->numReserva = $num;
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function tipo(){
		return 'HotSale';
	}

	public function boton($usu){
		return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VE Y APROVECHA EL HOTSALE</a></p>";
	}

	public function botonIr(){
		return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VER RESERVA HT</a></p>";
	}	

	public function vistaResi($estado){
		if ($estado) {
			return "Semana en Hot Sale";
		} else {
			return "Semana adquirida en Hot Sale";
		}
	}

	public function vistaReservar($res, $bol){
		if (!$res->__GET('estado')) {
            if ($bol) {
                $str = "<button class='btn btn-danger' type='submit' name='cancelar'>CANCELAR RESERVA</button>"; 
            } else {
                $str = "<h3>YA SE REALIZO LA RESERVA</h3>";        
            }
        } else {
            $str = "
					<h3> PRECIO: ".$res->__GET('precioBase')."</h3>
					<input type='hidden' name='monto' value='".$res->__GET('precioBase')."' />
            		<button class='btn btn-primary' type='submit' name='reservar'>ADQUIRIR HOT SALE</button>"; 
        }
        return $str;
	}

	public function reservar($usu, $monto){
		
		$this->historial->registrarPuja($this->__GET('numReserva'), $monto ,$usu->__GET('username'));

	}

	public function fechaInicioPublicacion($fechainicio){ //Tiempo que falta para cambio de estado
		$año = substr($fechainicio, 0, 4);
		$mes = substr($fechainicio, 5, 2);
		$dia = substr($fechainicio, 8, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $mes, $dia);
		return $fecha;
	}

	public function fechaFinPublicacion($fechainicio){ //Tiempo que falta para cambio de estado
		$año = substr($fechainicio, 0, 4);
		$mes = substr($fechainicio, 5, 2);
		$dia = substr($fechainicio, 8, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $mes, $dia);
		$fecha->add(new DateInterval("P1D"));
		return $fecha;
	}

	public function tiempoRes(){
		$año = substr($this->fechaInicio, 0, 4);
		$mes = substr($this->fechaInicio, 5, 2);
		$dia = substr($this->fechaInicio, 8, 2);
		return $año.$mes.$dia;
	}

	public function cancelarReserva($usu){
		$this->historial->eliminarPuja($this->__GET('numReserva') ,$usu->__GET('username'));
	}

	public function siguienteTipo($res){
		$res->__SET('state', new StateReserva($this->__GET('numReserva')));
	}

	public function pujaMaxima($pb){
		return $pb;
	}

	public function ganador($max){
		return $this->historial->ObtenerGanador($this->numReserva, $max);
	}
}
?>