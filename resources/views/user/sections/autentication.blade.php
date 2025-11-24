<div class="col-md-6">
    <div class="">
        <h5 class="text-center" style="background-color: #f3f3f3">
            <i class="fas fa-fingerprint"></i> 
            Cambiar contraseña
        </h5>
    </div>
    <div class="inside">
        <form action="{{ url('/account/edit/password') }}" method="POST">
            @csrf
            
            <div class="input-group mb-2 mt-4">
                <label for="apassword">Contraseña actual: </label>
                <input type="password" name="apassword" required class="input-connect p-3" style="height: 30px !important; width: 500px;">
            </div>
            
            <div class="input-group mb-2">
                <label for="password">Nueva contraseña: </label>
                <input type="password" name="password" required class="input-connect p-3" style="height: 30px !important;width: 500px;">
            </div>
            
            <div class="input-group mb-2">
                <label for="cpassword">Confirmar contraseña: </label>
                <input type="password" name="cpassword" required class="input-connect p-3" style="height: 30px !important;width: 500px;">
            </div>
            <div class="container my-4 d-flex justify-content-center">
                <button type="submit" class="mt-3 w-50 border-b-dark border-0">Actualizar contraseña</button>
            </div>
        </form>
    </div>
</div>