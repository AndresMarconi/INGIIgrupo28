<?php
class Residencia
{
	private $idresidencia;
	private $dni;
	private $nombre;
	private $descripcion;
	private $pais;
	private $direccion;
	private $ciudad;
	private $cantpersonas;


// Constructor
	public function __CONSTRUCT(){}

//Getter y Setter
	public function __GET($k){ return $this->$k; }
	public function __SET($k, $v){ return $this->$k = $v; }

	public function cargarImagen($img, $i){
		$target_dir = "../assets/img/residencias/";
		$imageFileType = strtolower(pathinfo($img['name'],PATHINFO_EXTENSION));
		$target_file = $target_dir . "imagen".$i."resi".$this->idresidencia.".". $imageFileType;
		if (move_uploaded_file($img["tmp_name"], $target_file)) {
			echo "<script languaje= 'javascript'>";
			echo "alert('la imagen".$img['name']." se cargo');";
			echo "</script>";	
		}
	}
}
?>