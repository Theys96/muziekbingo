

<div class='section blue-section'>
	<form method='post'>
	<div class="card page-block">
		<div class="card-header dark-header">
			<h1><?php txt('admin'); ?> - <?php echo $code_info['code'] ?></h1>
		</div>
		
		<div class="card-header menu-header">
			<div class="row">
				<div class="col-sm-9 text-center text-sm-left">
				<?php
				echo "<a class='btn btn-secondary' href='/admin/" . $code_info['admin'] . "'>" . txtval('back') . "</a>\n";
				echo "<input class='btn btn-blue' type='submit' value='" . txtval('save') . "' />\n";
				?>
				</div>
				<div class='col-sm-3 text-center text-sm-right'>
					<a href="?lang=nl"><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
					<a href="?lang=en"><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
				</div>
			</div>
		</div>

		<?php
		if ($imported) {
			echo "<div class='alert alert-warning' role='alert'>".txtval('songs_imported')."</div>";
		}
		?>

		<div class="card-body scrollable">
			<center>
			<?php
			echo "<table class='creator' cellspacing='0'>\n";
			echo "<colgroup><col><col><col width='0'></colgroup>\n";
			echo "<tr class='header'><td>\n";
			txt('creator_title');
			echo "</td><td>\n";
			txt('creator_artist');
			echo "</td><td></td></tr>\n";
			foreach ($code_playlist as $song) {
				echo "<tr>";
				echo "<td><input name='title[]' type='text' value='" . htmlspecialchars($song[0], ENT_QUOTES) . "' /></td>";
				echo "<td><input name='artist[]' type='text' value='" . htmlspecialchars($song[1], ENT_QUOTES) . "' /></td>";
				echo "<td class='text-right'><a class='btn btn-secondary delete-song'><img src='/img/bin.png' class='icon' /></a></td>";
				echo "</tr>\n";
			}
			echo "</table>\n";
			echo "<a class='btn btn-success add-song'>+</a>\n";

			echo "<br /><br />\n";
			echo "<input class='btn btn-blue' type='submit' value='" . txtval('save') . "' />\n";
			echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#resetModal'>" . txtval('reset') . "</button>\n";;
			?>
			<hr />
			</center>
		</div>
	</div>
	</form>
</div>

<script>
function deleteSong() {
	row   = $(this).parent().parent();
	cells = row.children().children();
	row.fadeOut(500);
	cells.slideUp(500);
	row.remove();
}

function addSong() {
	var newRow = $('<tr>');
	var removeButton = $("<a class='btn btn-secondary delete-song'><img src='/img/bin.png' class='icon' /></a>");
	removeButton.on('click', deleteSong);
	newRow.append($("<td><input name='title[]' type='text' /></td>"));
	newRow.append($("<td><input name='artist[]' type='text' /></td>"));
	var removeCell = $("<td class='text-right'>");
	removeCell.append(removeButton);
	newRow.append(removeCell);
	$('.creator').append(newRow);
}

$('.delete-song').on('click', deleteSong);
$('.add-song').on('click', addSong);
</script>
