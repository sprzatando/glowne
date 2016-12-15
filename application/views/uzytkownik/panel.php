<div class="container-fluid">
	<div class="row">
		<div class="col-md-1">
		</div>
		<div class="col-md-11">
			<a href="<?php echo site_url('glowny'); ?>"><button class="btn btn-default">GŁÓWNA</button></a><a href="<?php echo site_url('uzytkownik/mojezlecenia'); ?>"><button class="btn btn-default">MOJE ZLECENIA</button></a><a href="<?php echo site_url('opinie/dla/'.$ja); ?>"><button class="btn btn-default">MOJE OCENY</button></a><a href="<?php echo site_url('glowny/wyloguj'); ?>"><button class="btn btn-default">WYLOGUJ</button></a>
		</div>
	</div>
	<hr/>
	<div class="row">
		<div class="col-md-6">
			<?php
			$akt_stat = 'inny';
			$otwarto_tabele = false;
			foreach($zgloszenia as $x){
				if($x->status != $akt_stat){
					if($otwarto_tabele){
						echo '</table>';
					}
					if($x->status == '1'){
						echo '<h2>Zlecenia podjęte</h2>';
					}else if($x->status == '0'){
						echo '<h2>Zlecenia wygrane</h2>';
					}else if($x->status === null){
						echo '<h2>Zlecenia do których się zgłosiłeś</h2>';
					}
					echo '<table class="table table-striped">';
					echo '<tr><th>miejsce</th><th>data</th><th>czas</th><th>szczegóły</th></tr>';
					$otwarto_tabele = true;
					$akt_stat = $x->status;
				}
				echo '<tr><td>'.$x->miejsce.'</td><td>'.$x->data.'</td><td>'.$x->czas.'</td><td><a target="_blank" href="'.site_url('zlecenie/index/'.$x->id_zlecenie).'"><button class="btn btn-default">SZCZEGÓŁY</button></a></td></tr>';
			}
			if($otwarto_tabele){
				echo '</table>';
			}
			?>
		</div>
		<div class="col-md-6">
			<table class="table">
				<tr><th>ocena</th><th>komentarz</th><th>zlecenie</th></tr>
			<?php
				foreach($opinie as $x){
					echo '<tr><td>'.$x->ocena.'</td><td>'.$x->komentarz.'</td><td><a target="_blank" href="'.site_url('zlecenie/index/'.$x->zlecenie_id).'"><button class="btn btn-default">SZCZEGÓŁY</button></a></td></tr>';
				}
			?>
			</table>
		</div>
	</div>
</div>
</body>
</html>