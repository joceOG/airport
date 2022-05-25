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
        $newItem->user_id = $request->ad['user_id'];
        $newItem->ticket_number = $request->ad['ticket_number'];
        $newItem->ticket_number = $request->ad['travel_company'];
        $newItem->departure = $request->ad['departure'];
        $newItem->destination = $request->ad['destination'];
        $newItem->departure_date = $request->ad['departure_date'];
        $newItem->arrival_date = $request->ad['arrival_date'];
        $newItem->space = $request->ad['space'];
        $newItem->categories_accepted = json_encode($request->ad['categories_accepted']);
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
            $existingAd->ticket_number = $request->ad['ticket_number'];
            $existingAd->ticket_number = $request->ad['travel_company'];
            $existingAd->departure = $request->ad['departure'];
            $existingAd->destination = $request->ad['destination'];
            $existingAd->departure_date = $request->ad['departure_date'];
            $existingAd->arrival_date = $request->ad['arrival_date'];
            $existingAd->space = $request->ad['space'];
            $existingAd->categories_accepted = json_encode($request->ad['categories_accepted']);
            $existingAd->save();

            return $existingAd;
        } else {
            return "Ad not found";
        }

    }

    /**
     * Return ads matching some characteristics of the package
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function search(Request $request)
    {
        $package = $request->package;
        $upper_bound = strtotime('+3 day', strtotime($package['departure_date']));
        $lower_bound = strtotime('-3 day', strtotime($package['departure_date']));
        $matchingAds = Ads::get()->filter(function ($value, $key) use($package, $upper_bound, $lower_bound){
            $ad_departure_date = strtotime($value['departure_date']);
            return $value['space'] >= $package['weight']
            && $value['departure'] == $package['departure']
            && $value['destination'] == $package['destination']
            && ($ad_departure_date > $lower_bound && $ad_departure_date < $upper_bound);
        });

        $matchingAds = $matchingAds->filter(function ($value, $key) use($package){
            $categoriesAccepted = json_decode($value['categories_accepted']);
            foreach($categoriesAccepted as $category) {
                if($category === $package['category'])
                    return true;
                else
                    return false;
            }
        });

        return $matchingAds;
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
