# About

This script allows to deliver SMTP bonces to any HTTP service, 
that implements simple REST interface.
It uses disk queue dir, to flush bounces in another context.

## Configuration

Configuration files (one for each domain) should be placed
in configs directory next to the scripts.
Configuration files should be named as domains with '.json' extension
(see example configuration for example.net).

Configuration files should be in JSON format.

### Configuration parameters

- queue.parentDir - full path for directory where queue should be placed
-	queue.hashLength - length of hash directories names
-	delivery.url - URL to destination site - see below
-	delivery.method - HTTP  method of delivery (POST/GET)
-	delivery.sendBody - Do you want to include source of the mail in the body ? (true/false)
-	delivery.bodyField - Form field that mail body should came in 
-	delivery.expectResponse - Expected response from the server

#### Destination url fields

url can have few fields, that will be replaces bases on delivered mail :

- %%user%% - user (before +) part of mail destination
- %%token%% - token (after +) part of mail destination
- %%domain%% - domain of mail destination 
- %%email%% - full email destination  
- %%uniq%% - unique name of the bounce, generated as-they-come

## Architecture

Script has two parts : processor and delivery script

### process\_message

This script process bounce as-they-come from the SMTP client.
It should be configured as local forward program.
You can do that using .forward file by putting there :
<pre><code>|/path/to/script/process_message</code></pre>

### deliver\_message

This script should be run by cron, or from shell, with config file path in first argument.

It reads messages from the queue and forwards them to the HTTP one-by-one.
