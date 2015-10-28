/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadNHLStandings(){
    $("body").addClass("loading");
    $.ajax({
        type: "POST",
        url: "psiStandings.php",
        datatype: "html",
        success: function(html){
            $("#standings").html(html);
            $("body").removeClass("loading");
        },
        fail: function(){
            $("#standings").html("<p>Failed to load standings from NHL.com - Try refreshing the page.</p>");
            $("body").removeClass("loading");
        }
    }); 
}

function loadStandings(sport){
    $("body").addClass("loading");
    $.ajax({
        type: "POST",
        url: "getStandings.php",
        data: {selectedSport:sport},
        datatype: "html",
        success: function(html){
            $("#standings").html(html);
            $("body").removeClass("loading");
       },
        fail: function(){
            $("#standings").html("<p>Failed to load the selected standings.</p>");
            $("body").removeClass("loading");
       }
    });
}
