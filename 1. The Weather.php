//we use the API of the sites to use their data rather then scraping as we did in weather scraping site.
//becoz we may baned if we use their site to much. and also because if they change their html our site code breaks and faced issue

//grab the content of API url using file get contents prosess the JSON and extract the bits of the weather forecast that we want to desplay to user

	
<?php

    $weather = "";
    
    $error = "";
    
    if ($_GET['city']) {
        
        //echo file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&appid=92f97ec539667303d9ca3adc7bc05615");
		//our page is in JSON formate now
        
		$urlContents = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".urlencode($_GET['city'])."&appid=92f97ec539667303d9ca3adc7bc05615");
		
		//$city = str_replace(' ', '', $_GET["city"]);   use this to remove spaces from users city name.
		//or use urlencode() to remove all spaces symbols like ?,&,%, <> etc.
		
		$weatherArray = json_decode($urlContents, true);      //built fxn in php to process JSON.  we gonna add here true which will return the data in the form of an associative array which we can extract the data that we need from.
		
		//print_r($weatherArray);
		
		if ($weatherArray['cod'] == 200) {
		
			$weather = "The weather in ".$_GET['city']." is currently '".$weatherArray['weather'][0]['description']."'. ";     //from our page source
		
		//	$tempInCelcius = intval($weatherArray['main']['temp'] - 273);    //for temp is in kelvin there
		
		//	$weather .= " The temperatureis ".$tempInCelcius."&deg;C";
			
			$tempInCelcius = intval($weatherArray['main']['temp'] - 273);    //for temp is in kelvin there
		
			$weather .= " The temperatureis ".$tempInCelcius."&deg;C and the wind speed is ".$weatherArray['wind']['speed']."m/s.";
			
		} else {
			
			$error = "Could not find city - please try again.";
			
		}
		
	}




?>


	<!doctype html>
        <html lang="en">
          <head>
            <!-- Required meta tags -->
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <title>Weather Scraper</title>
            
            <!-- Bootstrap CSS -->
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
            <title>Hello, world!</title>
          
            <style type="text/css">
                
                html { 
                  background: url(Background.jpg) no-repeat center center fixed; 
                  -webkit-background-size: cover;
                  -moz-background-size: cover;
                  -o-background-size: cover;
                  background-size: cover;
                }
                
                body {
                    background:none;
                }
                
                .container {
                    text-align:center;
                    margin-top:150px;
                    width:450px;
                }
                
                input{
                    margin:20px 0;
                }
                
                #weather {
                    margin-top:15px;
                }
                
            </style>
          
           </head>
            <body>
              
                <div class="container">
                
                    <h1>What's The Weather?</h1>
                    
                <form>
                  <div class="form-group">
                    <label for="city">Enter the name of a city.</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Eg. London, Tokyo" value = "<?php 
                    
                        if (array_key_exists("city", $_GET)) {
                            
                            echo $_GET["city"];
                        }
                    
                    ?>">
                    
                  
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                
                <div id="weather"><?php 
                
                    if ($weather) {
                        
                        echo '<div class="alert alert-success" role="alert">
                            '.$weather.'</div>';
                        
                        
                    } else if ($error) {
                        
                        echo '<div class="alert alert-danger" role="alert">
                            '.$error.'</div>';
                        
                        
                    }
                
                ?></div>
            
        
            <!-- Optional JavaScript -->
            <!-- jQuery first, then Popper.js, then Bootstrap JS -->
            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            
            </body>
        </html>