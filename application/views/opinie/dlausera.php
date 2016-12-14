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
		<tr><th>zlecenie</th><th>data</th><th>ocena</th><th>komentarz</th></tr>
		<?php
		foreach($oceny as $x){
			echo '<tr>';
			echo '<td><a target=_blank" href="'.site_url('zlecenie/index/'.$x->zlecenie_id).'"><button class="btn btn-default">ZLECENIE</button></a></td>';
			echo '<td>'.$x->data.'</td><td>'.$x->ocena.'</td><td>'.$x->komentarz.'</td>';
			echo '</tr>';
		}
		?>
		</table>
	</div>
</div>
</body>
</html>