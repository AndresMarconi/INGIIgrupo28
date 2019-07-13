<?php
class adminModel
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

	public function listar()
	{
		try 
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM `administrador`");
			$stm->execute(array());
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$adm = new admin();

				$adm->__SET('username', $r->username);
				$adm->__SET('nombre', $r->nombre);
				$adm->__SET('apellido', $r->apellido);
				$adm->__SET('contraseña', $r->contraseña);
				$adm->__SET('email', $r->mail);

				$result[] = $adm;
			}
			return $result;
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
			          ->prepare("SELECT * FROM `administrador` WHERE username = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$adm = new admin();

			$adm->__SET('username', $r->username);
			$adm->__SET('nombre', $r->nombre);
			$adm->__SET('apellido', $r->apellido);
			$adm->__SET('contraseña', $r->contraseña);
			$adm->__SET('email', $r->mail);
			
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
			          ->prepare("DELETE FROM administrador WHERE username = ?");			          

			$stm->execute(array($id));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function Actualizar(admin $data, $admViejo)
	{
		try 
		{
			$sql = "UPDATE administrador SET 
						nombre             	= ?,
						apellido           	= ?,
						contraseña          = ?, 
						mail     			= ?, 
						username     		= ?
				    WHERE username = ?";

			$this->pdo->prepare($sql)
			     ->execute(
				array(
					$data->__GET('nombre'),
					$data->__GET('apellido'),
					$data->__GET('contraseña'),
					$data->__GET('email'),
					$data->__GET('username'),
					$admViejo
					)
				);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
	
	public function Registrar(admin $data)
	{
		try 
		{
		$sql = "INSERT INTO administrador (`nombre`, `apellido`, `username`, `mail`, `contraseña`) 
		        VALUES (?, ?, ?, ?, ?)";
		$this->pdo->prepare($sql)
		     ->execute(
			array(
				$data->__GET('nombre'),
				$data->__GET('apellido'),
				$data->__GET('username'),
				$data->__GET('email'),
				$data->__GET('contraseña'),
				)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function existe($id){
		try 
		{
			$stm = $this->pdo->prepare("SELECT * FROM administrador WHERE username = ?");
			$stm->execute(array($id));
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
	
	public function cambiarPrecios($basico, $premiun){
		try 
		{
			$sql = "UPDATE precios SET basico = ?, premiun	= ? WHERE id = 1";
			$this->pdo->prepare($sql)->execute(array($basico, $premiun));
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function precioBasico()
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT basico from precios WHERE id = 1");
			     
			$stm->execute();
			$r = $stm->fetch(PDO::FETCH_OBJ);
			
			return $r->basico;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function precioPremium(){
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT premiun from precios WHERE id = 1");
			     
			$stm->execute();
			$r = $stm->fetch(PDO::FETCH_OBJ);
			
			return $r->premiun;
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}
}