<link type="text/css" rel="stylesheet" href="/require/css/login.css" />
<script id="login.js" type="text/javascript" src="/require/js/login.js"></script>
<script id="validacoes.js" type="text/javascript" src="/require/js/validacoes.js"></script>
<script id="funcoes.js" type="text/javascript" src="/require/js/funcoes.js"></script>

<form action="javascript:void(0)" id="formLogin" autocomplete="off">
	<p>Login</p>
	<div>
		<label for="eLogin">Login:</label>
		<input type="text" id="eLogin" name="login" placeholder="Digite seu LOGIN" />
		<span id="msgELogin" for="eLogin" class="msgCamposLogin inputCampo inputButton"></span>
	</div>
	<div>
		<label for="sLogin">Senha:</label>
		<input type="password" id="sLogin" name="senha" placeholder="Digite sua SENHA" />
		<span id="msgSLogin" for="sLogin" class="msgCamposLogin inputCampo inputButton"></span>
	</div>
	<div>
		<button onclick="fctLogin()" class="inputButton button">Entrar</button>
	</div>
	<span id="msgLogin"></span>
</form>