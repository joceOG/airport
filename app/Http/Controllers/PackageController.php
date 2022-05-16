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
        $newItem->item = $request->ad['item'];
        $newItem->category = $request->ad['category'];
        $newItem->length = $request->ad['length'];
        $newItem->width = $request->ad['width'];
        $newItem->sender_id = $request->ad['sender_id'];
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
        $existingAd = Packages::find($id);

        if ($existingAd) {
            $existingAd->item = $request->ad['item'];
            $existingAd->category = $request->ad['category'];
            $existingAd->length = $request->ad['length'];
            $existingAd->width = $request->ad['width'];
            $existingAd->weight = $request->ad['weight'];
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
        //
    }
}
