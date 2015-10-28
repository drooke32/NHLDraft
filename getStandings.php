<?php
//include the html parser
require 'library/simple_html_dom.php';

$websites = array(
    "NFL" => "http://espn.go.com/nfl/standings/_/group/league",
    "NHL" => "http://espn.go.com/nhl/standings/_/group/1",
    "NBA" => "http://espn.go.com/nba/standings/_/group/league",
    "MLB" => "http://espn.go.com/mlb/standings/_/group/overall"
);
$sport = filter_input(INPUT_POST, "selectedSport");
if(array_key_exists($sport, $websites)){
    if($sport == "NHL"){
        parseNHLStandings();
    }
    else{
        parseStandings($websites, $sport);
    }
}

function parseStandings($websites, $sport){
    $html = file_get_html($websites[$sport]);
    foreach($html->find('table[class=standings]') as $standings){
        foreach($standings->find('a') as $anchor){
            $anchor->href = "#";
        }
        $rank = 1;
        foreach($standings->find('thead') as $head){
            $head->innertext = "<th></th>".$head->innertext;
        }
        foreach($standings->find('tr') as $row){
            foreach($row->find('abbr') as $abbr){
                $abbr->outertext = "";
            }
            $row->innertext = "<td>" . $rank . "</td>". $row->innertext;                
            $rank++;
        }
    }
    
    $str = $standings->outertext;
    $finalHTML = str_get_html($str);
    echo $finalHTML;
}

function parseNHLStandings(){
    $html = file_get_html("http://espn.go.com/nhl/standings/_/group/1");
    foreach($html->find('table[class=tablehead]') as $standings){
        foreach($standings->find('a') as $anchor){
            $anchor->href = "#";
        }
        $rank = 1;
        $headers = 0;
        foreach($standings->find('tr') as $row){
            if($headers < 2){
                $row->innertext = "<td></td>". $row->innertext; 
            }
            else{
                $row->innertext = "<td>" . $rank . "</td>". $row->innertext;
                $rank++;
            }            
            $headers++;
        }
    }
    $str = $standings->outertext;
    $finalHTML = str_get_html($str);
    echo $finalHTML;
}

