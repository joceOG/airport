<?php

namespace App\Http\Controllers;

use App\Models\Packages;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Packages::orderBy('created_at', 'DESC')->get();
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
        $newItem = new Packages();
        $newItem->package_id = UuidV4::uuid4();
        $newItem->item = $request->package['item'];
        $newItem->category = $request->package['category'];
        $newItem->weight = $request->package['weight'];
        $newItem->departure = $request->package['departure'];
        $newItem->destination = $request->package['destination'];
        $newItem->departure_date = $request->package['departure_date'];
        $newItem->sender_id = $request->package['sender_id'];
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
        $existingItem = Packages::find($id);

        if ($existingItem) {
            $existingItem->item = $request->package['item'];
            $existingItem->category = $request->package['category'];
            $existingItem->weight = $request->package['weight'];
            $existingItem->departure = $request->package['departure'];
            $existingItem->destination = $request->package['destination'];
            $existingItem->departure_date = $request->package['departure_date'];
            $existingItem->save();

            return $existingItem;
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
        $existingItem = Packages::find($id);

        if ($existingItem ) {
            $existingItem ->delete();
            return "Package successfully deleted";
        } else {
            return "Package not found";
        }
    }
}
