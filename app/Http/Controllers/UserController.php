<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Deliveries;
use App\Models\Orders;
use App\Models\Packages;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Ramsey\Uuid\Rfc4122\UuidV4;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Ajouter vérification usermin

        $users = User::all() ;
        return response()->json($users , 200);
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
        $newUser = new User();
        $newUser->user_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'user.first_name' => 'required|string|alphanum',
            'user.last_name' => 'required|string|min:2|max:255',
            'user.email' => 'required|string|email|unique:App\Models\User,email',
            'user.password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
            'user.phone' => 'required|string|unique:App\Models\User,phone|min:10|max:15',
            'user.whatsapp' => 'required|boolean',
            'user.id_picture_front' => 'required|file|mimes:jpg,jpeg,svg,png,pdf',
            'user.id_picture_back' => 'required|file|mimes:jpg,jpeg,svg,png,pdf',
            'user.passport' => 'file|mimes:jpg,jpeg,svg,png,pdf'
        ], [
            'user.first_name.required' => 'Prénom requis',
            'user.last_name.required' => 'Nom de famille requis',
            'user.password.required' => 'Mot de passe requisrequis',
            'user.phone.required' => 'Numero de téléphone requis',
            'user.whatsapp.required' => 'Whatsapp requis',
            'user.id_picture_front.required' => 'Avant de la pièce d\'identité requis',
            'user.id_picture_back.required' => 'Arrière de la pièce d\'identité requis',
            'user.*.mimes' => ':file doit être une image ou un pdf'
        ]);

        if(!$validator->fails()) {
            $newUser->first_name = UserController::mysql_escape_mimic($request->user['first_name']);
            $newUser->last_name = UserController::mysql_escape_mimic($request->user['last_name']);
            $newUser->email = UserController::mysql_escape_mimic($request->user['email']);
            $newUser->password = bcrypt($request->user['password']);
            $newUser->phone = UserController::mysql_escape_mimic($request->user['phone']);
            $newUser->whatsapp = UserController::mysql_escape_mimic($request->user['whatsapp']);
            $newUser->admin_key = bcrypt($request->user['admin_key']) ?? null;
            $newUser->id_picture_front = $request->file('id_picture_front');
            $newUser->id_picture_back = $request->file('id_picture_back');
            $newUser->passport = $request->file('passport');
            $newUser->save();

            return response()->json(['data' => '', 'message' => 'Utilisateur crée avec success'], 201);
        } else {
            return response()->json(['data' => '', 'message' => $validator->errors()], 400);
        }

        // Send an email to ask the user to validate their email

        
    }

    public function check(Request $request)
    {
        $user = User::where('email','=', $request->user['email'])->first();

        if($user && $user->verified) {
            // if($user->user_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            if($user->password === bcrypt($request->user['password'])) {
                $request->session()->put('user_id', $user->user_id);
                return response()->json(['status'=>'true','message'=>'Authentification Reussie']);
            } else{
                return response()->json(['status'=>'false','message'=>'Mot de Passe Incorrect']);
            }
        } else {
            return response()->json(['status'=>'false', 'message'=>'Email Incorrect']);
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

    public function validation($request, $id)
    {
        $newUser = User::find($id);
        $admin = User::firstWhere('user_id', $request->session()->get('user_id'));

        if($newUser) {
            if($admin->admin_key === bcrypt(env('ADMIN_KEY'))) {
                $newUser->verified = true;
                $newUser->save();
                return response()->json(['message' => 'Utilisateur validé'], 200);
            } else {
                return response()->json(['message' => 'Action interdite'], 403);
            }
        } else {
            return response()->json(['message' => 'Cet utilisateur n\'existe pas'], 404);
        }
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
        $existingUser = User::find($id);

        if($existingUser) {
            // if($existingUser->user_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $validator = Validator::make($request->all(), [
                'user.first_name' => 'required|string|alphanum',
                'user.last_name' => 'required|string|min:2|max:255',
                'user.email' => 'required|string|email|unique:App\Models\User,email',
                'user.password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->numbers()
                        ->symbols(),
                    'confirmed'
                ],
                'user.phone' => 'required|string|unique:App\Models\User,phone|min:10|max:15',
                'user.whatsapp' => 'required|boolean',
            ], [
                'user.first_name.required' => 'Prénom requis',
                'user.last_name.required' => 'Nom de famille requis',
                'user.password.required' => 'Mot de passe requisrequis',
                'user.phone.required' => 'Numero de téléphone requis',
                'user.whatsapp.required' => 'Whatsapp requis',
            ]);

            if(!$validator->fails()) {
                $existingUser->first_name = UserController::mysql_escape_mimic($request->user['first_name']);
                $existingUser->last_name = UserController::mysql_escape_mimic($request->user['last_name']);
                $existingUser->email = UserController::mysql_escape_mimic($request->user['email']);
                $existingUser->password = bcrypt($request->user['password']);
                $existingUser->phone = UserController::mysql_escape_mimic($request->user['phone']);
                $existingUser->whatsapp = UserController::mysql_escape_mimic($request->user['whatsapp']);
                $existingUser->save();

                return response()->json(['data' => '', 'message' => 'Utilisateur modifié avec success'], 201);
            } else {
                return response()->json(['data' => '', 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette utilisateur n\'existe pas'], 404);
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
        $existingUser = User::find($id);
        $admin = User::firstWhere('user_id', session()->get('user_id'));

        if($existingUser) {
            if($admin && $admin->admin_key === bcrypt(env('ADMIN_KEY'))) {
                $existingAds = Ads::where('user_id', $existingUser->user_id)->delete();
                if(!empty($existingAds)) $existingAds->delete();
                $existingUserPackages = Packages::where('sender_id', $existingUser->user_id);
                if(!empty($existingUserPackages)) $existingUserPackages->delete();
                $existingUserDeliveries = Deliveries::where('courier_id', $existingUser->user_id);
                if(!empty($existingUserDeliveries)) $existingUserDeliveries->delete();
                $existingUserOrders = Orders::where('sender_id', $existingUser->user_id);
                if(!empty($existingUserOrders)) $existingUserOrders->delete();
                $existingUser->delete();
                return response()->json(['data' => '', 'message' => 'Utilisateur supprimé avec success'], 200);
            } else {
                return response()->json(['data' => '', 'message' => 'Action interdite'], 403);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette utilisateur n\'existe pas'], 404);
        }
    }
}
