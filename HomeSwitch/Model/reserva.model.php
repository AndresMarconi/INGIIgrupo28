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

	public function ListarSubastas()
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM subasta s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia)");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sub = new Subasta();
				$sub->__SET('numReserva', $r->numreserva);
				
				$sub->__SET('residencia', $r->nombre);
				$sub->__SET('fechaInicio', $r->fechainicio);
				$sub->__SET('precioBase', $r->preciobase);
				$sub->__SET('estado', $r->estado);

				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('dni', $r->dni);
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

	public function ListarSubastasAbiertas()
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM subasta s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE estado = 1");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sub = new Subasta();
				$sub->__SET('numReserva', $r->numreserva);
				
				$sub->__SET('residencia', $r->nombre);
				$sub->__SET('fechaInicio', $r->fechainicio);
				$sub->__SET('precioBase', $r->preciobase);
				$sub->__SET('estado', $r->estado);

				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('dni', $r->dni);
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

	public function ObtenerSubasta($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM subasta s INNER JOIN residencia r ON (s.idresidencia=r.idresidencia) WHERE s.numreserva = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$sub = new Subasta();
			$sub->__SET('numReserva', $r->numreserva);
				
			$sub->__SET('residencia', $r->nombre);
			$sub->__SET('fechaInicio', $r->fechainicio);
			$sub->__SET('precioBase', $r->preciobase);

			$resi = new residencia();

			$resi->__SET('idresidencia', $r->idresidencia);
			$resi->__SET('dni', $r->dni);
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
			          ->prepare("UPDATE `subasta` SET `estado`= 0 WHERE numreserva = ?");			          

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
	
	public function RegistrarSubasta(Subasta $data)
	{
		try 
		{
		$sql = "INSERT INTO subasta(numreserva, idresidencia, preciobase, fechainicio, estado) 
				VALUES (?, ?, ?, ?, 1)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('numReserva'),
				$data->__GET('idResidencia'),
				$data->__GET('precioBase'),
				$data->__GET('fechaInicio')				
			)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function existe($id)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM usuarios WHERE dni = ?");
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			if (mysqli_num_rows($r)==1){
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
			$stm = $this->pdo->prepare("SELECT * FROM `subasta` WHERE idresidencia = ? AND estado = 1");
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
			$stm = $this->pdo->prepare("SELECT max(s.numreserva )sub, MAX(d.numreserva)dir, MAX(h.numreserva)hot 
										FROM subasta s, directa d, hotsale h");
			$stm->execute(array());
			$r = $stm->fetch(PDO::FETCH_OBJ);
			return $this->maximo($r->dir, $r->sub, $r->hot) + 1;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	private function maximo($dir,$sub,$hot){
		if (($dir > $sub)&&($dir > $hot)) {
			$max = $dir;
		}
		if (($sub > $dir)&&($sub > $hot)) {
			$max = $sub;
		}
		if (($hot > $sub)&&($hot > $dir)) {
			$max = $hot;
		}
		return $max;
	}
}