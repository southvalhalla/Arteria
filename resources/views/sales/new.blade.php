@extends('show')
@section('content')
@include('sales.error')

<div class="bg-body-secondary border" id="formregistrar">
    <div class="" id="formregistrar">
        <form action="{{ route('sales.store') }}" class="" method="POST">
            @csrf
            <div class="row">
                <div class="col-12 border-bottom">
                    <h1 class="text-center">Nueva Compra</h1>
                </div>
                <div class="row mx-2 border-bottom">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="row mb-2">
                                    <div class="col-lg-8">
                                        <label for="">Cliente</label>
                                        <select name="client_id" id="" class="form-select">
                                            <option value="" disabled selected>Seleccione Cliente</option>
                                            @foreach($clients as $client)

                                            <option value="{{$client->id}}">{{$client->names.' '.$client->lastnames}}</option>

                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="">Fecha</label>
                                        <input type="date" name="date" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row m-2 border-bottom">
                    <div class="col-lg-3">
                        <button type="button" id="btnAdd" class="btn btn-primary">Añadir otro producto</button>
                    </div>
                    <div class="col-12">
                        <div class="row" id="product">
                            <div class="col-lg-4" id="new">
                                <div class="row mb-2">
                                    <div class="col-lg-9">
                                        <label for="">Producto</label>
                                        <select name="productSelected[]" id="" class="form-select">
                                            <option value="" disabled selected>Seleccione un Producto</option>
                                            @foreach($products as $product):
                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="">Cantidad</label>
                                        <input type="number" name="quantity[]" min="1" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12  border-bottom">
                    <div class="row m-2">
                        <div class="col-lg-4 col-xs-6">
                            <div class="row" id="card_method">
                                <div class="col-12">
                                    <p>
                                        <input type="radio" value="{{ $METHODS_PAYMENT['METHOD_CARD'] }}" name="confirm_method" id="confirm_card_method" required> Tarjeta de Credito/Debito
                                    </p>
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Numero de tarjeta</label>
                                    <input class="form-control" type="number" name="number_account" id="card_element1" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Banco emisor</label>
                                    <input class="form-control" type="text" name="bank" id="card_element5" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Nombres titular</label>
                                    <input class="form-control" type="text" name="name" id="card_element7" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Apellidos titular</label>
                                    <input class="form-control" type="text" name="lastName" id="card_element2" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Fecha de vencimiento</label>
                                    <input class="form-control" type="date" name="expirate_date" id="card_element3" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Código de seguridad</label>
                                    <input class="form-control" type="text" name="security_cod" id="card_element4" maxlength="4" disabled >
                                </div>
                                <div class="col-lg-6 col-sm-6">
                                    <label>Tipo de tarjeta</label>
                                    <input class="form-control" type="text" name="card_type" id="card_element6" disabled >
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6 border-start border-end">
                            <div class="row" id="cash_method">
                                <div class="col-12 mt-sm-2 mt-lg-0">
                                    <p>
                                        <input type="radio" value="{{ $METHODS_PAYMENT['METHOD_CASH'] }}" name="confirm_method" id="confirm_cash_method" required> Efectivo
                                    </p>
                                </div>
                                <div class="col-6">
                                    <label>Nombres</label>
                                    <input class="form-control" type="text" name="name" id="cash_element1" disabled>
                                </div>
                                <div class="col-6">
                                    <label>Apellidos</label>
                                    <input class="form-control" type="text" name="lastName" id="cash_element2" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-sm-6">
                            <div class="row" id="nequi_method">
                                <div class="col-12 mt-sm-2">
                                    <p>
                                        <input type="radio" value="{{ $METHODS_PAYMENT['METHOD_NEQUI'] }}" name="confirm_method" id="confirm_nequi_method" required> Nequi
                                    </p>
                                </div>
                                <div class="col-6">
                                    <label>Nombres</label>
                                    <input class="form-control" type="text" name="name" id="nequi_element1" disabled>
                                </div>
                                <div class="col-6">
                                    <label>Apellidos</label>
                                    <input class="form-control" type="text" name="lastName" id="nequi_element3" disabled>
                                </div>
                                <div class="col-6">
                                    <label>Celular</label>
                                    <input class="form-control" type="text" name="number_account" id="nequi_element2" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 border-bottom">
                    <div class="row m-2">
                        <div class="col-lg-4 col-sm-6">
                            <div class="row">
                                <div class="col-3">
                                    <a href="{{route('sales.index')}}"><button class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                                </div>
                                <div class="col-3">
                                    <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este usuario?');">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="{{asset('js/sales.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </div>
</div>
@endsection
