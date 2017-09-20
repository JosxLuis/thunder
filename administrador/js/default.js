$(document).ready(function(){

    $(".toggle").click(function(){
            //$(".submenu").toggle();
            var itemid = $(this).attr("id");
            $("#item_"+itemid).toggle();
    }); 

});