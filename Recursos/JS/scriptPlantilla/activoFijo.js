$(document).ready(function(){

    $('a[role="menuitem"]').on('click',function(){
        
        console.log($("a[href$='#next']").parent());
        
    });

});