<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use Illuminate\Http\Request;
use Ramsey\Uuid\Rfc4122\UuidV4;

class AdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ads::orderBy('created_at', 'DESC')->get();
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
        $newItem = new Ads();
        $newItem->ad_id = UuidV4::uuid4();
        $newItem->departure = $request->ad['departure'];
        $newItem->destination = $request->ad['destination'];
        $newItem->departure_date = $request->ad['departure_date'];
        $newItem->arrival_date = $request->ad['arrival_date'];
        $newItem->space = $request->ad['space'];
        $newItem->packages_accepted = $request->ad['packages_accepted'];
        $newItem->clicks = $request->ad['clicks'];
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
        $existingAd = Ads::find($id);

        if ($existingAd) {
            $existingAd->departure = $request->ad['departure'];
            $existingAd->destination = $request->ad['destination'];
            $existingAd->departure_date = $request->ad['departure_date'];
            $existingAd->arrival_date = $request->ad['arrival_date'];
            $existingAd->space = $request->ad['space'];
            $existingAd->packages_accepted = $request->ad['packages_accepted'];
            $existingAd->save();

            return $existingAd;
        } else {
            return "Ad not found";
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
        $existingItem = Ads::find($id);

        if ($existingItem ) {
            $existingItem ->delete();
            return "Ad successfully deleted";
        } else {
            return "Ad not found";
        }

    }
}
