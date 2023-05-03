@extends('app')
@section('content')
@if (session('success'))
    <h6 class="alert alert-success">{{ session('success') }}</h6>
@endif
@include('clients/error')
        <div id="barrabuscar" class="mx-auto my-3">
            <form method="POST" class="">
                <div class="row">
                    <div class="col-2 offset-2">
                        <select class="form-select" name="option_search" id="option_search">
                            <option value="" selected disabled>Filtro</option>
                            <option value="id">ID</option>
                            <option value="name">Nombre</option>
                            <option value="document_number">Numero de documento</option>
                        </select>
                    </div>
                    <div class="col-4">
                        <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar cliente" class="form form-control">
                    </div>
                    <div class="col-2">
                        <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
                    </div>
                </div>
            </form>
        </div>
        <table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width:95%;">
            <thead class="border table-primary">
                <tr><th colspan="9" class="text-center"><h1>LISTA DE CLIENTES</h1><th><a class="btn btn-primary mt-2" onclick="abrirform()">Agregar</a></th></tr>
                <tr>
                    <th>ID</th>
                    <th>TIPO DE DOCUMENTO</th>
                    <th>NUMERO DE DOCUMENTO</th>
                    <th>NOMBRES</th>
                    <th>APELLIDOS</th>
                    <th>TELEFONO - CELULAR</th>
                    <th>CORREO</th>
                    <th>DIRECCION</th>
                    <th>CIUDAD</th>
                    <th>Accion</th>

                </tr>
            </thead>
            <tbody class="border" id="tbody-products">
                @foreach($clients as $client)
                <tr>
                    <td>{{ $client->id }} </td>
                    {{-- <td>{{ $client->document_type }} </td> --}}
                    @foreach($document_types as $document_type)
                        @if($client->document_type_id == $document_type->id)
                            <td>{{ $document_type->document_type }}</td>
                        @endif
                    @endforeach
                    <td>{{ $client->document_number }} </td>
                    <td>{{ $client->names }} </td>
                    <td>{{ $client->lastnames }} </td>
                    <td>{{ $client->phone }} </td>
                    <td>{{ $client->email }} </td>
                    <td>{{ $client->address }} </td>
                    <td>{{ $client->city }} </td>
                    <td style='width:26%'>
                        <a class='btn btn-success' href="{{ route('clients.show', [$client->id]) }}">Modificar</a> | <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$client->id}}').submit();">Eliminar</a>
                        <form id="delete-form-{{$client->id}}" action="{{ route('clients.destroy', [$client->id]) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-2 offset-5">
                <nav class="" aria-label="Page navigation">
                    <ul class="pagination">
                        @if($page > 1)
                            <li class="page-item"><a class="page-link" href="{{ url('clients?num=1') }}">Inicio</a></li>
                            <li class="page-item"><a class="page-link" href="{{ url('clients?num=' . ($page - 1)) }}">{{ $page - 1 }}</a></li>
                        @endif

                        <li class="page-item"><a class="page-link" href="{{ url('clients?num=' . $page) }}">{{ $page }}</a></li>

                        @if($page < $end)
                            <li class="page-item"><a class="page-link" href="{{ url('clients?num=' . ($page + 1)) }}">{{ $page + 1 }}</a></li>
                            <li class="page-item"><a class="page-link" href="{{ url('clients?num=' . $end) }}">Final</a></li>
                        @endif

                    </ul>
                </nav>
            </div>
        </div>
        <div class="caja_popup bg-body-secondary border border-4 border-primary-subtle rounded position-absolute top-50 start-50 translate-middle" style="width: 35%; height: 60%;" id="formregistrar">
            <form action="{{ route('clients.store') }}" class="contenedor_popup" method="POST">
                @csrf
                <table>
                    <tr><th colspan="2">Nuevo Cliente</th></tr>
                    <tr>
                        <td>
                            <select class="form-select" name="document_type_id" required>
                                <option value="" disabled selected>Tipo de documento</option>
                                @foreach($document_types as $document_type)
                                <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input class="form-control" type="number" name="document_number" placeholder="Numero de documento" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input class="form-control" type="text" name="names" placeholder="Nombres" required>
                        </td>
                        <td>
                            <input class="form-control" type="text" name="lastnames" placeholder="Apellidos" required>
                        </td>
                    </tr>
                    <tr>
                        <td  colspan="2">
                            <input class="form-control" type="email" name="email" placeholder="Correo" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="form-control" type="number" name="phone" placeholder="Telefono" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="form-control" type="text" name="address" placeholder="Direccion" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input class="form-control" type="text" name="city" placeholder="Ciudad" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <a href=""><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                            <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');">
                        </td>
                    </tr>
                </table>
            </form>
            <script src="{{asset('js/main.js')}}"></script>
            <script src="{{asset('js/clients.js')}}"></script>
        </div>
@endsection
