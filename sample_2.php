<?php

require 'MadTTS.class.php';

// just return the mp3 data in english ISO 639-1

$mp3 = MadTTS::say('wow, I am talking in english', 'en');
