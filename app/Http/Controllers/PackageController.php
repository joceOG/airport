<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Validator;
use App\Models\Packages;
use App\Models\User;
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
        // $admin = User::where('user_id', session()->get('user_id'))->first();
        // if($admin && $admin->admin_key === bcrypt(config('app.admin_key'))) {
        //     $packages = Packages::all();
        //     return response()->json($packages , 200);
        // } else {
        //     return response()->json('Accès interdit' , 403);
        // }
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
        // $user = User::where('user_id', $request->session()->get('user_id'))->first();

       // if(!($user && $user->verified)) {
        //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
        // }

        $newItem = new Packages();
        $newItem->package_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'package.item' => 'required|string|min:2|max:255',
            'package.category' => 'required|string|min:2|max:255',
            'package.weight' => 'required|numeric|min:0|max:100',
            'package.departure' => 'required|string|alpha_dash|min:2|max:255',
            'package.destination' => 'required|string|alpha_dash|min:2|max:255',
            'package.departure_date' => 'required|date|after:today',
            'package.price' => 'required|numeric|min:0'
        ], [
            'package.item.required' => 'Article à envoyer requis',
            'package.category.required' => 'Categorie requise',
            'package.weight.required' => 'Poids de l\'article requis',
            'package.departure.required' => 'Lieu de départ requis',
            'package.destination.required' => 'Destination requise',
            'package.departure_date.required' => 'Date de départ requise',
            'package.price.required' => 'Prix requis'
        ]);

        if(!$validator->fails()) {
            $newItem->item = PackageController::mysql_escape_mimic($request->package['item']);
            $newItem->category = PackageController::mysql_escape_mimic($request->package['category']);
            $newItem->weight = $request->package['weight'];
            $newItem->departure = PackageController::mysql_escape_mimic($request->package['departure']);
            $newItem->destination = PackageController::mysql_escape_mimic($request->package['destination']);
            $newItem->departure_date = PackageController::mysql_escape_mimic($request->package['departure_date']);
            // $newItem->sender_id = PackageController::mysql_escape_mimic($request->session()->get('user_id'));
            $newItem->sender_id = PackageController::mysql_escape_mimic($request->package['sender_id']);
            $newItem->price = $request->package['price'];
            $newItem->save();

            // if($request->session()->missing('package_id')) {
            //     $request->session()->put('package_id', $newItem->package_id);
            // } else {
            //     $request->session()->forget('package_id');
            //     $request->session()->put('package_id', $newItem->package_id);
            // }

            return response()->json(['data' => $newItem, 'message' => 'Envoi crée'], 201);
        } else {
            return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
        }
    }

    /**
     * Display the specified resources.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::where('user_id', $request->session()->get('user_id'))->first();

        if($user)
            $existingPackages = Packages::where('user_id', $user->user_id);
        else
            return response()->json(['data' => '', 'message' => 'Vous devez être connecté pour accéder à cette resource.'], 401);

        if($existingPackages)
            return response()->json(['data' => $existingPackages, 'message' => 'Envoi(s) trouvé(s)'], 200);
        else
            return response()->json(['data' => '', 'message' => 'Aucune envoi trouvé'], 200);
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

            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingItem->sender_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            // $associatedDeliveries = Deliveries::where('package_id', $existingItem->package_id);
            // if(!empty($associatedDeliveries)) {
            //     return response()->json(['data' => '', 'message' => 'Cet envoi ne peut pas être supprimé car elle est associé à une livraison en cours'], 403);
            // }

            $validator = Validator::make($request->all(), [
                'package.item' => 'string|min:2|max:255',
                'package.category' => 'string|min:2|max:255',
                'package.weight' => 'numeric|min:0|max:100',
                'package.departure' => 'string|alpha_dash|min:2|max:255',
                'package.destination' => 'string|alpha_dash|min:2|max:255',
                'package.departure_date' => 'date|after:today',
                'package.price' => 'required|numeric|min:0'
            ], [
                'package.price.required' => 'Prix requis'
            ]);

            if(!$validator->fails()) {
                $existingItem->item = $request->package['item'] ? PackageController::mysql_escape_mimic($request->package['item']) : $existingItem->item;
                $existingItem->item = $request->package['category'] ? PackageController::mysql_escape_mimic($request->package['category']) : $existingItem->category;
                $existingItem->item = $request->package['weight'] ? $request->package['weight'] : $existingItem->weight;
                $existingItem->item = $request->package['departure'] ? PackageController::mysql_escape_mimic($request->package['departure']) : $existingItem->departure;
                $existingItem->item = $request->package['destination'] ? PackageController::mysql_escape_mimic($request->package['destination']) : $existingItem->destination;
                $existingItem->item = $request->package['departure_date'] ? PackageController::mysql_escape_mimic($request->package['departure_date']) : $existingItem->departure_date;
                $existingItem->price = $request->package['price'];
                $existingItem->save();

                return response()->json(['data' => $existingItem, 'message' => 'Envoi modifié'], 200);
            } else {
                return response()->json(['data' => '', 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cet envoi n\'existe pas'], 404);
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

        if ($existingItem) {
            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingItem->sender_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            // $associatedOrder = Deliveries::where('package_id', $existingItem->package_id)->first();
            // if($associatedOrder && $associatedOrder->status != 'livrée') {
            //     return response()->json(['data' => '', 'message' => 'Cet envoi ne peut pas être supprimé car il est associé à une commande en cours'], 403);
            // }

            $existingItem ->delete();
            return response()->json(['data' => '', 'message' => 'Envoi supprimée'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cet envoi n\'existe pas'], 404);
        }
    }
}
