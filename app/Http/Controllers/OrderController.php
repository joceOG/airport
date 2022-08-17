<?php

namespace App\Http\Controllers;

use App\Mail\DeliveryConfirmation;
use App\Models\Deliveries;
use Illuminate\Support\Facades\Validator;
use App\Models\Orders;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Packages;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $admin = User::where('user_id', session()->get('user_id'))->first();
        // if($admin && $admin->admin_key === bcrypt(env('ADMIN_KEY'))) {
        //     $orders = Orders::all();
        //     return response()->json($orders , 200);
        // } else {
        //     return response()->json('Accès interdit' , 403);
        // }
        $orders = Orders::all();
        return response()->json($orders , 200);
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

        // $newOrder = new Orders();
        // $newOrder->order_id = UuidV4::uuid4();

        // $validator = Validator::make($request->all(), [
        //     'order.sender_id' => 'required|uuid',
        //     'order.package_id' => 'required|uuid',
        //     'order.delivery_id' => 'required|uuid',
        //     'order.status' => 'required|string|in:pending,acceptée,rejetée'
        // ], [
        //     'order.sender_id.required' => 'Sender ID requis',
        //     'order.package_id.required' => 'Package ID requis',
        //     'order.delivery_id.required' => 'Delivery ID requis',
        //     'order.status.required' => 'Status de la livraison requis',
        //     'order.status.in' => 'Cette livraison doit être pending, acceptée ou rejetée'
        // ]);

        // if(!$validator->fails()) {
        //     // $sender = User::firstWhere('user_id', $request->delivery['sender_id']);
        //     // $courier = User::firstWhere('user_id', $request->session()->get('user_id'));
        //     // $newOrder->sender_email = OrderController::mysql_escape_mimic($sender->email);
        //     // $newOrder->courier_email = OrderController::mysql_escape_mimic($courier->email);
        //     $newOrder->sender_email = OrderController::mysql_escape_mimic($request->order['sender_email']);
        //     $newOrder->courier_email = OrderController::mysql_escape_mimic($request->order['courier_email']);
        //     // $newOrder->sender_phone = OrderController::mysql_escape_mimic($sender->phone);
        //     // $newOrder->courier_phone = OrderController::mysql_escape_mimic($courier->phone);
        //     $newOrder->sender_phone = OrderController::mysql_escape_mimic($request->order['sender_phone']);
        //     $newOrder->courier_phone = OrderController::mysql_escape_mimic($request->order['courier_phone']);
        //     // $newOrder->sender_whatsapp = $sender->whatsapp;
        //     // $newOrder->courier_whatsapp = $courier->whatsapp;
        //     $newOrder->sender_whatsapp = OrderController::mysql_escape_mimic($request->order['sender_whatsapp']);
        //     $newOrder->courier_whatsapp = OrderController::mysql_escape_mimic($request->order['courier_whatsapp']);
        //     $newOrder->ad_id = OrderController::mysql_escape_mimic($request->order['ad_id']);
        //     // $newOrder->package_id = $request->delivery['package_id'];
        //     $newOrder->package_id = OrderController::mysql_escape_mimic($request->order['package_id']);
        //     // $newOrder->delivery_id = $request->delivery['delivery_id'];
        //     $newOrder->delivery_id = OrderController::mysql_escape_mimic($request->order['delivery_id']);
        //     $newOrder->status = OrderController::mysql_escape_mimic($request->order['status']);
        //     // $newOrder->sender_id = OrderController::mysql_escape_mimic($sender->user_id);
        //     // $newOrder->courier_id = OrderController::mysql_escape_mimic($courier->user_id);
        //     $newOrder->sender_id = OrderController::mysql_escape_mimic($request->order['sender_id']);
        //     $newOrder->courier_id = OrderController::mysql_escape_mimic($request->order['courier_id']);
        //     $newOrder->save();

        //     return response()->json(['data' => $newOrder, 'message' => 'Commande crée'], 201);
        // } else {
        //     return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $user = User::where('user_id', $request->session()->get('user_id'))->first();

        if($user)
            $existingOrders = Orders::where('user_id', $user->user_id);
        else
            return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);

        if($existingOrders)
            return response()->json(['data' => $existingOrders, 'message' => 'Annonce trouvées'], 200);
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
        $existingOrder = Orders::find($id);

        if ($existingOrder) {
            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingOrder->sender_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            $validator = Validator::make($request->all(), [
                'order.status' => 'required|string|alpha|in:livrée,non-livrée'
            ], [
                'order.status.required' => 'Nouveau status requis',
                'order.status.in' => 'Cette commande doit être confirmée comme livrée ou non-livrée'
            ]);

            if(!$validator->fails()) {
                $existingOrder->status = OrderController::mysql_escape_mimic($request->order['status']);
                $existingOrder->save();

                $associatedPackage = Packages::where('package_id', $existingOrder->package_id)->first();

                Mail::to($existingOrder->courier_email)->send(new DeliveryConfirmation($existingOrder));

                $associatedDelivery = Deliveries::where('delivery_id', $existingOrder->delivery_id)->first();
                if($associatedDelivery && $existingOrder->status === 'livrée') {
                    // Release payment to the courier

                    $existingOrder->delete();
                    $associatedDelivery->status = 'payée';
                    $associatedDelivery->save();
                } elseif($existingOrder->status === 'non-livrée') {
                    // Refund sender??



                } else {
                    // Refund sender??


                    // $associatedPackage->delete();
                }
            }
        }
    }

    /*
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingOrder = Orders::find($id);

            if($existingOrder) {
                // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingOrder->courier_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            // $associatedDelivery = Deliveries::where('delivery_id', $existingOrder->delivery_id)->first();
            // if($associatedDelivery && ($associatedDelivery->status != 'livrée')) {
            //     return response()->json(['data' => '', 'message' => 'Cette commande ne peut pas être supprimée car elle est associé à une commande en cours'], 403);
            // }

                $existingOrder ->delete();

                return response()->json(['data' => '', 'message' => 'Commande annulée'], 200);
            } else {
                return response()->json(['data' => '', 'message' => 'Cette commande n\'existe pas'], 404);
            }
    }
}
