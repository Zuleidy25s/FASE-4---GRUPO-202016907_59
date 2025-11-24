<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ApiController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ItemController;
use App\Http\Controllers\Admin\AlquilerController;
use App\Http\Controllers\Admin\BilleteraController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\SettingsController;

Route::prefix('/admin')->group(function () {
    // View dashboard admin
    Route::get('/', [DashboardController::class, 'getDashboard'])->name('dashboard');

    // Module Users
    // GET
    Route::get('/users/{status}', [UserController::class, 'getUsers'])->name('user_list');
    Route::get('/user/{id}/edit', [UserController::class, 'getUserEdit'])->name('user_edit_get');
    Route::get('/user/{id}/banned', [UserController::class, 'getUserBanned'])->name('user_banned');
    Route::get('/user/{id}/permissions', [UserController::class, 'getUserPermissions'])->name('user_permissions_get');
    // POST
    Route::post('/user/{id}/edit', [UserController::class, 'postUserEdit'])->name('user_edit');
    Route::post('/user/{id}/permissions', [UserController::class, 'postUserPermissions'])->name('user_permissions');

    // Module categories
    // GET
    Route::get('/categories/{module}', [CategoriesController::class, 'getHome'])->name('categories');
    Route::get('/category/{id}/edit', [CategoriesController::class, 'getCategoryEdit'])->name('category_edit_get');
    Route::get('/category/{id}/subs', [CategoriesController::class, 'getSubCategories'])->name('category_subs');
    Route::get('/category/{id}/delete', [CategoriesController::class, 'getCategoryDelete'])->name('category_delete');
    // POST  
    Route::post('/category/add/{module}', [CategoriesController::class, 'postCategoryAdd'])->name('category_add');
    Route::post('/category/{id}/edit', [CategoriesController::class, 'postCategoryEdit'])->name('category_edit');
    
    // Module Poducts
    // GET
	Route::get('/products/{status}', [ProductController::class, 'getHome'])->name('products');
	Route::get('/product/add', [ProductController::class, 'getProductAdd'])->name('product_add');
	Route::get('/product/{id}/edit', [ProductController::class, 'getProductEdit'])->name('product_edit');
	Route::get('/product/{id}/delete', [ProductController::class, 'getProductDelete'])->name('product_delete');
	Route::get('/product/{id}/restore', [ProductController::class, 'getProductRestore'])->name('product_restore');
    // POST     
	Route::post('/product/add', [ProductController::class, 'postProductAdd'])->name('product_add_post');
	Route::post('/product/search', [ProductController::class, 'postProductSearch'])->name('product_search');
	Route::post('/product/{id}/edit', [ProductController::class, 'postProductEdit'])->name('product_edit_post');
	Route::post('/product/uploadimage', [ProductController::class, 'uploadimage'])->name('product.uploadimage');

    // Module Inventory product
    // GET
    Route::get('/product/{id}/inventory', [ProductController::class, 'getProductInventory'])->name('product_inventory_get');
    Route::get('/product/{id}/edit_inventory', [ProductController::class, 'getProductInventoryEdit'])->name('edit_inventory');
    Route::get('/product/{id}/delete_inventory', [ProductController::class, 'getProductInventoryDelete'])->name('delete_inventory');
    // POST
    Route::post('/product/{id}/inventory', [ProductController::class, 'postProductInventory'])->name('product_inventory_post');
    Route::post('/product/{id}/edit_inventory', [ProductController::class, 'postProductInventoryEdit'])->name('edit_inventory_post');
    // Variants
    Route::get('/product/{id}/variant/delete', [ProductController::class, 'getProductInventoryVariantDelete'])->name('variant_delete');
    Route::post('/product/{id}/variant_product', [ProductController::class, 'postProductInventoryVariantAdd'])->name('variant_add');
    // Api interna JS Request
    Route::get('/md/api/load/subcategories/{parent}', [ApiController::class, 'getSubcategories'])->name('subcategories');
    
    //upload image products
    // Ruta para cargar una nueva imagen en la galería de productos
    Route::post('/admin/product/{id}/gallery/upload', [ProductGalleryController::class, 'upload'])->name('product.gallery.upload');
    // Ruta para eliminar una imagen de la galería de productos
    Route::delete('/products/{productId}/gallery/{imageId}/delete', [ProductGalleryController::class, 'destroy'])->name('product.gallery.destroy');

    // ****************  Ordenes *************
        Route::get('/orders', [OrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/orders/list', [OrderController::class, 'list'])->name('admin.orders.list'); // DataTables

        Route::get('/orders/{id}/view', [OrderController::class, 'view'])->name('admin.orders.view');
        Route::put('/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
        Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('admin.orders.destroy');

        // imprimir
        // Mostrar mini-factura
        Route::get('/admin/order/{id}/print', [OrderController::class, 'print'])->name('admin.orders.print');
        
    // **************** Items/Alquileres ******
        Route::get('/items', [ItemController::class, 'index'])->name('admin.items.index');
        Route::get('/items/add', [ItemController::class, 'create'])->name('admin.items.create');

        Route::post('/items/store', [ItemController::class, 'store'])->name('admin.items.store');
        Route::delete('/items/{id_item}', [ItemController::class, 'destroy'])->name('admin.items.destroy');

        // Muestra el formulario para iniciar la reserva (Selección de ítems/fecha)
        Route::get('/alquileres/reservar', [AlquilerController::class, 'index'])->name('admin.alquileres.home');

    // **************** Ingreso/egresos ******
        Route::get('/billetera', [BilleteraController::class, 'index'])->name('admin.billetera.home');
        Route::get('/comunal', [BilleteraController::class, 'comunal'])->name('admin.billetera.comunal');

    // **************** Reportess ******
        Route::get('/report', [ReporteController::class, 'index'])->name('admin.reporte.home');
        Route::get('/consult-gastos', [ReporteController::class, 'comunal'])->name('admin.reporte.consult');
        Route::get('/saldo-total', [ReporteController::class, 'saldo'])->name('admin.reporte.saldo');

    // **************** Configuraciones ******
        //Module settings
        Route::get('/settings', [SettingsController::class, 'getHome'])->name('settings');
        Route::post('/settings/add',[SettingsController::class, 'postHome'])->name('settings_add');
	
});
?>
