	<div>
	<?php
	if($zalogowany){
		echo '<a href="'.site_url('zlecenie/nowe').'"><button class="btn btn-default">NOWE ZLECENIE</button></a>';
		echo '<a href="'.site_url('glowny/wyloguj').'"><button class="btn btn-default">WYLOGUJ SIĘ</button></a>';
	}else{
		echo '<a href="'.site_url('glowny/zaloguj').'"><button class="btn btn-default">LOGOWANIE</button></a>';
		echo '<a href="'.site_url('glowny/przypomnij').'"><button class="btn btn-default">ZAPOMNIAŁEM HASŁA</button></a>';
		echo '<a href="'.site_url('rejestracja').'"><button class="btn btn-default">REJESTRACJA</button></a>';
	}
	?>
	</div>
	<!--
	<div>
		<div>
			<form method="post">
				<select name="lista_porzadek">
					<option value="0">--</option>
					<option value="1">malejaco</option>
					<option value="2">rosnąco</option>
				</select>
				<div>
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
							<input onChange="pokoj('.$l_pokoi.')" type="checkbox" id="inputch'.$l_pokoi.'" class="form-control" name="lista_'.$x->id_pokoj.'" value="tak"/>
							<div style="display:none" class="form-group prace" id="prace'.$l_pokoi.'">';
						}
						echo '<div class="form-group">
							<label for="inputch'.$l_pokoi.$l_prace.'">'.$x->praca.'</label>
							<input type="checkbox" id="inputch'.$l_pokoi.$l_prace.'" class="form-control" name="lista_'.$x->id_pokoj.'_'.$x->id_praca.'" value="tak"/>
						</div>';
						$l_prace++;
					}
				?>
				</div>
				<button type="submit">FILTRUJ</button>
			</form>
		</div>
		<div>
		<?php
			//tutaj zrobic petle do wyswietlania zlecen
			//var_dump($zlecenia);
		?>
		</div>
	</div>
	-->
<script>
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