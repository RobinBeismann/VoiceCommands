VoiceCommands
=============

Using your raspberry (or any other linux machine) to control your home or other devices.

Voicecommand by Robin Beismann (robin@beismann.biz)
https://github.com/RobinBeismann

Required packages are: mediainfo, curl and php5-cli incase you wanna work with PHP
Recording only when there is voice (adjust the parameters according to your microphone

I'd suggest create a RAM Drive for the Recording files, incase you're using debian/ubuntu, you only have to do the following:
mkdir /ram
"tmpfs    /ram     tmpfs    nosuid    0    0" >> /etc/fstab
sudo mount -a
