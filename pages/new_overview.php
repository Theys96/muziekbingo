<div class='section blue-section'>
  <div class="card page-block">
    <div class="card-header dark-header">
      <h1><?php txt('new_playlist'); ?></h1>
    </div>
    <div class="card-header menu-header">
      <div class='row'>
        <div class='col-sm-9 text-center text-sm-left'>
          <a href='#' class='btn btn-primary'><?php txt('home'); ?></a>
          <a href='<?php echo "/admin/".$info['admin']; ?>' class='btn btn-primary'><?php txt('manage'); ?></a>
        </div>
        <div class='col-sm-3 text-center text-sm-right'>
          <a href="?lang=nl"><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
          <a href="?lang=en"><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
        </div>
      </div>
    </div>
    <div class="card-body scrollable text-center">
      <h3><?php txt('created_playlist'); ?>: <?php echo $info['code']; ?></h3>
      <p>
        <?php txt('created_playlist_text'); ?> <br />
        <?php if ($info['created']) { txt('created_playlist_already_filled'); } ?>
      </p>

      <p class='mt-5'><?php txt('admin_link_description'); ?>:</p>
      <h5><a href='<?php echo "/admin/".$info['admin']; ?>'><?php echo "https://recordbingo.com/admin/".$info['admin']; ?></a></h5>

      <p class='mt-5'><?php txt('card_link_description'); ?>:</p>
<h5><a href='<?php echo "/c/".$info['code']; ?>'><?php echo "https://recordbingo.com/c/".$info['code']; ?></a></h5>
  

      <hr />

    </div>
    <div class="card-footer text-center">
      <a href='#' class='text-secondary'><?php txt('terms_conditions'); ?></a>
    </div>
  </div>
</div>
