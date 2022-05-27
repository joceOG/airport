<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
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
        $packages = Packages::all();
        return response()->json($packages , 200);
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

        $validator = Validator::make($request->all(), [
            'package.item' => 'required|string|max:255',
            'package.category' => 'required|string|max:255',
            'package.weight' => 'required|numeric|min:0|max:100',
            'package.departure' => 'required|string|max:255',
            'package.destination' => 'required|string|max:255',
            'package.departure_date' => 'required|date',
            'package.sender_id' => 'required|uuid',
            'package.price' => 'required|numeric|min:0'
        ], [
            'package.item.required' => 'Article à envoyer requis',
            'package.category.required' => 'Categorie requise',
            'package.weight.required' => 'Poids de l\'article requis',
            'package.departure.required' => 'Lieu de départ requis',
            'package.destination.required' => 'Destination requise',
            'package.departure_date.required' => 'Date de départ requise',
            'package.sender_id.required' => 'User ID requis',
            'package.price.required' => 'Prix requis',
        ]);

        if(!($validator->fails())) {
            $newItem->item = PackageController::mysql_escape_mimic($request->package['item']);
            $newItem->category = PackageController::mysql_escape_mimic($request->package['category']);
            $newItem->weight = PackageController::mysql_escape_mimic($request->package['weight']);
            $newItem->departure = PackageController::mysql_escape_mimic($request->package['departure']);
            $newItem->destination = PackageController::mysql_escape_mimic($request->package['destination']);
            $newItem->departure_date = PackageController::mysql_escape_mimic($request->package['departure_date']);
            // $newItem->sender_id = PackageController::mysql_escape_mimic($request->session()->get('user_id'));
            $newItem->sender_id = UuidV4::uuid4();
            $newItem->price = PackageController::mysql_escape_mimic($request->package['price']);
            $newItem->save();

            // if($request->session()->missing('package_id')) {
            //     $request->session()->put('package_id', $newItem->package_id);
            // } else {
            //     $request->session()->forget('package_id');
            //     $request->session()->put('package_id', $newItem->package_id);
            // }

            return response()->json(['data' => $newItem, 'message' => ''], 201);
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
         $existingItem = Packages::find($id);

        if ($existingItem) {

            // if($existingItem->sender_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $validator = Validator::make($request->all(), [
                'ticket_number' => 'required|string|alphanum',
                'travel_company' => 'required|string|max:255',
                'departure' => 'required|string|max:255',
                'destination' => 'required|string|max:255',
                'departure_date' => 'required|date',
                'arrival_date' => 'required|date|after:departure_date',
                'space' => 'required|numeric|min:0|max:100',
                'categories_accepted' => 'required|array'
            ], [
                'ticket_number.required' => 'Numéro du billet requis',
                'travel_company.required' => 'Nom de la compagnie de voyage requis',
                'departure.required' => 'Lieu de départ requis',
                'destination.required' => 'Destination requise',
                'departure_date.required' => 'Date de départ requise',
                'arrival_date.required' => 'Date d\'arrivée requise',
                'space.required' => 'Espace disponible requis',
                'categories_accepted.required' => 'Catégories acceptées requises',
            ]);

            if(!$validator->fails()) {
                $existingItem->item = PackageController::mysql_escape_mimic($request->package['item']);
                $existingItem->category = PackageController::mysql_escape_mimic($request->package['category']);
                $existingItem->weight = PackageController::mysql_escape_mimic($request->package['weight']);
                $existingItem->departure = PackageController::mysql_escape_mimic($request->package['departure']);
                $existingItem->destination = PackageController::mysql_escape_mimic($request->package['destination']);
                $existingItem->departure_date = PackageController::mysql_escape_mimic($request->package['departure_date']);
                $existingItem->sender_id = PackageController::mysql_escape_mimic($request->session()->get('user_id'));
                $existingItem->price = PackageController::mysql_escape_mimic($request->package['price']);
                $existingItem->save();

                return response()->json(['data' => $existingItem, 'message' => ''], 200);
            } else {
                return response()->json(['data' => '', 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette annonce n\'existe pas']);
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
            // if($existingItem->sender_id !== session('user_id)) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $existingItem ->delete();
            return response()->json(['data' => '', 'message' => 'Envoi supprimée'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cet envoi n\'existe pas'], 400);
        }
    }
}
