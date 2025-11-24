/* *--------------------------------------------------------------
# List products
--------------------------------------------------------------*/
let products_list; // Declaración global
const base = location.protocol + '//' + location.host;
const route = document.getElementsByName('routeName')[0].getAttribute('content');
const http = new XMLHttpRequest(); // Product list
const csrfToken = document.getElementsByName('csrf-token')[0].getAttribute('content'); // Product list
const currency = document.getElementsByName('currency')[0].getAttribute('content');
const auth = document.getElementsByName('auth')[0].getAttribute('content');
let page = 1;
let page_section = "";
let products_list_ids_temp = [];

document.addEventListener('DOMContentLoaded', function() {

    products_list = document.getElementById('products_list');
    var load_more_products = document.getElementById('load_more_products');

    if (load_more_products) {
        load_more_products.addEventListener('click', function(e) {
            e.preventDefault();
            load_products(page_section);
        });
    }

    if (route == "home") {
        load_products('home');
    }
    if (route == "store") {
        load_products('store');
    }
    if (route == "store_category") {
        let object_id = document.getElementsByName('category_id')[0].getAttribute('content');
        load_products('store_category', object_id);
    }

    //Load products 
    function load_products(section, object = null) {
        page_section = section;
        var url = `${base}/md/api/load/products/${page_section}?page=${page}&object_id=${object}`;
        
        http.open('GET', url, true);
        http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
        http.send();
    
        http.onreadystatechange = function() {
            if (http.readyState == 4) {
                if (http.status == 200) {
                    page++;
                    var data = http.responseText;
                    var response = JSON.parse(data);
    
                    if (response.data.length === 0) {
                        // No products scenario
                        if (page === 2) { // Check if it's the first page load
                            products_list.innerHTML = `<div class='text-center w-100 pt-5 pb-5'><p class='my-4 h5 lead'>No hay productos públicos o no hay productos almacenados</p></div>`;
                        }
                        return;
                    }
    
                    // Products found, populate the list
                    response.data.forEach(function(product, index) {
                        products_list_ids_temp.push(product.id);
                        var div = `
                            <div class="item-product mx-1">
                                <a class="" href="${base}/product/${product.id}/${product.slug}">
                                    <img src="${base}/storage/img/uploads_product_image/${product.image}" alt="${product.name}">
                                </a>
                                <div class="d-flex justify-content-center">
                                    <a href="" class="my-2 text-decoration-none text-dark mx-2" style="font-weight: 600;">${product.name}</a>
                                    <span class="my-2 mx-3">${currency}${product.price}</span>
                                </div>
                                <div class="my-1 d-flex justify-content-center">
                                    <a href="#" class="py-2 d-flex align-items-center text-center px-2">Agregar al carrito</a>
                                    <a href="#" class="hover-favorite" id="favorite_1_${product.id}">
                                        <i class="bi bi-heart px-4 my-3 d-flex align-items-center text-center text-favorite text-dark"></i>
                                    </a>
                                </div>
                            </div>`;
                        products_list.innerHTML += div;
                    });
    
                    // if (auth == "1") {
                    //     mark_user_favorites(products_list_ids_temp);
                    //     products_list_ids_temp = [];
                    // }
                } else {
                    // Error handling for HTTP status other than 200 (OK)
                    console.error('Error fetching products:', http.status);
                    products_list.innerHTML = `<div class='text-center w-100'><p class='my-4 h5 lead'>No se pueden cargar los productos en este momento.</p></div>`;
                }
            }
        };
    }
    

    // function mark_user_favorites(objects) {
    //     var url = base + '/md/api/load/user/favorites/';
    //     var params = 'module=1&objects=' + objects;
    //     http.open('POST', url, true);
    //     http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    //     http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    //     http.send(params);
    //     http.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             var data = this.responseText;
    //             data = JSON.parse(data);
    //             if (data.count > "0") {
    //                 data.objects.forEach(function(favorite, index) {
    //                     document.getElementById('favorite_1_' + favorite).removeAttribute('onclick');
    //                     document.getElementById('favorite_1_' + favorite).classList.add('favorite_active');
    //                 });
    //             }
    //         }
    //     }
    // }

    // function add_to_favorites(object, module) {
    //     url = base + '/md/api/favorites/add/' + object + '/' + module;
    //     http.open('POST', url, true);
    //     http.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    //     http.send();
    //     http.onreadystatechange = function() {
    //         if (this.readyState == 4 && this.status == 200) {
    //             var data = this.responseText;
    //             data = JSON.parse(data);
    //             if (data.status == "success") {
    //                 document.getElementById('favorite_' + module + '_' + object).removeAttribute('onclick');
    //                 document.getElementById('favorite_' + module + '_' + object).classList.add('favorite_active');
    //             }
    //         }
    //     }
    // }
});
