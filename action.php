<?
	
	if(!isset($argv[1]))
	{
		die("No args given.");
	}
	else
	{
		array_shift($argv);
	}
	
	$argv = array_map('strtolower', $argv);
	$str = implode(" ", $argv);
	
	function voiceOutput($outstr,$end)
	{
		$outstr = urlencode($outstr);
		system("mpg123 \"http://translate.google.com/translate_tts?tl=de&ie=UTF-8&q=". $outstr . "\";");
		if(isset($end)){ die($outstr); }
	}
	
	function voiceFound($s)
	{
		global $str;
		return (strpos($str,$s) !== false);
	}
	
	# Einfache Temperaturausgabe
	if(voiceFound("wetter"))
	{

		$loc = "GMXX1935"; # Ort (in dem Fall Freden(Leine)
		$weather_arr = parse_ini_string(file_get_contents("http://weather.tuxnet24.de/?id=" . $loc));
	
		if(voiceFound("heute"))
		{
			voiceOutput("In " . $weather_arr["city"] . " sind es heute " . str_replace("°C", "Grad Celsius",$weather_arr["current_temp"]),true);
		}
		elseif(voiceFound("morgen"))
		{
			voiceOutput("In " . $weather_arr["city"] . " werden es morgen mindestens " . str_replace("°C", "Grad Celsius",$weather_arr["tomorrow_temp_low"]) . " und maximal " . str_replace("°C", "Grad Celsius",$weather_arr["tomorrow_temp_high"]),true);
		}
		
		voiceOutput("Wetter wurde aufgerufen, allerdings wurde kein Tag übergeben.",true);
	}	
	
?>