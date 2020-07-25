
<div class='section blue-section'>
	<?php require 'langcorner.php'; ?>
	<div class="jumbotron pb-5" align="center">
		<h1><i><?php txt('maintitle'); ?></i></h1>
		<p class='tagline'><?php txt('tagline'); ?></p>
		<form onsubmit='return enterCode(this)'>
		   <div class="codeinput input-group mb-3">
			  <input name='bingocode' maxlength="6" type="text" class="form-control join-code" placeholder="<?php txt('joininputtext'); ?>">
			  <div class="input-group-append">
				 <button class="btn btn-blue" type="submit"><?php txt('join'); ?></button>
			  </div>
		   </div>
		</form>

		<a class='lighttext' href='/info'><?php txt('moreinfotagline'); ?> 	&#8594;</a>		
	</div>
</div>

<script>
function enterCode(form) {
	let code = $(form).find('.join-code').val();
	window.location.href = '/c/' + code.toUpperCase();
	return false;
}
</script>
