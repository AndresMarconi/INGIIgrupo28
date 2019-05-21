<?php
class usuarioModel
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
			$stm = $this->pdo->prepare("SELECT * FROM usuarios u 
								INNER JOIN planusuario upn ON (u.dni = upn.nrodni)
								INNER JOIN plannutricional pn ON (upn.nroplan = pn.idplan)
								INNER JOIN rutinausuario uru ON (u.dni = uru.nrodni)
								INNER JOIN rutina rut ON (uru.nrorutina = rut.idrutina)
								WHERE upn.actual = 1 AND uru.actual = 1");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$usr = new usuario();

				$usr->__SET('dni', $r->dni);
				$usr->__SET('nombre', $r->nombre);
				$usr->__SET('apellido', $r->apellido);
				$usr->__SET('contra', $r->contra);
				$usr->__SET('idciudad', $r->idciudad);
				$usr->__SET('direccion', $r->direccion);
				$usr->__SET('email', $r->email);
				$usr->__SET('ntel', $r->ntel);	
				$usr->__SET('plan', new planNutricional());
				$usr->__GET('plan')->__SET('nroplan', $r->idplan);
				$usr->__GET('plan')->__SET('nombre', $r->nombreplan);
				$usr->__GET('plan')->__SET('estado', $r->estado);
				$usr->__SET('rutina', new rutina());
				$usr->__GET('rutina')->__SET('nrorutina', $r->idrutina);
				$usr->__GET('rutina')->__SET('nombre', $r->nombrerut);			

				$result[] = $usr;
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
			          ->prepare("SELECT * FROM usuarios u 
								INNER JOIN planusuario upn ON (u.dni = upn.nrodni)
								INNER JOIN plannutricional pn ON (upn.nroplan = pn.idplan)
								INNER JOIN rutinausuario uru ON (u.dni = uru.nrodni)
								INNER JOIN rutina rut ON (uru.nrorutina = rut.idrutina)
								WHERE upn.actual = 1 AND uru.actual = 1 AND u.dni = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$usr = new usuario();

			$usr->__SET('dni', $r->dni);
			$usr->__SET('nombre', $r->nombre);
			$usr->__SET('apellido', $r->apellido);
			$usr->__SET('contra', $r->contra);
			$usr->__SET('idciudad', $r->idciudad);
			$usr->__SET('direccion', $r->direccion);
			$usr->__SET('email', $r->email);
			$usr->__SET('ntel', $r->ntel);
			$usr->__SET('plan', new planNutricional());
			$usr->__GET('plan')->__SET('nroplan', $r->idplan);
			$usr->__GET('plan')->__SET('nombre', $r->nombreplan);
			$usr->__GET('plan')->__SET('estado', $r->estado);
			$usr->__SET('rutina', new rutina());
			$usr->__GET('rutina')->__SET('nrorutina', $r->idrutina);
			$usr->__GET('rutina')->__SET('nombre', $r->nombrerut);	
			
			return $usr;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerAdmin($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM usuarios WHERE dni = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$adm = new admin();

			$adm->__SET('dni', $r->dni);
			$adm->__SET('nombre', $r->nombre);
			$adm->__SET('apellido', $r->apellido);
			$adm->__SET('contra', $r->contra);
			$adm->__SET('idciudad', $r->idciudad);
			$adm->__SET('direccion', $r->direccion);
			$adm->__SET('email', $r->email);
			$adm->__SET('ntel', $r->ntel);	
			
			return $adm;
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
			          ->prepare("DELETE FROM usuarios WHERE dni = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(usuario $data)
	{
		try 
		{
			$sql = "UPDATE usuarios SET 
						nombre             	= ?,
						apellido           	= ?,
						contra              = ?,
						idciudad           	= ?, 
						direccion          	= ?, 
						email     			= ?, 
						ntel	     		= ?
				    WHERE dni = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'),
					$data->__GET('apellido'),
					$data->__GET('contra'),
					$data->__GET('idciudad'),
					$data->__GET('direccion'),
					$data->__GET('email'),
					$data->__GET('ntel'),
					$data->__GET('dni')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ActualizarPlan(usuario $data)
	{
		try 
		{
			$sql = "UPDATE `planusuario` SET `actual`= ?,`estado`= ? WHERE nrodni = ? AND nroplan = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('plan')->__GET('actual'),
					$data->__GET('plan')->__GET('estado'),
					$data->__GET('dni'),
					$data->__GET('plan')->__GET('nroplan')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ActualizarRutina(usuario $data)
	{
		try 
		{
			$sql = "UPDATE `Rutinausuario` SET `actual`= ?,`estado`= ? WHERE nrodni = ? AND nrorutina = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('rutina')->__GET('actual'),
					$data->__GET('rutina')->__GET('estado'),
					$data->__GET('dni'),
					$data->__GET('rutina')->__GET('nrorutina')
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function Registrar(usuario $data)
	{
		try 
		{
		$sql = "INSERT INTO usuarios (`dni`, `nombre`, `apellido`, `idciudad`, `direccion`, `email`, `ntel`, `contra`) 
		        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('dni'),
				$data->__GET('nombre'),
				$data->__GET('apellido'),
				$data->__GET('idciudad'),
				$data->__GET('direccion'),
				$data->__GET('email'),
				$data->__GET('ntel'),
				$data->__GET('contra'),
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function RegistrarElPlan(usuario $data)
	{
		try 
		{
		$sql = "INSERT INTO `planusuario`(`nrodni`, `nroplan`, `actual`, `estado`) 
				VALUES (?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('dni'),
				$data->__GET('plan')->__GET('nroplan'),
				$data->__GET('plan')->__GET('actual'),
				$data->__GET('plan')->__GET('estado')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function RegistrarLaRutina(usuario $data)
	{
		try 
		{
		$sql = "INSERT INTO `rutinausuario`(`nrodni`, `nrorutina`, `actual`, `estado`) 
				VALUES (?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('dni'),
				$data->__GET('rutina')->__GET('nrorutina'),
				$data->__GET('rutina')->__GET('actual'),
				$data->__GET('rutina')->__GET('estado')
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
	
}