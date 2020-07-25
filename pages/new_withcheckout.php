<div class='section blue-section'>
  <div class="card page-block">
    <div class="card-header dark-header">
      <h1><?php txt('new_playlist'); ?></h1>
    </div>
    <div class="card-header menu-header">
      <div class='row'>
        <div class='col-sm-9 text-center text-sm-left'>
          <a href='#' class='btn btn-primary'>Home</a>
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
          echo 'The captcha text you entered is incorrect. Please try again.';
        } else if ($_GET['err'] == 'validation') {
          echo 'Something went wrong with your new code. Please try again.';
        } else {
          echo 'Something went wrong. Please try again.';
        }
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
      }
      ?>
      <p>On this page you can claim new RecordBingo playlist codes.</p>
      <form method='post' id='newPlaylistForm'>

        <h4>Pick a code type</h4>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="randomCode" value="randomCode" checked>
          <label class="form-check-label" for="randomCode">Random 6-character code</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="custom6Code" value="custom6Code">
          <label class="form-check-label" for="custom6Code">Custom 6-character code</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="codeType" id="customCode" value="customCode">
          <label class="form-check-label" for="customCode">Custom code (&le;6 characters)</label>
        </div>
        <ul class='mt-3'>
          <li><b>Random 6-character code</b> - You get a randomly generated 6-character code for your RecordBingo game, such as RH348D.</li>
          <li><b>Custom 6-character code</b> - You get to choose your own 6-character code (letter and numbers), such as BEATLE.</li>
          <li><b>Custom code</b> - You get to choose your own code with fewer than 6 characters, such as FILM.</li>
        </ul>

        <div id='codeInputBlock'>
          <h4>Pick a code</h4>
          <div class='form-inline my-3 row'>
            <div class="input-group col-12 col-lg-4 col-md-6">
              <input placeholder="Enter a code" type="text" name="code" class="form-control text-uppercase is-invalid" id="inputCode" maxlength="6" size="6">
              <div class="input-group-append">
                <a href='#' onClick='check()' class='btn btn-warning'>Check code</a>
              </div>
              <div class="valid-feedback" id="inputCodeValid">Valid code.</div>
              <div class="invalid-feedback" id="inputCodeInvalid">Note: The code can only consist of letters and numbers.</div>
            </div>
          </div>
        </div>

        <h4>Checkout</h4>
        <table class='table table-striped' style='width: 400px'>
          <thead><col><col width='100px'></thead>
          <tr><td id='product'>RecordBingo playlist, random code</td><td class='text-right' id='price_eur'>&euro; 0.00</td></tr>
          <tr><td class='text-right' id='vat_text'>VAT NL (21%):</td><td class='text-right' id='vat_eur'>&euro; 0.00</td></tr>
          <tr class='table-info'><td class='text-right'><b>Total:</b></td><td class='text-right' id='total_eur'>&euro; 0.00</td></tr>
        </table>

        <div class='form-inline'>
          <label for="inputCountry" class="form-label">Select your country:</label>
          <select id="inputCountry" name="country" class="form-control ml-3" style="width: 160px">
            <?php
            foreach ($countries as $c => $name) {
              echo "<option value='".$c."'>" . $name . "</option>";
            }
            ?>
          </select>
        </div>

        <br />
        <h5>Bot protection</h5>
        <img id="captcha" src="/php/securimage/securimage_show.php" alt="CAPTCHA Image" class='captcha-img' />
        <input type="text" placeholder='Enter the text above' class='form-control captcha-img' name="captcha_code" size="10" maxlength="6" />
        <a href="#" class='text-secondary' onclick="document.getElementById('captcha').src = '/php/securimage/securimage_show.php?' + Math.random(); return false">Different Image</a>
        
        <br />
        
        <button type='button' class="btn btn-primary m-3" onClick='createButton()' id='submit-button' data-toggle="modal" data-target="#createPlayListModal">Create!</button>

      </form>
        <hr />
    </div>
    <div class="card-footer text-center">
      <a href='#' class='text-secondary'>Terms & Conditions</a>
    </div>
  </div>
</div>

<script>
var codeType = 'randomCode';
var valid    = false;
var checkout = {price: 0, vat_percent: 21, vat: 0, total: 0};
var vat      = <?php echo json_encode($vat); ?>


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
  var selectCountry  = $('#inputCountry');

  codeTypeRadio.change(function() {
    codeType = this.value;
    if (codeType == "customCode" || codeType == "custom6Code") {
      $('#submit-button').text('Purchase')
      if (!codeInputBlock.is(':visible')) {
        codeInputBlock.slideDown();
      }
    } else {
      $('#submit-button').text('Create!')
      if (codeInputBlock.is(':visible')) {
        codeInputBlock.slideUp();
      }
    }
    if (inputCode.value.length > 0) {
      check();
    }
    updateCheckout();
  });

  selectCountry.change(function() {
    checkout.vat_percent = vat[this.value];
    $('#vat_text').text("VAT " + this.value + " (" + checkout.vat_percent + "%):");
    updateCheckout();
  });
});

function updateCheckout() {
  switch(codeType) {
    case "randomCode":
      checkout.price = 0;
      checkout.type = "random code";
      break;

    case "custom6Code":
      checkout.price = 1.5;
      checkout.type = "custom code";
      break;

    case "customCode":
      checkout.price = 4;
      checkout.type = "custom code";
      break;
  }
  checkout.vat = (checkout.price * 0.01*checkout.vat_percent).toFixed(2);
  checkout.total = (parseFloat(checkout.price) + parseFloat(checkout.vat)).toFixed(2);
  $('#product').text("RecordBingo playlist, " + checkout.type);
  $('#price_eur').html("&euro; " + checkout.price.toLocaleString('en-US', {minimumFractionDigits:2}) );
  $('#vat_eur').html("&euro; " + checkout.vat.toLocaleString('en-US', {minimumFractionDigits:2}) );
  $('#total_eur').html("&euro; " + checkout.total.toLocaleString('en-US', {minimumFractionDigits:2}) );
}

function checkCode(c, f, callback) {
  $.post('/checkCode.php', {code: c, freelen: f}, function(data) {
    callback(data)
  })
}

function check(check_callback) {
  code = inputCode.value;
  if (code == "") {
    setInvalid("Enter a code.");
    check_callback();
    return
  }

  checkCode(code, codeType == "customCode", function(state) {
    switch(state) {
      case 'valid':
        setValid("This code is valid.");
        break;

      case 'invalid-length':
        setInvalid("This code does not have a correct length.");
        break;

      case 'invalid-alnum':
        setInvalid("This code contains illegal characters.");
        break;

      case 'taken':
        setInvalid("This code is already taken.");
        break;
    }

    console.log(check_callback);
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
  $(inputCodeInvalid).text("Invalid: " + msg);
  $(inputCode).removeClass('is-valid').addClass('is-invalid');
}

function createButton() {
  check(function() {
    $(createPlaylistModalConfirm).show();
    if (codeType != 'randomCode') {
      if (valid) {
        txt = "Create playlist with code '" + inputCode.value.toUpperCase() + "'?";
      } else {
        txt = "Choose a correct code first.";
        $(createPlaylistModalConfirm).hide();
      }
    } else {
      txt = "Create playlist with random code?";
    }
    $(createPlaylistModalText).text(txt);
  })
}

function submit() {
  $('#newPlaylistForm').submit();
}
</script>
