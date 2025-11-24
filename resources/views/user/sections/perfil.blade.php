<div class="col-md-12 ">
    <div class="row">
        {{-- Avatar --}}
        <div class="col-md-6 my-5">
            @include('component.avatar_user')
        </div>
        {{-- password --}}
        <div class="col-md-6">
            {{-- edit information --}}
            <div class="mt-4 mt-lg-0">
                <div class="p-2">
                    <h4 class="text-center" style="background-color: #f3f3f3">
                        <i class="far fa-address-card"></i> 
                        Editar información
                    </h4>
                </div>
                <div class="inside">
                    <form action="{{ url('/account/edit/info') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Nombre:</label>
                                <div class="input-group mb-3">
                                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="input-connect p-3" style="height: 30px !important;">
                                </div>
                                <label for="lastname">Apellidos: </label>
                                <div class="input-group mb-3">
                                    <input type="text" name="lastname" value="{{ Auth::user()->lastname }}" class="input-connect p-3" style="height: 30px !important;">
                                </div>
                                <label for="email">Correo electrónico: </label>
                                <div class="input-group mb-3">
                                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="input-connect p-3" style="height: 30px !important;" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                
                                <label for="module" class="" style="font-size: 12px;">Fecha de nacimiento:Días-Mes-Año </label>
                                <div class="input-group mb-4">

                                    <input type="number" style="width: 40px;" name="day" value="{{ $birthday[2] }}" class="" min="1" max="31" required>
                                    <select name="month" class="form-select">
                                        @foreach (getMonths('list', null) as $key => $value)
                                            <option value="{{ $key }}" {{ $birthday[1] == $key ? 'selected' : '' }}>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <input type="number" style="width: 60px;" name="year" value="{{ $birthday[0] }}" class="" min="{{ getUserYears()[1] }}" max="{{ getUserYears()[0] }}" required>
                                
                                </div>

                                <label for="module" class="">Género: </label>
                                <div class="input-group mb-3">
                                    <select name="gender" class="input-connect p-1" style="height: 30px !important;">
                                        <option value="0" {{ Auth::user()->gender == 0 ? 'selected' : '' }}>Sin especificar</option>
                                        <option value="1" {{ Auth::user()->gender == 1 ? 'selected' : '' }}>Hombre</option>
                                        <option value="2" {{ Auth::user()->gender == 2 ? 'selected' : '' }}>Mujer</option>
                                    </select>
                                </div>
                                
                                <label for="phone">Teléfono: </label>
                                <div class="input-group mb-3">
                                    <input type="number" name="phone" value="{{ Auth::user()->phone }}" class="input-connect p-3" style="height: 30px !important;">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-outline-dark container">Guardar</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>

    </div>
    
</div>