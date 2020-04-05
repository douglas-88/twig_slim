console.log("fetch" in window);
var form = document.querySelector(".form-edit-category");

form.addEventListener("submit",function(ev){
    ev.preventDefault();

    url = this.getAttribute("action");
    let formData = new FormData(this);


    xmlHttpPOST(url,function () {
        success(function(){
            let response = JSON.parse(xmlHttp.responseText);
        });
    },formData);

});

function ajaxRequest(url,form){

    fetch(url,{
        method: "POST",
        body: form
    })
        .then(response => response.json())
        .then(data => mostraRetorno(data))
        .catch(erro => console.log(erro.message));
}

function mostraRetorno(d) {
    console.log(d);
}



