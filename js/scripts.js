/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function(){
    $.ajax({
       type: "POST",
       url: "standings.php",
       datatype: "html",
       success: function(html){
           $("#standings").html(html);
           //hide loading symbol
       },
       fail: function(){
           $("#standings").html("<p>Failed to load standings from NHL.com</p>");
           //hide loading symbol
       }
    });
});

