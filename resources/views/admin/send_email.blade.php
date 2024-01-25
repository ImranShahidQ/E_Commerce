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
                <h2 class="h2_font">Send Email To {{$data->email}}</h2>
                <form action="{{url('send_user_email',$data->id)}}" method="POST">
                    @csrf
                    <div class="div_design">
                        <label>Email Greeting :</label>
                        <input class="input_color" type="text" name="greeting">
                    </div>
                    <div class="div_design">
                        <label>Email Subject :</label>
                        <input class="input_color" type="text" name="subject">
                    </div>
                    <div class="div_design">
                        <label>Email Body :</label>
                        <input class="input_color" type="text" name="body">
                    </div>
                    <div class="div_design">
                        <label>Email Button :</label>
                        <input class="input_color" type="text" name="button">
                    </div>
                    <div class="div_design">
                        <label>Email Url :</label>
                        <input class="input_color" type="text" name="url">
                    </div>
                    <div class="div_design">
                        <label>Email Footer :</label>
                        <input class="input_color" type="text" name="footer">
                    </div>
                    <div class="div_design">
                        <input type="submit" name="submit" value="Send Email" class="btn btn-primary">
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