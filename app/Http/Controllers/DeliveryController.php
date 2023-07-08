<?php

namespace App\Http\Controllers;

use App\Mail\RequestSent;
use App\Mail\ResponseSent;
use Illuminate\Support\Facades\Validator;
use App\Models\Deliveries;
use App\Models\Packages;
use App\Models\User;
use App\Models\Ads;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        // $admin = User::where('user_id', session()->get('user_id'))->fist();
        // if($admin && $admin->admin_key === bcrypt(config('app.admin_key'))) {
        //     $deliveries = Deliveries::all();
        //     return response()->json($deliveries, 200);
        // } else {
        //     return response()->json('Accès interdit' , 403);
        // }
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
        // $user = User::where('user_id', $request->session()->get('user_id'))->first();

        // if(!($user && $user->verified)) {
        //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
        // }

        $newDelivery = new Deliveries();
        $newDelivery->delivery_id = UuidV4::uuid4();

        $validator = Validator::make($request->all(), [
            'delivery.ad_id' => 'required|uuid',
            'delivery.package_id' => 'required|uuid'
        ], [
            'delivery.ad_id' => 'Delivery Ad ID requis',
            'delivery.package_id' => 'Delivery Package ID requis'
        ]);

        if(!$validator->fails()) {
            // $sender = User::where('user_id', $request->session()->get('user_id'))->first();
            // $courier = User::where('user_id', $request->delivery['ad_user_id'])->first();
            // $newDelivery->sender_email = DeliveryController::mysql_escape_mimic($sender->email);
            // $newDelivery->courier_email = DeliveryController::mysql_escape_mimic($courier->email);
            $newDelivery->sender_email = DeliveryController::mysql_escape_mimic($request->delivery['sender_email']);
            $newDelivery->courier_email = DeliveryController::mysql_escape_mimic($request->delivery['courier_email']);
            // $newDelivery->sender_phone = DeliveryController::mysql_escape_mimic($sender->phone);
            // $newDelivery->courier_phone = DeliveryController::mysql_escape_mimic($courier->phone);
            $newDelivery->sender_phone = DeliveryController::mysql_escape_mimic($request->delivery['sender_phone']);
            $newDelivery->courier_phone = DeliveryController::mysql_escape_mimic($request->delivery['courier_phone']);
            // $newDelivery->sender_whatsapp = boolval($sender->whatsapp);
            // $newDelivery->courier_whatsapp = boolval($courier->whatsapp);
            $newDelivery->sender_whatsapp = boolval($request->delivery['sender_whatsapp']);
            $newDelivery->courier_whatsapp = boolval($request->delivery['courier_whatsapp']);
            // $newDelivery->package_id = $request->session()->get('package_id');
            $newDelivery->package_id = DeliveryController::mysql_escape_mimic($request->delivery['package_id']);
            // $newDelivery->ad_id = $request->delivery['ad_id'];
            $newDelivery->ad_id = DeliveryController::mysql_escape_mimic($request->delivery['ad_id']);
            $newDelivery->status = DeliveryController::mysql_escape_mimic($request->delivery['status']);
            // $newDelivery->status = 'en attente';
            // $newDelivery->sender_id = DeliveryController::mysql_escape_mimic($sender->user_id);
            // $newDelivery->courier_id = DeliveryController::mysql_escape_mimic($courier->user_id);
            $newDelivery->sender_id = DeliveryController::mysql_escape_mimic($request->delivery['sender_id']);
            $newDelivery->courier_id = DeliveryController::mysql_escape_mimic($request->delivery['courier_id']);

            // Email the courier about delivery request
            // $package = Packages::where('package_id', $newDelivery->package_id)->first();
            
            // if($package)
                // Mail::to($newDelivery->courier_email)->send(new RequestSent($package));
            // else
                // response()->json(['data' => '', 'message' => 'Cet envoi n\'existe pas']);

            $newDelivery->save();
            return response()->json(['data' => $newDelivery, 'message' => 'Nouvelle livraison crée'], 201);
        } else {
            return response()->json(['data' => $request->all(), 'message' => $validator->errors()], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $request->setLaravelSession(session());
        $user = User::where('user_id', $request->delivery['user_id'])->first();
         
        if($user)
            $existingDeliveries = Deliveries::where('sender_id', $user->user_id)->get();
        else
            return response()->json(['data' => '', 'message' => 'Accès interdit'], 401);


        if($existingDeliveries)
            return response()->json(['data' => $existingDeliveries, 'message' => 'Livraison(s) trouvée(s)'], 200);
        else
            return response()->json(['data' => '', 'message' => 'Aucune livraison trouvée'], 200);
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

        if($existingDelivery) {
            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingDelivery->sender_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            if($existingDelivery->space <= 0)
                return response()->json(['data' => '', 'message' => 'Vous n\'avez plus d\'espace disponible pour accepter cette nouvelle livraison'], 400);

            $validator = Validator::make($request->all(), [
                'delivery.status' => 'required|string|alpha|in:acceptée,rejetée,livrée'
            ], [
                'delivery.status.required' => 'Nouveau status requis',
                'delivery.status.in' => 'Cette livraison doit être acceptée, rejetée ou confirmée comme livrée'
            ]);

            if(!$validator->fails()) {
                $existingDelivery->status = !($existingDelivery->status == 'livrée' && $existingDelivery->status == 'payée' && $existingDelivery->status == 'acceptée') ? DeliveryController::mysql_escape_mimic($request->delivery['status']) : $existingDelivery->status;
                $existingDelivery->save();

                $associatedAd = Ads::where('ad_id', $existingDelivery->ad_id)->first();
                $associatedPackage = Packages::where('package_id', $existingDelivery->package_id)->first();
                $associatedOrder = Orders::where('delivery_id', $existingDelivery->delivery_id)->first();

                if($existingDelivery->status === 'acceptée') {
                    $associatedAd->space = $associatedAd->space > $associatedPackage->weight ? $associatedAd->space - $associatedPackage->weight : 0;
                    $associatedAd->save();

                    $newOrder = new Orders();
                    $newOrder->order_id = UuidV4::uuid4();
                    $newOrder->sender_email = OrderController::mysql_escape_mimic($existingDelivery->sender_email);
                    $newOrder->courier_email = OrderController::mysql_escape_mimic($existingDelivery->courier_email);
                    $newOrder->sender_phone = OrderController::mysql_escape_mimic($existingDelivery->sender_phone);
                    $newOrder->courier_phone = OrderController::mysql_escape_mimic($existingDelivery->courier_phone);
                    $newOrder->sender_whatsapp = boolval($existingDelivery->sender_whatsapp);
                    $newOrder->courier_whatsapp = boolval($existingDelivery->courier_whatsapp);
                    $newOrder->ad_id = OrderController::mysql_escape_mimic($existingDelivery['ad_id']);
                    $newOrder->package_id = OrderController::mysql_escape_mimic($existingDelivery['package_id']);
                    $newOrder->delivery_id = OrderController::mysql_escape_mimic($existingDelivery['delivery_id']);
                    $newOrder->status = OrderController::mysql_escape_mimic($existingDelivery['status']);
                    $newOrder->sender_id = OrderController::mysql_escape_mimic($existingDelivery['sender_id']);
                    $newOrder->courier_id = OrderController::mysql_escape_mimic($existingDelivery['courier_id']);
                    $newOrder->save();

                    // Charge the sender


                } elseif($associatedOrder && $existingDelivery->status === 'rejetée') {
                    // Send an email to the sender to notify them that their order was rejected
                    Mail::to($associatedOrder->sender_email)->send(new ResponseSent($associatedOrder));
                
                    $associatedPackage->delete();
                    // $existingDelivery->delete();

                } elseif ($associatedOrder && $existingDelivery->status === 'livrée') {
                    // Send an email to the sender to notify them that their order was delivered
                    // and ask them to confirm the delivery
                    Mail::to($associatedOrder->sender_email)->send(new ResponseSent($associatedOrder));
                } else {
                    // Send an email to the sender
                    // to confirm cancellation and refund
                    Mail::to($existingDelivery->sender_email)->send(new ResponseSent($associatedOrder));

                    // Refund sender??

                    // $associatedPackage->delete();
                    // $associatedOrder->delete();
                    // $existingDelivery->delete();
                }

                return response()->json(['data' => $existingDelivery, 'message' => 'Livraison modifiée'], 200);
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

        if($existingDelivery) {
            // $user = User::where('user_id', $request->session()->get('user_id'))->first();

            // if(!($user && ($existingDelivery->courier_id === $user->user_id))) {
            //     return response()->json(['data' => '', 'message' => 'Accès interdit'], 403);
            // }

            // $associatedOrder = Orders::where('delivery_id', $existingDelivery->delivery_id)->first();
            // if($associatedOrder && ($associatedOrder->status != 'livrée')) {
            //     return response()->json(['data' => '', 'message' => 'Cette livraison ne peut pas être supprimée car elle est associé à une commande en cours'], 403);
            // }

            $existingDelivery ->delete();

            return response()->json(['data' => '', 'message' => 'Livraison rejetée'], 200);
        } else {
            return response()->json(['data' => '', 'message' => 'Cette livraison n\'existe pas'], 404);
        }
    }
}
