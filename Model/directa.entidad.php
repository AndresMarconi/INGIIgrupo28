<?php
class Directa extends StateReserva
{
	private $limite;
	private $historial;

// Constructor
	public function __CONSTRUCT($num){
		$this->historial = new HistorialPujasModel();
		$this->numReserva = $num;
	}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function tipo(){
		return "directa";
	}

	public function cancelarReserva($usu){
		$this->historial->eliminarPuja($this->__GET('numReserva') ,$usu->__GET('username'));
	}

	public function vistaResi($estado){
		if ($estado) {
			return "Semana disponible en reserva directa";
		} else {
			return "reserva Adquirida";
		}
	}

	public function boton($usu){
		if ($usu->tipo() == 'Premium') {
			return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VE Y RESERVALA</a></p>";
		} else {
			return "<button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModal'>VE Y RESERVALA
        </button>";
		}	
	}

	public function botonIr(){
		return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VER RESERVA</a></p>";
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
					<input type='hidden' name='monto' value='1' />
            		<button class='btn btn-primary' type='submit' name='reservar'>RESERVAR</button>"; 
        }
        return $str;
	}

	public function reservar($usu, $monto){
		$this->historial->registrarPuja($this->numReserva, $monto ,$usu->__GET('username'));
	}

	public function ganador($max){
		return $this->historial->ObtenerGanador($this->numReserva, $max);
	}

	public function pujaMaxima($pb){
		return 1;
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
		$fecha->add(new DateInterval("P6M"));
		return $fecha;
	}

	public function cumplioFecha(){
		if($this->tiempoRestantePublicacion() <= 0){
			return true;
		}
		else {
			return false;
		}
	}

	public function limite(){
		$año = substr($this->__GET('fechainicio'), 0, 4);
		$mes = substr($this->__GET('fechainicio'), 5, 2);
		$dia = substr($this->__GET('fechainicio'), 8, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $mes, $dia);
		$fecha->add(new DateInterval("P6M"));
		$interval = $fecha->diff(new DateTime('today'));
		return $interval->format('%a');
	}

	public function siguienteTipo($res){
		$res->__SET('state', new Subasta($this->__GET('numReserva')));
	} 
}
?>