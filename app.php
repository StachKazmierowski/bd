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
                echo "        <th>tytuł</th>\n";
                echo "        <th>autor</th>\n";
                echo "        <th>typ</th>\n";
                echo "      </tr>\n";
                echo "      </table>";
                

            :break

        }
        
  :break
        
        
  
    }
