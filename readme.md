Drizzle
==========

Forecast.io API weather display.

Matt Gray http://www.mattg.co.uk

Yep, the code's dodgy. Yep, PHP's not the best tool for the job.

I made this to feed into GeekTool on my Mac so I have weather on my desktop.
If for some strange reason you want to nick my code, please credit me.

Usage
--------
`./drizzle.php [-h][-t] [<lat,long>]`

###Example
`$ ./drizzle.php 51.503355,-0.119723`

`17°C. Mostly cloudy for the hour. 0% chance of rain right now.`
`Light rain starting later tonight.`
``
`Next hour's rain as of 22:36: `
`▇▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▁▇`
``
`Next 24 hours' rain as of 22:00:`
`▇▂▁▂▂▃▄▄▄▄▄▄▄▃▃▄▄▄▄▄▄▄▄▄▃▂▂▂▁▁▁▁▁▁▁▁▁▁▁▂▂▂▃▃▃▃▃▂▁▁▇`


Download
--------

### Terms

This is provided for free (currently) with no guarantee that it is safe and won't break your computer.
By downloading it, you agree to not hold me liable for any bad stuff happening that may (or may not) be due to the use of this script. You also agree that any good stuff happening that may (or may not) be due to the use of this script is all thanks to me.

### Requirements

Seems to work OK on Snow Leopard (10.6.7)

### Download
1. Download drizzle.php
2. In command line navigate to parent directory of drizzle.php
3. Run `php drizzle.php -h` to see usage instructions.

Other
-----
I update my weather while I move by passing in Robert Harder's LocateMe script:

``./drizzle.php `LocateMe -f "{LAT},{LON}"` ``

http://iharder.sourceforge.net/current/macosx/locateme/
I'm not affiliated, I just found it useful!

