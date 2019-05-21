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

	public function ObtenerAdmin($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT * FROM `administrador` WHERE username = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			$adm = new admin();

			$adm->__SET('dni', $r->dni);
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