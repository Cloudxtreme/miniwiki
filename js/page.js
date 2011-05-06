function $(id) {
    return document.getElementById(id);
}

function fetch(url, id) {
    // Loads the URL into the element with given id.
    if (window.XMLHttpRequest) var q = new XMLHttpRequest();
    if (window.ActiveXObject)  var q = new ActiveXObject("Microsoft.XMLHTTP");
    q.onreadystatechange = function() {
        if (q.readyState == 4 && q.status == 200) $(id).innerHTML = q.responseText;
    }
    q.open("GET", url, true);
    q.send();
}