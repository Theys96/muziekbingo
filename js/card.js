function setCells(cells) {
    var d = new Date();
    d.setTime(d.getTime() + (24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = "bingocells=" + cells.join(',') + ";" + expires;
}

function getCells() {
    var name = "bingocells=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length).split(',');
        }
    }
    return [];
}

function checkSizeViolation(cells) {
	for (i = 0; i < cells.length; i++) {
		if (cells[i].scrollHeight + 10 >= cells[i].parentElement.scrollHeight) {
			return true;
		}
	}
	return false;
}

function scaleDownTextSizes(cells) {
	$('.kaart').css('font-size', parseFloat($('.kaart').css('font-size')) - 1);
}

function adjustTextSize() {
	$('.kaart').css('font-size', '1em');
	var cells = $('.kaartcell div');
	while (checkSizeViolation(cells)) {
		scaleDownTextSizes(cells);
	}
}

$(function() {
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});

	adjustTextSize();
	window.onresize = adjustTextSize;

	cells = getCells();
	console.log(cells);
	for (var i = 0; i < cells.length; i++) {
		if (cells[i] != "") {
			$('#' + cells[i]).addClass('selected');
		}
	}

	$('.kaart .kaartcell').on('click', function() {
		cells = getCells();
		if ($(this).hasClass('selected')) {
			var index = cells.indexOf($(this).attr('id'));
			if (index > -1) cells.splice(index, 1);
			$(this).removeClass('selected');
		} else  {
			cells.push($(this).attr('id'));
			$(this).addClass('selected');
		}
		setCells(cells);
	});
})
