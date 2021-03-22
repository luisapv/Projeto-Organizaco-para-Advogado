<?php
	session_start();
	require_once("require/php/autoload.php");
	require_once("require/config/config.php");
	$r_QueryString = explode('/',substr(REDIRECT_QUERY_STRING,3));
	$urlAmigavel = new UrlAmigavel;
?>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
		<title>SRSC - ADVOGADO</title>
		<link type="text/css" rel="stylesheet" href="/require/css/header.css" />
		<script type="text/javascript" src="/require/plugins/jquery/js/jquery-3.1.0.js"></script>
		<script type="text/javascript" src="/require/plugins/jquery/js/date-eu.js"></script>
		<script type="text/javascript" src="/require/js/header.js"></script>
	</head>
	<body>
		<div id="fb-root"></div>
		<script>
			(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
		<header>
			<div>
				
			</div>
			
			<div>
				<figure>
					
				</figure>
				
				<section>
					<figure>
						<?php
							if(!isset($_SESSION['logado'])){
						?>
						<a href="/login"><img src="/require<?=IMG_PROJETOS;?>login.png" /></a>
						<?php
							}
							else{
						?>
						<a href="/logoff"><img src="/require<?=IMG_PROJETOS;?>logoff.png" /></a>
						<?php	
							}
						?>
					</figure>
				</section>
			</div>
			
			<nav>
				<ul id="ulMenu">
					<li>
						<figure>
							<a href="/">
								<img src="/require<?=IMG_PROJETOS;?>homeP.png"/>
							</a>
						</figure>
					</li>
					<li>
						<a href="\quemsou">QUEM SOU?</a>
					</li>
					<li>
						CADASTRAR
						<ul>
							<li><a href="\advogado">ADVOGADO</a></li>
							<li><a href="\fases">FASES</a></li>
							<li><a href="\pessoaFisica">PESSOA FÍSICA</a></li>
							<li><a href="\pessoaJuridica">PESSOA JURÍDICA</a></li>
							<li><a href="\materia">MATERIA</a></li>
						</ul>
					</li>
					<li>
						<a href="\processo">PROCESSOS</a>
					</li>
					<li>
						<a href="\relatorios">RELATORIOS</a>
					</li>
				</ul>
			</nav>
		</header>
		<main>