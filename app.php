<?php

$mypassword='';

switch ($_GET["tabela"]){
    case"":
    
        echo "    <h4><a href=\"?tabela=dziela\"> Dzieła </a></h4>";

        echo "    <h4><a href=\"?tabela=artysci\"> Artyści </a></h4>";
    
        echo "    <h4><a href=\"?tabela=galerie\"> Galerie </a></h4>";
    
        echo "    <h4><a href=\"?tabela=objazdy\"> Objazdy </a></h4>";

	echo "    <h4><a href='http://students.mimuw.edu.pl/~sk372263/bd/login.php'> Dla pracowników </a></h4>";
    break;

    
    case"dziela":
	$header = "Dzieła";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");

   
        
        	$result = pg_query_params($link, "select *, dzielo.tytul as tytul, artysta.nazwisko as nazwisko, dzielo.typ as typ from dzielo inner join artysta on dzielo.id_tworca = artysta.id;", array());
		$numrows = pg_numrows($result); 	
                
        	echo "  <table>\n";
        	echo "      <tr>\n";
        	echo "        <th>tytuł</th>\n";
       		echo "        <th>autor</th>\n";
       		echo "        <th>typ</th>\n";
        	echo "      </tr>\n";
		for($i = 0; $i < $numrows; $i++){
			echo "<tr>";
			$row = pg_fetch_array($result, $i);
			echo " <td> " . $row["tytul"] .  "</td>";
			echo " <td> " . $row["nazwisko"] . "</td>";
			echo " <td> " . $row["typ"] . "</td>";
			echo "</tr>";
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
        echo "        <th>Imię</th>\n";
        echo "        <th>Nazwisko</th>\n";
        echo "        <th>Rok narodzin</th>\n";
        echo "        <th>Rok śmierci</th>\n";
        echo "      </tr>\n";
	for($i = 0; $i < $numrows; $i++){
		echo "<tr>";
		$row = pg_fetch_array($result, $i);
		echo " <td> " . $row["imie"] .  "</td>";
		echo " <td> " . $row["nazwisko"] . "</td>";
		echo " <td> " . $row["roknarodzin"] . "</td>";
		echo " <td> " . $row["roksmierci"] . "</td>";
		echo "</tr>";
	}

        echo "  </table>\n";
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
        	echo "        <th>Nazwa Galerii</th>\n";
        	echo "      </tr>\n";
		for($i = 0; $i < $numrows; $i++){
			echo "<tr>";
			$row = pg_fetch_array($result, $i);
			$idGalerii = $row["id"];
			echo " <td><a href=\"?tabela=galerie&id=$idGalerii\"> " . $row["nazwa"] .  "</a></td>";
			echo "</tr>";
		}

        	echo "  </table>\n";
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

        case"objazdy":
	$header = "Objazdy";
        echo " <h1>  $header   </h1>\n";
	$link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
        
        $result = pg_query_params($link, "select dzielo.tytul as tytul, ekspozycja.poczatek as poczatek, ekspozycja.koniec as koniec, ekspozycja.miasto as miasto from ekspozycja inner join dzielo on ekspozycja.id_dzielo = dzielo.id where miasto is not null and poczatek <= current_date and koniec >= current_date;", array());
	$numrows = pg_numrows($result); 	
                
        echo "  <table>\n";
        echo "      <tr>\n";
        echo "        <th>Dzieło</th>\n";
        echo "        <th>Poczatek</th>\n";
        echo "        <th>Koniec</th>\n";
        echo "        <th>Miasto</th>\n";
        echo "      </tr>\n";
	for($i = 0; $i < $numrows; $i++){
		echo "<tr>";
		$row = pg_fetch_array($result, $i);
		echo " <td> " . $row["tytul"] .  "</td>";
		echo " <td> " . $row["poczatek"] . "</td>";
		echo " <td> " . $row["koniec"] . "</td>";
		echo " <td> " . $row["miasto"] . "</td>";
		echo "</tr>";
	}

        echo "  </table>\n";
        break;
    }




 

?>
