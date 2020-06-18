<?php

namespace App\Http\Controllers\Api\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request){
        $status = 200;
        $json = [];

        try{
            $status = 200;
            $orders = \App\Model\Order::get();
            $json['data'] = ['orders'=>$orders];
            return response()->json($json)->setStatusCode($status);
        }catch(\Exception $e){
            $status = 500;
            $json['error'] = trans('api.internal_server_error');
        }
        return response()->json($json)->setStatusCode($status);
    }
    public function PlaceOrder(Request $request){
        $status = 200;
        $json = [];

        try{
            $validator = \Validator::make($request->all(), [
                'product_id'=> 'required|exists:products,id',
                'quantity'=> 'required|integer|between:1,5'
            ],[
               'product_id.*'=>'Product ID is required',
               'quantity.*'=>'Product Quantity is required',
              ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages){
                    $errors[$field_name] = $messages['0'];
                }
                $status = 422;
                $json['errors'] = $errors;
                return response()->json($json)->setStatusCode($status);
            }else{
                // Begin Transaction
                \DB::beginTransaction();
                $status = 200;
                $user_id = $request->user()->id;
                $total = 0;
                $product_info =  \App\Model\Product::find($request->product_id);
                $quantity = $request->quantity;
                $total = $product_info->price*$quantity;
                $Order = new \App\Model\Order();
                $Order->user_id = $user_id;
                $Order->order_status_id = 1;
                $Order->total = $total;
                $Order->save();

                $OrderProduct = new \App\Model\OrderProduct();
                $OrderProduct->product_id = $product_info->id;
                $OrderProduct->name = $product_info->name;
                $OrderProduct->quantity = $quantity;
                $OrderProduct->price = $product_info->price;
                $OrderProduct->total = $total;
                $Order->OrderProduct()->save($OrderProduct);
                // Commit Transaction
                \DB::commit();
                // Fire an event
                event(new \App\Events\PlaceOrder($request));
                $json['data'] = ['status'=>true,'msg'=>'OrderPlaced'];
                return response()->json($json)->setStatusCode($status);

            }
        }catch(\Exception $e){
            // Rollback Transaction
            \DB::rollback();
            $status = 500;
            $json['error'] = trans('api.internal_server_error');
        }
        return response()->json($json)->setStatusCode($status);
    }

    public function CancelOrder(Request $request){
        $status = 200;
        $json = [];

        try{
            $validator = \Validator::make($request->all(), [
                'order_id'=> 'required|exists:orders,id',
            ],[
               'order_id.*'=>'Order ID is required',
              ]);
            if ($validator->fails()) {
                foreach ($validator->messages()->getMessages() as $field_name => $messages){
                    $errors[$field_name] = $messages['0'];
                }
                $status = 422;
                $json['errors'] = $errors;
                return response()->json($json)->setStatusCode($status);
            }else{
                $orderID = $request->order_id;
                // Begin Transaction
                \DB::beginTransaction();
                $status = 200;
               
                $Order = \App\Model\Order::find($orderID);
                $Order->order_status_id = 3;
                $Order->save();
                // Commit Transaction
                \DB::commit();
                // Fire an event
                event(new \App\Events\CancelOrder($request));
                $json['data'] = ['status'=>true,'msg'=>'CancelOrder'];
                return response()->json($json)->setStatusCode($status);

            }
        }catch(\Exception $e){
            // Rollback Transaction
            \DB::rollback();
            $status = 500;
            $json['error'] = trans('api.internal_server_error');
        }
        return response()->json($json)->setStatusCode($status);
    }
}
