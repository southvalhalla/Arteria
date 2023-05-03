<?php

namespace App\Http\Controllers;

use App\Classes\MethodsPaymentBuilder;
use App\Models\Clients;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Models\Sales;
use App\Classes\ProductBuilder;
use App\Models\Methods_payment;
use App\Models\Products_sales;
use Carbon\Carbon;

class SalesController extends Controller
{
    const METHODS_PAYMENT  = [
        "METHOD_NEQUI" => 'nequi',
        "METHOD_CARD" => 'card',
        "METHOD_CASH" => 'cash',
    ];

    public function index(){
        $sales = Sales::orderBy('id', 'desc')->get();
        $clients = Clients::all();
        return view('sales.index',[
            'sales'     => $sales,
            'clients'   => $clients,
        ]);
    }

    public function create(){
        $products = Products::orderBy('name', 'asc')->get();
        $clients = Clients::orderBy('names', 'asc')->select('id','names','lastnames')->get();
        return view('sales.new',[
            'products'  => $products,
            'clients'   => $clients,
            'METHODS_PAYMENT'   => self::METHODS_PAYMENT,

        ]);
    }

    public function store(Request $request){
        $request->validate([
            'client_id'         => 'required',
            'date'              => 'required',
            'productSelected'   => 'required',
            'quantity'          => 'required',
            'confirm_method'    => 'required',
        ]);

        if($request->confirm_method == self::METHODS_PAYMENT['METHOD_CARD']){
            $request->validate([
                'number_account'    => 'required',
                'bank'              => 'required',
                'name'              => 'required' ,
                'lastName'          => 'required' ,
                'expirate_date'     => 'required' ,
                'security_cod'      => 'required' ,
                'card_type'         => 'required' ,
            ]);

            // $methodsPayment = (new MethodsPaymentBuilder())
            //     ->withType(self::METHODS_PAYMENT['METHOD_CARD'])
            //     ->withNumberAccount($request->number_account)
            //     ->withBank($request->bank)
            //     ->withName($request->name)
            //     ->withLastName($request->lastName)
            //     ->withExpirateDate($request->expirate_date)
            //     ->withSecurityCod($request->security_cod)
            //     ->withCardType($request->card_type)
            //     ->build();

            Methods_payment::create([
                'type' => self::METHODS_PAYMENT['METHOD_CARD'],
                'number_account' => $request->number_account,
                'bank' => $request->bank,
                'name' => $request->name,
                'lastName' => $request->lastName,
                'expirate_date' => $request->expirate_date,
                'security_cod' => $request->security_cod,
                'card_type' => $request->card_type,
            ]);


        }else if($request->confirm_method == self::METHODS_PAYMENT['METHOD_CASH']){
            $request->validate([
                'name' => 'required' ,
                'lastName' => 'required',
            ]);

            // $methodsPayment = (new MethodsPaymentBuilder())
            //     ->withType(self::METHODS_PAYMENT['METHOD_CASH'])
            //     ->withName($request->name)
            //     ->withLastName($request->lastName)
            //     ->build();

            Methods_payment::create([
                'type' => self::METHODS_PAYMENT['METHOD_CASH'],
                'name' => $request->name,
                'lastName' => $request->lastName,
            ]);

        }else if($request->confirm_method == self::METHODS_PAYMENT['METHOD_NEQUI']){
            $request->validate([
                'name' => 'required' ,
                'lastName' => 'required',
                'number_account' => 'required',
            ]);

            // $methodsPayment = (new MethodsPaymentBuilder())
            //     ->withType(self::METHODS_PAYMENT['METHOD_NEQUI'])
            //     ->withName($request->name)
            //     ->withLastName($request->lastName)
            //     ->withNumberAccount($request->number_account)
            //     ->build();

            Methods_payment::create([
                'type' => self::METHODS_PAYMENT['METHOD_NEQUI'],
                'name' => $request->name,
                'lastName' => $request->lastName,
                'number_account' => $request->number_account,
            ]);
        }
        $methodsPayment = Methods_payment::latest()->first()->id;

        $date = Carbon::createFromFormat('Y-m-d', $request->date);


        $total  = 0;
        $i = 0;
        foreach($request->productSelected as $product){
            $products = Products::find($product);

            $total += $products->price * $request->quantity[$i];
            $i++;
        }

        Sales::create([
            'cod' => 'S' . rand(1000,9999),
            'date' => $date,
            'client_id' => $request->client_id,
            'status' => 'pendiente',
            'methods_payment_id' => $methodsPayment,
            'total' => $total,
        ]);

        $i = 0;
        foreach($request->productSelected as $product){

            $sale_id  = Sales::latest()->first()->id;
            $validation_quatity = Products_sales::where('product_id',$product)->where('sale_id',$sale_id);

            if($validation_quatity->exists()){
                $validation_quatity->update([
                    'quantity' => $validation_quatity->first()->quantity + $request->quantity[$i],
                ]);
            }else{
                $products = Products::find($product);

                Products_sales::create([
                    'product_id' => $products->id,
                    'sale_id' => $sale_id,
                    'name' => $products->name,
                    'price' => $products->price,
                    'quantity' => $request->quantity[$i],
                ]);
            }
            $i++;
        }

        return redirect()->route('sales.index')->with('success', 'Venta registrada correctamente');
    }

    public function status(Request $request ,$id){

        $request->validate([
            'status' => 'required',
        ]);

        Sales::find($id)->update([
            'status' => $request->status,
        ]);

        return redirect()->route('sales.index')->with('success', 'Estado actualizado correctamente');
    }

    public function view($id){
        $sale = Sales::find($id);
        $client = Clients::find($sale->client_id);
        $method_payment = Methods_payment::find($sale->methods_payment_id);

        return view('sales.view',[
            'sale' => $sale,
            // 'client' => $client,
        ]);
    }

    public function destroy($id){
        $sale = Sales::findorFail($id);
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Venta eliminada correctamente');
    }
}
