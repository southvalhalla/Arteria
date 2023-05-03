const buttonAdd = document.querySelectorAll("#btnAdd");
const buttonDel = document.querySelectorAll("#btnDel");

const cardCheck = document.getElementById("confirm_card_method");
const cashCheck = document.getElementById("confirm_cash_method");
const nequiCheck = document.getElementById("confirm_nequi_method");

const cardElement1 = document.getElementById("card_element1");
const cardElement2= document.getElementById("card_element2");
const cardElement3 = document.getElementById("card_element3");
const cardElement4 = document.getElementById("card_element4");
const cardElement5 = document.getElementById("card_element5");
const cardElement6 = document.getElementById("card_element6");
const cardElement7 = document.getElementById("card_element7");

const cashElement1 = document.getElementById("cash_element1");
const cashElement2 = document.getElementById("cash_element2");

const nequiElement1 = document.getElementById("nequi_element1");
const nequiElement2 = document.getElementById("nequi_element2");
const nequiElement3 = document.getElementById("nequi_element3");

const MethodInfo = document.getElementById("view-method");
const productsInfo = document.getElementById("view-products");
const viewInfo = document.getElementById("view-info");

const buttonDelete = document.querySelectorAll(".bDelete");

buttonAdd.forEach(button => {
    i = 0;
    button.addEventListener("click", ()=>{
        i++;
        const product = document.getElementById("product");
        const newP = document.getElementById("new");

        let newclone = newP.cloneNode(true);
        newclone.setAttribute('id', 'new-'+i);
        newclone.setAttribute('data-id', 'new-'+i);

        product.appendChild(newclone);

        const deleteBtn = document.createElement('button');
        deleteBtn.innerText = 'Eliminar';
        deleteBtn.setAttribute('class', 'btn btn-danger col-12');
        deleteBtn.addEventListener('click', () => {
            newclone.remove();
        });
        newclone.appendChild(deleteBtn);

        product.appendChild(newclone);

    });
});

cardCheck.addEventListener("change", function(){
    cardElement1.setAttribute('required','');
    cardElement2.setAttribute('required','');
    cardElement3.setAttribute('required','');
    cardElement4.setAttribute('required','');
    cardElement5.setAttribute('required','');
    cardElement6.setAttribute('required','');
    cardElement7.setAttribute('required','');

    cardElement1.removeAttribute('disabled');
    cardElement2.removeAttribute('disabled');
    cardElement3.removeAttribute('disabled');
    cardElement4.removeAttribute('disabled');
    cardElement5.removeAttribute('disabled');
    cardElement6.removeAttribute('disabled');
    cardElement7.removeAttribute('disabled');

    cashElement1.removeAttribute('required','');
    cashElement2.removeAttribute('required','');

    cashElement1.setAttribute('disabled','');
    cashElement2.setAttribute('disabled','');

    nequiElement1.removeAttribute('required','');
    nequiElement2.removeAttribute('required','');
    nequiElement3.removeAttribute('required','');

    nequiElement1.setAttribute('disabled','');
    nequiElement2.setAttribute('disabled','');
    nequiElement3.setAttribute('disabled','');
});

cashCheck.addEventListener("change", function(){
    cardElement1.removeAttribute('required','');
    cardElement2.removeAttribute('required','');
    cardElement3.removeAttribute('required','');
    cardElement4.removeAttribute('required','');
    cardElement5.removeAttribute('required','');
    cardElement6.removeAttribute('required','');
    cardElement7.removeAttribute('required','');

    cardElement1.setAttribute('disabled','');
    cardElement2.setAttribute('disabled','');
    cardElement3.setAttribute('disabled','');
    cardElement4.setAttribute('disabled','');
    cardElement5.setAttribute('disabled','');
    cardElement6.setAttribute('disabled','');
    cardElement7.setAttribute('disabled','');

    cashElement1.setAttribute('required','');
    cashElement2.setAttribute('required','');

    cashElement1.removeAttribute('disabled');
    cashElement2.removeAttribute('disabled');

    nequiElement1.removeAttribute('required','');
    nequiElement2.removeAttribute('required','');
    nequiElement3.removeAttribute('required','');

    nequiElement1.setAttribute('disabled','');
    nequiElement2.setAttribute('disabled','');
    nequiElement3.setAttribute('disabled','');
});

nequiCheck.addEventListener("change", function(){
    cardElement1.removeAttribute('required','');
    cardElement2.removeAttribute('required','');
    cardElement3.removeAttribute('required','');
    cardElement4.removeAttribute('required','');
    cardElement5.removeAttribute('required','');
    cardElement6.removeAttribute('required','');
    cardElement7.removeAttribute('required','');

    cardElement1.setAttribute('disabled','');
    cardElement2.setAttribute('disabled','');
    cardElement3.setAttribute('disabled','');
    cardElement4.setAttribute('disabled','');
    cardElement5.setAttribute('disabled','');
    cardElement6.setAttribute('disabled','');
    cardElement7.setAttribute('disabled','');

    cashElement1.removeAttribute('required','');
    cashElement2.removeAttribute('required','');

    cashElement1.setAttribute('disabled','');
    cashElement2.setAttribute('disabled','');

    nequiElement1.setAttribute('required','');
    nequiElement2.setAttribute('required','');
    nequiElement3.setAttribute('required','');

    nequiElement1.removeAttribute('disabled');
    nequiElement2.removeAttribute('disabled');
    nequiElement3.removeAttribute('disabled');
});


function change(id){
    // const id = this.dataset.id;
    const buttonChange = document.getElementById("btnChange-" + id);
    const formStatus = document.getElementById("formStatus-" + id);
    const viewStatus = document.getElementById("viewStatus-" + id);
    viewStatus.setAttribute('hidden','');
    buttonChange.setAttribute('hidden','');
    formStatus.removeAttribute('hidden');
};
buttonDelete.forEach(button => {
    button.addEventListener("click", function(){
        const id = this.dataset.id;
        const confirm = window.confirm(`¿Deseas eliminar el producto(${id})?`);

        if (confirm) {
            httpRequest("sales/status/" + id, function(){
                console.log(this.responseText);

                const tbody = document.querySelector("#tbody-sales");
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
