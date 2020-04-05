var xmlHttp = new XMLHttpRequest();


function xmlHttpGET(url,callback,parameters = ""){

    xmlHttp.open("GET",url+parameters,true);

    xmlHttp.onerror = function(){console.log ("** Ocorreu um erro durante a transação ***")};

    xmlHttp.send();

    xmlHttp.onreadystatechange = callback;

};

function xmlHttpPOST(url,callback,parameters = ""){

    xmlHttp.open("POST",url,true);

    xmlHttp.onerror = function(){console.log ("** Ocorreu um erro durante a transação ***")};

    if(typeof parameters != "object"){
        xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }

    xmlHttp.send(parameters);

    xmlHttp.onreadystatechange = callback;



};

function beforeSend(callback){

    if(xmlHttp.readyState == 3){
        callback();
    }

};

function success(callback){

    if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
        callback();
    }

};
