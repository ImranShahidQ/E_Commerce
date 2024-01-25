<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order PDF</title>
</head>
<body>
    <h1>Order Details</h1>

    Customer Name :<h3>{{$data->name}}</h3>
    Customer Email :<h3>{{$data->email}}</h3>
    Customer Phone_No. :<h3>{{$data->phone}}</h3>
    Customer Address :<h3>{{$data->address}}</h3>
    Product Title :<h3>{{$data->title}}</h3>
    Product Quantity :<h3>{{$data->quantity}}</h3>
    Product Price :<h3>${{$data->price}}</h3>
    Product Payment_status :<h3>{{$data->payment_status}}</h3>
    Product Image :
    <br>
    <img height="250" width="450" src="{{ public_path('/product/' . $data->image) }}" />
    
</body>
</html>