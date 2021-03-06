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

      <div class="album py-5 bg-light">
        <div class="container">

          <div class="row">
            @foreach($productList as $products)
            <div class="col-md-4">
              <div class="card mb-4 shadow-sm">
                <img class="card-img-top" /{{$products["img_src"]}}" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/{{$products["img_src"]}}" data-holder-rendered="true">
                <div class="card-body">
                  <p class="card-text">
                    {{$products["product_name"]}}
                     ${{$products["price"]}}
                  </p>

                  <div class="d-flex justify-content-between 
                  align-items-center">
                    <div class="btn-group">
                      <button type="button" class="btn btn-sm btn-outline-secondary add_to_cart" product_id="{{$products['id']}}">Add Cart</button>
                     
                    </div>
                    
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>
      </div>

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
      console.log($("body").length)
      $(".add_to_cart").click(function(){
        var _this = $(this);
        var url="/cart/add";
        
        $.ajax({
          url:url,
          type: "POST",
          data: {
            product_id:_this.attr("product_id"),
            _token:$("#csrf_token").val(),
          },
          success: function(message) 
          {
            alert(message);
          }
        });
      })

      @if(!empty(Session::has('message')))
        alert("{{Session::get('message')}}")
      @endif
    </script>
  </body>
</html>