@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css">
@endsection

@if(isset($p) && $p->id)
    <h3 class="my-3 p-3" style="background-color: #f3f3f3;">Galería de imagenes</h3>
    <!-- Otros scripts que utilizan Dropzone -->
    <form method="POST" action="{{ route('product.gallery.upload', ['id' => $p->id]) }}" class="dropzone" id="my-dropzone">
        @csrf
        <div class="fallback">
            <input name="file" type="file" multiple />
        </div>
    </form>
@else
    <p>No se pudo encontrar el ID del producto.</p>
@endif

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>

<script>
    Dropzone.options.myDropzone = {
        maxFilesize: 2, // Tamaño máximo del archivo en MB
        acceptedFiles: 'image/*', // Solo permitir archivos de imagen
        dictDefaultMessage: 'Arrastra y suelta tus imágenes aquí',
        init: function() {
            this.on("success", function(file, response) {
                console.log(response); // Manejar la respuesta del servidor (por ejemplo, la ruta de la imagen)
            });

            // Manejar errores
            this.on("error", function(file, errorMessage) {
                // Verificar si errorMessage es un objeto
                if (typeof errorMessage === 'object') {
                    // Extraer el mensaje de error del objeto y asignarlo a errorMessageString
                    var errorMessageString = errorMessage.message || 'Se produjo un error al cargar la imagen.';
                } else {
                    // Si errorMessage no es un objeto, convertirlo a una cadena de texto
                    var errorMessageString = errorMessage.toString();
                }
                
                // Mostrar el mensaje de error en el div correspondiente
                document.getElementById('error-messages').innerHTML = errorMessageString;
                // Eliminar el archivo de la vista de Dropzone
                this.removeFile(file);
            });

            // Eliminar imagen
            this.on("removedfile", function(file) {
                // Verificar si el elemento delete_image existe
                var deleteImageElement = document.getElementById('delete_image');
                if (deleteImageElement) {
                    // Establecer el valor del campo oculto para indicar la eliminación de la imagen
                    deleteImageElement.value = 1;
                }
            });

        }
    };
</script>
@endsection
