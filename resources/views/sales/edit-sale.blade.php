<html>
    <head>    
		<title>Arteria</title>
		<meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <link rel="stylesheet" href="<?= constant('URL') ?>public/css/style.css">
    </head>
    <body class="border bg-body-secondary">
        <?php
            include 'app/views/navBar.php';
        ?>
        <div class="row">
            <div class="col-5">
                <div class="rounder">
                    <div class="row">
                        <div class="col-12 table-primary p-1">
                            <h3 class="text-center">Informacion de pago</h3>
                        </div>
                        <div class="col-12 border bg-body-secondary m-2">
                            <?php if($this->saleInfoPay[0] == 'card'){ 
                                $security_code = substr($this->saleInfoPay[4],0,2) .'**';?>
                                <p><b>Numero de tarjeta: </b><?= $this->saleInfoPay[1]; ?></p>
                                <p><b>Nombre del Titular: </b><?= $this->saleInfoPay[2]; ?></p>
                                <p><b>Fecha de vencimiento: </b><?= $this->saleInfoPay[3]; ?></p>
                                <p><b>Codigo de seguridad: </b><?= $security_code ?></p>
                                <p><b>Banco Emisor: </b><?= $this->saleInfoPay[5]; ?></p>
                                <p><b>Tipo de tarjeta: </b><?= $this->saleInfoPay[6]; ?></p>
                            <?php }else if($this->saleInfoPay[0] == 'cash'){ ?>
                                <p><b>Nombres y apellidos: </b><?= $this->saleInfoPay[1]; ?></p>
                                <p><b>Codigo de factura: </b><?= $this->saleInfoPay[2]; ?></p>
                            <?php }else if($this->saleInfoPay[0] == 'nequi'){ ?>
                                <p><b>Nombres y apellidos: </b><?= $this->saleInfoPay[1]; ?></p>
                                <p><b>Celular: </b><?= $this->saleInfoPay[2]; ?></p>
                            <?php } ?>
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
                            <?php foreach($this->sales as $sale):?>
                                <div class="col-4 border bg-body-secondary">
                                    <div class="m-2">
                                        <p><b>ID:</b> <?= $sale['id']; ?></p>
                                        <p><b>Cod:</b> <?= $sale['cod']; ?></p>
                                        <p><b>Fecha:</b> <?= $sale['date']; ?></p>
                                        <p><b>ID Cliente:</b> <?= $sale['id_client']; ?></p>
                                        <p><b>Estado:</b> <?= $sale['status']; ?></p>
                                        <p><b>Total:</b> <?= $sale['total']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach;
                            foreach($this->clients as $client):?>
                                <div class="col-8 border bg-body-secondary">
                                    <div class="m-2">
                                        <p><b>ID Cliente: </b><?= $sale['id_client']; ?></p>
                                        <p><b>Tipo de documento: </b><?= $client['document_type']; ?></p>
                                        <p><b>Documento: </b><?= $client['document_number']; ?></p>
                                        <p><b>Nombre del cliente: </b><?= $client['names'].' '.$client['lastnames']; ?></p>
                                        <p><b>Telefono: </b><?= $client['phone']; ?></p>
                                        <p><b>Email: </b><?= $client['email']; ?></p>
                                        <p><b>Direccion: </b><?= $client['address']; ?></p>
                                        <p><b>Ciudad: </b><?= $client['city']; ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
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
                            <?php foreach($this->saleInfoProds as $infoProd):
                            $infoView = explode('_', $infoProd);  ?>
                            <div class="col-6 border bg-body-secondary">
                                <div class="m-2">
                                    <p><b>ID: </b><?= $infoView[0]; ?></p>
                                    <p><b>Cod: </b><?= $infoView[2]; ?></p>
                                    <p><b>Producto: </b><?= $infoView[1]; ?></p>
                                    <p><b>Cantidad Requerida: </b><?= $infoView[5]; ?></p>
                                    <p><b>En inventario: </b><?= $infoView[3]; ?></p>
                                    <p><b>Precio Und.: </b><?= $infoView[4]; ?></p>
                                    <p><b>Precio Total: </b><?= $infoView[4]*$infoView[5]; ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-2">
                <div style='width:26%'>
                <a href="<?= constant('URL').'sales' ?>"><button class='btn btn-danger' >Volver</button></a>
                </div>
            </div>
        </div>
    </body>
</html>
