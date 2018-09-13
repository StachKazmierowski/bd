<?php

switch ($_GET["tabela"]){
    case"":

    echo "    <a href=\"?tabela=eksponaty\"> eksponaty </a>";

    echo "    <a href=\"?tabela=artysci\"> artyści </a>";
    
    echo "    <a href=\"?tabela=galerie\"> galerie </a>";
    
    echo "    <a href=\"?tabela=objazdy\"> odjazdy </a>";
    break;
    }
