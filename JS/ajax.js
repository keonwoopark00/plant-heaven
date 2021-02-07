// Revision History
// DEVELOPER                     DATE            COMMENTS
//
// Keon Woo Park (1831319)       2020-04-24      Created ajax.js file
//
// Keon Woo Park (1831319)       2020-04-30      Debug and check
//
//



function handleError(error){
    alert("An error occured in JavaScript: " + error);
}

function getXmlHttpRequest(){
    try{
        // create a variable for the xhr request
        var xhr = null;
        
        // check if the brower supports XHR
        if(window.XMLHttpRequest){
            // initialize
            xhr = new XMLHttpRequest();
        }
        else{
            // for Internet Explorer
            if(window.ActiveXObject){
                try{
                    xhr = new ActiveXObject("Msxml2.XMLHTTP");
                }
                catch(error){
                    xhr = new ActiveXObject("Microsoft.XMLHTTP");
                }
            }
            else{
                alert("Your browser does not support XML HTTP Request objects.");
                xhr = null;
            }
        }
        return xhr;
    }
    catch(error){
        handleError(error);
    }
}

function searchPurchases(){
    try{
        // declare a XHR variable to perform an AJAX request
        xhr = getXmlHttpRequest();
        
        xhr.onreadystatechange = function(){
            if(xhr.readyState == 4 && xhr.status == 200){
                // get the reponse text and place it in the div
                document.getElementById("searchResults").innerHTML = xhr.responseText;
            }
        }
        
        // specify which page to query during the POST request
        xhr.open("POST", "searchPurchases.php");
        
        // specify that the request does not contain binary data
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        
        // get the letters search by the user
        var searchQuery = document.getElementById("searchQuery").value;
        
        // send the request to the server
        xhr.send("searchQuery=" + searchQuery);
    }
    catch(error){
        handleError(error);
    }
}