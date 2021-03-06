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
    "Montreal" => "DR",
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
    "BS" => "<a href='#NY Rangers'>NY Rangers</a>, <a href='#St. Louis'>St. Louis</a>, <a href='#Calgary'>Calgary</a>",
    "CD" => "<a href='#NY Islanders'>NY Islanders</a>, <a href='#Columbus'>Columbus</a>, <a href='#Los Angeles'>Los Angeles</a>",
    "CL" => "<a href='#Dallas'>Dallas</a>, <a href='#Minnesota'>Minnesota</a>, <a href='#Pittsburgh'>Pittsburgh</a>",
    "DH" => "<a href='#Detroit'>Detroit</a>, <a href='#Florida'>Florida</a>, <a href='#Washington'>Washington</a>",
    "DR" => "<a href='#Montreal'>Montreal</a>, <a href='#Philadelphia'>Philadelphia</a>, <a href='#Colorado'>Colorado</a>",
    "MK" => "<a href='#Winnipeg'>Winnipeg</a>, <a href='#Tampa Bay'>Tampa Bay</a>, <a href='#Vancouver'>Vancouver</a>",
    "SG" => "<a href='#San Jose'>San Jose</a>, <a href='#Edmonton'>Edmonton</a>, <a href='#Anaheim'>Anaheim</a>",
    "SM" => "<a href='#Nashville'>Nashville</a>, <a href='#Chicago'>Chicago</a>, <a href='#Boston'>Boston</a>"
];

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

//$html = file_get_html("https://www.nhl.com/standings/league", false, stream_context_create($arrContextOptions));
$html = file_get_html("http://espn.go.com/nhl/standings/_/group/1");

foreach($html->find('table[class=tablehead]') as $standings){
    foreach($standings->find('a') as $anchor){
        $anchorText = $anchor->plaintext;
        $anchorTitle = $anchor->title;
        $anchor->outertext = "<span title='".$anchorTitle."'>".$anchorText."</span>";
    }
    $rank = 1;
    $headers = 0;
    foreach($standings->find('tr') as $row){
        if($headers < 2){
            $row->innertext = "<td></td>". $row->innertext; 
        }
        else{
            $team = cleanTeamName($row->find('td', 0)->plaintext);
            //$team = rtrim(preg_replace("/[^A-Za-z .é]/", '', $row->find('td', 0)->plaintext));
            if(array_key_exists($team, $teams)){
                $owner = $teams[$team];
                if($owner != "NONE"){
                    $points[$owner] += (int)$rank;
                }
            }
            $row->id = $team;
            $row->innertext = "<td>" . $rank . "</td>". $row->innertext;
            $rank++;
        }
        $headers++;
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

function cleanTeamName($dirtyName){
    //get rid of any special characters in montreal/st louis
    $cleanName = rtrim(preg_replace("/[^A-Za-z .é]/", '', $dirtyName));
    //clean out playoff clinch prefixes
    $cleanerName = ltrim($cleanName, "x - ");
    $almostCleanName = ltrim($cleanerName, "e - ");
    $cleanestName = ltrim($almostCleanName, "* - ");
    $fuckingClean = ltrim($cleanestName, "y - ");
    return ltrim($fuckingClean, "z - ");
}