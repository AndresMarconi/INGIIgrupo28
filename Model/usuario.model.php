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
			$stm = $this->pdo->prepare("SELECT * FROM usuarios");
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
			$stm = $this->pdo->prepare("SELECT * FROM usuario WHERE username = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$tipo = $r->tipo;
			if (!empty($r)) {
				$usr = new $tipo();

				$usr->__SET('dni', $r->dni);
				$usr->__SET('nombre', $r->nombre);
				$usr->__SET('apellido', $r->apellido);
				$usr->__SET('username', $r->username);
				$usr->__SET('contra', $r->contraseña);
				$usr->__SET('direccion', $r->direccion);
				$usr->__SET('email', $r->mail);
				$usr->__SET('telefono', $r->telefono);
				$usr->__SET('nroTarjeta', $r->numTarjeta);
				$usr->__SET('vencimiento', $r->vencimientoTarjeta);
				$usr->__SET('codSeg', $r->codSegTarjeta);
				
			} else{
				$usr = new usuario();
			}
			return $usr;
			
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
			          ->prepare("DELETE FROM usuarios WHERE username = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(usuario $data, $userViejo)
	{
		try 
		{
			$sql = "UPDATE usuario SET
						dni                 = ?,
						username 			= ?, 
						nombre             	= ?,
						apellido           	= ?,
						contraseña              = ?,
						direccion          	= ?, 
						mail     			= ?, 
						telefono	     		= ?,
						vencimientoTarjeta 	= ?,
						codSegTarjeta 		= ?,
						numTarjeta			= ?
				    WHERE username = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('dni'),
					$data->__GET('username'),
					$data->__GET('nombre'),
					$data->__GET('apellido'),
					$data->__GET('contra'),
					$data->__GET('direccion'),
					$data->__GET('email'),
					$data->__GET('telefono'),
					$data->__GET('vencimiento'),
					$data->__GET('codSeg'),					
					$data->__GET('nroTarjeta'),
					$userViejo
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
		$sql = "INSERT INTO usuario(dni, tipo, contraseña, cantReservas, nombre, apellido, mail, telefono, direccion, inicioContrato, finContrato, numTarjeta, vencimientoTarjeta, codSegTarjeta, username) 
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('dni'),
				1,
				$data->__GET('contra'),
				2,
				$data->__GET('nombre'),
				$data->__GET('apellido'),
				$data->__GET('email'),
				$data->__GET('telefono'),
				$data->__GET('direccion'),
				0,
				0,
				$data->__GET('nroTarjeta'),
				$data->__GET('vencimiento'),
				$data->__GET('codSeg'),
				$data->__GET('username')
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function existe($un)
	{
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM usuario WHERE username = ?");
			$stm->execute(array($un));
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
}