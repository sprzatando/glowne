	<div class="container-fluid">	
		<div class="row">
		<?php
		if($zalogowany){
			echo '<a href="'.site_url('zlecenie/nowe').'"><button class="btn btn-default">NOWE ZLECENIE</button></a>';
			echo '<a href="'.site_url('uzytkownik').'"><button class="btn btn-default">PANEL UŻYTKOWNIKA</button></a>';
			echo '<a href="'.site_url('glowny/wyloguj').'"><button class="btn btn-default">WYLOGUJ SIĘ</button></a>';
		}else{
			echo '<a href="'.site_url('glowny/zaloguj').'"><button class="btn btn-default">LOGOWANIE</button></a>';
			echo '<a href="'.site_url('glowny/przypomnij').'"><button class="btn btn-default">ZAPOMNIAŁEM HASŁA</button></a>';
			echo '<a href="'.site_url('rejestracja').'"><button class="btn btn-default">REJESTRACJA</button></a>';
		}
		?>
		</div>
		<div class="row">
			<div class="col-md-2">
				<form method="post">
					<select name="lista_porzadek">
						<option <?php echo (($porzadek == null)? 'selected':''); ?> value="0">--</option>
						<option <?php echo(($porzadek == 1)? 'selected':''); ?> value="1">malejaco</option>
						<option <?php echo(($porzadek == 2)? 'selected':''); ?> value="2">rosnąco</option>
					</select>
					<?php
						//skrypt do formularza prac
						$ostatni_pokoj = "";
						$l_pokoi=0;
						$l_prace = 1;
						foreach($prace as $x){
							if($x->pokoj != $ostatni_pokoj){
								if($l_pokoi >0){
									echo '</div></fieldset>';
								}
								$l_pokoi++;
								$l_prace = 0;
								$ostatni_pokoj = $x->pokoj;
								echo '
								<fieldset>
								<legend>'.$ostatni_pokoj.'<input '.((strpos($sparsowany,$x->id_pokoj.'_'))? 'checked':'').' onChange="pokoj('.$l_pokoi.')" type="checkbox" id="inputch'.$l_pokoi.'" class="form-control" name="lista_'.$x->id_pokoj.'" value="tak"/></legend>
								<div style="display:none" id="prace'.$l_pokoi.'">';
							}
							echo '<div class="form-group">
								<label for="inputch'.$l_pokoi.$l_prace.'">'.$x->praca.'</label>
								<input '.((strpos($sparsowany,$x->id_pokoj.'_'.$x->id_praca))?'checked':'').' type="checkbox" id="inputch'.$l_pokoi.$l_prace.'" class="form-control" name="lista_'.$x->id_pokoj.'_'.$x->id_praca.'" value="tak"/>
							</div>';
							$l_prace++;
						}
						echo '</div></fieldset>';
					?>
					<button class="btn btn-default" type="submit">FILTRUJ</button>
				</form>
			</div>
			<div class="col-md-10">
				<h2>AKTUALNE ZLECENIA</h2>
				<table class="table table-striped">
					<tr><th>zlecający</th><th>miejsce</th><th>data</th><th>godzina</th><th>cena</th><th>szczegóły</th></tr>
					<?php
						foreach($zlecenia as $x){
							echo '<tr><td>'.$x->nick.'</td><td>'.$x->miejsce.'</td><td>'.$x->data.'</td><td>'.$x->godzina.'</td><td>'.$x->cena.'</td><td><a target="_blank" href="'.site_url('zlecenie/index/'.$x->id_zlecenie).'"><button class="btn btn-default">SZCZEGÓŁY</button></a></td></tr>';
						}
					?>
				</table>
			</div>
		</div>
	</div>
<script>
function pokoj(l){
	var div = document.getElementById("prace"+l);
	console.log(l);
	var checkbox = document.getElementById("inputch"+l);
	console.log(checkbox);
	if(checkbox.checked){
		div.style.display = "block";
	}else{
		div.style.display = "none";
	}
}

window.onload = function(){
	for(var i = 1;i <= <?php echo $l_pokoi; ?>;i++){
		pokoj(i);
	}
}
</script>
</body>
</html>