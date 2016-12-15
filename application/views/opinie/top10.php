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
		<table class="table table-striped">
			<tr><th>numer</th><th>użytkownik</th><th>średnia ocen</th><th>najnowsze</th></tr>
			<?php 
			//var_dump($lista);
			$n = 1;
			foreach($lista  as $x){
				echo '<tr>';
				echo '<td>'.$n.'</td><td><a target="_blank" href="'.site_url('opinie/dla/'.$x->uzytkownik_id).'"><button class="btn btn-default">'.$x->nick.'</button></a></td>';
				echo '<td>'.$x->srednia.'</td>';
				echo '<td><table class="table"><tr><th>ocena</th><th>komentarz</th></tr>';
				foreach($x->najnowsze as $y){
					echo '<tr><td>'.$y->ocena.'</td><td>'.$y->komentarz.'</td></tr>';
				}
				echo '</table></td>';
				echo '</tr>';
				$n++;
			}
			?>
		</table>
	</div>
</div>
</body>
</html>