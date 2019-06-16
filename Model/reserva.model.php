<?php
class reservaModel
{
	private $pdo;

	public function __CONSTRUCT()
	{
		try
		{
			$this->pdo = new PDO('mysql:host=localhost;dbname=homeswitch;charset=utf8', 'root', '');
			$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		        
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Listar($tipo)
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE tipo = ?");
			$stm->execute(array($tipo));
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sub = new $tipo();
				$sub->__SET('numReserva', $r->numreserva);
				
				$sub->__SET('residencia', $r->nombre);
				$sub->__SET('fechainicio', $r->fechainicio);
				$sub->__SET('año', $r->año);
				$sub->__SET('semana', $r->semana);
				$sub->__SET('precioBase', $r->preciobase);
				$sub->__SET('estado', $r->estado);

				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('nombre', $r->nombre);
				$resi->__SET('descripcion', $r->descripcion);
				$resi->__SET('pais', $r->pais);
				$resi->__SET('ciudad', $r->ciudad);
				$resi->__SET('direccion', $r->direccion);
				$resi->__SET('cantpersonas', $r->cantpersonas);

				$sub->__SET('idResidencia', $resi);		

				$result[] = $sub;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarAbiertas($tipo)
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE estado = 1 AND tipo = ?");
			$stm->execute(array($tipo));
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sub = new $tipo();
				$sub->__SET('numReserva', $r->numreserva);
				
				$sub->__SET('residencia', $r->nombre);
				$sub->__SET('año', $r->año);
				$sub->__SET('semana', $r->semana);
				$sub->__SET('fechainicio', $r->fechainicio);
				$sub->__SET('precioBase', $r->preciobase);
				$sub->__SET('estado', $r->estado);

				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('nombre', $r->nombre);
				$resi->__SET('descripcion', $r->descripcion);
				$resi->__SET('pais', $r->pais);
				$resi->__SET('ciudad', $r->ciudad);
				$resi->__SET('direccion', $r->direccion);
				$resi->__SET('cantpersonas', $r->cantpersonas);

				$sub->__SET('idResidencia', $resi);		

				$result[] = $sub;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function ListarXresidencia($idres)
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM reserva 
										WHERE (idresidencia = ?)AND((año > ?) OR ((semana >= ?)AND(año = ?)))");
			$stm->execute(array($idres, date('Y'), date('w'), date('Y')));
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$res = new $r->tipo;
				$res->__SET('numReserva', $r->numreserva);
				$res->__SET('fechainicio', $r->fechainicio);
				$res->__SET('año', $r->año);
				$res->__SET('semana', $r->semana);
				$res->__SET('precioBase', $r->preciobase);
				$res->__SET('estado', $r->estado);		

				$result[] = $res;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id, $tipo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE s.numreserva = ? AND s.tipo = ?");
			     
			$stm->execute(array($id, $tipo));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$sub = new $tipo();
			$sub->__SET('numReserva', $r->numreserva);
				
			$sub->__SET('residencia', $r->nombre);
			$sub->__SET('año', $r->año);
			$sub->__SET('semana', $r->semana);
			$sub->__SET('precioBase', $r->preciobase);

			$resi = new residencia();

			$resi->__SET('idresidencia', $r->idresidencia);
			$resi->__SET('nombre', $r->nombre);
			$resi->__SET('descripcion', $r->descripcion);
			$resi->__SET('pais', $r->pais);
			$resi->__SET('ciudad', $r->ciudad);
			$resi->__SET('direccion', $r->direccion);
			$resi->__SET('cantpersonas', $r->cantpersonas);

			$sub->__SET('idResidencia', $resi);	
			
			return $sub;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function cerrar($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("UPDATE `reserva` SET `estado`= 0 WHERE numreserva = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Eliminar($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("DELETE FROM reserva WHERE idreserva = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(reserva $data)
	{
		try 
		{
			$sql = "UPDATE reserva SET 
						nombre             	= ?,
						direccion          	= ?,
						ciudad              = ?,
						pais	           	= ?, 
						descripcion        	= ?, 
						cantpersonas		= ?
				    WHERE idreserva = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'),
					$data->__GET('direccion'),
					$data->__GET('ciudad'),
					$data->__GET('pais'),
					$data->__GET('descripcion'),
					$data->__GET('cantpersonas'),
					$data->__GET('idresidencia')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function Registrar($data, $tipo)
	{
		try 
		{
		$sql = "INSERT INTO reserva(numreserva, tipo, idresidencia, preciobase, fechainicio, año, semana, estado) 
				VALUES (?, ?, ?, ?, ?, ?, ?, 1)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('numReserva'),
				$tipo,
				$data->__GET('idResidencia'),
				$data->__GET('precioBase'),
				date('Y-m-d'),
				$data->__GET('año'),
				$data->__GET('semana')				
			)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function existeReserva($idres, $semana, $año)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM reserva WHERE idresidencia = ? AND semana = ? AND año=?");
			$stm->execute(array($idres, $semana, $año));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			if (!empty($r)){
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function tieneReservas($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM `reserva` WHERE idresidencia = ? AND estado = 1");
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);
			if (empty($r)){
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function sigId()
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT max(numreserva) max FROM reserva");
			$stm->execute(array());
			$r = $stm->fetch(PDO::FETCH_OBJ);
			return $r->max + 1;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}