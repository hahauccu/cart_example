<html lang="en"><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

    <title>Cart Example</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.1/examples/album/">

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/album.css" rel="stylesheet">

  </head>

  <body>

    @include("header")

    <main role="main">

      <table class="table">
  <thead>
    <tr>
      <th scope="col">product name</th>
      <th scope="col">photo</th>
      <th scope="col">number</th>
      <th scope="col">price</th>
      <th scope="col">total price</th>
      <th scope="col">remove</th>
    </tr>
  </thead>
  <tbody>
    @foreach($productData as $product)
    <tr>
      <td>{{$product["product_name"]}}</td>
      <td>{{$product["product_name"]}}</td>
      <td product_id="{{$product['id']}}">
        <button class="minus_to_cart">-</button> {{$product["in_cart"]}} <button class="add_to_cart">+</button> </td>
      <td>{{$product["price"]}}</td>
      <td>{{$product["in_cart_price"]}}</td>
      <td><a href="JavaScript:void(0)" class="remove_from_cart" product_id="{{$product["id"]}}">remove</a></td>
    </tr>
    @endforeach
    <tr>
      <td style="text-align:right" colspan="5">
        {{!empty($discount["discount_content"])? $discount["discount_content"] : ""}}
        <input id="discount_code" {{!empty($discount["discount_code"])? 'value='.$discount["discount_code"] : ""}}> <button id="use_discount_code">use discount code</button>
        total :{{$orderPrice}}
        <a id="check_out" href="javascript:void(0);">CheckOut</a>
      </td>
    </tr>
  </tbody>
</table>

     

    </main>

    <footer class="text-muted">
      <div class="container">
      </div>
    </footer>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="/js/popper.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/holder.min.js"></script>
  

<svg xmlns="http://www.w3.org/2000/svg" width="348" height="225" viewBox="0 0 348 225" preserveAspectRatio="none" style="display: none; visibility: hidden; position: absolute; top: -100%; left: -100%;"><defs><style type="text/css"></style></defs><text x="0" y="17" style="font-weight:bold;font-size:17pt;font-family:Arial, Helvetica, Open Sans, sans-serif">Thumbnail</text></svg>
  <script type="text/javascript">
      
      $(".remove_from_cart").click(function(){
        var _this = $(this);
        var url="/cart/remove_product";
        
        $.ajax({
          url:url,
          type: "POST",
          data: {
            product_id:_this.attr("product_id"),
            _token:$("#csrf_token").val(),
          },
          success: function(message) 
          {
            location.reload();
          }
        });
      })


      $(".add_to_cart").click(function(){
        var _this = $(this);
        var url="/cart/add";
        
        $.ajax({
          url:url,
          type: "POST",
          data: {
            product_id:_this.parent().attr("product_id"),
            _token:$("#csrf_token").val(),
          },
          success: function(message) 
          {
            alert(message);
            location.reload(); 
          }
        });
      })


      $(".minus_to_cart").click(function(){
        var _this = $(this);
        var url="/cart/minus";
        
        $.ajax({
          url:url,
          type: "POST",
          data: {
            product_id:_this.parent().attr("product_id"),
            _token:$("#csrf_token").val(),
          },
          success: function(message) 
          {
            location.reload(); 
          }
        });
      })


      $("#use_discount_code").click(function(){
        if($("#discount_code").val() == "")
        {
          alert("discount code is empty");
          return 0;
        }
        var url="/cart/add_discount_code";
        $.ajax({
          url:url,
          type: "POST",
          data: {
            to_add_code:$("#discount_code").val(),
            _token:$("#csrf_token").val(),
          },
          success: function(message) 
          {
            alert(message);
            location.reload(); 
          }
        });
      })

      $("#check_out").click(function(){
        var url="/cart/check_out";
        $.ajax({
          url:url,
          type: "POST",
          data: {
            _token:$("#csrf_token").val(),
          },
          success: function(random_id) 
          {
            location.href="/order/list/"+random_id; 
          }
        });
      })


      @if(!empty(Session::has('message')))
        alert("{{Session::get('message')}}")
      @endif

    </script>
  
  </body>
</html>