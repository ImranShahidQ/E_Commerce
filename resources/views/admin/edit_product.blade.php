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
    label
    {
        display: inline-block;
        width: 200px;
    }
    .div_design
    {
        padding-bottom: 15px;
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
                <h2 class="h2_font">Edit Product</h2>
                <form action="{{url('update_product',$product->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="div_design">
                        <label>Product Title :</label>
                        <input class="input_color" type="text" name="title" placeholder="Write Product Title" required="" value="{{$product->title}}">
                    </div>
                    <div class="div_design">
                        <label>Product Description :</label>
                        <input class="input_color" type="text" name="description" placeholder="Write Product Description" required="" value="{{$product->description}}">
                    </div>
                    <div class="div_design">
                        <label>Product Category :</label>
                        <select class="input_color" name="category" required="">
                            <option value="{{$product->category}}" selected="">{{$product->category}}</option>
                            @foreach($data as $data)
                            <option value="{{$data->category_name}}">{{$data->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="div_design">
                        <label>Product Quantity :</label>
                        <input class="input_color" type="number" min="0" name="quantity" placeholder="Write Product Quantity" required="" value="{{$product->quantity}}">
                    </div>
                    <div class="div_design">
                        <label>Product Price :</label>
                        <input class="input_color" type="number" name="price" placeholder="Write Product Price" required="" value="{{$product->price}}">
                    </div>
                    <div class="div_design">
                        <label>Product Discount_Price :</label>
                        <input class="input_color" type="number" name="discount_price" placeholder="Write Product Discount_Price" value="{{$product->discount_price}}">
                    </div>
                    <div class="div_design">
                        <label>Previous Product Image :</label>
                        <img style="margin: auto;" height="100" width="100" src="/product/{{$product->image}}" alt="">
                    </div>
                    <div class="div_design">
                        <label>Product Image :</label>
                        <input type="file" name="image">
                    </div>
                    <div class="div_design">
                        <input type="submit" name="submit" value="Update Product" class="btn btn-primary">
                    </div>
                </form>
            </div>
          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
  </body>
</html>