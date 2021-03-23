<?php
	require_once"../autoload.php";
	$cprocesso = new ControllerProcesso;
	
	extract($_POST);
	extract($_FILES);
	
	if($status=='SU'){
		print $cprocesso->selectUnicoProcesso($processo);
	}
	elseif($status=='IN'){
		if(empty($arquivo["name"])){
			$arq = 0;
		}
		else{
			$allowedExts = array(
	//							"gif",
	//							"jpeg",
	//							"jpg",
	//							"png",
								"pdf"
							);
			$temp = explode(".", $arquivo["name"]);
			$extension = end($temp);
			if (
				(
					($arquivo["type"] == "application/pdf")
	//		|| ($arquivo["type"] == "image/jpeg")
	//		|| ($arquivo["type"] == "image/jpg")
	//		|| ($arquivo["type"] == "image/pjpeg")
	//		|| ($arquivo["type"] == "image/x-png")
	//		|| ($arquivo["type"] == "image/png")
	//		|| ($arquivo["type"] == "image/gif")
				)
	//		&& ($arquivo["size"] < 200000)
			&& in_array($extension, $allowedExts)) {
			    if ($arquivo["error"] > 0) {
			        print "Código de retorno: " . $arquivo["error"] . "<br>";
			        exit();
			    } else {
			        $filename = '../../arquivos/processos/'.$processo.'/';
			        if(!file_exists($filename)){
			            mkdir($filename, 0777, true);
			        } 
			        if(file_exists($filename)){
			            move_uploaded_file($arquivo["tmp_name"],$filename.'1.pdf');
			            if(file_exists($filename.'1.pdf')){
							$arq=1;
						}
			            else{
							$arq=0;
						}
			        }
			    }
			} else {
			    print "Arquivo Inválido";
			    exit();
			}
		}
		print $cprocesso->cadastrar($processo,$arq,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$statu,$login);
	}
	elseif($status=='ED'){
		if(empty($arquivo["name"])){
			$arq = 0;
		}
		else{
			$allowedExts = array(
	//							"gif",
	//							"jpeg",
	//							"jpg",
	//							"png",
								"pdf"
							);
			$temp = explode(".", $arquivo["name"]);
			$extension = end($temp);
			if (
				(
					($arquivo["type"] == "application/pdf")
	//		|| ($arquivo["type"] == "image/jpeg")
	//		|| ($arquivo["type"] == "image/jpg")
	//		|| ($arquivo["type"] == "image/pjpeg")
	//		|| ($arquivo["type"] == "image/x-png")
	//		|| ($arquivo["type"] == "image/png")
	//		|| ($arquivo["type"] == "image/gif")
				)
	//		&& ($arquivo["size"] < 200000)
			&& in_array($extension, $allowedExts)) {
			    if ($arquivo["error"] > 0) {
			        print "Código de retorno: " . $arquivo["error"] . "<br>";
			        exit();
			    } else {
			        $filename = '../../arquivos/processos/'.$processo.'/';
			        if(!file_exists($filename)){
			            mkdir($filename, 0777, true);
			        } 
			        if(file_exists($filename)){
			            move_uploaded_file($arquivo["tmp_name"],$filename.'1.pdf');
			            if(file_exists($filename.'1.pdf')){
							$arq=1;
						}
			            else{
							$arq=0;
						}
			        }
			    }
			} else {
			    print "Arquivo Inválido";
			    exit();
			}
		}
		print $cprocesso->editar($processo,$antigoProcesso,$arq,$juiz,$trtTurma,$trtRelator,$tstTurma,$tstRelator,$autor,$advogadoA,$reu,$advogadoR,$fase,$motivo,$statu,$login);
	}
	elseif($status=='DE'){
		print $cprocesso->deletar($processo);
	}
	elseif($status=='carregarColunasGrid'){
		print $cprocesso->controllerXmlProcesso($status2,$login,$colunas);
	}
?>