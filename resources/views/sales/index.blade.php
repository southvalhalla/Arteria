@extends('app')
@section('content')
@include('sales.error')

<div id="barrabuscar" class="mx-auto my-3">
    <form method="POST" class="">
        <div class="row">
            <div class="col-4 offset-3">
                <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar ID Venta" class="form form-control">
            </div>
            <div class="col-2">
                <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
            </div>
        </div>
    </form>
</div>
<table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width: 90%;height:auto">
    <thead class="border table-primary">
        <tr>
            <th colspan="7" class="text-center">
                <h1>VENTAS</h1>
            </th>
            <th>
                <a href="{{ route('sales.create') }}" class="mt-2"><button class="btn btn-primary">Agregar</button></a>
            </th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Cod</th>
            <th>Fecha</th>
            <th>ID Cliente</th>
            <th>Precio Total</th>
            <th>Información General</th>
            <th>Estado</th>
            <th>Accion</th>

        </tr>
    </thead>
    <tbody class="border" id="tbody-sales">
        @foreach($sales as $sale)
        <tr>
            <td>{{ $sale->id }}</td>
            <td>{{ $sale->cod }}</td>
            @php($date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sale->date)->setTimezone('America/Bogota'))
            <td>{{ $date->format('d/m/Y') }}</td>
            @foreach($clients as $client)
                @if ($client->id == $sale->client_id)
                    <td>{{ $client->names .' '. $client->lastnames }}</td>
                @endif
            @endforeach
            <td>{{ $sale->total }}</td>
            <td>
                <a href="{{ route('sales.view', [$sale->id, $sale->id_client]) }}"><button class="btn btn-info">Ver</button></a>
            </td>
            <td id="formStatus-{{$sale->id}}" hidden>
                <form action="{{ route('sales.status', [$sale->id]) }}" method="post" >
                    @method('PATCH')
                    @csrf
                    <div class="row mx-1">
                        <div class="col-8">
                            <select name="status" class="form-select ms-1">
                                    <option value="Pendiente" {{ $sale->status == "Pendiente" ? "selected" : "" }} >Pendiente</option>
                                    <option value="Cancelado" {{ $sale->status == "Cancelado" ? "selected" : "" }} >Cancelado</option>
                                    <option value="Despachando" {{ $sale->status == "Despachando" ? "selected" : "" }} >Despachando</option>
                                    <option value="Enviado" {{ $sale->status == "Enviado" ? "selected" : "" }} >Enviado</option>
                                    <option value="Finalizado" {{ $sale->status == "Finalizado" ? "selected" : "" }} >Finalizado</option>
                            </select>
                        </div>
                        <div class="col-4">
                            <button type="submit" id="btnSave-{{$sale->id}}" data-id="{{$sale->id}}" class='btn btn-success'>Guardar</button>
                        </div>
                    </div>
                </form>
            </td>
            <td id="viewStatus-{{$sale->id}}">{{$sale->status}}</td>
            <td style='width:26%'>
                <button onclick="change({{ $sale->id }})" id="btnChange-{{$sale->id}}" class='btn btn-success'>Cambiar Estado</button> <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$sale->id}}').submit();">Eliminar</a>
                <form id="delete-form-{{$sale->id}}" action="{{ route('sales.destroy', [$sale->id]) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            </td>
        @endforeach
        </tr>
    </tbody>
</table>
<div class="caja_popup bg-body-secondary border border-4 border-primary-subtle w-50 h-75" id="formregistrar">
    <div class="caja_popup" id="view-info">

    </div>
</div>
<script src="{{asset('js/main.js')}}"></script>
<script src="{{asset('js/sales.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
