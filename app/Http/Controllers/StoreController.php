<?php

namespace App\Http\Controllers;

use App\Pet;
use App\Order;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function storeOrder(Request $request)
    {
        $pet = Pet::findOrFail($request->petId);
        if ($pet->status != 'available') {
            return response('Invalid Order', 400);
        }
        
        $order = Order::create($request->except('id'));
        $pet->status = 'pending';
        $pet->save();
        return response('Successfully placed an order!', 200);
    }
    
    public function getOrderById($id)
    {
        $order = Order::findOrFail($id);
        return response($order, 200);
    }
    
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        if (strtotimem($order->shipDate) > strtotime('now')) {
            $pet = Pet::findOrFail($order->petId);
            $pet->status = 'available';
            $pet->save();
            $order->delete();
        }

        return response('Successfully deleted an order', 200);
    }
}
