const buttonDelete = document.querySelectorAll(".bDelete");

buttonDelete.forEach(button => {
    button.addEventListener("click", function(){
        const id = this.dataset.id;
        const confirm = window.confirm(`¿Deseas eliminar el producto(${id})?`);

        if (confirm) {
            httpRequest("http://localhost/ArteriaElectronicsMVC/products/deleteProduct/" + id, function(){
                console.log(this.responseText);

                const tbody = document.querySelector("#tbody-products");
                const rows = document.querySelector("#row-" + id);

                tbody.removeChild(rows);
            });
        }
    });

    function httpRequest (url, callback) {
        const http = new XMLHttpRequest();
        http.open("GET", url);
        http.send();
    
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                callback.apply(http);
            }
        }
    }
});