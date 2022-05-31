<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Deliveries;
use App\Models\Packages;
use App\Models\User;
use App\Models\Ads;
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
        $deliveries = Deliveries::all();
        return response()->json($deliveries, 200);
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
        // if($package->sender_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

        $newDelivery = new Deliveries();
        $newDelivery->delivery_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'ad.user_id' => 'required|uuid'
        ], [
            'ad.user_id.required' => 'User ID requis'
        ]);

        if(!$validator->fails()) {
            // $sender = User::firstWhere('user_id', $request->session()->get('user_id'));
            // $courier = User::firstWhere('user_id', $request->ad['user_id']);

            // $newDelivery->sender_email = DeliveryController::mysql_escape_mimic($sender->email);
            // $newDelivery->courier_email = DeliveryController::mysql_escape_mimic($courier->email);
            $newDelivery->sender_email = 'cmguinan@yahoo.fr';
            $newDelivery->courier_email = 'lasourcebeats@gmail.com';
            // $newDelivery->package_id = $request->session()->get('package_id');
            $newDelivery->package_id = UuidV4::uuid4();
            $newDelivery->status = 'en attente';
            // $newDelivery->sender_id = DeliveryController::mysql_escape_mimic($sender->user_id);
            // $newDelivery->courier_id = DeliveryController::mysql_escape_mimic($courier->user_id);
            $newDelivery->sender_id = UuidV4::uuid4();
            $newDelivery->courier_id = UuidV4::uuid4();
            $newDelivery->save();

            return response()->json(['data' => $newDelivery, 'message' => ''], 201);
        } else {
            return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
        }
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
        $existingDelivery = Deliveries::find($id);

        if ($existingDelivery) {

        // if($existingDelivery->courier_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $validator = Validator::make($request->all(), [
                'delivery.status' => 'required|string|alpha|in:acceptée,rejetée,livrée'
            ], [
                'delivery.status.required' => 'Nouveau status requis',
                'delivery.status.in' => 'Cette livraison doit être acceptée, rejetée ou confirmée comme livrée'
            ]);

            if(!$validator->fails()) {
                $existingDelivery->status = DeliveryController::mysql_escape_mimic($request->delivery['status']);
                $existingDelivery->save();

                $associatedAd = Ads::firstWhere('sender_id', $existingDelivery->sender_id);
                $associatedPackage = Packages::firstWhere('package_id', $existingDelivery->package_id);

                if($existingDelivery->status === 'accepted') {
                    $associatedAd->space = $associatedAd->space > $associatedPackage->weight ? $associatedAd->space - $associatedPackage->weight : 0;
                } elseif($existingDelivery->status === 'rejected') {
                    $associatedPackage->delete();
                    $existingDelivery->delete();
                }

                return response()->json(['data' => $existingDelivery, 'message' => ''], 200);
            } else {
                return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette livraison n\'existe pas'], 404);
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
        $existingDelivery = Deliveries::find($id);

        // if($existingDelivery->courier_id !== session()->get('user_id')) {
        //         return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
        // }

        if($existingDelivery) {
            $existingDelivery ->delete();

            return response()->json(['data' => '', 'message' => 'Livraison rejetée'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cette livraison n\'existe pas'], 404);
        }
    }
}
