	<div class="containter-fluid">
		<div class="col-md-11">
			<div class="row">
				<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a><a href="<?php echo site_url('uzytkownik'); ?>"><button class="btn btn-default">PANEL</button></a><a href="<?php echo site_url('glowny/wyloguj'); ?>"><button class="btn btn-default">WYLOGUJ</button></a>
			</div>
			<div class="row">
				<div class="col-md-1">
				</div>
				<div class="col-md-10">
					<h2>Zlecenia aktualne</h2>
					<table class="table table-striped">
					<tr><th>miejsce</th><th>data</th><th>godzina</th><th>cena</th><th>wykonawca</th><th>odnośnik</th></tr>
					<?php
					$aktualne = true;
					$teraz = new DateTime();
					//var_dump($teraz);
					echo '';
					foreach($zlecenia as $x){
						//var_dump($x);
						if($aktualne){
							$czas = new DateTime($x->data.' '.$x->godzina);
							$roznica = $teraz->diff($czas);
							if($roznica->invert == 1){
								$aktualne = false;
								echo '</table>';
								echo '<h2>Zlecenia archiwalne</h2>';
								echo '<table class="table">';
								echo '<tr><th>miejsce</th><th>data</th><th>godzina</th><th>cena</th><th>wykonawca</th><th>ocena</th><th>komentarz</th><th>odnośnik</th></tr>';
							}
							if($aktualne){
								echo '<tr><td>'.$x->miejsce.'</td><td>'.$x->data.'</td><td>'.$x->godzina.	'</td><td>'.$x->cena.'</td><td>'.$x->nick.'</td><td><a target="_blank" href="'.site_url('zlecenie/index/'.$x->id_zlecenie).'"><button class="btn btn-default">SZCZEGÓŁY</button></a></td></tr>';
							}
						}
						if(!$aktualne){
							echo '<tr><td>'.$x->miejsce.'</td><td>'.$x->data.'</td><td>'.$x->godzina.'</td><td>'.$x->cena.'</td><td>'.$x->nick.'</td><td>'.$x->ocena.'</td><td>'.$x->komentarz.'</td><td><a target="_blank" href="'.site_url('zlecenie/index/'.$x->id_zlecenie).'"><button class="btn btn-default">SZCZEGÓŁY</button></a></td></tr>';
						}
					}
					?>
					</table>
				</div>
				<div class="col-md-1">
				</div>
			</div>
		</div>
	</div>
</body>
</html>