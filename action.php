<?
	
	if(!isset($argv[1]))
	{
		die("No args given.");
	}
	else
	{
		array_shift($argv);
	}
	
	function voiceOutput($outstr)
	{
		system("mpg123 \"http://translate.google.com/translate_tts?tl=de&q= ". $outstr . "\";");
	}
	
	## Einfache Temperaturausgabe
	if(strtolower($argv[0]) == "wetter")
	{
		if(!isset($argv[1]))
		{
			die("Wetter wurde aufgerufen, allerdings wurde kein Tag übergeben.");
		}

		$loc = "GMXX1935"; # Ort (in dem Fall Freden(Leine)
		$weather_arr = parse_ini_string(file_get_contents("http://weather.tuxnet24.de/?id=" . $loc));
	
		if(strtolower($argv[1]) == "heute")
		{
			voiceOutput("In " . $weather_arr["city"] . " sind es heute " . str_replace("°C", "Grad Celsius",$weather_arr["current_temp"]));
		}
		elseif(strtolower($argv[1]) == "morgen")
		{
			voiceOutput("In " . $weather_arr["city"] . " werden es morgen mindestens " . str_replace("°C", "Grad Celsius",$weather_arr["tomorrow_temp_low"]) . " und maximal " . str_replace("°C", "Grad Celsius",$weather_arr["tomorrow_temp_high"]));
		}

	}	
	
?>