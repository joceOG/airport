<?php

namespace App\Http\Controllers;

use App\Models\Ads;
use App\Models\Deliveries;
use App\Models\Orders;
use App\Models\Packages;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        // $admin = User::firstWhere('user_id', session()->get('user_id'));
        // if($admin && $admin->admin_key === bcrypt(config('app.admin_key'))) {
        //     $users = User::all() ;
        //     return response()->json($users , 200);
        // } else {
        //     return response()->json('Accès interdit' , 403);
        // }

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
            'first_name' => 'required|string|alpha_dash|min:2|max:255',
            'last_name' => 'required|string|alpha_dash|min:2|max:255',
            'email' => 'required|string|email|unique:App\Models\User,email',
            'password' => [
                'required',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
                'confirmed'
            ],
            'phone' => 'required|string|unique:App\Models\User,phone|min:10|max:15',
            'whatsapp' => 'boolean',
            'id_front' => 'required|file|mimes:jpg,jpeg,svg,png,pdf',
            'id_back' => 'required|file|mimes:jpg,jpeg,svg,png,pdf',
            'passport' => 'file|mimes:jpg,jpeg,svg,png,pdf'
        ], [
            'first_name.required' => 'Prénom requis',
            'last_name.required' => 'Nom de famille requis',
            'email.required' => 'Adresse email requise',
            'password.required' => 'Mot de passe requisrequis',
            'phone.required' => 'Numero de téléphone requis',
            'id_front.required' => 'Avant de la pièce d\'identité requis',
            'id_back.required' => 'Arrière de la pièce d\'identité requis',
            '*.mimes' => ':file doit être une image ou un pdf'
        ]);

        if(!$validator->fails()) {
            $newUser->first_name = UserController::mysql_escape_mimic($request->first_name);
            $newUser->last_name = UserController::mysql_escape_mimic($request->last_name);
            $newUser->email = UserController::mysql_escape_mimic($request->email);
            $newUser->password = bcrypt($request->password);
            $newUser->phone = UserController::mysql_escape_mimic($request->phone);
            $newUser->whatsapp = boolval($request->whatsapp) ?? true;
            $admin_key = $request->admin_key ?? null;
            $newUser->admin_key = $admin_key !== null ? bcrypt($admin_key) : '';

            $directory = Storage::makeDirectory('users/' . $newUser->first_name . '_' . $newUser->last_name . '_' . $newUser->user_id);

            if($directory) {
                $newUser->dir = 'users/' . $newUser->first_name . '_' . $newUser->last_name . '_' . $newUser->user_id;

                $id_front = $request->file('id_front');
                $id_front_extension = $id_front->extension();
                $id_front_filename = gmdate('Y-m-d', time()) . '_' . $newUser->user_id . '_id_front.' . $id_front_extension;
                $id_front_path = $id_front->storeAs($newUser->dir, $id_front_filename);
                $newUser->id_front = $id_front_path;

                $id_back = $request->file('id_back');
                $id_back_extension = $id_back->extension();
                $id_back_filename = gmdate('Y-m-d', time()) . '_' . $newUser->user_id . '_id_back.' . $id_back_extension;
                $id_back_path = $id_back->storeAs($newUser->dir, $id_back_filename);
                $newUser->id_back = $id_back_path;

                $passport = $request->file('passport');
                if($passport) {
                    $passport_extension = $passport->extension();
                    $passport_filename = time() . '_' . $newUser->user_id . '_passport.' . $passport_extension;
                    $passport_path = $passport->storeAs($newUser->dir, $passport_filename);
                    $newUser->passport = $passport_path;
                }
                $newUser->save();
            } else {
                return response()->json(['data' => '', 'message' => 'Failed to create directory'], 400);
            }
            return response()->json(['data' => '', 'message' => 'Utilisateur crée avec success'], 201);
        } else {
            return response()->json(['data' => '', 'message' => $validator->errors()], 400);
        }

        // Send an email to ask the user to validate their email


    }

    public function login(Request $request)
    {
        $user = User::firstWhere('email', $request->user['email']);

        if($user && $user->verified) {
            if($user->password === bcrypt($request->user['password'])) {
                $request->session()->regenerate();
                $request->session()->put('user_id', $user->user_id);
                return response()->json(['status'=>'true','message'=>'Authentification Reussie']);
            } else{
                return response()->json(['status'=>'false','message'=>'Mot de Passe Incorrect']);
            }
        } else {
            return response()->json(['status'=>'false', 'message'=>'Email Incorrect']);
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return response()->json(['message' => 'Successfully logged out'], 200);
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
            if($admin->admin_key === bcrypt(config('app.admin_key'))) {
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
                'user.first_name' => 'required|string|alpha_dash|min:2|max:255',
                'user.last_name' => 'required|string|alpha_dash|min:2|max:255',
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
        // $admin = User::firstWhere('user_id', session()->get('user_id'));

        if($existingUser) {
            // if($admin && $admin->admin_key === bcrypt(config('app.admin_key'))) {
            //     Ads::where('user_id', $existingUser->user_id)->delete();
            //     Packages::where('sender_id', $existingUser->user_id)->delete();
            //     // Deliveries::where('courier_id', $existingUser->user_id)->delete();;
            //     // Orders::where('sender_id', $existingUser->user_id)->delete();
            //     $existingUser->delete();

            //     return response()->json(['data' => '', 'message' => 'Utilisateur supprimé avec success'], 200);
            // } else {
            //     return response()->json(['data' => '', 'message' => 'Action interdite'], 403);
            // }
            return response()->json(['data' => '', 'message' => 'Utilisateur supprimé avec success'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cette utilisateur n\'existe pas'], 404);
        }
    }
}
