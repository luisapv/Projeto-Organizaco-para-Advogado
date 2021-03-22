	</main>
	<footer>
		<div hidden>
			<?php
				if(!isset($_SESSION['logado'])){
			?>
			
			<?php
				}
				else{
			?>
				Login efetuado por: <span id="logadoId"><?= $_SESSION['logado']->idlogin ?></span>-<span id="logadoNome"><?= $_SESSION['logado']->nome ?></span>
			<?php	
				}
			?>
		</div>
	</footer>
	</body>
</html>
<?php

?>