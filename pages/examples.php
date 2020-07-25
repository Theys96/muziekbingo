<div class='section blue-section'>
  <div class="card page-block">
    <div class="card-header dark-header">
      <h1><?php txt('maintitle'); ?></h1>
    </div>
    <div class="card-header menu-header">
      <div class='row'>
        <div class='col-sm-9 text-center text-sm-left'>
          <a href='/' class='btn btn-primary'><?php txt('home'); ?></a>
          <a href='/info' class='btn btn-primary'><?php txt('information'); ?></a>
          <a href='#' class='btn btn-primary'><?php txt('organization'); ?></a>
          <a href='/examples' class='btn btn-primary disabled'><?php txt('examples'); ?></a>
        </div>
        <div class='col-sm-3 text-center text-sm-right'>
          <a href="?lang=nl"><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
          <a href="?lang=en"><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
        </div>
      </div>
    </div>
    <div class="card-body scrollable">
      <?php txt('examples_info'); ?>

      <table class='table'>
        <colgroup>
          <col style='width: 100px'>
          <col>
          <col>
        </colgroup>
        <thead>
          <tr>
            <th scope="col"><?php txt('code'); ?></th>
            <th scope="col"><?php txt('description'); ?></th>
            <th scope="col" class='text-right'><?php txt('spotify_link'); ?></th>
          </tr>
        </thead>
        <?php
          $examples = getExamples($Db, $Error, $lang);
          foreach ($examples as $example) {
            echo "<tr>";
            echo "<th scope='row' class='text-uppercase'><a href='/c/".$example['code']."'>".$example['code']."</a></th>";
            echo "<td>".$example['description']."</td>";
            echo "<td class='text-right'><a target='_blank' href='".$example['link']."' style='color: #1DB954'><i class='fas fa-external-link-alt'></i></a></td>";
            echo "</tr>";
          }
        ?>
      </table>
    </div>
    <div class="card-footer text-center">
      <a href='#' class='text-secondary'><?php txt('terms_conditions'); ?></a>
    </div>
  </div>
</div>

