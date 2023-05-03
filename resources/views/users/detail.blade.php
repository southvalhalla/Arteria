@extends('show')
@section('content')
@include('users/error')
<form action="{{route('users.update', [$user->id])}}" class="contenedor_popup" method="POST">
    @method('PATCH')
    @csrf
    <table class="table table-dark table-striped table-hover justify-content-center border-secondary rounded mx-auto">
        <tr><th colspan="2">Actualizar Usuario</th></tr>
        <tr>
            <td>Usuario</td>
            <td>
                <select class="form-select ms-1" name="user_id" required>
                    <option value="" disabled>--SELECCIONE UN USUARIO--</option>
                    <optgroup label="Clientes">
                        @foreach($clients as $client)

                        <option value="{{'client,'.$client->id}}" {{($client->id == $user->client_id) && ($user->client_id != NULL)  ? 'selected' : ''}} >{{$client->names .' '. $client->lastnames}}</option>

                        @endforeach
                    </optgroup>
                    <optgroup label="Empleados">
                        @foreach($employees as $employee)

                        <option value="{{'employee,'.$employee->id}}" {{($employee->id == $user->employee_id) && ($user->employee_id != NULL)  ? 'selected' : ''}} >{{$employee->names.' '.$employee->lastnames}}</option>

                        @endforeach
                    </optgroup>
                </select>
            </td>
        </tr>
        <tr>
            <td>Rol </td>
            <td>
                <select name="role" id="role" class="form-select ms-1" required>
                    <@foreach($roles as $role)

                    <option value="{{$role->id}}" {{$role->id == $user->role_id ? 'selected' : ''}}>{{$role->role}}</option>

                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>Correo Electronico </td>
            <td><input class="form-control ms-1" type="email" name="email" value="{{$user->email}}" required ></td>
        </tr>
        <tr>
            <td>Contraseña </td>
            <td><input type="password" name="password" class="form-control ms-1" value=""></td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{ url('users') }}"><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas actualizar este usuario?');">
            </td>
        </tr>
    </table>
</form>
@endsection
