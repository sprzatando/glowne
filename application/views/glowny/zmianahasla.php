	<?php
		if(isset($zmieniono)){
			if($zmieniono){
				echo '<h2>Hasło zostało zmienione pomyślnie</h2>';
				echo '<a href="'.site_url('glowny').'"><button class="btn btn-default">Przejdź do strony głównej</button></a>';
			}else{
				echo '<h1 style="color:red">Hasła nie są takie same</h1>';
			}
		}else{
			echo '<p>Wpisz nowe hasło</p>';
		}
	?>
	<form method="post" action="<?php echo site_url('glowny/zmianahasla'); ?>">
		<div class="form-group">
			<label for="input1">Nowe hasło:</label>
			<input id="input1" class="form-control" type="password" name="nowehaslo"/>
		</div>
		<div class="form-group">
			<label for="input2">Powtórz hasło:</label>
			<input id="input2" class="form-control" type="password" name="repnowehaslo"/>
		</div>
		<button class="btn btn-default" type="submit">Wyślij</button>
	</form>
</body>
</html>