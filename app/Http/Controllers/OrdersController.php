<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Models\User;
use App\Models\order_details;
use App\Models\Menu;
use App\Http\Requests\StoreordersRequest;
use App\Http\Requests\UpdateordersRequest;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Orders::all();
        return $order;
    }

    public function getOrderDetails($user_id){
        $order = Orders::where('user_id', $user_id)->get();
        //user 
        foreach ($order as $o){        
            $o->user = User::find($user_id);
            $o->order_details = order_details::where('order_id', $o->id)->get();
            //menu
            foreach ($o->order_details as $order_detail){
                $menu = Menu::find($order_detail->menu_id);
                $order_detail->menu_name = $menu->name;
                $order_detail->menu_price = $menu->price;
            }
        }
        return $order;
    }		
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreordersRequest $request)
    {
        $order = new Orders;
        $order->user_id = $request->user_id;
        $order->order_type = $request->order_type;
        $order->order_status = $request->order_status;
        $order->order_total = $request->order_total;
        $order->save();

         //insert order details
         foreach ($request->order_details as $menu_item){

            $order_details = new order_details;
            $order_details->order_id = $order->id;
            $order_details->menu_id = $menu_item['id'];
            $order_details->quantity = $menu_item['quantity'];
            $order_details->save();
        }   
        return $order;
    }

    /**
     * Display the specified resource.
     */
    public function show(orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateordersRequest $request, orders $orders)
    {
        $order = Orders::find($request->id);

        $order->user_id = $request->user_id;
        $order->order_type = $request->order_type;
        $order->order_status = $request->order_status;
        $order->order_total = $request->order_total;
        
        $order->save();
        return $order;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(orders $order)
    {
        //
    }
}
