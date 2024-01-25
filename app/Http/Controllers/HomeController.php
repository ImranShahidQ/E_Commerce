<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Reply;
use Illuminate\Support\Facades\Session;
use Stripe;

class HomeController extends Controller
{
    public function index()
    {
        $data = product::paginate(6);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::orderby('id','desc')->get();
        return view('home.userpage',compact('data','comment','reply'));
    }
    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        if($usertype=='1')
        {
            $total_product = product::all()->count();
            $total_order = order::all()->count();
            $total_user = user::all()->count();
            $order = order::all();
            $total_revenue = 0;
            foreach($order as $order)
            {
                $total_revenue = $total_revenue + $order->price;
            }
            $total_delivered = order::where('delivery_status','=','delivered')->get()->count();
            $total_processing = order::where('delivery_status','=','processing')->get()->count();
            $total_cancelled = order::where('delivery_status','=','cancelled')->get()->count();
            return view('admin.home',compact('total_product','total_order','total_user','total_revenue','total_delivered','total_processing','total_cancelled'));
        }
        else
        {
            $data = product::paginate(6);
            $comment = comment::orderby('id','desc')->get();
            $reply = reply::orderby('id','desc')->get();
            return view('home.userpage',compact('data','comment','reply'));
        }
    }
    public function product_details($id)
    {
        $product = product::find($id);
        return view('home.product_details',compact('product'));
    }
    public function add_cart(Request $request, $id)
    {
        if(Auth::id())
        {
            $user = Auth::user();
            $userid = $user->id;
            $product = product::find($id);
            $product_exist_id = cart::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();
            if($product_exist_id)
            {
                $cart = cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                if($product->discount_price!=null)
                {
                    $cart->price = $product->discount_price * $cart->quantity;
                }
                else
                {
                    $cart->price = $product->price * $cart->quantity;
                }
                $cart->save();
                Alert::success('Product Added Successfully','We Have Added Product To The Cart');
                return redirect()->back()->with('message','Product Added To The Cart Successfully');
            }
            else
            {
            $cart = new cart;
            $cart->user_id = $user->id;
            $cart->name = $user->name;
            $cart->email = $user->email;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->title = $product->title;
            $cart->quantity = $request->quantity;
            if($product->discount_price!=null)
            {
                $cart->price = $product->discount_price * $request->quantity;
            }
            else
            {
                $cart->price = $product->price * $request->quantity;
            }
            $cart->image = $product->image;
            $cart->product_id = $product->id;
            $cart->save();
            Alert::success('Product Added Successfully','We Have Added Product To The Cart');
            return redirect()->back()->with('message','Product Added To The Cart Successfully');
            }
        }
        else{
            return redirect('login');
        }
    }
    public function show_cart()
    {
        if(Auth::id())
        {
            $id = Auth::user()->id;
            $cart = cart::where('user_id','=',$id)->get();
            return view('home.show_cart',compact('cart'));
        }
        else{
            return redirect('login');
        }
    }
    public function remove_cart($id)
    {
        $cart = cart::find($id);
        $cart->delete();
        return redirect()->back();
    }
    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;
        $data = cart::where('user_id','=',$userid)->get();
        foreach($data as $data)
        {
            $order = new order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->title = $data->title;
            $order->quantity = $data->quantity;
            $order->price = $data->price;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';
            $order->save();
            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }
        return redirect()->back()->with('message','We Have Received Your Order.We Will Contact With You Soon...');
    }
    public function stripe($totalprice)
    {
        return view('home.stripe',compact('totalprice'));
    }
    public function stripePost(Request $request, $totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment." 
        ]);

        $user = Auth::user();
        $userid = $user->id;
        $data = cart::where('user_id','=',$userid)->get();
        foreach($data as $data)
        {
            $order = new order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->title = $data->title;
            $order->quantity = $data->quantity;
            $order->price = $data->price;
            $order->image = $data->image;
            $order->product_id = $data->product_id;
            $order->payment_status = 'paid';
            $order->delivery_status = 'processing';
            $order->save();
            $cart_id = $data->id;
            $cart = cart::find($cart_id);
            $cart->delete();
        }
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }
    public function order()
    {
        if(Auth::id())
        {
            $id = Auth::user()->id;
            $order = order::where('user_id','=',$id)->get();
            return view('home.order',compact('order'));
        }
        else{
            return redirect('login');
        }
    }
    public function cancel_order($id)
    {
        $order = order::find($id);
        $order->delivery_status = 'cancelled';
        $order->save();
        return redirect()->back()->with('message','You Cancel This Order Successfully');
    }
    public function add_comment(Request $request)
    {
        if(Auth::id())
        {
            $comment = new comment;
            $comment->name = Auth::user()->name;
            $comment->user_id = Auth::user()->id;
            $comment->comment = $request->comment;
            $comment->save();
            return redirect()->back();
        }
        else{
            return redirect('login');
        }
    }
    public function add_reply(Request $request)
    {
        if(Auth::id())
        {
            $reply = new reply;
            $reply->name = Auth::user()->name;
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->commentId;
            $reply->reply = $request->reply;
            $reply->save();
            return redirect()->back();
        }
        else{
            return redirect('login');
        }
    }
    public function product_search(Request $request)
    {
        $search = $request->search;
        $data = product::where('description','LIKE',"%$search%")
        ->orWhere('category','LIKE',"%$search%")
        ->orWhere('price','LIKE',"%$search%")
        ->orWhere('title','LIKE',"%$search%")
        ->orWhere('quantity','LIKE',"%$search%")
        ->orWhere('discount_price','LIKE',"%$search%")
        ->paginate(6);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::orderby('id','desc')->get();
        return view('home.userpage',compact('data','comment','reply'));
    }
    public function products()
    {
        $data = product::paginate(6);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::orderby('id','desc')->get();
        return view('home.all_product',compact('data','comment','reply'));
    }
    public function product_search____(Request $request)
    {
        $search = $request->search;
        $data = product::where('description','LIKE',"%$search%")
        ->orWhere('category','LIKE',"%$search%")
        ->orWhere('price','LIKE',"%$search%")
        ->orWhere('title','LIKE',"%$search%")
        ->orWhere('quantity','LIKE',"%$search%")
        ->orWhere('discount_price','LIKE',"%$search%")
        ->paginate(6);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::orderby('id','desc')->get();
        return view('home.all_product',compact('data','comment','reply'));
    }
}
