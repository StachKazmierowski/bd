<?php

$mypassword='lolek420';  	




if(empty($_POST["login"])){

	echo " <form action='http://students.mimuw.edu.pl/~sk372263/bd/login.php' method='post'>\n";
	echo " <div class='container'>\n";
    	echo " <label for='uname'><b>Username</b></label>\n";
    	echo " <input type='text' placeholder='Enter Username' name='login' required>\n";

    	echo " <label for='psw'><b>Password</b></label>\n";
    	echo " <input type='password' placeholder='Enter Password' name='password' required>\n";

	echo " <input type=\"submit\" name=\"button\" value=\"Zaloguj się\">\n";
  	echo " </div>\n";
	echo " </form>\n";
}
else{
	$login=$_POST["login"];
	$password=$_POST["password"];
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
	$result = pg_query_params($link, "select * from users where login = $1", array($login));	
	$num = pg_numrows($result);
  
	if ($num == 0) {
    
   		 pg_close($link);
    
    		echo " <h2> Nie udało się zalogować, błędny login </h2>";
    
  	}

	else{
		$user = pg_fetch_array($result, 0);
  
 		if ($password != $user["password"]) {
    
    			pg_close($link);
			echo " <h2> Nie udało się zalogować, błędne hasło </h2>";
		}
		else{
 			$cookie_value = $login;
			$cookie_name = 'user';
  			setcookie($cookie_name, $cookie_value, time() + (1800), "/");
			header("refresh: 2; url = ./appadmin.php");
		}
	}

}

?>
