$(function(){      
    bindNavigationButtons();
    $(".loadingText").text("Loading NFL standings...");
    loadStandings("NFL");
});

function bindNavigationButtons(){
    $("button").on("click", function(){
        var sport = $(this).data("sport");
        $(".loadingText").text("Loading "+sport+ " standings...");
        loadStandings(sport);
    });
}


