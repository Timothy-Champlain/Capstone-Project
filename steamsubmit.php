<!DOCTYPE HTML>                                                                                              
<html>                                                                                                       
<head>                                                                                                       
<title>Thank You</title>                                                                                     
<h1>Thank you for participating</h1>                                                                         
</head>                                                                                                      
<body>                                                                                                       
                                                                                                             
<?php                                                                                                        
$myfile = fopen("/var/www/html/logs/steamresponses.txt", "a") or die("WARNING: Something went wrong");       
$dt = date("y-m-d H:m:s");                                                                                   
fwrite($myfile, $dt);                                                                                        
$br = "\n";                                                                                                  
fwrite($myfile, $br);                                                                                        
$text = "Champlain Status = ";                                                                               
fwrite($myfile, $text);                                                                                      
$text = $_POST["ChampStatus"];                                                                               
fwrite($myfile, $text);                                                                                      
fwrite($myfile, $br);                                                                                        
$text = "Hours = ";                                                                                          
fwrite($myfile, $text);                                                                                      
$text = $_POST["Hours"];                                                                                     
fwrite($myfile, $text);                                                                                      
fwrite($myfile, $br);                                                                                        
$text = "Fav Game = ";                                                                                       
fwrite($myfile, $text);                                                                                      
$text = $_POST["favgame"];                                                                                   
fwrite($myfile, $text);                                                                                      
fwrite($myfile, $br);                                                                                        
$text = "Contact? = ";                                                                                       
fwrite($myfile, $text);                                                                                      
$contact = $_POST["Contact"];                                                                                
if ($contact == "YES") {                                                                                     
	$text = $_POST["email"];                                                                                    
} else {                                                                                                     
	$text = $_POST["Contact"];                                                                                  
}                                                                                                            
fwrite($myfile, $text);                                                                                      
fwrite($myfile, $br);                                                                                        
$text = "IP Address = ";                                                                                     
fwrite($myfile, $text);                                                                                      
$ip = $_SERVER['REMOTE_ADDR'];                                                                               
fwrite($myfile, $ip);                                                                                        
fwrite($myfile, $br);                                                                                        
fwrite($myfile, $br);                                                                                        
fclose($myfile);                                                                                             
echo "You may close the tab now";                                                                            
?>                                                                                                           
                                                                                                             
</body>                                                                                                      
</html> 
