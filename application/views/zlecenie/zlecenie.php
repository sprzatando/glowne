<div class="container-fluid">
	<div class="row">
		<div class="col-md-2">
		</div>
		<div class="col-md-10">
			<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a>
		</div>
	</div>
	<hr/>
	<div class="row">
	<?php
		if(isset($zglos_sie)){
			if($zglos_sie == 1){
				echo '<h2>Pomyślnie zgłoszono się do tego zlecenia</h2>';
			}
		}
		if(isset($podjecie)){
			if($podjecie == 1){
				echo '<h2>Pomyślnie podjęto się tej pracy</h2>';
			}
		}
		if(isset($zgloszenia)){
			if($zgloszenia == 1){
				echo '<h2>Wybrano osobę do wykonania tej pracy</h2>';
			}
		}
		if(isset($ocena)){
			if($ocena == 1){
				echo '<h2>Oceniono wykonanie pracy</h2>';
			}
		}
	?>
	</div>
	
	<hr/>
	
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-10">
				</div>
				<div class="col-md-2">
					<h3><?php echo $dane[0]->cena; ?></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-8">
					<div class="row">
						<table class="table">
							<tr><th>miejsce</th><th>data</th><th>godzina</th></tr>
							<tr><td><?php echo $dane[0]->miejsce; ?></td><td><?php echo $dane[0]->data; ?></td><td><?php echo $dane[0]->godzina; ?></td></tr>
						</table>
					</div>
					<div class="row">
						<table class="table">
							<tr><th>telefon</th><th>email</th></tr>
							<tr></td><td><?php echo $dane[0]->telefon; ?></td></td><td><?php echo $dane[0]->mail_kontaktowy; ?></td></tr>
						</table>
					</div>
					<div class="row">
						<div class="col-md-10">
						</div>
						<div class="col-md-2">
							<h3>zlecający</h3>
							<?php echo '<a target="_blank" href="'.site_url('opinie/dla/'.$dane[0]->zlecajacy_id).'"><button class="btn btn-default">'.$dane[0]->nick.'</button></a>'; ?>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<h2>pokoje i prace</h2>
					<ul>
					<?php
					$pp = $dane[0]->pokoje_i_prace;
					$pp = explode('|',$pp);
					$ostatni_pokoj = '';
					$pokoje=0;
					foreach($pp as $x){
						$y = explode('_',$x);
						if($ostatni_pokoj != $y[0]){
							$tab=0;
							while($prace[$tab]->id_pokoj != $y[0]){
								$tab++;
							}
							$pokoj = $prace[$tab]->pokoj;
							if($pokoje > 0){
								echo '</ul></li>';
							}
							echo '<li>'.$pokoj.'<ul>';
							$pokoje++;
							$ostatni_pokoj=$y[0];
						}
						if($y[1] != ''){
							$tab=0;
							while($prace[$tab]->id_pokoj != $y[0] || $prace[$tab]->id_praca != $y[1]){
								$tab++;
							}
							$praca = $prace[$tab]->praca;
							echo '<li>'.$praca.'</li>';
						}
					}
					?>
					</ul>
				</div>
			</div>
		</div>
		<div class="col-md-1">
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-3">
		</div>
		<div class="col-md-9">
		<?php
			if(isset($zglos_sie)){
				if($zglos_sie == 0){
					echo '<form method="post">';
					echo '<button class="btn btn-default" type="submit" name="zlecenie_zgloszenie" value="tak">ZGŁOŚ SIĘ</button>';
					echo '</form>';
				}
			}
			if(isset($podjecie)){
				if($podjecie == 0){
					echo '<form method="post">';
					echo '<button class="btn btn-default" type="submit" name="zlecenie_podjecie" value="tak">POTWIERDŹ PODJĘCIE</button>';
					echo '</form>';
				}
			}
			if(isset($potwierdzenie)){
				if($potwierdzenie == 0){
					echo '<form method="post">';
					echo '<button class="btn btn-default" type="submit" name="zlecenie_potwierdzenie" value="tak">POTWIERDŹ WYKONANIE</button>';
					echo '</form>';
				}
			}
			if(isset($zgloszenia)){
				if($zgloszenia != 1){
					echo '<form method="post">';
					foreach($zgloszenia as $x){
						echo '<button type="submit" class="btn btn-default" name="zlecenie_zwyciezca" value="'.$x->id_zgloszenie.'">'.$x->nick.'</button><br/>';
					}
					echo '</form>';
				}
			}
			if(isset($ocena)){
				if($ocena == 0){
					echo '<form method="post">';
					echo '<div class="form-group">';
					echo '<label for="input1">OCENA [1-6]</label>';
					echo '<input id="input1" class="form-control" type="number" min="1" max="6" name="zlecenie_ocena"/>';
					echo '</div>';
					echo '<div class="form-group">';
					echo '<label for="input1">KOMENTARZ</label>';
					echo '<textarea id="input1" class="form-control" name="zlecenie_komentarz"></textarea>';
					echo '</div>';
					echo '<button class="btn btn-default" type="submit">WYŚLIJ</button>';
					echo '</form>';
				}
			}
		?>
		</div>
	</div>
</div>
</body>
</html>