<?php
if (isset($_GET['lang']) && ($_GET['lang'] == 'nl' || $_GET['lang'] == 'en')) {
	$_SESSION['lang'] = $_GET['lang'];
}

if (!isset($_SESSION['lang'])) {
	if (strpos(file_get_contents("https://api.hostip.info/get_html.php?ip=" . $_SERVER['REMOTE_ADDR']), "NETHERLANDS") !== false ) {
		$_SESSION['lang'] = 'nl';
	} else {
		$_SESSION['lang'] = 'en';
	}
}

$lang = $_SESSION['lang'];

$text = array(
	'title' => array(
		'en' => "RecordBingo!",
		'nl' => "MuziekBingo!"),
	'maintitle' => array(
		'en' => "&#9835; RecordBingo &#9835;",
		'nl' => "&#9835; MuziekBingo &#9835;"),
	'tagline' => array(
		'en' => "The old-fashioned game with numbers, reinvented with songs!",
		'nl' => "Het ouderwetse spelletje opnieuw uitgevonden met liedjes!"),
	'scrolldown' => array(
		'en' => "Scroll down for more information.",
		'nl' => "Scroll naar beneden voor meer informatie."),
	'joininputtext' => array(
		'en' => "Enter a code to join a game",
		'nl' => "Vul een code in om mee te doen"),
	'home' => array(
		'en' => "Home",
		'nl' => "Home"
	),
	'join' => array(
		'en' => "Join",
		'nl' => "OK"),
	'create' => array(
		'en' => "Create",
		'nl' => "OK"),
	'save' => array(
		'en' => 'Save',
		'nl' => 'Opslaan'),
	'moreinfo' => array(
		'en' => "<i>Coming soon ...</i>",
		'nl' => "<i>Binnenkort meer.</i>"),
	'moreinfotagline' => array(
		'en' => "More information",
		'nl' => "Meer informatie"),
	'code' => array(
		'en' => "Code",
		'nl' => "Code"),
	'joinorcreate' => array(
		'en' => "Join or create a game",
		'nl' => "Meedoen of spel aanmaken"),
	'joingame' => array(
		'en' => "Join game",
		'nl' => "Meedoen"),
	'creategame' => array(
		'en' => "Create game",
		'nl' => "Spel aanmaken"),
	'card' => array(
		'en' => "Bingo card",
		'nl' => "Bingokaart"),
	'back' => array(
		'en' => "Back",
		'nl' => "Terug"),
	'edit' => array(
		'en' => "Edit",
		'nl' => "Wijzigen"),
	'import' => array(
		'en' => "Import",
		'nl' => "Importeren"),
	'empty' => array(
		'en' => "Empty",
		'nl' => "Leegmaken"),
	'cancel' => array(
		'en' => "Cancel",
		'nl' => "Annuleren"),
	'confirm' => array(
		'en' => "Confirm",
		'nl' => "Bevestigen"),
	'select' => array(
		'en' => "Select",
		'nl' => "Kiezen"),
	'newcard' => array(
		'en' => "New card",
		'nl' => "Nieuwe kaart"),
	'newcardwarning' => array(
		'en' => "Warning! This will create a new card and dispose the old one.",
		'nl' => "Let op! Hiermee gaat de oude kaart verloren."),
	'playlistcount1' => array(
		'en' => "This playlist contains ",
		'nl' => "Deze lijst bevat "),
	'playlistcount2' => array(
		'en' => " songs",
		'nl' => " liedjes"),
	'playlist' => array(
		'en' => "Playlist",
		'nl' => "Afspeellijst"),
	'admin' => array(
		'en' => 'Manage playlist',
		'nl' => 'Beheer afspeellijst'),
	'manage' => array(
		'en' => 'Manage',
		'nl' => 'Beheren'),
	'not_yet_created' => array(
		'en' => 'This playlist is empty.',
		'nl' => 'Deze afspeellijst is leeg.'),
	'creator_title' => array(
		'en' => 'Title',
		'nl' => 'Titel'),
	'creator_artist' => array(
		'en' => 'Artist',
		'nl' => 'Artiest'),
	'confirm_song_deletion' => array(
		'en' => 'Are you sure you want to remove this song from this playlist?',
		'nl' => 'Weet u zeker dat u dit liedje wilt verwijderen uit de afspeellijst?'),
	'warning' => array(
		'en' => "Warning",
		'nl' => "Let op"),
	'confirm_empty_playlist' => array(
		'en' => "Are you sure you want to remove all songs from this playlist?",
		'nl' => "Weet u zeker dat u deze lijst wilt leegmaken?"),
	'select_spotify_playlist' => array(
		'en' => "Select a Spotify playlist",
		'nl' => "Kies een Spotify afspeellijst"),
	'songs_imported' => array(
		'en' => "Playlist imported.",
		'nl' => "Afspeellijst ge&iuml;mporteerd."),
	'loading' => array(
		'en' => "Loading",
		'nl' => "Laden"),
	'something_went_wrong' => array(
		'en' => "Something went wrong. Please try again.",
		'nl' => "Er is iets misgegaan. Probeer het opnieuw."),
	'no_playlists' => array(
		'en' => "No Spotify playlists found.",
		'nl' => "Geen Spotify afspeellijsten gevonden."),
	'new_playlist' => array(
		'en' => "New playlist",
		'nl' => "Nieuwe afspeellijst"
	),
	'examples_info' => array(
		'en' => "<p>On this page you can find some of our Spotify playlists that can be used for playing RecordBingo. You can use the accompanied code to generate bingo cards for the playlists.</p>",
		'nl' => ""
	),
	'incorrect_captcha' => array(
		'en' => "The validation code you entered is incorrect. Please try again.",
		'nl' => "De controle code was incorrect. Probeer het opnieuw."),
	'invalid_code' => array(
		'en' => "The playlist code you entered was incorrect. Please try again.",
		'nl' => "Ongeldige playlist code. Probeer het opnieuw"),
	'new_page_intro' => array(
		'en' => "On this page you can claim new RecordBingo playlist codes.",
		'nl' => "Op deze pagina kunt u nieuwe codes claimen voor MuziekBingo."),
	'pick_code_type' => array(
		'en' => "Pick a code type",
		'nl' => "Kies een code type"),
	'random_code' => array(
		'en' => "Random 6-character code",
		'nl' => "Willekeurige code van 6 tekens"),
	'custom6_code' => array(
		'en' => "Custom 6-character code",
		'nl' => "Gekozen code van 6 tekens"),
	'custom_code' => array(
		'en' => "Custom code (&le;6 characters)",
		'nl' => "Gekozen code (&le; 6 tekens)"),
	'random_code_descr' => array(
		'en' => "You get a randomly generated 6-character code for your RecordBingo game, such as RH348D.",
		'nl' => "Je krijgt een willekeurige code van 6 tekens voor de je MuziekBingo spel, zoals RH348D."),
	'custom6_code_descr' => array(
		'en' => "You get to choose your own 6-character code (letter and numbers), such as BEATLE.",
		'nl' => "Je mag zelf een code kiezen van 6 tekens, zoals BEATLE."),
	'custom_code_descr' => array(
		'en' => "You get to choose your own code with fewer than 6 characters, such as FILM.",
		'nl' => "Je mag zelf een code kiezen van maximaal 6 tekens, zoals FILM."),
	'bot_protection' => array(
		'en' => "Bot protection",
		'nl' => "Bot bescherming"),
	'enter_code' => array(
		'en' => "Enter a code",
		'nl' => "Voer code in"),
	'pick_code' => array(
		'en' => "Pick a code",
		'nl' => "Kies een code"),
	'valid_code' => array(
		'en' => "Valid code.",
		'nl' => "Geldige code."),
	'code_alnum_notice' => array(
		'en' => "Let op: De code mag alleen bestaan uit letters en cijfers.",
		'nl' => "Note: The code can only consist of letters and numbers."),
	'code_invalid_length' => array(
		'en' => "This code does not have a correct length.",
		'nl' => "Deze code heeft niet de juiste lengte."),
	'code_invalid_alnum' => array(
		'en' => "This code contains illegal characters.",
		'nl' => "Deze code bevat tekens die niet toegestaan zijn."),
	'code_taken' => array(
		'en' => "This code is already taken.",
		'nl' => "Deze code bestaat al."),
	'ask_create_playlist' => array(
		'en' => "Create playlist with code",
		'nl' => "Afspeellijst aanmaken met de code"),
	'choose_code' => array(
		'en' => "Choose a correct code first.",
		'nl' => "Kies eerst een geldige code."),
	'ask_create_random' => array(
		'en' => "Create playlist with random code?",
		'nl' => "Afspeellijst aanmaken met een willekeurige code?"),
	'invalid' => array(
		'en' => "Invalid",
		'nl' => "Ongeldig"),
	'enter_above_text' => array(
		'en' => "Enter the text above",
		'nl' => "Voer de tekst in"),
	'different_image' => array(
		'en' => "Different image",
		'nl' => "Andere afbeelding"),
	'terms_conditions' => array(
		'en' => "Terms & Conditions",
		'nl' => "Algemene Voorwaarden"),
	'information' => array(
		'en' => "Information",
		'nl' => "Informatie"),
	'organization' => array(
		'en' => "Organization",
		'nl' => "Organiseren"),
	'examples' => array(
		'en' => "Examples",
		'nl' => "Voorbeelden"),
	'description' => array(
		'en' => "Description",
		'nl' => "Beschrijving"),
	'spotify_link' => array(
		'en' => "Spotify Link",
		'nl' => "Spotify Link"),
	'reset' => array(
		'en' => "Reset",
		'nl' => "Reset"),
	'confirm_create_reset' => array(
		'en' => "Reset changes and refresh the page?",
		'nl' => "Wijzigingen vergeten en pagina verversen?"),
	'notice' => array(
		'en' => "Notice",
		'nl' => "Let op"),
	'created_playlist' => array(
		'en' => "Succesfully created playlist",
		'nl' => "Afspeellijst aangemaakt"),
	'created_playlist_text' => array(
		'en' => "Congratulations! This playlist can now be filled with songs and cards can be generated from it.",
		'nl' => "Gefeliciteerd! De afspeellijst kan nu gevuld worden met liedjes zodat er kaarten van kunnen worden gegenereerd."),
	'created_playlist_already_filled' => array(
		'en' => "There are already songs in the playlist.",
		'nl' => "Deze lijst bevat al liedjes."),
	'admin_link_description' => array(
		'en' => "The link below can be used for managing the playlist, save it but keep it private",
		'nl' => "De onderstaande link kan worden gebruikt om de afspeellijst te beheren. Bewaar deze goed maar houd hem geheim"),
	'card_link_description' => array(
		'en' => "After filling the playlist, you can generate a bingo card here",
		'nl' => "Als de lijst gevuld is kunnen hier bingo kaarten gegenereerd worden"),
	'' => array(
		'en' => "",
		'nl' => ""),


	// Longer texts
	'info' => array(
		'en' => "<p>RecordBingo is a fun game to play with friends and family.</p>",
		'nl' => 
			"<p>MuziekBingo is een leuk spel om met vrienden, familie, en andere gezelschappen te spelen. Het werkt ongeveer net als het klassieke bingo, maar in plaats van cijfers staan er liedjes op de bingokaart.</p>
			<p><b>Hoe werkt het?</b><br />Iedere deelnemer ontvangt aan het begin een bingokaart. Die kan er bijvoorbeeld zo uit zien:</p>
			<img src='/img/example_card.png' height='300' />
			<p>De spelleider speelt de muziek in een afspeellijst af. Deze afspeellijst is verbonden met een code, die op <a href='/'>Homepagina</a> ingevuld kan worden om een bingokaart te zien te krijgen zoals in de afbeelding te zien.</p>
			<p>Zodra je een liedje hoort die op je kaart staat, kun je deze aanklikken om aan te geven dat hij geweest is. De eerste die een rijtje heeft (5 liedjes in dezelfde kolom of rij) en/of de eerste die alle liedjes op de kaart af heeft kunnen strepen, wint.</p>
			<p><b>Hoe begin ik?</b><br />Een spelletje MuziekBingo vereist een klein beetje voorbereiding. Om het spel te kunnen spelen is er iemand nodig die het spel leidt. De spelleider zorgt dat de muziek afgespeeld kan worden en dat de deelnemers een bingokaart kunnen krijgen. Deze website hierbij, en meer informatie hierover is te vinden op de pagina <a href='#'>Organiseren</a>.</p>")

);

function txtval($var) {
	global $text, $lang;
	return $text[$var][$lang];
}

function txt($var) {
	echo txtval($var);
}
?>