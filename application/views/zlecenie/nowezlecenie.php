<style>
.prace{
	text-align:center;
	display:none;
}
</style>
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
		<div class="col-md-2">
		</div>
		<div class="col-md-10">
		<?php
			if(isset($min_pokoi)){
				echo '<h2>Należy wybrać minimum jeden pokój do posprzątania</h2>';
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
					<label for="input1">Miejsce: </label>
					<input required type="text" id="input1" class="form-control" name="zlecenie_miejsce"/>
				</div>
				<div class="form-group">
					<label for="input2">data: </label>
					<input required type="date" id="input2" class="form-control" name="zlecenie_data" placeholder="YYYY-MM-DD"/>
				</div>
				<div class="form-group">
					<label for="input3">godzina: </label>
					<input required type="text" id="input3" class="form-control" name="zlecenie_godzina" placeholder="GG:MM"/>
				</div>
				<div class="form-group">
					<label for="input4">Email kontaktowy: </label>
					<input required type="email" id="input4" class="form-control" name="zlecenie_email"/>
				</div>
				<button type="button" onclick="skopiujEmail()" class="btn btn-default">SKOPIUJ DOMYŚLNY</button>
				<div class="form-group">
					<label for="input5">Telefon kontaktowy: </label>
					<input required type="text" id="input5" class="form-control" name="zlecenie_telefon"/>
				</div>
				<div class="form-group">
					<label for="input6">Cena PLN:</label>
					<input required type="number" id="input6" class="form-control" name="zlecenie_cena"/>
				</div>
				
				<div class="form-group">
					<?php
						//skrypt do formularza prac
						$ostatni_pokoj = "";
						$l_pokoi=0;
						$l_prace = 1;
						foreach($prace as $x){
							if($x->pokoj != $ostatni_pokoj){
								if($l_pokoi > 0){
									echo '</div></fieldset>';
								}
								$l_pokoi++;
								$l_prace = 0;
								$ostatni_pokoj = $x->pokoj;
								echo '<fieldset>
								<legend>'.$ostatni_pokoj.'</legend>
								<input onChange="pokoj('.$l_pokoi.')" type="checkbox" id="inputch'.$l_pokoi.'" class="form-control" name="zlecenie_'.$x->id_pokoj.'" value="tak"/>
								<div class="form-group prace" id="prace'.$l_pokoi.'">';
							}
							echo '<div class="form-group">
								<label for="inputch'.$l_pokoi.$l_prace.'">'.$x->praca.'</label>
								<input type="checkbox" id="inputch'.$l_pokoi.$l_prace.'" class="form-control" name="zlecenie_'.$x->id_pokoj.'_'.$x->id_praca.'" value="tak"/>
							</div>';
							$l_prace++;
						}
						echo '</div></fieldset>';
					?>
				</div>
				<button type="submit" class="btn btn-default">PRZEŚLIJ</button>
			</form>
		</div>
		<div class="col-md-1">
		</div>
	</div>
</div>
<script>
var email_domyslny = '<?php echo $email; ?>';

function skopiujEmail(){
	document.getElementById("input4").value = email_domyslny;
}
function pokoj(l){
	var div = document.getElementById("prace"+l);
	var checkbox = document.getElementById("inputch"+l);
	console.log(checkbox);
	if(checkbox.checked){
		div.style.display = "block";
	}else{
		div.style.display = "none";
	}
}
</script>
</body>
</html>