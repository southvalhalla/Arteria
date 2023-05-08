<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Classes\MethodsPaymentBuilder;
// use App\Classes\ProductBuilder;

use App\Models\Clients;
use App\Models\Products;
use App\Models\Sales;
use App\Models\Methods_payment;
use App\Models\Products_sales;

use App\Http\Requests\SalesRequest;
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

    public function store(SalesRequest $request){

        switch($request->confirm_method){
            case self::METHODS_PAYMENT['METHOD_CARD']:
                $this->methodCard($request);
                break;
            case self::METHODS_PAYMENT['METHOD_CASH']:
                $this->methodCash($request);
                break;
            case self::METHODS_PAYMENT['METHOD_NEQUI']:
                $this->methodNequi($request);
                break;
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

        $this->productBuilder($request);

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

    // methods payment
    private function methodCard($request){
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

    }
    private function methodCash($request){
        Methods_payment::create([
            'type' => self::METHODS_PAYMENT['METHOD_CASH'],
            'name' => $request->name,
            'lastName' => $request->lastName,
        ]);
    }

    private function methodNequi($request){
        Methods_payment::create([
            'type' => self::METHODS_PAYMENT['METHOD_NEQUI'],
            'name' => $request->name,
            'lastName' => $request->lastName,
            'number_account' => $request->number_account,
        ]);
    }

    private function productBuilder($request){
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
    }

}
