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
			$stm = $this->pdo->prepare("SELECT * FROM usuario");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$usr = new $r->tipo();

				$usr->__SET('dni', $r->dni);
				$usr->__SET('nombre', $r->nombre);
				$usr->__SET('apellido', $r->apellido);
				$usr->__SET('contra', $r->contraseña);
				$usr->__SET('username', $r->username);
				$usr->__SET('direccion', $r->direccion);
				$usr->__SET('email', $r->mail);
				$usr->__SET('telefono', $r->telefono);
				$usr->__SET('nroTarjeta', $r->numTarjeta);
				$usr->__SET('codSeg', $r->codSegTarjeta);
				$usr->__SET('vencimiento', $r->vencimientoTarjeta);			

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
				$usr->__SET('tokens', $r->cantReservas);
				
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
						username 			= ?, 
						nombre             	= ?,
						apellido           	= ?,
						contraseña          = ?,
						direccion          	= ?, 
						mail     			= ?, 
						telefono	     	= ?,
						vencimientoTarjeta 	= ?,
						codSegTarjeta 		= ?,
						numTarjeta			= ?
				    WHERE username = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
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
		$sql = "INSERT INTO usuario(tipo, contraseña, cantReservas, nombre, apellido, mail, telefono, direccion, inicioContrato, finContrato, numTarjeta, vencimientoTarjeta, codSegTarjeta, username) 
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				'basico',
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

	public function ascenderPremium($user)
	{
		try 
		{
			$sql = "UPDATE usuario SET tipo = ? WHERE username = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					'premiun',
					$user
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function restarToken($tok, $user){
		try {
			$sql = "UPDATE usuario SET cantReservas = ? WHERE username = ?";
			$this->pdo->prepare($sql)
			     ->execute(array($tok-1, $user));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}