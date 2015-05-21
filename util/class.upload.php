<?php
class Upload {
	
	// Constante responsбvel por guardar a pasta de onde os arquivos estarгo.
	const _FOLDER_DIR = "../../uploads/arquivos/";

	// Variбvel para guardar o array relacionado ao arquivo.
	public $_file;
	
	// Mйtodo construtor que recebe o array com os arquivos via POST
	// Verifica se jб existe diretуrio, caso nгo; й criado.
	function __construct($curFile){
		if(!file_exists(self::_FOLDER_DIR)){
			mkdir(self::_FOLDER_DIR);
		}
		$this->_file = $curFile;
	}

	//Metуdo para:
	//Verificar se existe arquivo;
	//Setar nome aleatуrio para evitar repetiзгo e substiuiзгo de arquivos;
	//Cria nome de arquivo concatenando DIRETУRIO + NOME ALEATУRIO + NOME DO ARQUIVO ENVIADO.
	//Verifica se o arquivo foi realizado o upload
	//Move o arquivo para o diretуrio escolhido, inserido na concatenaзгo realizada.
	//Retorna true em casos de upload com sucesso e false com erro.
	function makeUpload(){
		chmod ('../../uploads/arquivos/', 0777);

		if(isset($this->_file)){
			$randomName = rand(00,9999);
			$fileName = self::_FOLDER_DIR . "_" . $randomName . "_" . $this->_file["name"];
			if(is_uploaded_file($this->_file["tmp_name"])){
				if(move_uploaded_file($this->_file["tmp_name"], $fileName)){
					$arquivo = $randomName . "_" . $this->_file["name"];
					return $arquivo;
				}else{
					echo "Erro, problemas no envio.";
					return false;
				}
			}		
		}	
	}
}
?>