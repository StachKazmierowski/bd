<?php

$mypassword='';

switch ($_GET["tabela"]){
    case"":
    
        echo "    <a href=\"?tabela=dziela\"> dzieła </a>";

        echo "    <a href=\"?tabela=artysci\"> artyści </a>";
    
        echo "    <a href=\"?tabela=galerie\"> galerie </a>";
    
        echo "    <a href=\"?tabela=objazdy\"> odjazdy </a>";
    break;

  case"eksponaty":
        $header = "Dziela";
        echo " <div class=\header\">\n  $header\n   </div>\n\n";
        
        $link = pg_connect("host=labdb dbname=mrbd user=sk372263 password=$mypassword");
        
        switch ($_GET["id"]){
            case "":
                $result = pg_query_params($link, "select *, dzielo.id as idd, artysta.id as ida from eksponat left outer join artysta on dzielo.it_tworca = artysta.id order by artysta.nazwisko", array());
                $num = pg_numrows($result);
                
                $tabela_id = "t_dziela";
                echo "  <table id=\"$tabela_id\">\n";
                echo "      <tr>\n";
                echo "        <th onclick=\"sortTableAlphabetically('$tableId', 0)\" class=\"t_th_pointer\">tytuł</th>\n";
                echo "        <th onclick=\"sortTableAlphabetically('$tableId', 1)\" class=\"t_th_pointer\">autor</th>\n";
                echo "        <th onclick=\"sortTableAlphabetically('$tableId', 2)\" class=\"t_th_pointer\">typ</th>\n";
                echo "      </tr>\n";
                
                for ($i = 0; $i < $num; $i++) {
                    $row = pg_fetch_array($result, $i);
          
                    $idd = $row["idd"];
                    $ida = $row["ida"];
                    echo "      <tr>\n";
                    echo "        <td onclick=\"javascript:location.href='?table=exhibits&id=$ide'\" class=\"t_td_pointer\"><i>" . $row["tytul"] . "</i></td>\n";
          
                    $onclick = ($ida == "") ? ">" : " onclick=\"javascript:location.href='?table=artists&id=$ida'\" class=\"t_td_pointer\">";
                    $str = ($ida == "") ? "-" : $row["imie"] . " " . $row["nazwisko"];
                    echo "        <td" . $onclick . $str . "</td>\n";
                    echo "        <td>" . $row["typ"] . "</td>\n";
                    echo "      </tr>\n";
        }

        }
        
  :break
        
        
  
    }
