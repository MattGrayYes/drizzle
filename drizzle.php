#!/usr/bin/php
<?php
// Drizzle: forecast.io API weather display by Matt Gray mattg.co.uk
//
// Yep, the code's dodgy. Yep, PHP's not the best tool for the job.
// I made this to feed into GeekTool on my Mac so I have weather on my desktop.
// If for some strange reason you want to nick my code, please credit me.
//
// I update my weather while I move by passing in Robert Harder's LocateMe script:
//     ./drizzle.php `LocateMe -f "{LAT},{LON}"`
//
// http://iharder.sourceforge.net/current/macosx/locateme/
// I'm not affiliated, I just found it useful!



//Defaults
//$lat_long= "51.503355,-0.119723";
//$api_key= "APIKEY";		 

//dump a drizzle_settings.php declaring these two vars in the same folder
//to use my script without modifying.
if ( (!@include("drizzle_settings.php")) )
{
	$lat_long= "51.503355,-0.119723";
	$api_key= "APIKEY";	
}

$mode="";

if ($api_key=="APIKEY")
{
	echo "\n**You need to edit this script and paste in your forecast.io API key**\n\n";
	print_usage();
	exit;
}

if ($argc > 3) {
	echo "fail. $argc args\n";
	print_usage();
	exit;
}

if ( ($argc == 2) && ($argv[1]=="-h") ) {
	print_usage();
	exit;	
}

if ( ($argc >= 2) && ($argv[1]=="-t") ) //if we're in big temp mode
{
	if ( $argc == 3 )
	{
		//check latlong if present
		if( preg_match('/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/', $argv[2]) )
			$lat_long = $argv[2];
		else
			echo "That's not a real lat,long you gave me. Continuing with default:\n";
	}
	
	$mode= "big_temp";
}

elseif ( ($argc == 2) && ($argv[1]!="-h") ) //if we've been passed just a latlong
{
	//check if it really is one
	if( preg_match('/^[+-]?\d+\.\d+, ?[+-]?\d+\.\d+$/', $argv[1]) )
		$lat_long = $argv[1];
	else
		echo "That's not a real lat,long you gave me. Continuing with default:\n";
}



$url = "https://api.forecast.io/forecast/$api_key/$lat_long?units=si";
$json_data = @file_get_contents($url);

if($json_data === FALSE)
	return "fail";
else
{
	if($json_data[0]=="{")
		$f = json_decode($json_data);
	else
		return "JSON Loading Error.";

	$GLOBALS['deg']="\xC2\xB0"; //unicode escape sequence for degree symbol

	if($mode == "big_temp")
	{
		$temp = $f->currently->temperature;
		echo round($temp).$GLOBALS['deg']."C\n";
	}
	else
	{	
		echo_summary($f);
		echo_drizzle($f);
	}
}


function print_usage()
{
	echo "Drizzle: forecast.io API weather display by Matt Gray. http://www.mattg.co.uk\n\n";
	echo "USAGE\n";
	echo "\t./drizzle.php [-h][-t] [<lat,long>]\n\n";
	echo "EXAMPLES\n";
	echo "Default Location weather \n\t./drizzle.php\n";
	echo "London Eye weather \n\t./drizzle.php 51.503355,-0.119723\n";
	echo "London Eye temperature only \n\t./drizzle.php -t 51.503355,-0.119723\n";
	echo "Display this help info \n\t./drizzle.php -h\n";
	echo "\n";
	echo "I update my weather while I move by passing in Robert Harder's LocateMe script:\n";
	echo "\t./drizzle.php `LocateMe -f \"{LAT},{LON}\"`\n";
	echo "http://iharder.sourceforge.net/current/macosx/locateme/\n";
	echo "I'm not affiliated, I just found it useful!\n";
}

function echo_summary($f)
{
		$temp = $f->currently->temperature;
		$summary= $f->currently->summary;
		$rain= $f->currently->precipProbability;
		echo round($temp).$GLOBALS['deg']."C, ".$summary.", ". $rain*100 ."% chance of rain\n"; 

		if( isset($f->minutely) )
			echo $f->minutely->summary . "\n";
		
		$daysummary= $f->hourly->summary;			
		echo $daysummary."\n";
}

function echo_drizzle($f)
{
	if( isset($f->minutely) )
	{
		$graph = "";
		foreach( $f->minutely->data as $d)
		{	
			$n = ($d->precipProbability * 6);
			$graph .= num_to_bar(round($n));
		}
		echo num_to_bar(6).$graph.num_to_bar(6)."\n";
	}	
}

function num_to_bar($n)
{
	if ( ($n < 8) && ($n >= 0))
	{
		// because i can't do "\xe2\x96\x8".$n for some reason
		switch($n+1){
			// need to find a block space for 0
			case 1:
				return "\xe2\x96\x81";
				break;
			case 2:
				return "\xe2\x96\x82";
				break;
			case 3:
				return "\xe2\x96\x83";
				break;
			case 4:
				return "\xe2\x96\x84";
				break;
			case 5:
				return "\xe2\x96\x85";
				break;
			case 6:
				return "\xe2\x96\x86";
				break;
			case 7:
				return "\xe2\x96\x87";
				break;
			case 8:
				return "\xe2\x96\x88"; //this one looks a bit shit.
				break;
			}
	}
}

?>
