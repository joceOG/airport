<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Ads;
use App\Models\Packages;
use App\Models\User;
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
        // $admin = User::where('user_id', session()->get('user_id'));
        // if($admin && $admin->admin_key === bcrypt(config('app.admin_key'))) {
        //     $ads = Ads::all();
        //     return response()->json($ads , 200);
        // } else {
        //     return response()->json('Accès interdit' , 403);
        // }

        $ads = Ads::all();
        return response()->json($ads , 200);
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

        $newAd = new Ads();
        $newAd->ad_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'ad.ticket_number' => 'required|string|alphanum',
            'ad.departure' => 'required|string|alpha_dash|min:2|max:255',
            'ad.destination' => 'required|string||alpha_dash|min:2|max:255',
            'ad.departure_date' => 'required|date|after:today',
            'ad.arrival_date' => 'required|date|after:departure_date',
            'ad.space' => 'required|numeric|min:0|max:100',
        ], [
            'ad.ticket_number.required' => 'Numéro du billet requis',
            'ad.travel_company.required' => 'Nom de la compagnie de voyage requis',
            'ad.departure.required' => 'Lieu de départ requis',
            'ad.destination.required' => 'Destination requise',
            'ad.departure_date.required' => 'Date de départ requise',
            'ad.arrival_date.required' => 'Date d\'arrivée requise',
            'ad.space.required' => 'Espace disponible requis',
            'ad.categories_accepted.required' => 'Catégories acceptées requises',
        ]);

        if(!$validator->fails()) {
            // $newAd->user_id = $user->user_id;
            $newAd->user_id = AdController::mysql_escape_mimic($request->ad['user_id']);
            $newAd->ticket_number = AdController::mysql_escape_mimic($request->ad['ticket_number']);
            $newAd->travel_company = AdController::mysql_escape_mimic($request->ad['travel_company']);
            $newAd->departure = AdController::mysql_escape_mimic($request->ad['departure']);
            $newAd->destination = AdController::mysql_escape_mimic($request->ad['destination']);
            $newAd->departure_date = AdController::mysql_escape_mimic($request->ad['departure_date']);
            $newAd->arrival_date = AdController::mysql_escape_mimic($request->ad['arrival_date']);
            $newAd->space = $request->ad['space'];
            $newAd->categories_accepted = $request->ad['categories_accepted'];
            $newAd->save();

            return response()->json(['data' => $newAd, 'message' => 'Annonce crée'], 201);
        } else {
            return response()->json(['data' => '', 'message' => $validator->errors()], 400);
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
            $existingAds = Ads::where('user_id', $user->user_id);
        else
            return response()->json(['data' => '', 'message' => 'Vous devez être connecté pour accéder à cette resource.'], 401);

        if($existingAds)
            return response()->json(['data' => $existingAds, 'message' => 'Annonce(s) trouvée(s)'], 200);
        else
            return response()->json(['data' => '', 'message' => 'Aucune annonce trouvée'], 200);
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
            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingAd->user_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            // $associatedOrders = Orders::where('ad_id', $existingAd->ad_id);
            // if(!empty($associatedOrders)) {
            //     return response()->json(['data' => '', 'message' => 'Cette annonce ne peut pas être modifiée car elle est associé à une commande en cours'], 403);
            // }

            $validator = Validator::make($request->all(), [
                'ad.ticket_number' => 'string|unique:App\Models\Ad,ticket_number|alpha_dash',
                'ad.travel_company' => 'string|max:255',
                'ad.departure' => 'string|alpha_dash|min:2|max:255',
                'ad.destination' => 'string||alpha_dash|min:2|max:255',
                'ad.departure_date' => 'date|after:today',
                'ad.arrival_date' => 'date|after:departure_date',
                'ad.space' => 'required|numeric|min:0|max:100',
                'ad.categories_accepted' => 'required|array'
            ], [
                'space.required' => 'Espace disponible requis',
                'categories_accepted.required' => 'Catégories acceptées requises'
            ]);

            if(!$validator->fails()) {
                $existingAd->ticket_number = $request->ad['ticket_number'] ? AdController::mysql_escape_mimic($request->ad['ticket_number']) : $existingAd->ticket_number;
                $existingAd->ticket_number = $request->ad['travel_company'] ? AdController::mysql_escape_mimic($request->ad['travel_company']) : $existingAd->travel_company;
                $existingAd->ticket_number = $request->ad['departure'] ? AdController::mysql_escape_mimic($request->ad['departure']) : $existingAd->departure;
                $existingAd->ticket_number = $request->ad['destination'] ? AdController::mysql_escape_mimic($request->ad['destination']) : $existingAd->destination;
                $existingAd->ticket_number = $request->ad['departure_date'] ? AdController::mysql_escape_mimic($request->ad['departure_date']) : $existingAd->departure_date;
                $existingAd->ticket_number = $request->ad['arrival_date'] ? AdController::mysql_escape_mimic($request->ad['arrival_date']) : $existingAd->arrival_date;
                $existingAd->space = $request->ad['space'];
                $existingAd->categories_accepted = $request->ad['categories_accepted'];
                $existingAd->save();

                return response()->json(['data' => $existingAd, 'message' => 'Annonce modifiée'], 200);
            } else {
                return response()->json(['data' => '', 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette annonce n\'existe pas'], 404);
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
        $errors_size = 1;
        $errors = [];

        if($package) {
            // if($package->user_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            $upper_bound = strtotime('+3 day', strtotime($package['departure_date']));
            // $lower_bound = strtotime('-3 day', strtotime($package['departure_date']));
            $matchingAds = Ads::get()->filter(function ($value, $key) use($package, $upper_bound, $errors, $errors_size ){

                $ad_departure_date = strtotime($value['departure_date']);

                $space_match = $value['space'] >= $package['weight'];
                if(!$space_match)
                    $errors[$errors_size]['space'] = 'Package too heavy';

                $departure_match = $value['departure'] == $package['departure'];
                if(!$departure_match)
                    $errors[$errors_size]['departure'] = 'No courier leaving from $value["departure"]';

                $destination_match = $value['destination'] == $package['destination'];
                if(!$destination_match)
                    $errors[$errors_size ]['destination'] = 'No courier going to $value["destination"]';

                $date_match = $ad_departure_date < $upper_bound;
                if(!$date_match)
                    $errors[$errors_size]['date'] = 'No courier going to $value["destination"] from $value["departure"]';

                if(!$space_match || !$departure_match || !$destination_match || $date_match)
                    $errors_size++;

                return $space_match
                && $departure_match
                && $destination_match
                && $date_match;
            });

            $matchingAds = $matchingAds->filter(function ($value, $key) use($package){
                $categoriesAccepted = $value['categories_accepted'];
                foreach($categoriesAccepted as $category) {
                    if($category === $package['category'])
                        return true;
                    else
                        return false;
                }
            });

            $tab=[];
            foreach($matchingAds as $item){
                array_push($tab,$item);
            }

            if(count($tab) == 0) {
                $result = count($errors) == 0 ? [0 => '$package["category"] is not accepted by any courier'] : $errors;
                $to_delete = Packages::find($package['id']);
                if($to_delete)
                    $to_delete->delete();
                return response()->json(['data' => $result, 'message' => 'Aucun résultat'], 200);
            } else {
                return response()->json(['data' => $tab , 'message' => count($matchingAds) . " résultat(s)"], 200);
            }
        } else {
            return response()->json(['data' => [], 'message' => 'Envoi manquant'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingAd = Ads::find($id);

        if ($existingAd) {
            // $user = User::where('user_id', session()->get('user_id'));

            // if(!($user && ($existingAd->user_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            // $associatedOrders = Orders::where('ad_id', $existingAd->ad_id);
            // if(!empty($associatedOrders)) {
            //     return response()->json(['data' => '', 'message' => 'Cette annonce ne peut pas être supprimée car elle est associée à une (ou plusieurs) commande(s) en cours'], 403);
            // }

            $existingAd ->delete();
            return response()->json(['data' => '', 'message' => 'Annonce supprimée'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cette annonce n\'existe pas'], 404);
        }
    }
}
