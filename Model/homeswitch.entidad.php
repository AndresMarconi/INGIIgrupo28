<?php
class HomeSwitch
{
	private $usuarios;
	private $admins;
	private $residencias;

	public function __CONSTRUCT()
	{
		$this->usuarios = new UsuarioModel();
		$this->admins = new AdminModel();
		//$this->residencias = new ResidenciaModel();
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

	public function listaUsuarios(){
		return $this->usuarios->listar();
	}

	public function listarprovincias(){
		return $this->provincias->listar();
	}

	public function listaralimentos(){
		return $this->alimentos->listar();
	}

	public function obtenerPro($idp){
		return $this->provincias->obtener($idp);
	}

	public function asignarPlan($usu){
		$this->usuarios->RegistrarElPLan($usu);
	}

	public function quitarPlan($usu){
		$this->usuarios->ActualizarPLan($usu);
	}

	public function asignarRutina($usu){
	
		$this->usuarios->RegistrarLaRutina($usu);
	}

	public function quitarRutina($usu){
		$this->usuarios->ActualizarRutina($usu);
	}
}