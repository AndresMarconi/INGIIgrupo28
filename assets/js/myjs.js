function selectLogin(id){	
	var usuario = document.getElementById("usuario");
	var admin = document.getElementById("admin");
	if (id == 'admin') {
		usuario.className = "nav-link";
		admin.className = "nav-link active";
	} else {
		admin.className = "nav-link";
		usuario.className = "nav-link active";
	}
	var tipo = document.getElementById("tipo");
	tipo.value = id;
}