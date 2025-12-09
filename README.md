# Team Phish Phood's Capstone Project
Created by Timothy Price and Riley Bashaw
FA25

## DISCLAIMER
This is a tool we have developed for the purposes of simulating a phishing attack, and is solely intended to aid in cybersecurity education and research. 

FOR LEGAL PURPOSES ONLY

## How does this tool work?
We ran this on an Ubuntu machine with an Apache HTTP Server. Several [posters](https://github.com/Timothy-Champlain/Capstone-Project/wiki/poster-graphics) would contain QR codes linking to `http://[web server]/surveys/steamgiftcardsurvey.html`. 
The general idea of this is that we would incentivize people into scanning our QR codes, which would direct them towards our malicious web server. On our web server, we had two primary vectors of attack which will be explained in further detail below: scraping various data from the target system (reconnaissance), and installation of "malware".

## How to set up
Install and set up apache2, and php.

You can pull the code into your machine with `git clone https://github.com/Timothy-Champlain/Capstone-Project`.

Move the two folders logs and surveys into the folder /var/www/html using the mvdir command.

Run `sudo chown www-data:www-data [file name]` for each of the files in the folders.

## The process at base:
When the body of web page `http://[web server]/surveys/steamgiftcardsurvey.html` is loaded, a function is called which automatically downloads the file `helper.txt` onto the target system. Fortunately for them, this is a harmless text file. 

When the target completes and submits the survey, they will be redirected to `http://[web server]/surveys/steamsubmit.php`. It is on this page that their answers will be saved to /var/www/html/logs/steamresponses.txt, where they will be nicely formatted. In addition to their responses, the date/time and their IP address will also be captured.

## Customization
### Changing the subject
Obviously, a Steam gift card survey won't appeal to everyone. Change the file names and questions to maximize appeal for your target group, as well as the `value=` for each option, since that gets passed along into the output file eventually. 
Be careful with changing `name=` and `id=`, since they're referenced multiple times, and in different files, and thus must remain semi-consistent. Additionally, if you're copying the files into new files with different names, you'll need to run `sudo chown www-data:www-data [file name]` for them too.

### What about that downloaded text file?
We are of the opinion that this is a useful learning tool in and of itself; for example, in a phishing simulation, it can demonstrate to less tech literate individuals how easy it is for a malicious web page to drop a file onto their computer.

However, we also recognize two things: first of all, this download is profoundly unsubtle. Second, a text file like this is quite toothless.

#### Disabling the download
When pen-testing, it is important to be aware of your scope. Unless you have approval to download files onto the client computers, we would strongly recommend disabling this feature. This can be done by commenting out line 11 of steamgiftcardsurvey.html (`		a.click();`)

Another reason you may want this disabled could be if you are primarily performing recon, and want to quietly scrape data without the targets noticing.

#### Replacing the text file
On the flip side, you may want to use this survey to deliver a payload. Once again, while pen-testing, be aware of your scope. You might be getting some very angry phone calls if you knock out your client's network. 
We will not tell you what malware to use here, nor where to find it, but if you have explicit permission, put the payload in the surveys folder and on line 16 of steamgiftcardsurvey.html (`<body onload="helperFunction('helperfile.txt')">`), replace helperfile.txt with the payload file. 
You'll also need to run `sudo chown www-data:www-data [file name]` for this file too.

Reminding you once again that this tool is in no way intended to be used for illegal activity.

### What other information can be pulled for recon?
In steamsubmit.php, line 42, you may note we pull the IP with `$ip = $_SERVER['REMOTE_ADDR'];`, and line 43 sends it to our log file with `fwrite($myfile, $ip);`. Much in the same vein, we can use `$_SERVER['REMOTE_HOST']` to pull the hostname of the target, and `$_SERVER['REMOTE_PORT']` to pull the port they're using. 
We also recommend after each fwrite, add a line `fwrite($myfile, $br);`, since this will make your logfile more readable.

There's much more you can pull than just this, of course, since pretty much any information up to and including Latitude and Longitude is collected by the browser, you just need to find where the code needs to ask.

### Security concerns
There isn't really anything stopping someone from using basic directory traversal to find the log file. If you're storing PII in there, you could run into some liability issues or even just company policy violations. Therefore, in any scenario in which PII may be collected, we strongly recommend putting the log file somewhere else on the computer.
Be sure to change the file path in line 10 of steamsubmit.php (`$myfile = fopen("/var/www/html/logs/steamresponses.txt", "a") or die("WARNING: Something went wrong");`) to match the new location of the logfile. If you're creating a new log file, make sure you run `sudo chown www-data:www-data [file name]`.
Fortunately, running `curl http://[web server]/surveys/steamsubmit.php` won't display the file path, but this still likely won't be the most secure tool. We would recommend deleting the log file and creating a new one (again, don't forget `sudo chown www-data:www-data [file name]`) after pentesting operations are complete.
