<?php
class SolicitudesPremiumModel
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

	public function registrarSolicitud($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("INSERT INTO `peticiones`(`username`, `estado`) VALUES (?,?)");
			     
			$stm->execute(array($id, "esperandoRespuesta"));

		} catch (Exception $e) 
		{
			die($e->getMessage());
		}
	}

	public function tienePendiente($id)
	{
		try 
		{
			$stm = $this->pdo
			          ->prepare("SELECT `username`, `estado` FROM `peticiones` WHERE username = ?");
			     
			$stm->execute(array($id));
			$r = $stm->fetch(PDO::FETCH_OBJ);

			if (!(empty($r))) {
				return true;
			}else{
				return false;
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

	public function Listar()
	{
		try
		{
			$result = array();
			$stm = $this->pdo->prepare("SELECT * FROM peticiones");
			$stm->execute();
			foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$sol = new solicitud();

				$sol->__SET('username', $r->username);
				$sol->__SET('estado', $r->estado);	

				$result[] = $sol;
			}
			return $result;
		}
		catch(Exception $e)
		{
			die($e->getMessage());
		}
	}

}