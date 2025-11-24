<?php

// Key value From Json
function kvfj($json, $key){
    if($json == null):
        return null;
    else:
        $json = $json;
        $json = json_decode($json, true);
        if(array_key_exists($key, $json)):
            return $json[$key];
        else:
            return null;
        endif;
    endif;    
}

function getModulesArray(){
    $a = [
        '0' => 'Productos',
        '1' => 'Blog'
    ];
        return $a;
}

function getRoleUserArray($mode, $id){
    $roles = ['0' => 'Usuario normal', '1' => 'Administrador'];
    if(!is_null($mode)):
                return $roles;
        else:
                return $roles[$id];
    endif;
}

function getUserStatusArray($mode, $id){
    $status = ['0' => 'Registrado', '1' => 'Verificado', '100' => 'Baneado'];
    if(!is_null($mode)):
                return $status;
        else:
                return $status[$id];
    endif;
}

function user_permissions(){
    $p = [
        'dashboard' => [
            'icon' => '<i class="fas fa-home"></i>',
            'title' => 'Modulo Dashboard',
            'keys' => [
                'dashboard' => 'Puede ver el dashboard.'
            ]
        ],

        'users' => [
            'icon' => '<i class="fas fa-user-friends"></i>',
            'title' => 'Modulo Usuarios',
            'keys' => [
                'user_list' => 'Puede ver el listado de usuarios.',
                'user_edit' => 'Puede editar usuarios.',
                'user_banned' => 'Puede banear usuarios.',
                'user_permissions_get' => 'Puede administrar permisos de usuarios.',
                'user_permissions' => 'Puede cambiar permisos de usuarios.',
            ]
        ],

        'categories' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Categoria',
            'keys' => [
                'categories' => 'Puede ver el listado de las categorias.',
                'category_add' => 'Puede agregar categorias.',
                'category_subs' => 'Puede ver las Sub Categorias.',
                'category_edit' => 'Puede editar las categorias.',
                'category_delete' => 'Puede eliminar las categorias.',
            ]
        ],

        'products' => [
            'icon' => '<i class="fas fa-boxes"></i>',
            'title' => 'Modulo Producto',
            'keys' => [
                'products' => 'Puede ver el listado de productos.',
                'product_add' => 'Puede agregar nuevos productos.',
                'product_edit' => 'Puede editar productos.',
                'product_search' => 'Puede buscar productos.',
                'product_delete' => 'Puede eliminar productos.',
                'product_gallery_add' => 'Puede agregar imágenes a la galería.',
                'product_gallery_delete' => 'Puede eliminar imágenes de la galería.',
                'product_inventory' => 'Puede ver el inventario del producto.',
                'product_inventory_variants' => 'puede ver las variaciones producto',
                'product_inventory_edit' => 'Puede editar el inventario',
                'product_inventory_delete' => 'Puede eliminar el inventario',
                'variant_delete' => 'Puede eliminar una variante'
            ]
        ],

        'orders' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Ordenes',
            'keys' => [
                'order_list' => 'Puede ver el listado de las ordenes.',

            ]
        ],

        'items' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Items',
            'keys' => [
                'item_list' => 'Puede ver el listado de los items.',
                'item_add' => 'Puede agregar items.',
                'item_delete' => 'Puede eliminar los items.',
            ]
        ],
        'alquiler' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Alquiler',
            'keys' => [
                'alquiler_list' => 'Puede ver el listado de los alquiler.',
                'alquiler_add' => 'Puede agregar alquiler.',
                'alquiler_edit' => 'Puede agregar alquiler.',
                'alquiler_delete' => 'Puede eliminar los alquiler.',
            ]
        ],

        'billetera' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Billetera',
            'keys' => [
                'billetera_list' => 'Puede ver el listado de ingresos e egresos',
                'billetera_comunal' => 'Puede ver el istado de comunales.',
                
            ]
        ],
        'reportes' => [
            'icon' => '<i class="fas fa-folder-open"></i>',
            'title' => 'Modulo Reportes',
            'keys' => [
                'reporte_list' => 'Puede ver el reporte ingresos e egresos',
                'reporte_gastos' => 'Puede ver el istado de Gastos/Inversiones.',
                'reporte_total' => 'Puede ver el saldo total.',
            ]
        ],

        'settings' => [
            'icon' => '<i class="fas fa-cogs"></i>',
            'title' => 'Modulo de Configuraciones',
            'keys' => [
            'settings' => 'Puede modificar la configuración.'
            ]
        ],

    ];

    return $p;
}

function getUserYears(){
    $ya = date('Y');
    $ym = $ya - 18;
    $yo = $ym - 62;

    return [$ym,$yo];
}

function getMonths($mode, $key){
    $m = [
        '01' => 'Enero',
        '02' => 'Febrero',
        '03' => 'Marzo',
        '04' => 'Abril',
        '05' => 'Mayo',
        '06' => 'Junio',
        '07' => 'Julio',
        '08' => 'Agosto',
        '09' => 'Septiembre',
        '10' => 'Octubre',
        '11' => 'Noviembre',
        '12' => 'Diciembre'
    ];
    if($mode == "list"){
        return $m;
    }else{
        return $m[$key];
    }
}

?>