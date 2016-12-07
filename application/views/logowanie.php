	<main>
		<h1>Witamy na stronie sprzątando!</h1>
		<h2>Proszę zalogować się lub przejść do strony rejestracji</h2>
		<form method="post">
			<div class="form-group">
				<label for="input1">E-mail: </label>
				<input id="input1" class="form-control" type="text" name="email_logowanie"/>
			</div>
			<div class="form-group">
				<label for="input2">Haslo: </label>
				<input id="input2" class="form-control" type="password" name="haslo_logowanie"/>
			</div>
			<button class="btn btn-default" type="submit">Zaloguj</button>
		</form>
		<a href="<?php echo site_url('rejestracja'); ?>">REJESTRACJA</a>
	</main>
</body>
</html>