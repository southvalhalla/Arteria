const buttonDelete = document.querySelectorAll(".bDelete");

buttonDelete.forEach(button => {
    button.addEventListener("click", function(){
        const id = this.dataset.id;
        const confirm = window.confirm(`¿Deseas eliminar la categoria(${id})?`);

        if (confirm) {
            httpRequest("http://localhost/ArteriaElectronicsMVC/categories/deleteCategory/" + id, function(){
                console.log(this.responseText);

                const tbody = document.querySelector("#tbody-categories");
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

const addCategoryForm = document.querySelector("#addCategoryForm");

addCategoryForm.addEventListener("submit", function(){

  // Obtener los datos del formulario
    const formData = new FormData(addCategoryForm);

    const confirm = window.confirm("¿Deseas agregar la categoria?");
  // Enviar una solicitud AJAX al controlador PHP
    if (confirm) {
        httpRequest("http://localhost/ArteriaElectronicsMVC/categories/createCategory/", formData, function(){
            console.log(this.responseText);

            // Obtener el ID de la nueva categoría del objeto responseText
            const response = JSON.parse(this.responseText);
            const categoryId = response.id;

            // Actualizar la vista con la nueva categoría
            const tbody = document.querySelector("#tbody-categories");
            newRow.id = `row-${categoryId}`;
                newRow.innerHTML = `
                <td>${categoryId}</td>
                <td>${formData.get('category-name')}</td>
                <td>${formData.get('category-characteristics')}</td>
                <td>
                    <a class="btn btn-success" href="<?= constant('URL').'Categories/showCategory/' . ${categoryId}; ?>">Modificar</a>
                    |
                    <button class="bDelete btn btn-danger" data-id="${categoryId}">Eliminar</button>
                </td>
            `;
            tbody.appendChild(newRow);

            // Limpiar el formulario
            addCategoryForm.reset();
        });
    }

    function httpRequest (url, formData, callback) {
        const http = new XMLHttpRequest();
        http.open("POST", url);
        http.send(formData);
    
        http.onreadystatechange = function(){
            if (this.readyState == 4 && this.status == 200) {
                callback.apply(http);
            }
        }
    }
});



