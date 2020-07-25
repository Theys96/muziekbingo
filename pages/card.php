
<div class='section blue-section'>
	<div class='page-vh no-padding'>
		<?php
		echo "<div class='kaart'>\n";
		$i = 0;
		foreach ($kaart as $song) {
			echo "<div class='kaartcell' id='".$i."'><div><b>" . $song[0] . "</b><br />" . $song[1] . "</div></div>\n";
			$i++;
		}
		echo "</div>\n";
		?>
	</div>
</div>

<div class='section blue-section'>
	<?php require 'langcorner.php'; ?>
	<div class="page">
		<div class="container">
			<div class="jumbotron">
				<center>
					<?php
					echo "<h3>" . txtval('playlist') . " " . $code . "</h3>";
					echo "<a class='btn btn-info mx-2' href='/'>" . txtval('back') . "</a>";
					echo "<a class='btn btn-warning mx-2' href='?new' data-toggle='tooltip' title='" . txtval('newcardwarning') . "'>" . txtval('newcard') . "</a>";
					echo "<p class='mt-2'>" . txtval('playlistcount1') . $num . txtval('playlistcount2') . ".</p>";
					?>
				</center>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="/js/card.js"></script>
