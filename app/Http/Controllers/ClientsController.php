<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientsRequest;
use App\Models\Clients;
use App\Models\Document_type;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_REQUEST['num'])){
            $_REQUEST['num'] = $_REQUEST['num']!=''|!empty($_REQUEST['num'])?$_REQUEST['num']:1;
            $page = $_REQUEST['num'];
        }else{
            $page=1;
        }
        $viewRows = 5;
        $begin = is_numeric($page)?(($page-1)*$viewRows):0;
        $clients = Clients::orderBy('id', 'DESC')->skip($begin)->take($viewRows)->get();
        $rows = Clients::orderBy('id','asc')->count();


        $prev = $page - 1;
        $next = $page + 1;
        $end = ceil($rows/$viewRows);

        $document_types = Document_type::orderBy('id', 'ASC')->get();

        return view('clients.index', [
            'clients' => $clients,
            'document_types' => $document_types,
            'prev' => $prev,
            'next' => $next,
            'end' => $end,
            'page' => $page
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientsRequest $request)
    {
        Clients::create($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Clients::find($id);
        $document_types = Document_type::all();
        return view('clients.detail', [
            'client' => $client,
            'document_types' => $document_types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientsRequest $request, $id)
    {
        Clients::find($id)->update($request->all());

        return redirect()->route('clients.index')->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Clients::findorFail($id);
        $client->users()->each(function($user){
            $user->delete();
        });
        $client->sales()->each(function($sale){
            $sale->delete();
        });
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente '. $client->id.' eliminado correctamente.');
    }

    // public function updateAll()
    // {
    //     $document_types = Document_type::all();
    //     $clients = Clients::all();

    //     foreach($clients as $client){
    //         foreach($document_types as $document_type){
    //             if($client->document_type == $document_type->document_type){
    //                 $client->document_type_id = $document_type->id;
    //             }
    //         }
    //         $client->save();
    //     }
    // }
}
