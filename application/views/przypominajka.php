	<?php
	if(isset($email)){
		echo '<p>Na adres email '.$email.' wysłano link do zmiany hasła</p>';
		echo '<p style="color:red">Link jest ważny 10 minut</p>';
	}
	?>
	<form method="post">
		<div class="form-group">
			<label for="input1">Email:</label>
			<input id="input1" class="form-control" name="email_przypominajka" type="email"/>
		</div>
		<button class="btn btn-default" type="submit">Wyślij</submit>
	</form>
</body>
</html>