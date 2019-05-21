<?php
class HomeSwitch
{
	private $usuarios;
	private $admins;
	private $residencias;
	private $reservas;

	public function __CONSTRUCT()
	{
		$this->usuarios = new UsuarioModel();
		$this->admins = new AdminModel();
		$this->residencias = new residenciaModel();
		$this->reservas = new reservaModel();
	}

	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }
	
	public function obtenerUsu($idu){
		$usu = $this->usuarios->Obtener($idu);
		if(($usu->__GET('dni') != " ")){
			return $usu;
		} else {
			echo "<script languaje= 'javascript'>";
			echo "window.location='login.php';";
			echo "alert ('DNI Incorrecto')";
			echo "</script>";
		}
	}

	public function obtenerAdmin($idu){
		$adm = $this->admins->ObtenerAdmin($idu);
		if(($adm->__GET('dni') != " ")){
			return $adm;
		} else {
			echo "<script languaje= 'javascript'>";
			echo "window.location='login.php';";
			echo "alert ('DNI Incorrecto')";
			echo "</script>";
		}
	}

	public function agregarUsu($usu){
		$this->usuarios->Registrar($usu);
		$this->usuarios->RegistrarElPLan($usu);
		echo "<script languaje= 'javascript'>";
		echo "alert ('Usuario Registrado')";
		echo "</script>";
	}

	public function listarSubastas(){
		return $this->reservas->listarSubastas();
	}

	public function listarSubastasAbiertas(){
		return $this->reservas->listarSubastasAbiertas();
	}

	public function obtenerSubasta($id){
		return $this->reservas->obtenerSubasta($id);
	}

	public function tieneReservas($id){
		return $this->reservas->tieneReservas($id);
	}

	public function listaUsuarios(){
		return $this->usuarios->listar();
	}

	public function obtenerResidencia($idresi){
		$resi = $this->residencias->Obtener($idresi);
		return $resi;
	}

	public function listarResidencias(){
		return $this->residencias->listar();
	}


}