<?php
class Reserva
{
	private $numReserva;
	private $idResidencia;
	private $residencia;
	private $fechainicio;
	private $año;
	private $semana;
	private $estado;
	private $precioBase;
	private $state;

// Constructor
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function cancelarSubasta($usu){
		$this->__GET('state')->cancelarReserva($usu);
	}

	public function disponibilidad(){
		switch ($this->__GET('estado')) {
			case 1:
				$str = 'disponible';
			break;
			case 0:
				$str = 'reservada';
			break;
			case 2:
				$str = 'esperando';
			break;
			default:
				$str='sigue sin estado';	
			break;
		}
		return $str;
	}

	public function tipo(){
		if (!$this->estado) {
			$str = 'reserva adquirida por: '.$this->ganador($this->pujaMaxima()) ;
		} else {
			$str = $this->__GET('state')->tipo();
		}
		return $str;
	}

	public function vistaResidencia(){
		return $this->__GET('state')->vistaResi($this->__GET('estado'));
	}

	public function boton($usu){
		return $this->__GET('state')->boton($usu);
	}

	public function botonIr(){
		return $this->__GET('state')->botonIr();
	}

	public function reservarVista($bol){
		return $this->__GET('state')->vistaReservar($this, $bol);
	}

	public function reservar($usu, $monto){
		return $this->__GET('state')->reservar($usu, $monto);
	}

	public function ganador($max){
		return $this->__GET('state')->ganador($max);
	}

	public function difereciaAHoy($fecha){
		$interval = $fecha->diff(new DateTime('today'));
		return $interval->format('%a');
	}

	public function fechaDeComienzo(){
		$dto = new DateTime();
  		$dto->setISODate($this->__GET('año'), $this->__GET('semana'));
  		return $dto->format('Y-m-d');
	}

	public function tiempoRestanteReserva(){ //Tiempo que falta para la semana
		$fecha = $this->fechaDeComienzo();
		$año = substr($fecha, 0, 4);
		$mes = substr($fecha, 5, 2);
		$dia = substr($fecha, 8, 2);
		$fecha = date_create();
		return $this->difereciaAHoy(date_date_set($fecha, $año, $mes, $dia));
	}

	public function arranquePublicacion(){
		return $this->__GET('state')->fechaInicioPublicacion($this->__GET('fechainicio'))->format('Y-m-d');
	}

	public function finEstadoActual(){ //Tiempo que falta para cambio de estado
		return $this->__GET('state')->fechaFinPublicacion($this->__GET('fechainicio'))->format('Y-m-d');
	}

	public function tiempoRestantePublicacion(){ //Tiempo que falta para cambio de estado
		return $this->difereciaAHoy($this->__GET('state')->fechaInicioPublicacion($this->__GET('fechainicio')));
	}

	public function cancelarReserva($usu){
		$this->__SET('estado', 1);
		$this->__GET('state')->cancelarReserva($usu);
		while ($this->cambioDeEstado()) {
		}
	}

	public function cambioDeEstado(){
		if($this->finEstadoActual() < date("Y-m-d")) {
			echo "<script languaje= 'javascript'>";
			echo "alert ('".$this->__GET('fechainicio')." debe actualizar ".$this->__GET('numReserva').$this->finEstadoActual()."');";
			echo "</script>";
			$this->__GET('state')->siguienteTipo($this);
			$bol = true;
		} else {
			$bol = false;
		}
		return $bol;
	}

	public function finDePublicacion(){
		if ($this->fechaDeComienzo() <= date("Y-m-d")) {
			echo "<script languaje= 'javascript'>";
			echo "alert ('termino la publicacion".$this->__GET('numReserva')."');";
			echo "</script>";
			$this->__SET('estado', 0);
			$bol = true;
		} else {
			$bol = false;
		}
		return $bol;
	}

	public function ponerEnHotsale($precio, $fecha){
		$this->__SET('state', new HotSale($this->__GET('numReserva')));
		$this->__SET('precioBase', $precio);
		$this->__SET('fechainicio', $fecha);
	}

	public function pujar($monto, $usu){
		return $this->__GET('state')->pujar($monto, $usu);
	}

	public function pujaMaxima(){
		return $this->__GET('state')->pujaMaxima($this->__GET('precioBase'));
	}
}
?>