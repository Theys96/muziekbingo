<div class='section blue-section'>
  <div class="card page-block">
    <div class="card-header dark-header">
      <h1><?php txt('new_playlist'); ?></h1>
    </div>
    <div class="card-header menu-header">
      <div class='row'>
        <div class='col-sm-9 text-center text-sm-left'>
          <a href='/' class='btn btn-primary'><?php txt('home'); ?></a>
        </div>
        <div class='col-sm-3 text-center text-sm-right'>
          <a href="?lang=nl"><img alt="dutch language" class="lang-inline" src="/img/nl.svg"></a>
          <a href="?lang=en"><img alt="english language" class="lang-inline" src="/img/en.svg"></a>  
        </div>
      </div>
    </div>
    <div class="card-body scrollable">
      <?php
      if (isset($_GET['err'])) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        if ($_GET['err'] == 'captcha') {
          txt('incorrect_captcha');
        } else if ($_GET['err'] == 'validation') {
          txt('invalid_code');
        } else {
          txt('something_went_wrong');
        }
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
      }
      ?>
      <p><?php txt('new_page_intro'); ?></p>
      <form method='post' id='newPlaylistForm'>

        <h4><?php txt('pick_code_type'); ?></h4>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="randomCode" value="randomCode" checked>
          <label class="form-check-label" for="randomCode"><?php txt('random_code'); ?></label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="custom6Code" value="custom6Code">
          <label class="form-check-label" for="custom6Code"><?php txt('custom6_code'); ?></label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="customCode" value="customCode">
          <label class="form-check-label" for="customCode"><?php txt('custom_code'); ?></label>
        </div>
        <ul class='mt-3'>
          <li><b><?php txt('random_code');  ?></b> - <?php txt('random_code_descr'); ?></li>
          <li><b><?php txt('custom6_code'); ?></b> - <?php txt('custom6_code_descr'); ?></li>
          <li><b><?php txt('custom_code');  ?></b> - <?php txt('custom_code_descr'); ?></li>
        </ul>

        <div id='codeInputBlock'>
          <h4><?php txt('pick_code'); ?></h4>
          <div class='form-inline my-3'>
            <input placeholder="<?php txt('enter_code'); ?>" type="text" name="code" class="form-control text-uppercase is-invalid" id="inputCode" maxlength="6" size="14">
            <div class="valid-feedback" id="inputCodeValid"><?php txt('valid_code'); ?></div>
            <div class="invalid-feedback" id="inputCodeInvalid"><?php txt('code_alnum_notice'); ?></div>
          </div>
        </div>

        <h5><?php txt('bot_protection'); ?></h5>
        <img id="captcha" src="/lib/securimage/securimage_show.php" alt="CAPTCHA Image" class='captcha-img' />
        <input type="text" placeholder='<?php txt('enter_above_text'); ?>' class='form-control captcha-img' name="captcha_code" size="10" maxlength="6" />
        <a href="#" class='text-secondary' onclick="document.getElementById('captcha').src = '/lib/securimage/securimage_show.php?' + Math.random(); return false"><?php txt('different_image'); ?></a>
        
        <br />
        
        <button type='button' class="btn btn-primary m-3" onClick='createButton()' id='submit-button' data-toggle="modal" data-target="#createPlayListModal"><?php txt('create'); ?>!</button>

      </form>
        <hr />
    </div>
    <div class="card-footer text-center">
      <a href='#' class='text-secondary'><?php txt('terms_conditions'); ?></a>
    </div>
  </div>
</div>

<script>
var codeType = 'randomCode';
var valid    = false;


// Prevent accidental submission
$('#newPlaylistForm').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

$(function() {
  var codeInputBlock = $('#codeInputBlock');
  var codeTypeRadio  = $('input[type=radio][name=codeType]');

  codeTypeRadio.change(function() {
    codeType = this.value;
    if (codeType == "customCode" || codeType == "custom6Code") {
      if (!codeInputBlock.is(':visible')) {
        codeInputBlock.slideDown();
      }
    } else {
      if (codeInputBlock.is(':visible')) {
        codeInputBlock.slideUp();
      }
    }
    if (inputCode.value.length > 0) {
      check();
    }  
  });

  $('#inputCode').change(function() {
    check();
  })

});

function checkCode(c, f, callback) {
  $.post('/checkCode.php', {code: c, freelen: f}, function(data) {
    callback(data)
  })
}

function check(check_callback) {
  code = inputCode.value;
  if (code == "") {
    setInvalid("<?php txt('enter_code'); ?>.");
    if (check_callback) {
      check_callback();
    }
    return
  }

  checkCode(code, codeType == "customCode", function(state) {
    switch(state) {
      case 'valid':
        setValid("<?php txt('valid_code'); ?>");
        break;

      case 'invalid-length':
        setInvalid("<?php txt('code_invalid_length'); ?>");
        break;

      case 'invalid-alnum':
        setInvalid("<?php txt('code_invalid_alnum'); ?>");
        break;

      case 'taken':
        setInvalid("<?php txt('code_taken'); ?>");
        break;
    }

    if (check_callback) {
      check_callback();
    }
  })
}

function setValid(msg) {
  valid = true;
  $(inputCodeValid).text(msg);
  $(inputCode).removeClass('is-invalid').addClass('is-valid');
}

function setInvalid(msg) {
  valid = false;
  $(inputCodeInvalid).text("<?php txt('invalid'); ?>: " + msg);
  $(inputCode).removeClass('is-valid').addClass('is-invalid');
}

function createButton() {
  check(function() {
    $(createPlaylistModalConfirm).show();
    if (codeType != 'randomCode') {
      if (valid) {
        txt = "<?php txt('ask_create_playlist'); ?> '" + inputCode.value.toUpperCase() + "'?";
      } else {
        txt = "<?php txt('choose_code'); ?>";
        $(createPlaylistModalConfirm).hide();
      }
    } else {
      txt = "<?php txt('ask_create_random'); ?>";
    }
    $(createPlaylistModalText).text(txt);
  })
}

function submit() {
  $('#newPlaylistForm').submit();
}
</script>
