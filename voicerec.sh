#!/bin/bash

: <<'Introduction'
	Voicecommand by Robin Beismann (robin@beismann.biz)
	https://github.com/RobinBeismann

	Required packages are: mediainfo, curl and php5-cli incase you wanna work with PHP
	Recording only when there is voice (adjust the parameters according to your microphone
	I'd suggest create a RAM Drive for the Recording files, incase you're using debian/ubuntu, you only have to do the following:
	mkdir /ram
	"tmpfs    /ram     tmpfs    nosuid    0    0" >> /etc/fstab
	sudo mount -a
Introduction

rm /ram/rec.flac

echo "Nehme auf.";
rec --bits 16 --channels 1 --rate 48000 /ram/rec.flac rate 32k silence 1 0.1 3% 1 3.0 3%

let duration=$(mediainfo "--Inform=General;%Duration%" /ram/rec.flac)/1000;

#Checking it it's longer then 15 seconds, since the Google API v2 has a restriction of 15 seconds anyway and we can sort out content that isn't even meant to be checked here, like longer conversations
if (( $duration < 15 )); then 	
	echo "Verarbeite.";
	# Caching the result into a variable so you can use it in the way you want
	result=$(curl -X POST --data-binary @'/ram/rec.flac' \
	--header 'Content-Type: audio/x-flac; rate=44100;' \
	'https://www.google.com/speech-api/v2/recognize?output=json&lang=de&key=AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw' \
	| sed -e 's/[{}]/''/g' | awk -F":" '{print $4}'  | awk -F"," '{print $1}' | sed -e 's/^"//'  -e 's/"$//')

	# I'm using php to work with the results (<? echo $argv[1]; ?>)
	php5 action.php $result;
else
	echo "Aufnahme zu lang!";
fi

# Re-executing, just comment it out in case you don't want it to listen all the time 
./voicerec.sh


: <<'Example_Script'
	<?
	
		if(!isset($argv[1]))
		{
			die("No args given.");
		}
		else
		{
			array_shift($argv);
		}
		
		print_r($argv);
	?>
Example_Script