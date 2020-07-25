

<div class='section blue-section'>
	<div class="card page-block">
		<?php if (isset($code)) : ?>
		<div class="card-header dark-header">
			<h1><?php txt('admin'); ?> - <?php echo $code_info['code'] ?></h1>
		</div>
		<?php else: ?>

		<div class="card-header dark-header">
			<h1 id='admin_title'><?php txt('admin'); ?> - </h1>
		</div>

		<div class="card-header menu-header">
			<div class="row">
				<div class="col-sm-9 text-center text-sm-left">
					<a id='back_button' class='btn btn-secondary'><?php txt('back'); ?></a>
				</div>
				<div class='col-sm-3 text-center text-sm-right'>
					<a id='lang_nl'><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
					<a id='lang_en'><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
				</div>
			</div>
		</div>
		
		<div class="card-body scrollable">
			<h4 class='text-center'><?php txt('select_spotify_playlist'); ?></h4>
			<table id='spotify_lists' class='creator'>
				<tr class='header'><td colspan='2'><b><?php txt('playlist'); ?></b></td><td colspan='2'><b>#<?php txt('playlistcount2'); ?></b></td></tr>
			</table>
			<p id="loading" class="text-center"><i><?php txt('loading'); ?>...</i></p>
			<p id="loading-failed" style="display: none" class="text-center"><?php txt('something_went_wrong'); ?> <a href='/'><?php txt('back'); ?></a>.</p>
			<p id="loading-no_playlists" style="display: none" class="text-center"><?php txt('no_playlists'); ?></p>
			<hr />
		</div>

   		<script type="text/javascript" src="/js/spotify.js"></script>

		<?php endif; ?>
	</div>
</div>
