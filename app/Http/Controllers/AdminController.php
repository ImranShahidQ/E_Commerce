<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Notifications\SendEmailNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{
    public function view_category()
    {
        if(Auth::id())
        {
        $data = category::all();
        return view('admin.category',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function add_category(Request $request)
    {
        if(Auth::id())
        {
        $data = new category;
        $data->category_name = $request->category_name;
        $data->save();
        return redirect()->back()->with('message','Category Added Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function delete_category($id)
    {
        if(Auth::id())
        {
        $data = category::find($id);
        $data->delete();
        return redirect()->back()->with('message','Category Deleted Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function view_product()
    {
        if(Auth::id())
        {
        $data = category::all();
        return view('admin.product',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function add_product(Request $request)
    {
        if(Auth::id())
        {
        $data = new product;
        $data->title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->discount_price = $request->discount_price;
        $data->quantity = $request->quantity;
        $data->category = $request->category;
        $image = $request->image;
        $imagename = time().'.'.$image->getClientOriginalExtension();
        $request->image->move('product',$imagename);
        $data->image = $imagename;
        $data->save();
        return redirect()->back()->with('message','Product Added Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function show_product()
    {
        if(Auth::id())
        {
        $data = product::all();
        return view('admin.all_product',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function edit_product($id)
    {
        if(Auth::id())
        {
        $product = product::find($id);
        $data = category::all();
        return view('admin.edit_product',compact('product','data'));
        }
        else{
            return redirect('login');
        }
    }
    public function update_product(Request $request, $id)
    {
        if(Auth::id())
        {
        $product = product::find($id);
        $product->title = $request->title;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->discount_price = $request->discount_price;
        $product->quantity = $request->quantity;
        $product->category = $request->category;
        $image = $request->image;
        if($image)
        {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $product->image = $imagename;
        }
        $product->save();
        return redirect()->back()->with('message','Product Updated Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function delete_product($id)
    {
        if(Auth::id())
        {
        $data = product::find($id);
        $data->delete();
        return redirect()->back()->with('message','Product Deleted Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function view_order()
    {
        if(Auth::id())
        {
        $data = order::all();
        return view('admin.order',compact('data'));
        }
        else{
            return redirect('login');
        }
        
    }
    public function delivered($id)
    {
        if(Auth::id())
        {
        $data = order::find($id);
        $data->delivery_status = "delivered";
        $data->payment_status = "paid";
        $data->save();
        return redirect()->back()->with('message','Delivery Status Updated Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function print_pdf($id)
    {
        if(Auth::id())
        {
        $data = order::find($id);
        $pdf = PDF::loadView('admin.pdf',compact('data'));
        return $pdf->download('order_details.pdf');
        }
        else{
            return redirect('login');
        }
    }
    public function send_email($id)
    {
        if(Auth::id())
        {
        $data = order::find($id);
        return view('admin.send_email',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
    public function send_user_email(Request $request, $id)
    {
        if(Auth::id())
        {
        $data = order::find($id);
        $details = [
            'greeting' => $request->greeting,
            'subject' => $request->subject,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'footer' => $request->footer,
        ];
        Notification::send($data,new SendEmailNotification($details));
        return redirect()->back()->with('message','Email Sent Successfully.');
        }
        else{
            return redirect('login');
        }
    }
    public function search(Request $request)
    {
        if(Auth::id())
        {
        $search = $request->search;
        $data = order::where('name','LIKE',"%$search%")
        ->orWhere('email','LIKE',"%$search%")
        ->orWhere('phone','LIKE',"%$search%")
        ->orWhere('address','LIKE',"%$search%")
        ->orWhere('title','LIKE',"%$search%")
        ->orWhere('quantity','LIKE',"%$search%")
        ->orWhere('price','LIKE',"%$search%")
        ->get();
        return view('admin.order',compact('data'));
        }
        else{
            return redirect('login');
        }
    }
}
