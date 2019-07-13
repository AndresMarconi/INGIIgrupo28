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

	public function Obtener($id, $tipo)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE s.numreserva = ? AND s.tipo = ?");
			     
			$stm->execute(array($id, $tipo));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$sub = new reserva();
			$sub->__SET('state', new $r->tipo($r->numreserva));
			$sub->__SET('numReserva', $r->numreserva);			
			$sub->__SET('residencia', $r->nombre);
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
			
			return $sub;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerRes($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE s.numreserva = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$sub = new reserva();
			$sub->__SET('state', new $r->tipo($r->numreserva));
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
			$stm = $this->pdo->prepare("UPDATE `reserva` SET `estado`= 0 WHERE numreserva = ?");			          
			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function publicar($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("UPDATE `reserva` SET `estado`= 1 WHERE numreserva = ?");			          
			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function abrir($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("UPDATE `reserva` SET `tipo`= 'subasta' WHERE numreserva = ?");			          
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
						idResidencia       	= ?,
						preciobase          = ?,
						fechainicio        	= ?, 
						semana	        	= ?, 
						año					= ?,
						estado				= ?,
						tipo 				= ?
				    WHERE numreserva = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('idResidencia')->__GET('idresidencia'),
					$data->__GET('precioBase'),
					$data->__GET('fechainicio'),
					$data->__GET('semana'),
					$data->__GET('año'),
					$data->__GET('estado'),
					$data->__GET('state')->tipo(),
					$data->__GET('numReserva')
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

	public function hizoReserva($id, $username)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM reserva r INNER JOIN historialdepujas h ON (r.numreserva=h.idsubasta) 
										WHERE h.idsubasta = ? AND h.username = ?");
			$stm->execute(array($id, $username));
			$r = $stm->fetch(PDO::FETCH_OBJ);
			if (empty($r)){
				return false;
			} else {
				return true;
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

	public function cantidadDePublicaciones($filtro)
	{
		try 
		{
			$sql = "SELECT COUNT(numreserva) cant FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE estado = 1 ";
			$sql .= $filtro;
			$stm = $this->pdo->prepare($sql);
			$stm->execute(array());
			$r = $stm->fetch(PDO::FETCH_OBJ);
			return $r->cant;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ListarReservasConFiltro($filtro)
	{
		try
		{
			$result = array();
			$sql = "SELECT * FROM reserva s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE ";
			$sql .= $filtro;
			$stm = $this->pdo->prepare($sql);
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sub = new reserva();
				$sub->__SET('state', new $r->tipo($r->numreserva));
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

	public function listarReservasUsuario($usu){
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT DISTINCT numreserva, tipo, fechainicio, semana, año, estado, res.* 
										FROM historialdepujas h INNER JOIN reserva r ON (r.numreserva = h.idsubasta) 
										INNER JOIN residencia res ON (r.idresidencia = res.idresidencia)
										WHERE h.username = ?");
			$stm->execute(array($usu));
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$res = new reserva();
				$res->__SET('state', new $r->tipo($r->numreserva));
				$res->__SET('numReserva', $r->numreserva);
				$res->__SET('fechainicio', $r->fechainicio);
				$res->__SET('año', $r->año);
				$res->__SET('semana', $r->semana);
				$res->__SET('estado', $r->estado);	

				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('nombre', $r->nombre);
				$resi->__SET('descripcion', $r->descripcion);
				$resi->__SET('pais', $r->pais);
				$resi->__SET('ciudad', $r->ciudad);
				$resi->__SET('direccion', $r->direccion);
				$resi->__SET('cantpersonas', $r->cantpersonas);

				$res->__SET('idResidencia', $resi);			

				$result[] = $res;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function actualizarTipo($res , $tipo){
		if ($tipo = 0){
			// estado = 2;
		}
		else {
			// tipo = siguiente;
		}

	}
}