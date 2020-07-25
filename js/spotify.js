var QLIMIT = 50;
var list = [];
var access_token;
var code;
var code_admin;

function chooseList(id, owner) {
	list = [];
	getTracks(id, owner, list, 0, function(list) {
		$.redirect('/create/' + code_admin, {'code': code, 'list': JSON.stringify(list)});
	});
}

function getHashParams() {
  var hashParams = {};
  var e, r = /([^&;=]+)=?([^&;]*)/g,
      q = window.location.hash.substring(1);
  while ( e = r.exec(q)) {
     hashParams[e[1]] = decodeURIComponent(e[2]);
  }
  return hashParams;
}

function chooseImage(images, minWidth) {
	if (images.length == 0) {
		return "/img/default.jpg";
	}
	x = 0;
	while (x < images.length && images[x].width > minWidth) {
		x++;
	}
	if (x == 0) {
		return images[0].url;
	} else {
		return images[x-1].url;
	}
}

function showFailure() {
	$('#loading').hide(); $('#loading-failed').show();
}

function getTracks(id, owner, list, offset, callback) {
	$.ajax({
		dataType: "json",
		url: "https://api.spotify.com/v1/users/"+owner+"/playlists/"+id+"/tracks?limit="+QLIMIT+"&offset="+offset,
		headers: {"Authorization": "Bearer "+access_token}
	}).done(function (data) {
		for (i = 0; i < data.items.length; i++) {
			artists = [];
			for (a = 0; a < data.items[i].track.artists.length; a++) {
				artists.push(data.items[i].track.artists[a].name);
			}
			list.push([
				data.items[i].track.name,
				artists
				]);
		}
		if (data.items.length == QLIMIT) {
			getTracks(id, owner, list, offset+QLIMIT, callback)
		} else {
			callback(list);
		}
	}).fail(function () {
		showFailure();
	});
}

function getLists(list, offset, callback) {
	$.ajax({
		dataType: "json",
		url: "https://api.spotify.com/v1/me/playlists?limit="+QLIMIT+"&offset="+offset,
		headers: {"Authorization": "Bearer "+access_token}
	}).done(function (data) {
		for (i = 0; i < data.items.length; i++) {
			list.push([
				chooseImage(data.items[i].images, 100),
				data.items[i].name,
				data.items[i].tracks.total,
				data.items[i].id,
				data.items[i].owner.id]);
		}
		if (data.items.length == QLIMIT) {
			getLists(list, offset+QLIMIT, callback)
		} else {
			callback(list);
		}
	}).fail(function () {
		showFailure();
	});
}

$(function() {
	params = getHashParams();
	access_token = params['access_token'];
	state = params['state'].split('-');
	code_admin = state[0];
	code       = state[1];
	$('#spotify_lists').hide();

	// Settings
	$('#admin_title').append(code);
	$('#back_button').attr('href', '/admin/' + code_admin)
	$('#lang_nl').attr('href', '/create_spotify/' + code_admin + '/?lang=nl');
	$('#lang_en').attr('href', '/create_spotify/' + code_admin + '/?lang=en');

	getLists(list, 0, function(list) {
		if (list.length == 0) {
			// Show message (no playlists)
			$('#loading').hide(); $('#loading-no_playlists').show();
		} else {
			for (i = 0; i < list.length; i++) {
				$('#spotify_lists').append(
					"<tr class='spotify_playlist'><td><img class='spotify_cover' src='"+list[i][0]+"' /></td><td>"+list[i][1]+"</td><td><b>"+list[i][2]+"</b></td><td align='right'><a onClick='chooseList(\""+list[i][3]+"\",\""+list[i][4]+"\")' class='btn btn-blue mr-1'><img class='icon' src='/img/export.png' /></a></td></tr>");
			}

			$('#loading').fadeOut(function() {
		console.log("HERE");
				$('#spotify_lists').fadeIn();
			});
		}
	})
});	
