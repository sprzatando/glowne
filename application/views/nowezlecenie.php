	<form method="post">
		<div class="form-group">
			<label for="input1">Miejsce: </label>
			<input type="text" id="input1" class="form-control" name="zlecenie_miejsce"/>
		</div>
		<div class="form-group">
			<label for="input2">data: </label>
			<input type="date" id="input2" class="form-control" name="zlecenie_data" placeholder="YYYY-MM-DD"/>
		</div>
		<div class="form-group">
			<label for="input3">godzina: </label>
			<input type="text" id="input3" class="form-control" name="zlecenie_godzina" placeholder="GG:MM"/>
		</div>
		<div class="form-group">
			<label for="input4">Email kontaktowy: </label>
			<input type="email" id="input4" class="form-control" name="zlecenie_email"/>
		</div>
		<button onclick="skopiujEmail()" class="btn btn-default">SKOPIUJ DOMYŚLNY</button>
		<div class="form-group">
			<label for="input5">Telefon kontaktowy: </label>
			<input type="text" id="input5" class="form-control" name="zlecenie_telefon"/>
		</div>
		<div class="form-group">
			<label for="inputch1">xd</label>
			<input type="checkbox" id="inputch1" class="form-control" name="zlecenie_pokoje1" value="xd"/>
			<div class="form-group prace" id="prace1">
				
			</div>
			<label for="inputch2">xddd</label>
			<input type="checkbox" id="inputch2" class="form-control" name="zlecenie_pokoje2" value="gitara siema"/>
			<div class="form-group prace" id="prace2">
				
			</div>
		</div>
		<button type="submit" class="btn btn-default">Prześlj</button>
	</form>
</body>
</html>