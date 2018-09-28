<?php
/***************************************************************************************************

--------------------------------------------------------------------------------------------------------------------------
Clase emailFormulario -  Esta clase recoge y enviar datos de un formulario a una o varias direcciones
--------------------------------------------------------------------------------------------------------------------------
Clase emailNormal -  Esta clase sirve para enviar mensajes ordinarios a una o varias direcciones
--------------------------------------------------------------------------------------------------------------------------
Clase emailAvanzado -  Esta clase sirve para enviar correo con 'attachments' y versiones alternativas
--------------------------------------------------------------------------------------------------------------------------

/***************************************************************************************************/
if (phpversion() < 5) die("Este script necesita PHP versión 5.0.0 o superior");

abstract class email {
	const       version = "1.0";
	protected $html = 0;
	protected $mensaje;
	protected $para = array();
	protected $asunto;
	protected $cabeceras; 
	
	public function __construct() {
		if (phpversion() < 5) die("Este script necesita PHP versión 5.0.0 o superior");
	}
	
	public function enHTML($html) {
		if (is_bool($html)) {
			($html)? $this->html = 1 : $this->html = 0;
			return true;
		}
		return false;
	}
	
	public function cabecera($cabecera) {
		if (is_string($cabecera)) {
			$this->cabeceras.="$cabecera\r\n";
			return true;
		}
		return false;
	}
	
	public function asunto($asunto) {
		if (is_string($asunto)) {
			$this->asunto = $asunto;
			return true;
		}
		return false;
	}
	
	public function para($para) {
		if (is_array($para)) {
			foreach($para as $val) {
				$this->para[] = $val;
			}
			return true;
		}
		if (is_string($para)) {
			$this->para[] = $para;
			return true;
		}
		return false;
	}

	public function de($email, $nombre) {
		if ((is_string($nombre)) && ($nombre != "") && (is_string($email)))  {
			$this->cabeceras.= "From: $nombre <$email>\r\n";
			return true;
		} elseif (is_string($email)) {
			$this->cabeceras.="From: <$email>\r\n";			
		}
		return false;
	}
	
	public function responder_a($email, $nombre = "") {
		$this->cabeceras.= "Reply-To: $nombre  <$email>\r\n";
	}
	
	public function copia_a($email, $nombre ="") {
		$this->cabeceras.= "Cc: $nombre  <$email>\r\n";
	}
	
	public function copia_oculta_a($email, $nombre ="") {
		$this->cabeceras.= "Bcc: $nombre  <$email>\r\n";
	}
	
	public function enviar() {
		if($this->html) {
			$this->cabeceras.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$this->mensaje = "<html>".$this->mensaje."</html>";
			$this->mensaje = nl2br($this->mensaje);
		} else {
			$this->cabeceras.= "Content-type: text/plain; charset=iso-8859-1\r\n";
		}
		
		if(mail(implode(", ", $this->para), $this->asunto, $this->mensaje, $this->cabeceras)) {
			return true;      
		} else {
			return false;
		}
	}
}


class emailFormulario extends email {
	private $sitio;
	private $html_fuente;
	private $metodo;
	private $extra = "";
	
	public function __construct($sitio = "SITIO WEB") {
		parent::__construct();
		$this->sitio	    = strtoupper($sitio);
		$this->metodo      = $_POST;
		$this->cabeceras   = "MIME-Version: 1.0\r\n";
		
		$this->mensaje = "Message sent from ".$this->sitio." Request Information Service"." :\n\n";
	}
	
	public function cabecera($cabecera) {
		if (is_string($cabecera)) {
			$this->cabeceras[] = $cabecera;
			return true;
		}
		return false;
	}
	
	public function enHTML($html, $fuente) {
		parent::enHTML($html);
		if (is_string($fuente)) {
			$this->html_fuente = $fuente;
			return true;
		}
		return false;
	}
	
	public function metodo($metodo) {
		if (is_array($metodo)) {
			$this->metodo = $metodo;
			return true;
		}
		switch (strtolower($metodo)) {
			case "post":
				$this->metodo = $_POST; break;
			case "get":
				$this->metodo = $_GET; break;
			default: return false; break;
		}
		return true;
	}

	public function campo($nombre, $campo) {
		if ((func_num_args() == 0) && (is_array($this->metodo))) {
			foreach ($this->metodo as $val) {
				$this->mensaje.= "\n".$val[0].":\n".$val[1]."\n\n\n";
			}
			return true;
		}
		
		if ((array_key_exists($campo, $this->metodo)) && ($this->metodo[$campo] != ""))
		if ($this->metodo[$campo] != "") {
			$this->mensaje.= "\n".$nombre.":\n". $this->metodo[$campo]."\n\n\n";
			return true;
		}
			return false;
	}
	
	public function extra($texto) {
		if (is_string($texto)) {
			$this ->extra = "\n$texto";
			return true;
		}
		return false;
	}
	
	public function enviar() {
		if($this->html) {
			$this->mensaje = str_replace("----------------------------------------------\n", "<hr>", $this->mensaje);
			$this->mensaje = str_replace("\n----------------------------------------------", "<hr>", $this->mensaje);
			$this->mensaje = "<font face=\"".$this->html_fuente."\">".$this->mensaje.$this->extra."</font>";
		} else {
			$this->mensaje.= $this->extra;	
		}
		$this->asunto.= ": ".$this->sitio;
		parent::enviar();
	}
	
}

class emailNormal extends email {
	public function __construct() {
		parent::__construct();	
	}
	
	public function mensaje($mensaje) {
		$this->mensaje = $mensaje;	
	}
}

class emailAvanzado extends email {
	
	private $cuerpo_mime  = array();
	private $adjuntos 	= array();
	private $version_texto  = array();
	private $version_html   = array();

	public function __construct() {
		$this->version_texto[0] = false;
		$this->version_html[0] = false;
		parent::__construct();
	}
	
	public function version_texto($mensaje) {
		if(is_string($mensaje)) {
			$this->version_texto[0] = true;
			$this->version_texto[1] = $mensaje;
			return true;
		}
		return false;
	}
	
	public function version_html($mensaje) {
		if(is_string($mensaje)) {
			$this->version_html[0] = true;
			$this->version_html[1] = $mensaje;
			return true;
		}
		return false;
	}
	
	public function adjuntar($archivo, $nombre, $tipo = "application/octet-stream") {
		if (is_file($archivo)) {
			$this->adjuntos[] = array("archivo" => $archivo, "nombre" => $nombre, "tipo" => $tipo );
			return true;
		}
		return false;

	}
	
	public function enviar() {
		for ($i=0;$i<=1;$i++) {
			$lim[$i] = "_=" . md5(uniqid(time()));
		}
		$this->cabecera("Date: ". date("D, d M y H:i:s"));
		$this->cabecera("MIME-Version: 1.0");
		$this->cabecera("Content-Type: multipart/mixed; ".chr(13).chr(10).chr(9)." boundary=\"$lim[0]\";");
		$this->cuerpo_mime[] = "--$lim[0]";
		$this->hacer_versoines($lim[1]);
		$this->cuerpo_mime[] = "--$lim[0]";
		$this->hacer_adjuntos($lim[0]);	
		$this->cuerpo_mime[] = "--$lim[0]--";
		
		if(mail(implode(", ", $this->para), $this->asunto, implode("\r\n", $this->cuerpo_mime), $this->cabeceras)) {
			return true;
		} else{
			return false;	
		}
	}
	
	private function hacer_version_texto() {
		if ($this->version_texto[0]) {
			$this->cuerpo_mime[] = "Content-Type: text/plain";
			$this->cuerpo_mime[] = "Content-Transfer-Encoding: base64\r\n";
			$this->cuerpo_mime[] = chunk_split(base64_encode($this->version_texto[1]));
		}
	}
	
	private function hacer_version_html() {
		if ($this->version_html[0]) {
			$this->cuerpo_mime[] = "Content-Type: text/html";
			$this->cuerpo_mime[] = "Content-Transfer-Encoding: base64\r\n";
			$this->cuerpo_mime[] = chunk_split(base64_encode($this->version_html[1]));
		}
	}
	
	private function hacer_versoines($lim) {
		if (($this->version_html[0]) && ($this->version_texto[0])) {
			$this->cuerpo_mime[] = "Content-Type: multipart/alternative; ".chr(13).chr(10).chr(9)." boundary=\"$lim\";\r\n";
			$this->cuerpo_mime[] = "--$lim";
			$this->hacer_version_texto();
			$this->cuerpo_mime[] = "--$lim";
			$this->hacer_version_html();
			$this->cuerpo_mime[] = "--$lim--";
		} else {
			$this->hacer_version_texto();
			$this->hacer_version_html();
		}
	}
	
	protected function leer_archivo($archivo) {
		if ($fp = fopen($archivo, "rb")) {
			$contenido = fread($fp, filesize($archivo));
			fclose($fp);
			return $contenido;
		} else {
			return false;		
		}
	}
	
	private function hacer_adjuntos($lim) {
		foreach ($this->adjuntos as $val) {
			$this->cuerpo_mime[] = "Content-Type: ".$val['tipo']."; name=\"".$val['nombre']."\";";
			$this->cuerpo_mime[] = "Content-Transfer-Encoding: base64";
			$this->cuerpo_mime[] = "Content-Disposition: attachment; filename=\"".$val['nombre']."\"\r\n";
			$this->cuerpo_mime[] = chunk_split(base64_encode($this->leer_archivo($val['archivo'])));
			$this->cuerpo_mime[] = "--$lim";
		}
	}
	
}
?>