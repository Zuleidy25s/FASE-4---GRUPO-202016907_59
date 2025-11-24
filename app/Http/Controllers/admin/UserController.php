<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __Construct(){
    	$this->middleware('auth');
    	// $this->middleware('user.status');
        // $this->middleware('user.permissions');
    	$this->middleware('isadmin');
    }

    public function getUsers($status){
        // Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'user_list')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permisos para ver la lista de usuarios.');
        }

        if ($status == 'all') {
            $users = User::orderBy('id', 'Desc')->paginate(30);
        } else {
            $users = User::where('status', $status)->orderBy('id', 'Desc')->paginate(30);
        }

        $data = ['users' => $users];
        return view('admin.users.home', $data);
    }

    public function getUserEdit($id){
        $u = User::findOrFail($id);

        // Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'user_edit')) {
            abort(403, 'No tienes permisos para editar este usuario.');
        }

        $data = ['u' => $u];
        return view('admin.users.user_edit', $data);
    }

    public function postUserEdit(Request $request, $id){
        $u = User::findOrFail($id);
        $u->role = $request->input('user_type');
            if($request->input('user_type') == "1"):
                if(is_null($u->permissions)):
                    $permissions = [
                'dashboard' => true
            ];
            $permissions = json_encode($permissions);
                    $u->permissions = $permissions;
            endif;
        else:
            $u->permissions = null;
        endif;
            if($u->save()):
                if($request->input('user_type') == "1"):
                return redirect('/admin/user/'.$u->id.'/edit')->with('message', 'El tipo de usuario, se actualizo con exito.')->with('typealert', 'success');
            else:
                return back()->with('message', 'El tipo de usuario, se actualizo con exito.')->with('typealert', 'success');
            endif;
        endif;
    }

    //Banear usuario//
    public function getUserBanned($id) {
        $u = User::findOrFail($id);
        if ($u->status == "100") {
            $u->status = "0";
            $msg = "Usuario activo nuevamente.";
            $typealert = "success";
        } else {
            $u->status = "100";
            $msg = "Usuario suspendido con éxito.";
            $typealert = "danger"; // Cambia el tipo de alerta a "danger" para el mensaje de suspensión
        }
    
        if ($u->save()) {
            return back()->with('message', $msg)->with('typealert', $typealert);
        }
    }
    

    public function getUserPermissions($id){
        $u = User::findOrFail($id);
        // Verificar si el usuario tiene permisos para editar
        if (!kvfj(Auth::user()->permissions, 'user_permissions')) {
            // Handle unauthorized access (redirect, show error message, etc.)
            abort(403, 'No tienes permiso para ver la lista de permisos.');
        }
        $data = ['u' => $u];
        return view('admin.users.user_permissions', $data);
    }

    public function postUserPermissions(Request $request, $id){
        $u = User::findOrFail($id);
        $u->permissions = $request->except(['_token']);
        if($u->save()):
            return back()->with('message', 'Los permisos del usuario fueron actualizados con éxito')->with('typealert','success');
        endif;
    }
}
