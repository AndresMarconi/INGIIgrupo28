<?php
class residenciaModel
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

	public function Listar()
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM residencia");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$resi = new residencia();

				$resi->__SET('idresidencia', $r->idresidencia);
				$resi->__SET('dni', $r->dni);
				$resi->__SET('nombre', $r->nombre);
				$resi->__SET('descripcion', $r->descripcion);
				$resi->__SET('pais', $r->pais);
				$resi->__SET('ciudad', $r->ciudad);
				$resi->__SET('direccion', $r->direccion);
				$resi->__SET('cantpersonas', $r->cantpersonas);		

				$result[] = $resi;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

	public function Obtener($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM `residencia` WHERE idresidencia = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$resi = new residencia();

			$resi->__SET('idresidencia', $r->idresidencia);
			$resi->__SET('dni', $r->dni);
			$resi->__SET('nombre', $r->nombre);
			$resi->__SET('descripcion', $r->descripcion);
			$resi->__SET('pais', $r->pais);
			$resi->__SET('ciudad', $r->ciudad);
			$resi->__SET('direccion', $r->direccion);
			$resi->__SET('cantpersonas', $r->cantpersonas);	
			
			return $resi;
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
			          ->prepare("DELETE FROM residencia WHERE idresidencia = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(residencia $data)
	{
		try 
		{
			$sql = "UPDATE residencia SET 
						nombre             	= ?,
						direccion          	= ?,
						ciudad              = ?,
						pais	           	= ?, 
						descripcion        	= ?, 
						cantpersonas		= ?
				    WHERE idresidencia = ?";

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
	
	public function Registrar(residencia $data)
	{
		try 
		{
		$sql = "INSERT INTO residencia(idresidencia, descripcion, direccion, nombre, pais, ciudad, cantpersonas) 
				VALUES (?, ?, ?, ?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('idresidencia'),
				$data->__GET('descripcion'),
				$data->__GET('direccion'),
				$data->__GET('nombre'),
				$data->__GET('pais'),
				$data->__GET('ciudad'),
				$data->__GET('cantpersonas')
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
	

	public function sigId()
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT max(idresidencia + 1) as max FROM `residencia`");
			$stm->execute(array());
			$r = $stm->fetch(PDO::FETCH_OBJ);

			return $r->max;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}