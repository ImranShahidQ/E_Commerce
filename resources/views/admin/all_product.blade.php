<!DOCTYPE html>
<html lang="en">
  <head>
  @include('admin.css')
  <style>
    .div_center
    {
        text-align: center;
        padding-top: 40px;
    }
    .h2_font
    {
        font-size: 40px;
        padding-bottom: 40px;
    }
    .input_color
    {
        color: black;
    }
    .center
    {
        margin: auto;
        width: 50%;
        text-align: center;
        border: 3px solid blue;
    }
    .img_size
    {
        width: 100px;
        height: 100px;
    }
    .th_color
    {
        background: blue;
    }
    .th_deg
    {
        padding: 30px;
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
                <h2 class="h2_font">ALL Products</h2>
                <table class="center">
                    <tr class="th_color">
                        <th class="th_deg">Title</th>
                        <th class="th_deg">Description</th>
                        <th class="th_deg">Category</th>
                        <th class="th_deg">Quantity</th>
                        <th class="th_deg">Price</th>
                        <th class="th_deg">Discount_Price</th>
                        <th class="th_deg">Image</th>
                        <th class="th_deg">Action</th>
                    </tr>
                    @foreach($data as $data)
                    <tr>
                        <td>{{$data->title}}</td>
                        <td>{{$data->description}}</td>
                        <td>{{$data->category}}</td>
                        <td>{{$data->quantity}}</td>
                        <td>${{$data->price}}</td>
                        <td>${{$data->discount_price}}</td>
                        <td>
                            <img class="img_size" src="/product/{{$data->image}}" alt="">
                        </td>
                        <td>
                        <a class="btn btn-success" href="{{url('edit_product',$data->id)}}">Edit</a>
                            <a onclick="return confirm('Are You Really Want To Delete This Product')" class="btn btn-danger" href="{{url('delete_product',$data->id)}}">Delete</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>