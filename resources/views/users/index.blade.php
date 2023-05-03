@extends('app')
@section('content')
@if (session('success'))
    <h6 class="alert alert-success">{{ session('success') }}</h6>
@endif
@include('users/error')
<div id="barrabuscar" class="mx-auto my-3">
    <form method="POST" class="">
        <div class="row">
            <div class="col-2 offset-2">
                <select class="form-select" name="option_search" id="option_search">
                    <option value="" selected disabled>Filtro</option>
                    <option value="id">ID</option>
                    <option value="user">Nombre Usuario</option>
                    <option value="email">Correo Electronico</option>
                </select>
            </div>
            <div class="col-4">
                <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar usuario" class="form form-control">
            </div>
            <div class="col-2">
                <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
            </div>
        </div>
    </form>
</div>
<table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width:70%;height:auto">
    <thead class="border table-primary">
        <tr><th colspan="4" class="text-center"><h1>LISTA DE USUARIOS</h1><th><a class="btn btn-primary mt-2" onclick="abrirform()">Agregar</a></th></tr>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Accion</th>

        </tr>
    </thead>
    <tbody class="border" id="tbody-users">
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->employee_id != null ? $user->employee->names.' '.$user->employee->lastnames : $user->client->names.' '.$user->client->lastnames }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role->role }}</td>
            <td style='width:26%'>
                <a class='btn btn-success' href="{{ route('users.show',[$user->id]) }}">Modificar</a> | <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">Eliminar</a>
                <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy',[$user->id]) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="caja_popup bg-body-secondary border border-4 border-primary-subtle rounded position-absolute top-50 start-50 translate-middle w-50 h-75" id="formregistrar">
    <form action="{{ route('users.store') }}" class="contenedor_popup" method="POST">
        @csrf
        <table>
            <tr><th colspan="2">Nuevo Usuario</th></tr>
            <tr>
                <td>Usuario</td>
                <td>
                    <select class="form-select ms-1" name="user_id" required>
                        <option value="" disabled selected>--SELECCIONE UN USUARIO--</option>
                        <optgroup label="Clientes">
                            @foreach($clients as $client)

                            <option value="{{'client,'.$client->id}}">{{$client->names .' '. $client->lastnames}}</option>

                            @endforeach
                        </optgroup>
                        <optgroup label="Empleados">
                            @foreach($employees as $employee)

                            <option value="{{'employee,'.$employee->id}}">{{$employee->names.' '.$employee->lastnames}}</option>

                            @endforeach
                        </optgroup>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Rol </td>
                <td>
                    <select name="role" id="role" class="form-select ms-1">
                        <option value="" disabled selected>--SELECCIONE UN ROL--</option>
                        <@foreach($roles as $role)

                        <option value="{{$role->id}}">{{$role->role}}</option>

                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Correo Electronico </td>
                <td><input type="email" name="email"class="form-control ms-1"></td>
            </tr>
            <tr>
                <td>Contraseña </td>
                <td><input type="password" name="password"class="form-control ms-1"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href=""><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                    <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');">
                </td>
            </tr>
        </table>
    </form>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/users.js') }}"></script>
</div>
@endsection
