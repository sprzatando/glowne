	<?php
	if(isset($bledy)){
		if($bledy !== true){
			$bledy = explode('|',$bledy);
			foreach($bledy as $x){
				echo '<p>'.$x.'</p>';
			}
		}
		if(!$hasla){
			echo '<p>Podane hasła nie są takie same</p>';
		}
	}else{
		if(isset($email)){
			echo '<p>Na podany adres email <strong>'.$email.'</strong> wysłano link aktywacyjny</p>';
		}
	}
	?>
	<form method="post">
		<div class="form-group">
			<label for="input1">E-mail:</label>
			<input id="input1" class="form-control" name="email_rejestracja" type="email"/>
		</div>
		<div class="form-group">
			<label for="input2">Hasło:</label>
			<input id="input2" class="form-control" name="haslo_rejestracja" type="password"/>
		</div>
		<div class="form-group">
			<label for="input3">Powtórz hasło:</label>
			<input id="input3" class="form-control" name="rep_haslo_rejestracja" type="password"/>
		</div>
		<div class="form-group">
			<label for="input4">Nick:</label>
			<input id="input4" class="form-control" name="nick_rejestracja" type="text"/>
		</div>
		<button class="btn btn-default" type="submit">Rejestruj</button>
	</form>
</body>
</html>