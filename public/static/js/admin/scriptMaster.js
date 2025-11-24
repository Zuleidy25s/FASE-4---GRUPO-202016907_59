var base = location.protocol + '//' + location.host;
var route = document.getElementsByName('routeName')[0].getAttribute('content');
var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
var http = new XMLHttpRequest();

document.addEventListener('DOMContentLoaded', function() {
    var category = document.getElementById('category');
    if(route == "product_add"){ 
        setSubcategoriesToProducts();
    }
    if(route == "product_edit"){ 
        setSubcategoriesToProducts();
    }
    if (category) {
        
        category.addEventListener('change', setSubcategoriesToProducts);
    }
});

// load categories, subcategories - add edit product
function setSubcategoriesToProducts() {
    var parent_id = category.value;
    let subcategory_actual = document.getElementById('subcategory_actual').value;
    var select = document.getElementById('subcategory');
    let url = base + '/admin/md/api/load/subcategories/' + parent_id;

    http.open('GET', url, true);
    http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    http.send();
    
    http.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Limpiar las subcategorías existentes
            select.innerHTML = "";

            let data = JSON.parse(this.responseText);

            if (Array.isArray(data)) {
                data.forEach(element => {
                    if(subcategory_actual == element.id){
                        select.innerHTML += "<option value=\"" + element.id + "\" selected>" + element.name + "</option>";
                    }else{
                        select.innerHTML += "<option value=\"" + element.id + "\">" + element.name + "</option>";
                    }
                });
            }
        }
    }
}
