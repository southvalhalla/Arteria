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
    public function all(Request $request)
    {
        $limit = $request->limit ??  5;
        $begin = Is_numeric($request->page) ? ($request->page - 1) * $limit : 0;
        $clients = Clients::orderBy('id', 'DESC')->skip($begin)->take($limit)->get();
        $clients->load('document_type');

        return response()->json($clients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(ClientsRequest $request)
    {
        $client = new Clients;
        $client->fill($request->all());
        $client->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        $client = Clients::findOrFail($id);
        $client->load('document_type');

        return response()->json($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function patch(Request $request, $id)
    {
        $client = Clients::findOrFail($id);
        $client->fill($request->all());
        $client->save();
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
    }
}
