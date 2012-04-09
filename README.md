# About

This script allows to deliver SMTP bounces to any HTTP service, 
that implements simple REST interface.
It uses disk queue dir, to flush bounces in separate context
from the incoming mails.
This allows to controll, delay delivery and load-balance while many bounces came in.

## Configuration

Configuration files (one for each domain) should be placed
in *configs* directory next to the scripts.
Configuration files should be named as domains with *'.json'* extension
(see example configuration for example.net in this repo).

Configuration files should be in JSON format.

### Configuration parameters

- queue.parentDir - full path for directory where queue should be placed
-	queue.hashLength - length of hash directories names
-	delivery.url - URL to destination site - see below
-	delivery.method - HTTP  method of delivery (POST/GET)
-	delivery.sendBody - Do you want to include source of the mail in the body ? (true/false)
-	delivery.bodyField - Form field name that mail body should came in 
-	delivery.expectResponse - Expected response code from the server

#### Destination url fields

url can have few fields, that will be replaced based on delivered mail :

- %%user%% - user part of mail destination (before +)
- %%token%% - token part of mail destination (after +)
- %%domain%% - domain of mail destination 
- %%email%% - full email destination  
- %%uniq%% - unique name of the bounce, generated as-they-come

## Architecture

Script has two parts : processor and delivery script

### process\_message

This script process bounce as-they-come from the SMTP client.
It should be configured as local forward program.
You can do that using *.forward* file by putting there :
<pre><code>|/path/to/script/process_message</code></pre>

### deliver\_message

This script should be run by cron, or from shell, with config file path in first argument.

It reads messages from the queue and forwards them to the HTTP one-by-one.
