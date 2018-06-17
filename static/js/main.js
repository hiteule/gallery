<!--
/*
* Hiteule Gallery
* Par Hiteule Créative - http://hiteulegallery.hiteule-creative.fr
*
* Cette application est libre et livrée sous licence Creative Commons
* Paternité-Partage des Conditions Initiales à l'Identique 3.0 Unported
* http://creativecommons.org/licenses/by-sa/3.0/deed.fr
*
* This software is free and distributed with the term of Creative Commons licence
* Attribution-Share Alike 3.0 Unported
* http://creativecommons.org/licenses/by-sa/3.0/deed.en
*/

function keyboardNavigation(e){
    if(!e) e=window.event;
    if (e.altKey) return true;
    var target = e.target || e.srcElement;
    if (target && target.type) return true; //an input editable element
    var keyCode=e.keyCode || e.which;
    var docElem = document.documentElement;
    switch(keyCode) {
        case 63235: case 39:
            if ((e.ctrlKey || docElem.scrollLeft==docElem.scrollWidth-docElem.clientWidth) && typeof(nextURL)!='undefined'){
                window.location=nextURL; return false;
            }
        break;
        case 63234: case 37:
            if ((e.ctrlKey || docElem.scrollLeft==0) && typeof(backURL)!='undefined'){
            	window.location=backURL; return false;
            }
        break;
    }
    return true;
}
-->