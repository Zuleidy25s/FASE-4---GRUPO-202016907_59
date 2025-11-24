<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery, App\Models\Product;

use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class ProductGalleryController extends Controller
{
    public function __Construct(){
    	$this->middleware('auth');
        // $this->middleware('user.status');
        // $this->middleware('user.permissions');
    	$this->middleware('isadmin');
    }

    // Método para cargar imágenes en la galería de productos
    public function upload(Request $request, $productId){
        // Validar la solicitud
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ajusta las reglas de validación según tus necesidades
        ]);
    
        // Obtener el archivo de imagen del formulario
        $image = $request->file('file');
    
        // Obtener el nombre del producto
        $productName = Product::find($productId)->name; // Asumo que tienes una forma de obtener el nombre del producto a partir del ID
    
        // Generar un nombre de archivo único
        $fileName = $productName . '_' . time() . '.' . $image->getClientOriginalExtension();
    
        // Construir el nombre del directorio de almacenamiento
        $storageDirectory = '/' . $productName; // Guardar las imágenes en un directorio por nombre de producto
    
        // Guardar la imagen en el sistema de archivos público
        $path = $image->storeAs($storageDirectory, $fileName, 'uploads_product');
    
        // Crear una nueva entrada en la tabla product_galleries
        ProductGallery::create([
            'product_id' => $productId,
            'file_path' => $path,
            'file_name' => $fileName,
        ]);
    
        // Redirigir de vuelta a la página anterior con un mensaje de éxito
        return back();
    }
    
    // Método para eliminar una imagen de la galería de productos
    public function destroy($productId, $imageId){
        // Buscar la imagen en la galería de productos
        $image = ProductGallery::find($imageId);
    
        // Verificar si la imagen existe
        if ($image) {
            // Ruta completa al archivo
            $filePath = storage_path('app/uploads_product/' . $image->file_path);
    
            // Eliminar la imagen del sistema de archivos
            Storage::delete($filePath);
    
            // Eliminar la entrada de la imagen de la base de datos
            $image->delete();
    
            // Redirigir de vuelta a la página anterior con un mensaje de éxito
            return back()->with('success', 'La imagen se ha eliminado correctamente.');
        }
    
        // Si la imagen no se encuentra, redirigir de vuelta con un mensaje de error
        return back()->with('error', 'La imagen no se ha encontrado.');
    }
}
