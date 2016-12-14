<div class="container-fluid">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-11">
			<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a>
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-md-4">
		</div>
		<div class="col-md-8">
		<?php
		if(isset($bledy)){
			if($bledy !== true){
				$bledy = explode('|',$bledy);
				foreach($bledy as $x){
					echo '<h3>'.$x.'</h3>';
				}
			}
			if(!$hasla){
				echo '<h3>Podane hasła nie są takie same</h3>';
			}
		}else{
			if(isset($email)){
				echo '<h3>Na podany adres email <strong>'.$email.'</strong> wysłano link aktywacyjny</h3>';
			}
		}
		?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<form method="post">
				<div class="form-group">
					<label for="input1">E-mail:</label>
					<input required id="input1" class="form-control" name="email_rejestracja" type="email"/>
				</div>
				<div class="form-group">
					<label for="input2">Hasło:</label>
					<input required id="input2" class="form-control" name="haslo_rejestracja" type="password"/>
				</div>
				<div class="form-group">
					<label for="input3">Powtórz hasło:</label>
					<input required id="input3" class="form-control" name="rep_haslo_rejestracja" type="password"/>
				</div>
				<div class="form-group">
					<label for="input4">Nick:</label>
					<input required id="input4" class="form-control" name="nick_rejestracja" type="text"/>
				</div>
				<button class="btn btn-default" type="submit">Rejestruj</button>
			</form>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
</body>
</html>