<?php
//include the html parser
require 'library/simple_html_dom.php';

$teams = array(
    "Winnipeg" => "MK",
    "Tampa Bay" => "MK",
    "NY Rangers" => "BS",
    "Vancouver" => "MK",
    "San Jose" => "SG",
    "Detroit" => "DH",
    "Dallas" => "CL",
    "Arizona" => "NONE",
    "Montréal" => "DR",
    "Ottawa" => "NONE",
    "St. Louis" => "BS",
    "Nashville" => "SM",
    "Minnesota" => "CL",
    "Chicago" => "SM",
    "Philadelphia" => "DR",
    "NY Islanders" => "CD",
    "Carolina" => "NONE",
    "Colorado" => "DR",
    "Edmonton" => "SG",
    "New Jersey" => "NONE",
    "Columbus" => "CD",
    "Pittsburgh" => "CL",
    "Calgary" => "BS",
    "Boston" => "SM",
    "Buffalo" => "NONE",
    "Toronto" => "NONE",
    "Los Angeles" => "CD",
    "Anaheim" => "SG",
    "Florida" => "DH",
    "Washington" => "DH"
);

$points = [
    "BS" => 0,
    "CD" => 0,
    "CL" => 0,
    "DH" => 0,
    "DR" => 0,
    "MK" => 0,
    "SG" => 0,
    "SM" => 0,
];

$ownerTeams = [
    "BS" => "NY Rangers, St. Louis, Calgary",
    "CD" => "NY Islanders, Columbus, Los Angeles",
    "CL" => "Dallas, Minnesota, Pittsburgh",
    "DH" => "Detroit, Florida, Washington",
    "DR" => "Montréal, Philadelphia, Colorado",
    "MK" => "Winnipeg, Tampa Bay, Vancouver",
    "SG" => "San Jose, Edmonton, Anaheim",
    "SM" => "Nashville, Chicago, Boston"
];


$html = file_get_html('http://www.nhl.com/ice/standings.htm?type=lea');


foreach($html->find('table[class=standings]') as $standings){
    foreach($standings->find('a') as $anchor){
        $anchor->href = "#";
    }
    $headers = true;
    foreach($standings->find('tr') as $row){
        if(!$headers){
            $team = preg_replace("/[^A-Za-z .é]/", '', $row->find('td', 1)->plaintext);
            $rank = $row->find('td', 0)->plaintext;
            if(array_key_exists($team, $teams)){
                $owner = $teams[$team];
                if($owner != "NONE"){
                    $points[$owner] += (int)$rank;
                }
            }
        }
        $headers = false;
    }
    asort($points);
    $playerRanks = "<table class='u-full-width'><thead><tr><th>Owner</th><th>Teams</th><th class='text-center'>Total</th></tr></thead><tbody>";
    foreach($points as $key => $value){
        $playerRanks .= "<tr><td>".$key."</td><td>".$ownerTeams[$key]."</td><td class='text-center'>".$value."</td></tr>";
    }
    $playerRanks .= "</tbody></table><h2>NHL Standings</h2>";
    $standings->class = "u-full-width";
    $str = $standings->outertext;
    $playerRanks .= $str;
    $finalHTML = str_get_html($playerRanks);
    echo $finalHTML;
}