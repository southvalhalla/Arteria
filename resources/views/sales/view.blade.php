<html>
    <head>
		<title>Arteria</title>
		<meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <body class="border bg-body-secondary">
        @include('navBar')
        <div class="row">
            <div class="col-5">
                <div class="rounder">
                    <div class="row">
                        <div class="col-12 table-primary p-1">
                            <h3 class="text-center">Informacion de pago</h3>
                        </div>
                        <div class="col-12 border bg-body-secondary m-2">
                            @if($sale->methods_payment->type == 'card')
                                <p><b>Numero de tarjeta: </b>{{ $sale->methods_payment->number_account }}</p>
                                <p><b>Nombre del Titular: </b>{{ $sale->methods_payment->name .' '. $sale->methods_payment->lastName }}</p>
                                <p><b>Fecha de vencimiento: </b>{{ $sale->methods_payment->expirate_date }}</p>
                                <p><b>Codigo de seguridad: </b> ****</p>
                                <p><b>Banco Emisor: </b>{{ $sale->methods_payment->bank }}</p>
                                <p><b>Tipo de tarjeta: </b>{{ $sale->methods_payment->card_type }}</p>
                            @elseif($sale->methods_payment->type == 'cash')
                                <p><b>Nombres y apellidos: </b>{{ $sale->methods_payment->name .' '. $sale->methods_payment->lastName }}</p>
                            @elseif($sale->methods_payment->type == 'nequi')
                                <p><b>Nombres y apellidos: </b>{{ $sale->methods_payment->name .' '. $sale->methods_payment->lastName }}</p>
                                <p><b>Celular: </b>{{ $sale->methods_payment->number_account }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-7">
                <div class="rounder">
                    <div class="row">
                        <div class="col-12 table-primary p-1">
                            <h3 class="text-center">Informacion completa de la Compra</h3>
                        </div>
                        <div class="row">
                            <div class="col-4 border bg-body-secondary">
                                <div class="m-2">
                                    <p><b>ID: </b>{{ $sale->id }}</p>
                                    <p><b>Cod: </b>{{ $sale->cod }}</p>
                                    @php($date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $sale->date)->setTimezone('America/Bogota'))
                                    <p><b>Fecha: </b>{{ $date->format('d/m/Y') }}</p>
                                    <p><b>ID Cliente: </b>{{ $sale->client_id }}</p>
                                    <p><b>Estado: </b>{{ $sale->status }}</p>
                                    <p><b>Total: </b>{{ $sale->total }}</p>
                                </div>
                            </div>
                            <div class="col-8 border bg-body-secondary">
                                <div class="m-2">
                                    <p><b>ID Cliente: </b>{{ $sale->client_id }}</p>
                                    <p><b>Tipo de documento: </b>{{ $sale->client->document_type->document_type}}</p>
                                    <p><b>Documento: </b>{{ $sale->client->document_number }}</p>
                                    <p><b>Nombre del cliente: </b>{{ $sale->client->names.' '.$sale->client->lastnames }}</p>
                                    <p><b>Telefono: </b>{{ $sale->client->phone }}</p>
                                    <p><b>Email: </b>{{ $sale->client->email }}</p>
                                    <p><b>Direccion: </b>{{ $sale->client->address }}</p>
                                    <p><b>Ciudad: </b>{{ $sale->client->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="rounder">
                    <div class="">
                        <div class="text-center table-primary p-1">
                            <h3>Productos</h3>
                        </div>
                        <div class="row">
                            @foreach($sale->products as $product)
                            <div class="col-6 border bg-body-secondary">
                                <div class="m-2">
                                    <p><b>ID: </b>{{ $product->id }}</p>
                                    <p><b>Producto: </b>{{ $product->name }}</p>
                                    <p><b>Cantidad Requerida: </b>{{ $product->pivot->quantity }}</p>
                                    <p><b>Precio Und.: </b>{{ $product->price }}</p>
                                    <p><b>Precio Total: </b>{{ $product->price * $product->pivot->quantity }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <div style='width:26%'>
                <a href="{{route('sales.index')}}"><button class='btn btn-danger' >Volver</button></a>
                </div>
            </div>
        </div>
    </body>
</html>
