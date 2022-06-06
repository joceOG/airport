<?php

namespace App\Http\Controllers;

use App\Models\Deliveries;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Deliveries::orderBy('created_at', 'DESC')->get();
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
    public function store(Request $request)
    {
        $newItem = new Deliveries();
        $newItem->delivery_id = UuidV4::uuid4();
        $newItem->sender_email = $request->delivery['sender_email'];
        $newItem->courier_email = $request->delivery['courier_email'];
        $newItem->package = $request->delivery['package'];
        $newItem->status = $request->delivery['status'];
        $newItem->sender_id = $request->delivery['sender_id'];
        $newItem->courier_id = $request->delivery['courier_id'];
        $newItem->save();

        return $newItem;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existingAd = Deliveries::find($id);

        if ($existingAd) {
            $existingAd->status = $request->delivery['status'];
            $existingAd->save();

            return $existingAd;
        } else {
            return "Delivery not found";
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingItem = Deliveries::find($id);

        if ($existingItem ) {
            $existingItem ->delete();
            return "Delivery successfully deleted";
        } else {
            return "Delivery not found";
        }
    }
}
