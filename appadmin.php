<?php

$mypassword = "lolek420";

$cookie_name = "user";
if(!isset($_COOKIE[$cookie_name])){
	echo " <h2> Nie jesteś zalogowany </h2>\n";
}
switch ($_GET["tabela"]){
    case"":
    
        echo "    <h4><a href=\"?tabela=dziela\"> Dzieła </a></h4>";

        echo "    <h4><a href=\"?tabela=artysci\"> Artyści </a></h4>";
    
        echo "    <h4><a href=\"?tabela=galerie\"> Galerie </a></h4>";
    
        echo "    <h4><a href=\"?tabela=ekspozycje\"> Ekspozycje </a></h4>";

	echo "    <h4><a href='http://students.mimuw.edu.pl/~sk372263/bd/login.php'> Dla pracowników </a></h4>";
    break;

    
    case"dziela":
	$header = "Dzieła";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");

   
        
        	$result = pg_query_params($link, "select *, dzielo.wysokosc as wysokosc, dzielo.szerokosc as szerokosc, dzielo.waga as waga, dzielo.id as id, dzielo.tytul as tytul, artysta.nazwisko as nazwisko, dzielo.typ as typ from dzielo inner join artysta on dzielo.id_tworca = artysta.id;", array());
		$numrows = pg_numrows($result); 	
                
        	echo "  <table>\n";
        	echo "      <tr>\n";
        	echo "        <th>id</th>\n";
        	echo "        <th>tytuł</th>\n";
       		echo "        <th>autor</th>\n";
        	echo "        <th>wysokosc</th>\n";
       		echo "        <th>szerokosc</th>\n";
       		echo "        <th>waga</th>\n";
       		echo "        <th>typ</th>\n";
        	echo "      </tr>\n";
		for($i = 0; $i < $numrows; $i++){
			echo "<tr>";
			$row = pg_fetch_array($result, $i);
			echo " <td> " . $row["id"] .  "</td>";
			echo " <td> " . $row["tytul"] .  "</td>";
			echo " <td> " . $row["nazwisko"] . "</td>";
			echo " <td> " . $row["wysokosc"] .  "</td>";
			echo " <td> " . $row["szerokosc"] . "</td>";
			echo " <td> " . $row["waga"] . "</td>";
			echo " <td> " . $row["typ"] . "</td>";
			echo "</tr>";
		}
		

		echo " <form action='http://students.mimuw.edu.pl/~sk372263/bd/appadmin.php?tabela=dziela' method='post'>\n";
		echo " <div class='container'>\n";

    		echo " <label for='id'><b>id</b></label>\n";
    		echo " <input type='text' name='id' required>\n";
	
    		echo " <label for='tytul'><b>tytul</b></label>\n";
    		echo " <input type='text' name='tytul' required>\n";

    		echo " <label for='id twórcy'><b>id twórcy</b></label>\n";
    		echo " <input type='text' name='id_tworca'>\n";

    		echo " <label for='nazwa'><b>wysokosc</b></label>\n";
    		echo " <input type='text' name='wysokosc' required>\n";

    		echo " <label for='nazwa'><b>szerokosc</b></label>\n";
    		echo " <input type='text' name='szerokosc' required>\n";

    		echo " <label for='nazwa'><b>waga</b></label>\n";
    		echo " <input type='text' name='waga' required>\n";

    		echo " <label for='nazwa'><b>typ</b></label>\n";
    		echo " <input type='text' name='typ' required>\n";

		echo " <input type=\"submit\" name=\"button\" value=\"Dodaj\">\n";
  		echo " </div>\n";
		echo " </form>\n";

		$id=$_POST["id"];
		$nazwa=$_POST["tytul"];
		$id_tworca=$_POST["id_tworca"];
		$wysokosc=$_POST["wysokosc"];
		$szerokosc=$_POST["szerokosc"];
		$waga=$_POST["waga"];
		$typ=$_POST["typ"];

		$wynik = pg_query_params($link, "INSERT INTO dzielo VALUES ($1,$2,$3,$4,$5,$6,$7);",array($id,pg_escape_string($nazwa),pg_escape_string($typ),$wysokosc,$szerokosc,$waga,$id_tworca));





if ($wynik) {
	echo "OK";
}
else {
	echo "Błąd, nie dodano eksponatu";
}

break;

    case"artysci":
	$header = "Artyści";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
        
        $result = pg_query_params($link, "select * from artysta;", array());
	$numrows = pg_numrows($result); 	
                
        echo "  <table>\n";
        echo "      <tr>\n";
        echo "        <th>Id</th>\n";
        echo "        <th>Imię</th>\n";
        echo "        <th>Nazwisko</th>\n";
        echo "        <th>Rok narodzin</th>\n";
        echo "        <th>Rok śmierci</th>\n";
        echo "      </tr>\n";
	for($i = 0; $i < $numrows; $i++){
		echo "<tr>";
		$row = pg_fetch_array($result, $i);
		echo " <td> " . $row["id"] .  "</td>";
		echo " <td> " . $row["imie"] .  "</td>";
		echo " <td> " . $row["nazwisko"] . "</td>";
		echo " <td> " . $row["roknarodzin"] . "</td>";
		echo " <td> " . $row["roksmierci"] . "</td>";
		echo "</tr>";
	}
        echo "  </table>\n";

		echo " <form action='http://students.mimuw.edu.pl/~sk372263/bd/appadmin.php?tabela=artysci' method='post'>\n";
		echo " <div class='container'>\n";

    		echo " <label for='id'><b>id</b></label>\n";
    		echo " <input type='text' name='id' required>\n";
	
    		echo " <label for='imie'><b>imie</b></label>\n";
    		echo " <input type='text' name='imie' required>\n";

    		echo " <label for='nazwisko'><b>nazwisko</b></label>\n";
    		echo " <input type='text' name='nazwisko'>\n";

    		echo " <label for='rok narodzin'><b>rok narodzin</b></label>\n";
    		echo " <input type='text' name='rok_narodzin' required>\n";

    		echo " <label for='rok smierci'><b>rok smierci</b></label>\n";
    		echo " <input type='text' name='rok_smierci' required>\n";

		echo " <input type=\"submit\" name=\"button\" value=\"Dodaj\">\n";
  		echo " </div>\n";
		echo " </form>\n";

		$id=$_POST["id"];
		$imie=$_POST["imie"];
		$nazwisko=$_POST["nazwisko"];
		$rok_narodzin=$_POST["rok_narodzin"];
		$rok_smierci=$_POST["rok_smierci"];

		$wynik = pg_query_params($link, "INSERT INTO artysta VALUES ($1,$2,$3,$4,$5);",array($id,pg_escape_string($imie),pg_escape_string($nazwisko),$rok_narodzin,$rok_smierci));





if ($wynik) {
	echo "OK";
}
else {
	echo "Błąd, nie dodano eksponatu";
}

        
	break;

    case "galerie":
	$header = "Galerie";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
	
	
        switch ($_GET["id"]){

	    case "":
        	$result = pg_query_params($link, "select * from galerie;", array());
		$numrows = pg_numrows($result); 	
                
        	echo "  <table>\n";
        	echo "      <tr>\n";
        	echo "        <th>id</th>\n";
        	echo "        <th>Nazwa Galerii</th>\n";
        	echo "      </tr>\n";
		for($i = 0; $i < $numrows; $i++){
			echo "<tr>";
			$row = pg_fetch_array($result, $i);
			$idGalerii = $row["id"];
			echo " <td>" . $row["id"] .  "</td>";
			echo " <td><a href=\"?tabela=galerie&id=$idGalerii\"> " . $row["nazwa"] .  "</a></td>";
			echo "</tr>";
		}
        	echo "  </table>\n";

		echo " <form action='http://students.mimuw.edu.pl/~sk372263/bd/appadmin.php?tabela=galerie' method='post'>\n";
		echo " <div class='container'>\n";

    		echo " <label for='id'><b>id</b></label>\n";
    		echo " <input type='text' name='id' required>\n";
	
    		echo " <label for='nazwa'><b>nazwa</b></label>\n";
    		echo " <input type='text' name='nazwa' required>\n";

		echo " <input type=\"submit\" name=\"button\" value=\"Dodaj\">\n";
  		echo " </div>\n";
		echo " </form>\n";


		$id=$_POST["id"];
		$nazwa=$_POST["nazwa"];

		$wynik = pg_query_params($link, "INSERT INTO galerie VALUES ($1,$2);",array($id,pg_escape_string($nazwa)));
		if ($wynik) {
			echo "OK";
		}
		else {
			echo "Błąd, nie dodano eksponatu";
		}
		$nazwa=0;



	    break;

	    default:
		$result = pg_query_params($link, "select id_dzielo, nr_sala, poczatek, koniec from ekspozycja inner join sale on ekspozycja.nr_sala = sale.nr where ekspozycja.poczatek <= current_date and sale.id_galeria = $1;", array($_GET["id"]));
		$numrows = pg_numrows($result);

        	echo "  <table>\n";
        	echo "      <tr>\n";
        	echo "        <th> Dzieło </th>\n";
        	echo "        <th> Nr_sali </th>\n";
        	echo "        <th> Początek ekspozycji</th>\n";
        	echo "        <th> Koniec ekspozycji </th>\n";
        	echo "      </tr>\n";
		for($i = 0; $i < $numrows; $i++){
			echo "<tr>";
			$row = pg_fetch_array($result, $i);
			$idDziela = $row["id_dzielo"];

			$dziela_results =  pg_query_params($link, "select tytul from dzielo where id = $1;",array($idDziela));
			$dziela_numrows = pg_numrows($dziela_results);
			$dziela_row = pg_fetch_array($dziela_results,0);


			echo " <td> " . $dziela_row["tytul"] . "</td>";
			echo " <td> " . $row["nr_sala"] .  "</td>";
			echo " <td> " . $row["poczatek"] .  "</td>";
			echo " <td> " . $row["koniec"] .  "</td>";
			echo "</tr>";
		}
		
	    break;
	}
   break;

        case"ekspozycje":
	$header = "ekspozycje";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
        
        $result = pg_query_params($link, "select dzielo.tytul as tytul, dzielo.id as idd, ekspozycja.nr_sala as nrs, ekspozycja.id as ide, ekspozycja.poczatek as poczatek, ekspozycja.koniec as koniec, ekspozycja.miasto as miasto from ekspozycja inner join dzielo on ekspozycja.id_dzielo = dzielo.id;", array());
	$numrows = pg_numrows($result); 	
                
        echo "  <table>\n";
        echo "      <tr>\n";
        echo "        <th>id Ekspozycji,</th>\n";
        echo "        <th>id Dzieła,</th>\n";	
        echo "        <th>Nazwa dzieła,</th>\n";
        echo "        <th>nr Sali,</th>\n";
        echo "        <th>Poczatek</th>\n";
        echo "        <th>Koniec</th>\n";
        echo "        <th>Miasto</th>\n";
        echo "      </tr>\n";
	for($i = 0; $i < $numrows; $i++){
		echo "<tr>";
		$row = pg_fetch_array($result, $i);
		echo " <td> " . $row["ide"] .  "</td>";
		echo " <td> " . $row["idd"] .  "</td>";
		echo " <td> " . $row["tytul"] . "</td>";
		echo " <td> " . $row["nrs"] . "</td>";
		echo " <td> " . $row["poczatek"] . "</td>";
		echo " <td> " . $row["koniec"] . "</td>";
		echo " <td> " . $row["miasto"] . "</td>";
		echo "</tr>";
	}

        echo "  </table>\n";


		echo " <form action='http://students.mimuw.edu.pl/~sk372263/bd/appadmin.php?tabela=ekspozycje' method='post'>\n";
		echo " <div class='container'>\n";

    		echo " <label for='id'><b>id</b></label>\n";
    		echo " <input type='text' name='id' required>\n";
	
    		echo " <label for='imie'><b>id dzieła</b></label>\n";
    		echo " <input type='text' name='idd' required>\n";

    		echo " <label for='nazwisko'><b>nr sali</b></label>\n";
    		echo " <input type='text' name='nrs'>\n";

    		echo " <label for='rok narodzin'><b>miasto</b></label>\n";
    		echo " <input type='text' name='miasto' required>\n";

    		echo " <label for='rok smierci'><b>poczatek</b></label>\n";
    		echo " <input type='date' name='poczatek' required>\n";

    		echo " <label for='rok smierci'><b>koniec</b></label>\n";
    		echo " <input type='date' name='koniec' required>\n";

		echo " <input type=\"submit\" name=\"button\" value=\"Dodaj\">\n";
  		echo " </div>\n";
		echo " </form>\n";

		$id=$_POST["id"];
		$idd=$_POST["idd"];
		$nrs=$_POST["nrs"];
		$miasto=$_POST["miasto"];
		$poczatek=$_POST["poczatek"];
		$koniec=$_POST["koniec"];

		$wynik = pg_query_params($link, "INSERT INTO ekspozycja VALUES ($1,$2,$3,$4,$5,$6);",array($id,$idd,$nrs,pg_escape_string($miasto),pg_escape_string($poczatek),pg_escape_string($koniec)));
        break;
    }

?>
