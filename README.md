restful-frotz
=============

## Overview


*restful-frotz* is a set of PHP scripts that will simulate a REST interface to the Z-Machine emulator [FROTZ](`https://github.com/DavidGriffith/frotz`).

## Credits
Project source: [https://github.com/tlef/restful-frotz](https://github.com/tlef/restful-frotz)

Created by: Tim Lefler ([tlef](https://github.com/tlef/))

Frotz is maintained by [David Griffith](https://github.com/DavidGriffith/frotz)

## Install and Setup

Installing *restful-frotz* on your own server is realitivily simple:

First you need to build and install DUMB-Frotz (dfrotz) which can be found at [David Griffith's Frotz GitHub page](`https://github.com/DavidGriffith/frotz`).

Next you need some data files to use within Frotz. Infocom (creators of Zork) allows you to download Zork 1-3 for free [from their website](http://www.infocom-if.org/downloads/downloads.html), and in the next step, you can point *restful-frotz* to the .DAT files included in these downloads
.

Lastly you need to download *restful-frotz* and add it to a web accessible directory, and customize the config.php to match your server setup.

    $FROTZ_EXE_PATH 	= '<the full path to dfrotz>';
    $FROTZ_SAVE_PATH 	= '<the full path to a writable directory to store frotz saves>';
    $STREAM_PATH		= '<the full path to a writable directory to store the stream files>';

    $FROTZ_DATA_MAP		= array(
	    '<data_id>' => '<the full path and metadata regarding a z-machine data file>',
    );
    
That's it. Once installed and setup, you should be able to just visit your URL (explained below) and start playing.

## Building your REST URL

#### Example
`http://sample.com/restful-frotz/?play&session_id=123456789&data_id=zork1`

#### Required Params
`play` - A flag that will indicate that this request is a gameplay action.

`session_id` - A unique ID used to identify your session (save). Make this as unique as you can, as anyone who has this session_id can play your game instance

`data_id` - The ID into the FROTZ_DATA_MAP, mapping to the data of the Z-Machine data file you want to load. (What game you want to play)

#### Optional Params
`handler` - The ID of the plugin handler to use. If not set, it will be set to ***default***.

*Plugins may also define their own additional parameters.*

## Plugins

### Default
The ***default*** handler will not modify input, and will use http body for output. 

(optional) `handler` - value: ***default*** - Flag telling *restful-frotz* to use the ***default*** handler plugin.

If no handler is defined in the http request, ***default*** will be assumed.


### JSON
The ***JSON*** handler will not modify input, and will use http body to output JSON data. 

`handler` - value: ***json*** - Flag telling *restful-frotz* to use the ***json*** handler plugin.


### Slack
The [Slack](http://slack.com) plugin is built to interact with the *Slack* incoming and outgoing webhooks, to allow for game playing within a specific #channel.

*restful-frotz* works with Slack by being targeted from an outgoing-webhook, and then posting the non-error data back to Slack via an incoming-webhook. Error data will be returned back to the outgoing-webhook. The reason we not return game data back to the outoing webhook because outgoing webhooks do not currently support Slack chat attachments.


#### Parameters
`handler` - value: ***slack*** - Flag telling *restful-frotz* to use the ***slack*** handler plugin.

`output-webhook` - value: ***a slack incoming-webhook URL*** - The URL to be called to post the results of the http request. 

#### Example URL
`http://sample.com/restful-frotz/?play&session_id=123456789&data_id=zork1&handler=slack&output-webhook=http://sample.slack.com/services/hooks/incoming-webhook?token=abcdefghijklmnop`


