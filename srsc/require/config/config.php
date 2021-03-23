<?php
#REDIRECT'S
	define('REDIRECT_QUERY_STRING',isset($_SERVER['REDIRECT_QUERY_STRING'])?$_SERVER['REDIRECT_QUERY_STRING']:NULL);
	define('REDIRECT_URL',isset($_SERVER['REDIRECT_URL'])?$_SERVER['REDIRECT_URL']:NULL);
	define('DOCUMENT_ROOT',isset($_SERVER['DOCUMENT_ROOT'])?$_SERVER['DOCUMENT_ROOT']:NULL);
	
#IMAGENS
	define('IMG_EMPRESAS','/img/empresas/');
	define('IMG_LOGOS','/img/logos/');
	define('IMG_MINIATURAS','/img/miniaturas/timthumb.php?src=');
	define('IMG_PESSOAS','/img/pessoas/');
	define('IMG_PRODUTOS','/img/produtos/');
	define('IMG_PROJETOS','/img/projeto/');
	define('IMG_CARTOES','/img/projeto/cartoes/');
	
#ARQUIVOS
	define('ARQ_PROCESSOS','/arquivos/processos/');
?>