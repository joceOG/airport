<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Orders::orderBy('created_at', 'DESC')->get();
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
        $newItem = new Orders();
        $newItem->order_id = UuidV4::uuid4();
        $newItem->sender_email = $request->ad['sender_email'];
        $newItem->courier_email = $request->ad['courier_email'];
        $newItem->package = $request->ad['package'];
        $newItem->status = $request->ad['status'];
        $newItem->sender_id = $request->ad['sender_id'];
        $newItem->courier_id = $request->ad['courier_id'];
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
        $existingAd = Orders::find($id);

        if ($existingAd) {
            $existingAd->status = $request->ad['status'];
            $existingAd->save();

            return $existingAd;
        } else {
            return "Order not found";
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
        $existingItem = Orders::find($id);

        if ($existingItem ) {
            $existingItem ->delete();
            return "Deliveries successfully deleted";
        } else {
            return "Deliveries not found";
        }
    }
}
