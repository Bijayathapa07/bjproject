<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\cart;
use App\Models\order;

class PagesController extends Controller
{
    public function include()
    {
        if(!auth()->user())
        {
            $itemsincart = 0;
        }
        else
        {
            $itemsincart = Cart::where('user_id',auth()->user()->id)->where('is_ordered',false)->count();
        }
    }


    public function home()
    {
       $itemsincart= $this->include();
    
        $categories = Category::orderBy('priority')->get();

        
        //$products = Product::where('category_id', $product->category_id)::paginate(4);
        return view('welcome',compact('categories','itemsincart'));
        
    }

    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        $itemsincart= $this->include();
    
        $categories = Category::orderBy('priority')->get();

        
        //$products = Product::where('category_id', $product->category_id)::paginate(4);
        return view('contact',compact('categories','itemsincart'));
        
    }

    public function viewproduct(Product $product)
    {
        //$product = Product::find($id);
        $itemsincart= $this->include();
        $categories= Category::orderBy('priority')->get();
        $relatedproducts = Product::where('category_id',$product->category_id)->whereNot('id',$product->id)->get();
        return view('viewproduct', compact('product','categories','itemsincart'));
    }

   


    public function userlogin()
    {   
        $itemsincart= $this->include();
        $categories = Category::orderBy('priority')->get();
        return view('userlogin',compact('categories','itemsincart'));
    }

    public function categoryproduct($id)
    {
        $category = Category::find($id);
        $itemsincart = $this->include();
        $products = Product::where('category_id',$id)->paginate(2);
        $categories = Category::orderBy('priority')->get();
        return view('categoryproduct',compact('products','categories','itemsincart','category'));
    }


    public function orders()
    {
        $categories = Category::orderBy('priority')->get();
        $itemsincart = $this->include();
        $orders = order::where('user_id',auth()->user()->id)->get();
        foreach($orders as $order)
        {
            $cartids = explode(',',$order->cart_id);
            $carts = [];
            foreach($cartids as $cartid)
            {
                $cart = Cart::find($cartid);
                array_push($carts,$cart);
            }
            $order->carts = $carts;
        }

        return view('orderlist',compact('orders','categories','itemsincart'));
    }

}
