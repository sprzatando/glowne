<div class="container-fluid">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-11">
			<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
		<?php
		if(isset($email)){
			echo '<h2>Na adres email '.$email.' wysłano link do zmiany hasła</h2>';
			echo '<h3 style="color:red">Link jest ważny 10 minut</h3>';
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
					<label for="input1">Email:</label>
					<input required id="input1" class="form-control" name="email_przypominajka" type="email"/>
				</div>
				<button class="btn btn-default" type="submit">Wyślij</submit>
			</form>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
</body>
</html>