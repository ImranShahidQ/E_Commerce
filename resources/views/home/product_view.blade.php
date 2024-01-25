<section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  All <span>products</span>
               </h2>
               <br>
               <form action="{{url('product_search____')}}" method="GET">
                  @csrf
                     <input style="width: 500px;" type="text" name="search" placeholder="Search For Something">
                     <input type="submit" value="Search" class="btn btn-primary">
               </form>
            </div>
            @if(session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button>
                {{session()->get('message')}}
            </div>
            @endif
            <div class="row">
               @foreach($data as $dataa)
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{url('product_details',$dataa->id)}}" class="option1">
                           Product Details
                           </a>
                           <form action="{{url('add_cart',$dataa->id)}}" method="POST">
                              @csrf
                              <div class="row">
                              <div class="col-md-4"><input type="number" name="quantity" value="1" min="1" style="width:100px"></div>
                              <div class="col-md-4"><input type="submit" value="Add To Cart"></div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="img-box">
                        <img src="product/{{$dataa->image}}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                           {{$dataa->title}}
                        </h5>
                        @if($dataa->discount_price!=null)
                        <h6 style="color: red;">
                           Discount Price
                           <br>
                           ${{$dataa->discount_price}}
                        </h6>

                        <h6 style="text-decoration:line-through; color:blue;">
                           Price
                           <br>
                           ${{$dataa->price}}
                        </h6>
                        @else
                        <h6 style="color: blue;">
                           Price
                           <br>
                           ${{$dataa->price}}
                        </h6>
                        @endif
                        
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
            <span style="padding-top: 20px;">
            {!!$data->withQueryString()->links('pagination::bootstrap-4')!!}
            </span>
         </div>
      </section>