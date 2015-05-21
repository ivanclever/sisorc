<?php
require('../util/conn.php');
require('../util/util.php');
require('../util/auth.php');
LimpaPost($_POST);
extract($_POST);
$do = $_REQUEST['do'];

switch ($do) {
	case 'cadastra':
		ValidaVazio($nome,'Campo nome inválido');

		$_SESSION['clientes'] = $_POST;
		$cpf = soNum($cpf);
		$cnpj = soNum($cnpj);

		if($tipo == '0') {
			ValidaCPF($cpf,'Campo CPF inválido');
			$documento = $cpf;
		} else {
			ValidaCNPJ($cnpj);
			$documento = $cnpj;
		}
		$data = DateToUs($data);

		if (semErros()) {
			if (mysql_query("INSERT INTO clientes
					(Nome, CPF_CNPJ, FAX, TelefoneResidencial, TelefoneComercial, TelefoneCelular, Email, Endereco, Numero, Complemento, Bairro, Contato, Observacoes, DataNascimento, status, DataCadastra)
				VALUES
					('$nome', '$documento', '$fax', '$residencial', '$comercial', '$celular', '$email', '$logradouro', '$numero', '$complemento', '$bairro', '$contatos', '$observacoes', '$data', '$status', NOW())")) {
				Info('Cliente cadastrado com sucesso');
				unset($_SESSION['clientes']);
				Go('../?s=clientes');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE clientes SET status='0' WHERE CodCliente = '$id'")) {
		//if (mysql_query("DELETE FROM clientes WHERE CodCliente = '$id'")) {
			Info ("Cliente removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'ativa':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE clientes SET status='1' WHERE CodCliente = '$id'")) {
		//if (mysql_query("DELETE FROM clientes WHERE CodCliente = '$id'")) {
			Info ("Cliente ativo com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
		ValidaID($id,'CodCliente','clientes');
		ValidaVazio($nome,'Campo nome inválido');
		$cpf = soNum($cpf);
		$cnpj = soNum($cnpj);

		if($tipo == '0') {
			ValidaCPF($cpf,'Campo CPF inválido');
			$documento = $cpf;
		} else {
			ValidaCNPJ($cnpj);
			$documento = $cnpj;
		}
		$data = DateToUs($data);
		
		if (semErros()) {
			if (mysql_query("UPDATE clientes 
					SET
						status='$status',
						Nome='$nome',
						CPF_CNPJ='$documento',
						FAX='$fax',
						TelefoneResidencial='$residencial',
						TelefoneComercial='$comercial',
						TelefoneCelular='$celular',
						Email='$email',
						Endereco='$logradouro',
						Numero='$numero',
						Complemento='$complemento',
						CEP='$cep',
						Bairro='$bairro',
						Contato='$contatos',
						Observacoes='$observacoes',
						DataNascimento='$data'
					WHERE
						CodCliente = '$id'")) {
				Info('Cliente alterado com sucesso');
				Go('../?s=clientes');
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>