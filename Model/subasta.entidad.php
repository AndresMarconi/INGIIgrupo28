<?php
class Subasta extends StateReserva
{
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
		return 'subasta';
	}

	public function vistaResi($estado){
		if (!$estado) {
			return "cerro la subasta con ganador";
		} else {
			if ($estado == 1) {
				return "Semana con Subasta Abierta";
			} else {
				return "cerro la subasta esperando que acepte el ganador";
			}
		}
	}

	public function vistaReservar($res, $bol){
		$max = $res->pujaMaxima();
		if ($res->__GET('estado') == 1) {
			$str = "";
            if ($_SESSION['usu'] == $this->ganador($this->pujaMaxima(1))) {
            	$str .= "<h1>Tu puja es la mayor Hasta el momento</h1>";
            }
			$str .= "
			<h1>PUJA ACTUAL</h1>
	        <h1>".$max."</h1><br><br>
	        <form class='d-flex flex-column' method='post' action='?sub=".$res->__GET('numReserva')."'>
	            <input class='border rounded-0 form-control' type='number' step='0.25' placeholder='ingrese su puja' name='monto'>
	            <button class='btn btn-primary' type='submit' name='pujar'>PUJAR</button>
	        </form>";
	        if ($bol) {
	        	$str .= "<button class='btn btn-danger' type='submit' name='rechazar'>CANCELAR PUJAS</button>";
	        }
        } else {
        	if ($_SESSION['usu'] == $this->ganador($this->pujaMaxima(1))) {
            	if ($res->__GET('estado') == 2) {
            		$str = "<h1>HAS GANADO LA SUBASTA CON TU PUJA DE ".$max."</h1><br>
            				<input type='hidden' name='monto' value='0' />
            				<button class='btn btn-primary' type='submit' name='reservar'>ACEPTAR RESERVA</button>
            				<button class='btn btn-danger' type='submit' name='rechazar'>RECHAZAR RESERVA</button>";
            	} else {
            		$str = "<button class='btn btn-danger' type='submit' name='cancelar'>CANCELAR RESERVA</button>";	
            	} 
            } else {
            	if ($res->__GET('estado') == 2) {
            		$str = "LA SUBASTA TERMINO PERO AUN NO SE HA ACEPTADO POR EL GANADOR";
            	} else {
                	$str = "<h3>YA SE REALIZO LA RESERVA</h3>";
                }        
            }
        }
        return $str;
	}

	public function fechaInicioPublicacion($fechainicio){ //Tiempo que falta para cambio de estado
		$año = substr($fechainicio, 0, 4);
		$mes = substr($fechainicio, 5, 2);
		$dia = substr($fechainicio, 8, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $mes, $dia);
		$fecha->add(new DateInterval("P6M"));
		$fecha->add(new DateInterval("P1D"));
		return $fecha;
	}

	public function fechaFinPublicacion($fechainicio){ //Tiempo que falta para cambio de estado
		$año = substr($fechainicio, 0, 4);
		$mes = substr($fechainicio, 5, 2);
		$dia = substr($fechainicio, 8, 2);
		$fecha = date_create();
		date_date_set($fecha, $año, $mes, $dia);
		$fecha->add(new DateInterval("P6M"));
		$fecha->add(new DateInterval("P4D"));
		return $fecha;
	}

	public function pujaMaxima($precio){
		$res = $this->historial->ObtenerPujaMaxima($this->numReserva);
		if (is_null($res)) {
			$res = $precio;
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

	public function cancelarReserva($usu){
		$this->historial->eliminarPuja($this->__GET('numReserva') ,$usu->__GET('username'));
	}

	public function reservar($usu, $monto){
			
	}

	public function boton($usu){
		return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VE A PUJAR</a></p>";
	}

	public function botonIr(){
		return "<p><a class='btn btn-primary' role='button' href='directa.php?dir=".$this->numReserva."'>VER SUBASTA</a></p>";
	}
	
	public function siguienteTipo($res){
		$max = $this->pujaMaxima(0);
        $ganador = $this->ganador($max);
        $var2="Aun no tiene";
        echo "<script languaje= 'javascript'>";
        if(strcmp($ganador, $var2) !== 0){
            $res->__SET('estado', 2);
            echo "alert ('Se cerro la subasta, El ganador es ".$gan." con ",$max."');";
        } else {
            $res->__SET('state', new StateReserva($this->__GET('numReserva')));
            echo "alert ('Se cerro la subasta, sin un ganador');";
        }
		echo "</script>";
	} 
}
?>