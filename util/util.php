<?php
#evita engraçadinhos aproveitarem sqlInjection 
function _antiSqlInjection($Target){
    $sanitizeRules = array('OR','FROM','SELECT','INSERT','DELETE','WHERE','DROP TABLE','SHOW TABLES','*','--','=');
    foreach($Target as $key => $value):
        if(is_array($value)): $arraSanitized[$key] = _antiSqlInjection($value);
        else:
            $arraSanitized[$key] = (!get_magic_quotes_gpc()) ? addslashes(str_ireplace($sanitizeRules,"",$value)) : str_ireplace($sanitizeRules,"",$value);
        endif;
    endforeach;
    return $arraSanitized;
}

function encrypt($string,$key) {
	$result = '';
	for ($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	$result = urlencode($result);
	$result = base64_encode($result);
	return $result;
}

function decrypt($string,$key) {
	$result = '';
	$string = base64_decode($string);
	$string = urldecode($string);
	for ($i=0; $i<strlen($string); $i++) {
		$char = substr($string, $i, 1);
		$keychar = substr($key, ($i % strlen($key))-1, 1);
		$char = chr(ord($char)-ord($keychar));
		$result.=$char;
	}
	return $result;
}
function SubjectEncode($string) {
	return '=?UTF-8?B?'.base64_encode($string).'?=';
}
function utf8_strtolower($string) {
	return utf8_encode(strtolower(utf8_decode($string)));
}
function title($string) {
	$string = utf8_strtolower($string);
	$preps = array('a','o','as','os','uma','um','umas','uns','da','das',
			'do','dos','de','em','para','à','na','no','nas','nos','que');
	$string = explode(' ',$string);
	foreach ($string as $k => $value) {
		if (!in_array($value,$preps)) {
			$string[$k] = ucfirst($value);
		}
	}
	return implode(' ',$string);
}
function FiltraPost(&$post) {
	foreach ($post as $key => $value) {
		if (is_array($value)) FiltraPost($value);
		else {
			if (get_magic_quotes_gpc()) $post[$key] = trim($post[$key]); else $post[$key] = addslashes(trim($post[$key]));
		}
	}
}
function LimpaPost(&$post) {
	if (get_magic_quotes_gpc()) {
		foreach ($post as $key => $val) {
			$val = trim($val);
		}
	} else {
		foreach ($post as $key => $val) {
			$val = addslashes(trim($val));
		}
	}
}
function LimpaPonto($var) {
	$var = strtolower($var);
	$var = str_replace("-","",$var);
	$var = str_replace(",","",$var);
	$var = str_replace(".","",$var);
	return $var;
}
function old_Normaliza($string){
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
    $string = utf8_decode($string);    
    $string = strtr($string, utf8_decode($a), $b);
    $string = strtolower($string);
    return utf8_encode($string);
}
function Normaliza($string) {
	$table = array('Š'=>'S','š'=>'s','Đ'=>'Dj','đ'=>'dj','Ž'=>'Z','ž'=>'z','Č'=>'C','č'=>'c','Ć'=>'C','ć'=>'c','À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'A','Ç'=>'C','È'=>'E','É'=>'E',
	'Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I','Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y','Þ'=>'B','ß'=>'Ss',
	'à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a','æ'=>'a','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i','í'=>'i','î'=>'i','ï'=>'i','ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o',
	'ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u','ý'=>'y','ý'=>'y','þ'=>'b','ÿ'=>'y','Ŕ'=>'R','ŕ'=>'r');
	return strtr($string, $table);
}
function formataURL($s,$n=5) {
	$r = array(',','"',"'",';','.',':','?','!','&');
	$s = Normaliza($s);
	$s = str_replace('/','-',$s);
	$s = str_replace($r,'',$s);
	$a = explode(' ',$s);
	$a = array_slice($a,0,$n);
	return implode('-',$a);
}
function soNum($s){
    return preg_replace('/[^0-9]/','',$s);
}

function MoedaBr($s) {
	return number_format($s,2,',','.');
}
function MoedaUs($s) {
	$s = str_replace('.','',$s);
	$s = str_replace(',','.',$s);
	return number_format($s,2,'.','');
}
function DateToUs($s) {
	list($d,$m,$a) = explode('/',$s);
	return $a.'-'.$m.'-'.$d;
}

function DateToBr($s) {
	list($a,$m,$d) = explode('-',$s);
	return $d.'/'.$m.'/'.$a;
}
function DateLeg($s) {
	list($d,$m) = explode('-',$s);
	return $d.'/'.$m;
}

function SmallDateToBr($s) {
	list($a,$m,$d) = explode('-',$s);
	return $d.'/'.$m;
}

function DateToArr($s) {
	if (strpos($s,'/') !== false) list($d,$m,$a) = explode('/',$s); else list($a,$m,$d) = explode('-',$s);
	$a = array('d'=>$d,'m'=>$m,'a'=>$a);
	return $a;
}
function datetimeToUs($s) {
	list($d,$t) = explode(' ',$s,2);
	list($d,$m,$a) = explode('/',$d);
	list($h,$i) = explode(':',$t);
	return $a.'-'.$m.'-'.$d.' '.$h.':'.$i;
}
function datetimeToBr($s) {
	list($d,$t) = explode(' ',$s,2);
	list($a,$m,$d) = explode('-',$d);
	list($h,$i,$s) = explode(':',$t);
	return $d.'/'.$m.'/'.$a.' - '.$h.':'.$i.':'.$s;
}

function FloatToBr($s) {
	$s = str_replace(',','',$s);
	return str_replace('.',',',$s);
}

function FloatToUs($s) {
	$s = str_replace('.','',$s);
	return str_replace(',','.',$s);
}

function AltCase($string,$tp=1) {
	if ($tp == "1") $string = strtr(strtoupper($string),"àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ","ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß");
    else $string = strtr(strtolower($string),"ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖ×ØÙÜÚÞß","àáâãäåæçèéêëìíîïðñòóôõö÷øùüúþÿ");
    return $string;
}

function cut($string,$chars) {
	$len = strlen($string);
	if ($chars < $len) {
		$string = substr($string,0,$chars);
		if (substr($string,-1,1) != ' ') {
			for ($x = -2; $x < 0 ; $x--) {
				if (substr($string,$x,1) == ' ') {
					break;
				}
			}
			$x = $chars + $x;
			return substr($string,0,$x).'...';
		} else {
			return substr($string,0,$chars-1).'...';
		}
	} else {
		return $string;
	}
}

function Reduz($string,$maxwords) {
	$words = explode(' ',$string);
	$numwords = count($words);
	if ($numwords > $maxwords) {
		for ($i=0;$i<$maxwords;$i++) {
			$text .= ' '.$words[$i];
		}
		return trim($text).'...';
	} else {
		return trim($string);
	}
}

function FormataCep($cep) {
	return substr($cep,0,5).'-'.substr($cep,5,3);
}
	
function FormataFone($fone) {
	return '('.substr($fone,0,2).') '.substr($fone,2,4).' '.substr($fone,6,4);
}

function Redir($pag='') {
	echo "<script type=\"text/javascript\">";
	if (empty($pag)) {
		echo "window.open(\"".$_SERVER['HTTP_REFERER']."\",\"_self\");";
	} else {
		echo "window.open(\"".$pag."\",\"_self\");";
	}
	echo "</script>";
	exit;
}

function Go($pag='') {
	if ($pag) header('Location: '.$pag); else header('Location: '.$_SERVER['HTTP_REFERER']);
	header('Connection: close');
	exit();
}

function Erro($str) {
	$_SESSION['Erros'][count($_SESSION['Erros'])] = $str;
}
function Erro2($str) {
	$_SESSION['Erros2'][count($_SESSION['Erros2'])] = $str;
}

function Info($str) {
	$_SESSION['Info'] = $str;
}

function showErros() {
	$erros = count($_SESSION['Erros']);
	$info = count($_SESSION['Info']);
	if ($erros > 0) {
		echo '<div class="alert alert-error">
				<button class="close" data-dismiss="alert">×</button>';

		foreach ($_SESSION['Erros'] as $erro) {
			echo '<p>'.$erro.'</p>';
		}
		echo '</div>';
		#session_unregister('Erros'); deprecated
		unset($_SESSION['Erros']);
	}
	if ($info>0) {
		echo '<div class="alert alert-success"><button class="close" data-dismiss="alert">×</button>'.$_SESSION['Info'].'</div>';
		unset($_SESSION['Info']);
		#session_unregister('Info'); deprecated
	}
}

function semErros() {
	if (count($_SESSION['Erros'])) return false; else return true;
}

function print_array($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function ValidaSenha($senha,$conf) {
	if (strlen($senha) > 3) {
		if ($senha == $conf) {
			return true;
		} else {
			Erro('A confirmação deve ser idêntica à senha');
			return false;
		}
	} else {
		Erro('Campo senha deve conter no mínimo 4 caracteres');
		return false;
	}
}
//Validar Cnpj
function ValidaCNPJ($Cnpj) {
	$RecebeCNPJ=${"Cnpj"};
	$s="";
	for ($x=1; $x<=strlen($RecebeCNPJ); $x=$x+1) {
		$ch=substr($RecebeCNPJ,$x-1,1);
		if (ord($ch)>=48 && ord($ch)<=57) {
			$s=$s.$ch;
		}
	}

	$RecebeCNPJ=$s;
	if ($RecebeCNPJ=="00000000000000") {
		$then;
		return false;
	} else {
		$Numero[1]=intval(substr($RecebeCNPJ,1-1,1));
		$Numero[2]=intval(substr($RecebeCNPJ,2-1,1));
		$Numero[3]=intval(substr($RecebeCNPJ,3-1,1));
		$Numero[4]=intval(substr($RecebeCNPJ,4-1,1));
		$Numero[5]=intval(substr($RecebeCNPJ,5-1,1));
		$Numero[6]=intval(substr($RecebeCNPJ,6-1,1));
		$Numero[7]=intval(substr($RecebeCNPJ,7-1,1));
		$Numero[8]=intval(substr($RecebeCNPJ,8-1,1));
		$Numero[9]=intval(substr($RecebeCNPJ,9-1,1));
		$Numero[10]=intval(substr($RecebeCNPJ,10-1,1));
		$Numero[11]=intval(substr($RecebeCNPJ,11-1,1));
		$Numero[12]=intval(substr($RecebeCNPJ,12-1,1));
		$Numero[13]=intval(substr($RecebeCNPJ,13-1,1));
		$Numero[14]=intval(substr($RecebeCNPJ,14-1,1));
		
		$soma=$Numero[1]*5+$Numero[2]*4+$Numero[3]*3+$Numero[4]*2+$Numero[5]*9+$Numero[6]*8+$Numero[7]*7+
		$Numero[8]*6+$Numero[9]*5+$Numero[10]*4+$Numero[11]*3+$Numero[12]*2;
		
		$soma=$soma-(11*(intval($soma/11)));
		
		if ($soma==0 || $soma==1) {
			$resultado1=0;
		} else {
			$resultado1=11-$soma;
		}
	
		if ($resultado1==$Numero[13]) {
			$soma=$Numero[1]*6+$Numero[2]*5+$Numero[3]*4+$Numero[4]*3+$Numero[5]*2+$Numero[6]*9+
			$Numero[7]*8+$Numero[8]*7+$Numero[9]*6+$Numero[10]*5+$Numero[11]*4+$Numero[12]*3+$Numero[13]*2;
			$soma=$soma-(11*(intval($soma/11)));
			if ($soma==0 || $soma==1) {
				$resultado2=0;
			} else {
				$resultado2=11-$soma;
			}

			if ($resultado2==$Numero[14]) {
				return false;
			} else {
				Erro('CNPJ Inválido.');
				return false;
			}
		} else {
			Erro('CNPJ Inválido.');
			return false;
		}
	}
}

function ValidaCPF($cpf,$mensagem='CPF inválido') {
	if (!$cpf) {
		if ($mensagem) {
			Erro($mensagem);
		}
	}
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{
		Erro($mensagem);
		return false;
    }
	$RecebeCPF=$cpf;
	$s="";
	for ($x=1; $x<=strlen($RecebeCPF); $x++) {
		$ch=substr($RecebeCPF,$x-1,1);
		if (ord($ch)>=48 && ord($ch)<=57) {
			$s=$s.$ch;
		}
	}
	
	$RecebeCPF=$s;
	if ($RecebeCPF=="00000000000") {
		$then;
		if ($mensagem) {
			Erro($mensagem);
		}
		return false;
	} else {
		$Numero[1]=intval(substr($RecebeCPF,1-1,1));
		$Numero[2]=intval(substr($RecebeCPF,2-1,1));
		$Numero[3]=intval(substr($RecebeCPF,3-1,1));
		$Numero[4]=intval(substr($RecebeCPF,4-1,1));
		$Numero[5]=intval(substr($RecebeCPF,5-1,1));
		$Numero[6]=intval(substr($RecebeCPF,6-1,1));
		$Numero[7]=intval(substr($RecebeCPF,7-1,1));
		$Numero[8]=intval(substr($RecebeCPF,8-1,1));
		$Numero[9]=intval(substr($RecebeCPF,9-1,1));
		$Numero[10]=intval(substr($RecebeCPF,10-1,1));
		$Numero[11]=intval(substr($RecebeCPF,11-1,1));
		
		$soma = 10*$Numero[1]+9*$Numero[2]+8*$Numero[3]+7*$Numero[4]+6*$Numero[5]+5*
		$Numero[6]+4*$Numero[7]+3*$Numero[8]+2*$Numero[9];
		$soma=$soma-(11*(intval($soma/11)));
		
		if ($soma==0 || $soma==1) {
			$resultado1=0;
		} else {
			$resultado1=11-$soma;
		}
		if ($resultado1==$Numero[10]) {
			$soma=$Numero[1]*11+$Numero[2]*10+$Numero[3]*9+$Numero[4]*8+$Numero[5]*7+$Numero[6]*6+$Numero[7]*5+
			$Numero[8]*4+$Numero[9]*3+$Numero[10]*2;
			$soma=$soma-(11*(intval($soma/11)));
			if ($soma==0 || $soma==1) {
				$resultado2=0;
			} else {
				$resultado2=11-$soma;
			}
	
			if ($resultado2==$Numero[11]) {
				return true;
			} else {
				if ($mensagem) {
					Erro($mensagem);
				}
				return false;
			}
		} else {
			if ($mensagem) {
				Erro($mensagem);
			}
			return false;
		}
	}
}

// Função que valida o CPF
function validarCPF($cpf)
{	// Verifiva se o número digitado contém todos os digitos
    $cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);
	
	// Verifica se nenhuma das sequências abaixo foi digitada, caso seja, retorna falso
    if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999')
	{

	return false;
    }
	else
	{   // Calcula os números para verificar se o CPF é verdadeiro
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf{$c} * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf{$c} != $d) {
                return false;
            }
        }

        return true;
    }
}

function ValidaNome($nome) {
	if (strlen($nome) > 4) {
		return true;
	} else {
		Erro('O nome deve conter no mínimo 5 caracteres.');
		return false;
	}
}

function ValidaCidade($cidade) {
	if (strlen($cidade) > 2) {
		return true;
	} else {
		Erro('O campo cidade deve conter no mínimo 3 caracteres.');
		return false;
	}
}

function ValidaEndereco($endereco) {
	if (strlen($endereco) > 5) {
		return true;
	} else {
		Erro('Endereço inválido.');
		return false;
	}
}

function ValidaID($id,$campo,$tabela,$msg='') {
	if ($msg == '') $msg = 'Identificação inválida.';
	if (!empty($id)) {
		if (is_numeric($id)) {
			$res = mysql_query("SELECT $campo FROM $tabela WHERE $campo = $id");
			if (@mysql_num_rows($res) > 0) {
				return true;
			} else {
				Erro($msg);
				return false;
			}
		} else {
			Erro($msg);
			return false;
		}
	} else {
		Erro($msg);
		return false;
	}
}

function ValidaCEP($cep,$mensagem='') {
	if (ereg("^[0-9]{8}$",$cep)) {
		return true;
	} else {
		if ($mensagem) Erro($mensagem);
		return false;
	}
}

// function ValidaEmail($email,$m='') {
// 	if (ereg("^([0-9,a-z,A-Z]+)([.,_]([0-9,a-z,A-Z]+))*[@]([0-9,a-z,A-Z]+)([.,_,-]([0-9,a-z,A-Z]+))*[.]([0-9,a-z,A-Z]){2}([0-9,a-z,A-Z])?$",$email)) { 
// 		return true;
// 	} else {
// 		if (!$m) Erro('E-mail inválido.'); else Erro($m);
// 		return false;
// 	}
// }
function validaEmail($email) {
	$conta = "^[a-zA-Z0-9\._-]+@";
	$domino = "[a-zA-Z0-9\._-]+.";
	$extensao = "([a-zA-Z]{2,4})$";

	$pattern = $conta.$domino.$extensao;

	if (ereg($pattern, $email))
		return true;
	else
		return false;
}

function ValidaFone($fone,$msg) {
	if (ereg("^[0-9]{10}$",$fone)) {
		return true;
	} else {
		Erro($msg);
		return false;
	}
}

function ValidaVazio($campo,$msg='') {
	if (!empty($campo)) {
		return true;
	} else {
		if ($msg) {
			Erro($msg);
		}
		return false;
	}
}
function FormataCPF_CNPJ($campo, $formatado = true) {
    //retira formato
    $codigoLimpo = ereg_replace("[' '-./ t]",'',$campo);
    // pega o tamanho da string menos os digitos verificadores
    $tamanho = (strlen($codigoLimpo) -2);
    //verifica se o tamanho do código informado é válido
    if ($tamanho != 9 && $tamanho != 12) {
        return false;
    } 
    if ($formatado) {
        // seleciona a máscara para cpf ou cnpj
	   $mascara = ($tamanho == 9) ? '###.###.###-##' : '##.###.###/####-##';

        $indice = -1;
        for ($i=0; $i < strlen($mascara); $i++) {
            if ($mascara[$i] == '#') $mascara[$i] = $codigoLimpo[++$indice];
        }
        //retorna o campo formatado
        $retorno = $mascara;
 
    } else {
        //se não quer formatado, retorna o campo limpo
        $retorno = $codigoLimpo;
    }
    return $retorno;
}
function GeraSenha(){
	$senha = "";
	$str = "abcdefgh1234567890";
	for($i=1;$i<=10;$i++){
		$n = rand(0,18);
		$senha.= substr($str,$n,1);
	}
	return $senha;
}

$CaracteresAceitos = 'abcdxywzABCDZYWZ0123456789'; 
$max = strlen($CaracteresAceitos)-1;
$random = null;
for($i=0; $i < 4; $i++) { 
$random .= $CaracteresAceitos{mt_rand(0, $max)}; 
}

function data_extenso ($data = false) {
	if ($data) {
		$mes = date('m', strtotime($data));
	} else {
		$mes = date('m');
		$data = date('Y-m-d');
	}
	$meses = array
	(
		'01' => 'Janeiro',
		'02' => 'Fevereiro',
		'03' => 'Março',
		'04' => 'Abril',
		'05' => 'Maio',
		'06' => 'Junho',
		'07' => 'Julho',
		'08' => 'Agosto',
		'09' => 'Setembro',
		'10' => 'Outubro',
		'11' => 'Novembro',
		'12' => 'Dezembro'
	);
	$dias = array
	(
		0 => 'Domingo',
		1 => 'Segunda-feira',
		2 => 'Terça-feira',
		3 => 'Quarta-feira',
		4 => 'Quinta-feira',
		5 => 'Sexta-feira',
		6 => 'Sábado'
	);
	return date('d', strtotime($data)) . ' de ' . $meses[$mes] . ' de ' . date('Y', strtotime($data));
}

function ismyimage($myfile) {
    if((($myfile["type"] == "image/gif") || ($myfile["type"] == "image/jpg") || ($myfile["type"] == "image/jpeg") || ($myfile["type"] == "image/png")) && ($myfile["size"] <= 2097152 /*2mb*/) ) return true; 
    else return false;
}

function upload_file($myfile, $largura, $altura, $pasta) {   

	if(ismyimage($myfile)) {
	    $information=getimagesize($myfile["tmp_name"]);
	    $mywidth=$information[0];
	    $myheight=$information[1];

	    $newwidth=$mywidth;
	    $newheight=$myheight;
	    while(($newwidth > $largura) || ($newheight > $altura )) {
            $newwidth = $newwidth-ceil($newwidth/100);
            $newheight = $newheight-ceil($newheight/100);
        }

	    $files=$myfile["name"];

	    if($myfile["type"] == "image/gif"){
		    $tmp=imagecreatetruecolor($newwidth,$newheight);
		    $src=imagecreatefromgif($myfile["tmp_name"]);
		    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $mywidth, $myheight);
		    $con=imagegif($tmp.$pasta, $pasta.$files);
		    imagedestroy($tmp);
		    imagedestroy($src);
		    if($con){return true;} else {return false;}
	    }
	    else if(($myfile["type"] == "image/jpg") || ($myfile["type"] == "image/jpeg") ) {
		    $tmp=imagecreatetruecolor($newwidth,$newheight);
		    $src=imagecreatefromjpeg($myfile["tmp_name"]); 
		    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $mywidth, $myheight);
		    $con=imagejpeg($tmp, $pasta.$files);
		    imagedestroy($tmp);
		    imagedestroy($src);
		    if($con){  return true;} else {return false;}
	    }
	    else if($myfile["type"] == "image/png") {
		    $tmp=imagecreatetruecolor($newwidth,$newheight);
		    $src=imagecreatefrompng($myfile["tmp_name"]);
		    imagealphablending($tmp, false);
		    imagesavealpha($tmp,true);
		    $transparent = imagecolorallocatealpha($tmp, 255, 255, 255, 127);
		    imagefilledrectangle($tmp, 0, 0, $newwidth, $newheight, $transparent); 
		    imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $mywidth, $myheight);
		    $con=imagepng($tmp, $pasta.$files);
		    imagedestroy($tmp);
		    imagedestroy($src);
	    	if($con){ return true;} else { return false; }
	    }
	    return $files;
    }
	else return false;
}

?>
