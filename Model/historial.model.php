<?php
class HistorialPujasModel
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

	public function ObtenerPujaMaxima($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT  MAX(montopuja) as puja FROM historialdepujas WHERE idsubasta = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			return $r->puja;

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function ObtenerGanador($id, $max)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT username FROM historialdepujas WHERE idsubasta = ? AND montopuja = ?");
			     
			$stm->execute(array($id, $max));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			if (!(empty($r))) {
				return $r->username;
			}

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function registrarPuja($id, $puja, $username)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("INSERT INTO historialdepujas(username, idsubasta, montopuja) VALUES (?, ?, ?)");
			     
			$stm->execute(array(
				$username,
				$id,
				$puja
			)
			);
		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

}