/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $("body").addClass("loading");
    $.ajax({
       type: "POST",
       url: "standings.php",
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
});

