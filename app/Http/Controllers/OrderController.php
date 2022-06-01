<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Ramsey\Uuid\Rfc4122\UuidV4;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = User::firstWhere('user_id', session()->get('user_id'));
        if($admin && $admin->admin_key === bcrypt(env('ADMIN_KEY'))) {
            $orders = Orders::all();
        return response()->json($orders , 200);
        } else {
            return response()->json('Accès interdit' , 403);
        }
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
        // $user = User::firstWhere('user_id', $request->session()->get('user_id'));

        // if(!$user) {
        //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
        // }

        $newOrder = new Orders();
        $newOrder->order_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'delivery.sender_id' => 'required|uuid',
            'delivery.package_id' => 'required|uuid',
            'delivery.status' => 'required|string|alpha|in:acceptée,rejetée'
        ], [
            'delivery.sender_id.required' => 'Sender ID requis',
            'delivery.package_id.required' => 'Package ID requis',
            'delivery.status.required' => 'Status de la livraison requis',
            'delivery.status.in' => 'Cette livraison doit être acceptée ou rejetée'
        ]);

        if(!$validator->fails()) {
            // $sender = User::firstWhere('user_id', $request->delivery['sender_id']);
            $sender = User::first();
            // $courier = User::firstWhere('user_id', $request->session()->get('user_id'));
            $courier = User::first();

            // $newOrder->sender_email = OrderController::mysql_escape_mimic($sender->email);
            // $newOrder->courier_email = OrderController::mysql_escape_mimic($courier->email);
            $newOrder->sender_email = 'cmguinan@yahoo.fr';
            $newOrder->courier_email = 'lasourcebeats@gmail.com';
            // $newOrder->package_id = $request->delivery['package_id'];
            $newOrder->package_id = UuidV4::uuid4();
            $newOrder->status = $request->delivery['status'];
            // $newOrder->sender_id = OrderController::mysql_escape_mimic($sender->user_id);
            // $newOrder->courier_id = OrderController::mysql_escape_mimic($courier->user_id);
            $newOrder->sender_id = UuidV4::uuid4();
            $newOrder->courier_id = UuidV4::uuid4();
            $newOrder->save();

            return response()->json(['data' => $newOrder, 'message' => ''], 201);
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
        $existingOrder = Orders::find($id);

        if ($existingOrder) {
            // if($existingOrder->courier_id !== $request->session()->get('user_id')) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
            // }

            $validator = Validator::make($request->all(), [
                'order.status' => 'required|string|alpha|in:annulée,livrée,non-livrée'
            ], [
                'order.status.required' => 'Nouveau status requis',
                'order.status.in' => 'Cette commande doit être confirmée comme livrée ou non-livrée'
            ]);

            if(!$validator->fails()) {
                $existingOrder->status = OrderController::mysql_escape_mimic($request->order['status']);
                $existingOrder->save();

                if($existingOrder->status === 'livrée') {
                    // Release payment to the courier


                } elseif($existingOrder->status === 'non-livrée') {
                    // ???


                } else {
                    // Send an email to the sender
                    // to confirm cancellation and refund


                    // Refund sender

                }

                return response()->json(['data' => $existingOrder, 'message' => ''], 200);
            } else {
                return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
            }
        } else {
            return response()->json(['data' => '', 'message' => 'Cette commande n\'existe pas'], 404);
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
        $existingOrder = Orders::find($id);

            if($existingOrder) {
                if($existingOrder->courier_id !== session()->get('user_id')) {
                return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);
                }
                $existingOrder ->delete();

                return response()->json(['data' => '', 'message' => 'Commande annulée'], 200);
            } else {
                return response()->json(['data' => '', 'message' => 'Cette commande n\'existe pas'], 404);
            }
    }
}
