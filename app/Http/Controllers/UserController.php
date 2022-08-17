<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Mail\AccountCreated;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Mail;
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
        // $admin = User::where('user_id', session()->get('user_id'))->first();
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
        echo $request;
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
            'id_front' => 'file|mimes:jpg,jpeg,svg,png,pdf',
            'id_back' => 'file|mimes:jpg,jpeg,svg,png,pdf',
            'passport' => 'file|mimes:jpg,jpeg,svg,png,pdf',
            'terms' => 'required|boolean'
        ], [
            'first_name.required' => 'Prénom requis',
            'last_name.required' => 'Nom de famille requis',
            'email.required' => 'Adresse email requise',
            'password.required' => 'Mot de passe requis',
            'phone.required' => 'Numero de téléphone requis',
            'id_front.required' => 'Avant de la pièce d\'identité requis',
            'id_back.required' => 'Arrière de la pièce d\'identité requis',
            '*.mimes' => ':file doit être une image ou un pdf',
            'terms.required' => 'Signature des conditions d\'utilisation obligatoire. '
        ]);

        if(!$validator->fails()) {
            $newUser->first_name = UserController::mysql_escape_mimic($request->first_name);
            $newUser->last_name = UserController::mysql_escape_mimic($request->last_name);
            $newUser->email = UserController::mysql_escape_mimic($request->email);
            $newUser->password = bcrypt($request->password);
            $newUser->phone = UserController::mysql_escape_mimic($request->phone);
            if($request->whatsapp)
                $newUser->whatsapp = boolval($request->whatsapp);
            if($request->admin_key)
                $newUser->admin_key = bcrypt($$request->admin_key);
            $newUser->terms = boolval($request->whatsapp);

            $directory = Storage::makeDirectory('users/' . $newUser->first_name . '_' . $newUser->last_name . '_' . $newUser->user_id);

            if($directory) {
                $newUser->dir = 'users/' . $newUser->first_name . '_' . $newUser->last_name . '_' . $newUser->user_id;

                $id_front = $request->file('id_front');
                if($id_front) {
                    $id_front_extension = $id_front->extension();
                    $id_front_filename = gmdate('Y-m-d', time()) . '_' . $newUser->user_id . '_id_front.' . $id_front_extension;
                    $id_front_path = $id_front->storeAs($newUser->dir, $id_front_filename);
                    $newUser->id_front = $id_front_path;
                }

                $id_back = $request->file('id_back');
                if($id_back) {
                    $id_back_extension = $id_back->extension();
                    $id_back_filename = gmdate('Y-m-d', time()) . '_' . $newUser->user_id . '_id_back.' . $id_back_extension;
                    $id_back_path = $id_back->storeAs($newUser->dir, $id_back_filename);
                    $newUser->id_back = $id_back_path;
                }

                $passport = $request->file('passport');
                if($passport) {
                    $passport_extension = $passport->extension();
                    $passport_filename = time() . '_' . $newUser->user_id . '_passport.' . $passport_extension;
                    $passport_path = $passport->storeAs($newUser->dir, $passport_filename);
                    $newUser->passport = $passport_path;
                }
                $newUser->save();

                // Send an email to ask the user to validate their email
                // Mail::to($newUser->email)->send(new AccountCreated($newUser));
            } else {
                return response()->json(['data' => '', 'message' => 'Failed to create directory'], 400);
            }
            return response()->json(['data' => '', 'message' => 'Utilisateur crée avec success'], 201);
        } else {
            return response()->json(['data' => '', 'message' => $validator->errors()], 400);
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->user['email'])->first();

        if($user && boolval($user->terms)) {
            if($user->password === bcrypt($request->user['password'])) {
                $request->session()->regenerate();
                $request->session()->put('user_id', $user->user_id);
                $request->session()->put('id', $user->id);
                return response()->json(['status'=>'true','message'=>'Authentification reussie'], 200);
            } else{
                return response()->json(['status'=>'false','message'=>'Email ou mot de passe incorrect'], 401);
            }
        } else {
            return response()->json(['status'=>'false', 'message'=>'Email ou mot de passe incorrect ou termes d\'utilisation manquant.'], 400);
        }
    }

    public function logout(Request $request) {
        $request->session()->flush();
        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function resetPassword(Request $request, $id) {
        $existingUser = User::find($id);

        if($existingUser) {
            // if(!($existingUser->user_id === $request->session()->get('user_id'))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $validator = Validator::make($request->all(), [
                'password' => [
                    'required',
                    Password::min(8)
                        ->letters()
                        ->numbers()
                        ->symbols(),
                    'confirmed'
                ],
            ], [
                'password.required' => 'Mot de passe requis'
            ]);

            if(!$validator->fails()) {
                $existingUser->password = bcrypt($request->user['password']);
                $existingUser->save();

                return response()->json(['data' => '', 'message' => 'Mot de passe modifié avec success'], 200);
            } else {
                return response()->json(['data' => '', 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette utilisateur n\'existe pas'], 404);
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

    public function validation(UuidV4 $user_id)
    {
        $newUser = User::where('user_id', $user_id)->first();
        $newUser->email_verified_at = gmdate('Y-m-d', time());
        $newUser->save();
        return response()->json(['message' => 'Email validé'], 200);
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
                'first_name' => 'string|alpha_dash|min:2|max:255',
                'last_name' => 'string|alpha_dash|min:2|max:255',
                'phone' => 'string|unique:App\Models\User,phone|min:10|max:15',
                'whatsapp' => 'boolean',
                'id_front' => 'file|mimes:jpg,jpeg,svg,png,pdf',
                'id_back' => 'file|mimes:jpg,jpeg,svg,png,pdf',
                'passport' => 'file|mimes:jpg,jpeg,svg,png,pdf'
            ], [
                '*.mimes' => ':file doit être une image ou un pdf'
            ]);

            if(!$validator->fails()) {
                $existingUser->first_name = $request->first_name != '' ? UserController::mysql_escape_mimic($request->first_name) : $existingUser->first_name;
                $existingUser->last_name = $request->last_name != '' ? UserController::mysql_escape_mimic($request->last_name) : $existingUser->last_name;
                $existingUser->email = $request->email != '' ? UserController::mysql_escape_mimic($request->email) : $existingUser->email;
                $existingUser->phone = $request->phone != '' ? UserController::mysql_escape_mimic($request->phone) : $existingUser->phone;
                $existingUser->whatsapp = $request->firstwhatsapp_name != '' ? boolval($request->whatsapp) : $existingUser->whatsapp;

                $id_front = $request->file('id_front');
                if($id_front) {
                    $id_front_extension = $id_front->extension();
                    $id_front_filename = gmdate('Y-m-d', time()) . '_' . $existingUser->user_id . '_id_front.' . $id_front_extension;
                    $id_front_path = $id_front->storeAs($existingUser->dir, $id_front_filename);
                    $existingUser->id_front = $id_front_path;
                }

                $id_back = $request->file('id_back');
                if($id_back) {
                    $id_back_extension = $id_back->extension();
                    $id_back_filename = gmdate('Y-m-d', time()) . '_' . $existingUser->user_id . '_id_back.' . $id_back_extension;
                    $id_back_path = $id_back->storeAs($existingUser->dir, $id_back_filename);
                    $existingUser->id_back = $id_back_path;
                }

                $passport = $request->file('passport');
                if($passport) {
                    $passport_extension = $passport->extension();
                    $passport_filename = time() . '_' . $existingUser->user_id . '_passport.' . $passport_extension;
                    $passport_path = $passport->storeAs($existingUser->dir, $passport_filename);
                    $existingUser->passport = $passport_path;
                }

                if($id_front && $id_back && $existingUser->email_verified_at)
                    $existingUser->verified = true;

                $existingUser->save();

                return response()->json(['data' => '', 'message' => 'Utilisateur modifié avec success'], 200);
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
        // $admin = User::where('user_id', session()->get('user_id'))->first();

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
