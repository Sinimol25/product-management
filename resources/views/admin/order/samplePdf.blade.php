<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
     </head>
    <body>
        <h3> <b><u><center>Order Details</center></b></u></h3>
        <table style="border: 1px solid black;border-collapse: collapse;width:100%;">
        
            <tr >
                <td style="border: 1px solid black;border-collapse: collapse;">Customer name</td>
                <td style="border: 1px solid black;border-collapse: collapse;">{{$data->name}}</td>
            </tr>
            <tr >
                <td style="border: 1px solid black;border-collapse: collapse;">Order ID</td>
                <td style="border: 1px solid black;border-collapse: collapse;">{{$data->invoice_no}}</td>
            </tr>
            <tr>
            <td style="border: 1px solid black;border-collapse: collapse;">Products</td>
            <td style="border: 1px solid black;border-collapse: collapse;">
            @foreach($product as $key=>$val)
                {{++$key}} . {{$val->getProduct->product_name}} X {{$val->quantity}} = {{$val->net_amount}} <br>
                        
            @endforeach
             </td>
            </tr>
            <tr>
                <td style="border: 1px solid black;border-collapse: collapse;">Total</td>
                <td style="border: 1px solid black;border-collapse: collapse;">{{$total->total}}</td>
            </tr>  
        </table>
       
    </body>
 
</html>
