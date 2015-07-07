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

		$_SESSION['fornecedores'] = $_POST;
		$cnpj = soNum($cnpj);
		
		$nome = addslashes($nome);
		$razao_social = addslashes($razao_social);
		
		
		IF($email!=""){
			$checkEmail = mysql_query("SELECT CodFornecedor FROM fornecedores WHERE Email = '$email'");
			if(mysql_num_rows($checkEmail)>0) {
				Erro('E-mail já consta no sistema'); Go();
			}
		}
		
		IF($cnpj!=""){
			$checkCnpj = mysql_query("SELECT CodFornecedor FROM fornecedores WHERE CNPJ = '$cnpj'");
			if(mysql_num_rows($checkCnpj)>0) {
				Erro('CNPJ já consta no sistema'); Go();
			}
		ValidaCNPJ($cnpj);
		}
	if($cod_cidades ==  NULL) {$cod_cidades = '';}
		if (semErros()) {
			if (mysql_query("INSERT INTO fornecedores
					(Nome, CNPJ, FAX, Telefone, Celular, Produto, Email, Site, RazaoSocial, IE, CEP, Endereco, Numero, Complemento, Bairro, CodCidade, Contato, Observacoes, Ranking, BoxCEASA, BoxCEASABatata, status, DataCadastra)
				VALUES
					('$nome', '$cnpj', '$fax', '$telefone', '$celular', '$produtos', '$email', '$site', '$razao_social', '$insc', '$cep', '$logradouro', '$numero', '$complemento', '$bairro', '$cod_cidades', '$contatos', '$observacoes', '$ranking', '$ceasa', '$ceasa_batata', '$status', NOW())")) {
				Info('Fornecedor cadastrado com sucesso');
				unset($_SESSION['fornecedores']);
				Go('../?s=fornecedores');
			} else Erro("Erro durante cadastro, tente novamente");
		}
		Go();
	break;
	case 'exclui':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE fornecedores SET status='0' WHERE CodFornecedor = '$id'")) {

			mysql_query("UPDATE precos SET status='0' WHERE CodFornecedor = '$id'");

			Info ("Fornecedor removido com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'ativa':
		$id = (int)$_GET['id'];
		if (mysql_query("UPDATE fornecedores SET status='1' WHERE CodFornecedor = '$id'")) {

			mysql_query("UPDATE precos SET status='1' WHERE CodFornecedor = '$id'");

			Info ("Fornecedor ativo com sucesso");
		} else Erro("Erro durante a exclusão");
		Go();
	break;
	case 'altera':
	
		$nome = addslashes($nome);
		$razao_social = addslashes($razao_social);
		
		
		ValidaID($id,'CodFornecedor','fornecedores');
		ValidaVazio($nome,'Campo nome inválido');
		$data = DateToUs($data);
		
		if($cod_cidades ==  NULL) {$cod_cidades = '';}

						
		if (semErros()) {
			if (mysql_query("UPDATE fornecedores 
					SET
						status='$status',
						Ranking='$ranking',
						Nome='$nome',
						RazaoSocial='$razao_social',
						CNPJ='$cnpj',
						IE='$insc',
						FAX='$fax',
						Telefone='$telefone',
						Celular='$celular',
						Produto='$produtos',
						Email='$email',
						Endereco='$logradouro',
						Numero='$numero',
						Complemento='$complemento',
						CEP='$cep',
						Bairro='$bairro',
						CodCidade='$cod_cidades',
						Contato='$contatos',
						Observacoes='$observacoes',
						BoxCEASA='$ceasa',
						BoxCEASABatata='$ceasa_batata'
					WHERE
						CodFornecedor = '$id'")) {
				Info('Fornecedor alterado com sucesso');
				Go();
			} else {
				Erro('Erro durante a alteração, tente novamente');
			}
		}
		Go();
	break;
}
?>