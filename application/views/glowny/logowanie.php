<div class="container-fluid">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a>
		</div>
	</div>
	<hr />
	<?php
	if(isset($zledane)){
		echo '<h2>Niepoprawne dane logowania</h2>';
	}
	?>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-11">
			<form method="post">
				<div class="form-group">
					<label for="input1">E-mail: </label>
					<input required id="input1" class="form-control" type="text" name="email_logowanie"/>
				</div>
				<div class="form-group">
					<label for="input2">Haslo: </label>
					<input required id="input2" class="form-control" type="password" name="haslo_logowanie"/>
				</div>
				<button class="btn btn-default" type="submit">Zaloguj</button>
			</form>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
</body>
</html>