<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Employees;
use App\Models\Roles;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    const RULES = [
        'USER_TYPE_CLIENT'      => 'client',
        'USER_TYPE_EMPLOYEE'    => 'employee',

        'USER_ROLE_CLIENT'      => 'cliente',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Users::orderBy('id', 'DESC')->get();
        $roles = Roles::all();
        $clients = Clients::orderBy('names', 'ASC')->get();
        $employees = Employees::orderBy('names', 'ASC')->get();

        return view('users.index',[
            'users'     => $users,
            'roles'     => $roles,
            'clients'   => $clients,
            'employees' => $employees,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required',
            'role'      => 'required',
            'email'     => 'required|unique:users,email',
            'password'  => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
        ],[
            'email.unique'      => 'El correo electrónico ya ha sido registrado en nuestra base de datos',
            'password.min'      => 'La contraseña debe tener minimo 8 caracteres' ,
            'password.regex'    => 'La contraseña debe tener minimo una mayuscula y un numero' ,
        ]);

        $user_id = explode(',', $request->user_id);

        if($user_id[0] == self::RULES['USER_TYPE_CLIENT']){
            $request->validate([
                'user_id'   => 'unique:users,client_id',
            ],[
                'user_id' => 'Este cliente ya tiene un usuario'
            ]);

            $id_client = $user_id[1];
            $id_employee = null;

            $roles = Roles::all();
            foreach($roles as $role){
                if($role->role == self::RULES['USER_ROLE_CLIENT']){
                    $role_id = $role->id;
                }
            }
        }else if($user_id[0] == self::RULES['USER_TYPE_EMPLOYEE']){
            $request->validate([
                'user_id'   => 'unique:users,employee_id',
            ],[
                'user_id' => 'Este emleado ya tiene un usuario'
            ]);

            $id_employee = $user_id[1];
            $id_client = null;
            $role_id = $request->role;
        }

        Users::create([
            'client_id'   => $id_client,
            'employee_id' => $id_employee,
            'role_id'     => $role_id,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Users::find($id);
        $clients = Clients::orderBy('names', 'ASC')->get();
        $employees = Employees::orderBy('names', 'ASC')->get();
        $roles = Roles::all();

        return view('users.detail',[
            'user'      => $user,
            'clients'   => $clients,
            'employees' => $employees,
            'roles'     => $roles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Users::find($id);

        $request->validate([
            'user_id'   => 'required',
            'role'      => 'required',
            'email'     => 'required',
        ]);

        $user_id = explode(',', $request->user_id);

        if($user_id[0] == self::RULES['USER_TYPE_CLIENT']){
            $request->validate([
                'user_id'   => 'unique:users,client_id',
            ],[
                'user_id' => 'Este cliente ya tiene un usuario'
            ]);

            $id_client = $user_id[1];
            $id_employee = null;

            $roles = Roles::all();
            foreach($roles as $role){
                if($role->role == self::RULES['USER_ROLE_CLIENT']){
                    $role_id = $role->id;
                }
            }
        }else if($user_id[0] == self::RULES['USER_TYPE_EMPLOYEE']){

            $request->validate([
                'user_id'   => 'unique:users,employee_id',
            ],[
                'user_id' => 'Este emleado ya tiene un usuario'
            ]);

            $id_employee = $user_id[1];
            $id_client = null;
            $role_id = $request->role;
        }

        if($user->email != $request->email){
            $request->validate([
                'email'     => 'unique:users,email',
            ], [
                'email.unique' => 'El correo electrónico ya ha sido registrado en nuestra base de datos',
            ]);
            $email = $request->email;
        }else{
            $email = $user->email;
        }

        if($request->password == ''){
            $password = $user->password;
        }else{
            $request->validate([
                'password'  => 'min:8|regex:/^(?=.*[A-Z])(?=.*\d).+$/',
            ],[
                'password.min'      => 'La contraseña debe tener minimo 8 caracteres' ,
                'password.regex'    => 'La contraseña debe tener minimo una mayuscula y un numero' ,
            ]);
            $password = Hash::make($request->password);
        }

        $user->update([
            'client_id'   => $id_client,
            'employee_id' => $id_employee,
            'role_id'     => $role_id,
            'email'       => $email,
            'password'    => $password,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario modificado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Users::find($id);
        $user->delete();
        return redirect()->route('users.index')->with('success','Usuario eliminado exitosamente');
    }
}
