<!DOCTYPE html>
<html lang="en">
  <head>
  @include('admin.css')
  <style>
    .div_center
    {
        text-align: center;
        padding-top: 20px;
    }
    .h2_font
    {
        font-size: 40px;
        padding-bottom: 20px;
    }
    .input_color
    {
        color: black;
    }
    .center
    {
        margin: auto;
        width: 100%;
        text-align: center;
        border: 3px solid blue;
    }
    .img_size
    {
        width: 70px;
        height: 60px;
    }
    .th_color
    {
        background: blue;
    }
    table,th,td
        {
            border: 1px solid white;
        }
  </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        @include('admin.navbar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
            @endif
            <div class="div_center">
                <h2 class="h2_font">ALL Orders</h2>
                <div style="padding-bottom: 20px; color:black;">
                    <form action="{{url('search')}}" method="GET">
                      @csrf
                        <input type="text" name="search" placeholder="Search For Something">
                        <input type="submit" value="Search" class="btn btn-primary">
                    </form>
                </div>
                <table class="center">
                    <tr class="th_color">
                        <th class="th_deg">Name</th>
                        <th class="th_deg">Email</th>
                        <th class="th_deg">Phone</th>
                        <th class="th_deg">Address</th>
                        <th class="th_deg">Title</th>
                        <th class="th_deg">Quantity</th>
                        <th class="th_deg">Price</th>
                        <th class="th_deg">Payment_status</th>
                        <th class="th_deg">Delivery_Status</th>
                        <th class="th_deg">Image</th>
                        <th class="th_deg">Action</th>
                        <th class="th_deg">Print Pdf</th>
                        <th class="th_deg">Send Email</th>
                    </tr>
                    @forelse($data as $data)
                    <tr>
                        <td>{{$data->name}}</td>
                        <td>{{$data->email}}</td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->address}}</td>
                        <td>{{$data->title}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>${{$data->price}}</td>
                        <td>{{$data->payment_status}}</td>
                        <td>{{$data->delivery_status}}</td>
                        <td>
                            <img class="img_size" src="/product/{{$data->image}}" alt="">
                        </td>
                        <td>
                            @if($data->delivery_status=='processing')
                            <a onclick="return confirm('Are You Sure To Deliver This Product')" class="btn btn-info" href="{{url('delivered',$data->id)}}">Deliver</a>
                            @elseif($data->delivery_status=='cancelled')
                            <a class="btn btn-primary">Cancelled</a>
                            @else
                            <a class="btn btn-info">Delivered</a>
                            @endif
                        </td>
                        <td>
                            <a href="{{url('print_pdf',$data->id)}}" class="btn btn-secondary">Print Pdf</a>
                        </td>
                        <td>
                            <a href="{{url('send_email',$data->id)}}" class="btn btn-primary">Send Email</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16">
                            No Data Found
                        </td>
                    </tr>
                    @endforelse
                </table>
            </div>
          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>