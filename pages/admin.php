<div class='section blue-section'>
	<div class="card page-block">
		<div class="card-header dark-header">
			<h1><?php txt('admin'); ?> - <?php echo $code_info['code'] ?></h1>
		</div>
		<div class="card-header menu-header">
			<div class='row'>
				<div class='col-sm-9 text-center text-sm-left'>
					<a class='btn btn-primary' href='/create/<?php echo $code; ?>'><?php txt('edit'); ?></a>
					<?php
					if ($code_info['created']) : ?>
					<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#emptyPlayListModal"><?php txt('empty'); ?></button>
					<?php
					else :
						echo " <a href='".$API_loc."&state=".$code."-".$code_info['code']."' class='btn btn-spotify'>".txtval('import')."</a>";
					endif;
					?>
				</div>
				<div class='col-sm-3 text-center text-sm-right'>
					<a href="?lang=nl"><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
					<a href="?lang=en"><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
				</div>
			</div>
		</div>
		<div class="card-body scrollable">
			<?php
			if ($code_info['created']) {
				echo "<p class='text-center'>" . txtval('playlistcount1') . count($code_playlist) . txtval('playlistcount2') . ".</p>";
				echo "<table class='creator marged-creator'>\n";
				echo "<tr class='header'><td></td><td>\n";
				txt('creator_title');
				echo "</td><td>\n";
				txt('creator_artist');
				echo "</td></tr>\n";
				$i = 1;
				foreach ($code_playlist as $song) {
					echo "<tr><td class='num'>" . $i . "</td><td>" . $song[0] . "</td><td>" . $song[1] . "</td></tr>";
					$i++;
				}
				echo "</table>";
			} else {
				echo "<p class='text-center'>" . txtval('not_yet_created') . "</p>";
			}
			?>
			<hr />
		</div>
	</div>
</div>

