<?php
class Upload {
	
	// Constante respons�vel por guardar a pasta de onde os arquivos estar�o.
	const _FOLDER_DIR = "../../uploads/arquivos/";

	// Vari�vel para guardar o array relacionado ao arquivo.
	public $_file;
	
	// M�todo construtor que recebe o array com os arquivos via POST
	// Verifica se j� existe diret�rio, caso n�o; � criado.
	function __construct($curFile){
		if(!file_exists(self::_FOLDER_DIR)){
			mkdir(self::_FOLDER_DIR);
		}
		$this->_file = $curFile;
	}

	//Met�do para:
	//Verificar se existe arquivo;
	//Setar nome aleat�rio para evitar repeti��o e substiui��o de arquivos;
	//Cria nome de arquivo concatenando DIRET�RIO + NOME ALEAT�RIO + NOME DO ARQUIVO ENVIADO.
	//Verifica se o arquivo foi realizado o upload
	//Move o arquivo para o diret�rio escolhido, inserido na concatena��o realizada.
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