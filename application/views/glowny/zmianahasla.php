<div class="container-fluid">
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
		<?php
			if(isset($zmieniono)){
				if($zmieniono){
					echo '<h3>Hasło zostało zmienione pomyślnie</h3>';
					echo '<a href="'.site_url('glowny').'"><button class="btn btn-default">Przejdź do strony głównej</button></a>';
				}else{
					echo '<h3 style="color:red">Hasła nie są takie same</h3>';
				}
			}else{
				echo '<h3>Wpisz nowe hasło</h3>';
			}
		?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<form method="post" action="<?php echo site_url('glowny/zmianahasla'); ?>">
				<div class="form-group">
					<label for="input1">Nowe hasło:</label>
					<input required id="input1" class="form-control" type="password" name="nowehaslo"/>
				</div>
				<div class="form-group">
					<label for="input2">Powtórz hasło:</label>
					<input required id="input2" class="form-control" type="password" name="repnowehaslo"/>
				</div>
				<button class="btn btn-default" type="submit">Wyślij</button>
			</form>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
</body>
</html>