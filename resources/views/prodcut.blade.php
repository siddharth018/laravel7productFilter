<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="description" content="">
      <meta name="author" content="Real Programmer">
      <title>Product Filter In Laravel</title>
      <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <link href = "https://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel = "stylesheet">
      <link href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel = "stylesheet">
      <!-- Custom CSS -->
     <link rel="stylesheet" type="text/css" href="css/style.css">
   </head>
   <body>
      <!-- Page Content -->
      <div class="container">
         <div class="row">
            <br />
            <div class="jumbotron">
               <h2 class="display-4">Product Filter In Laravel</h2>
            </div>
            <br />
            <div class="col-md-3">
               <div class="list-group">
                  <h3>Price</h3>
                  <input type="hidden" id="hidden_minimum_price" value="0" />
                  <input type="hidden" id="hidden_maximum_price" value="65000" />
                  <p id="price_show">1000 - 65000</p>
                  <div id="price_range"></div>
               </div>
               <div class="list-group">
                  <h3>Brand</h3>
                  @foreach($brand as $row)
                   <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector brand" value="{{ $row->product_brand }}"  > {{ $row->product_brand }}</label>
                    </div>
                   @endforeach
               </div>
               <div class="list-group">
                  <h3>Size</h3>
                  @foreach($product_size as $row)
                   <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector size" value="{{ $row->product_size }}"  > {{ $row->product_size }}</label>
                    </div>
                   @endforeach
               </div>
            </div>
            <div class="col-md-9">
               <br />
               <div class="row filter_data">
               </div>
            </div>
         </div>
      </div>
      <style>
         #loading
         {
             text-align:center; 
             background: url('images/load.gif') no-repeat center; 
             height: 150px;
         }
      </style>
      <script>
         $(document).ready(function(){
             filter_data();
             function filter_data()
             {
                 $('.filter_data').html('<div id="loading" style="" ></div>');
                 var action = 'fetch_data';
                 var minimum_price = $('#hidden_minimum_price').val();
                 var maximum_price = $('#hidden_maximum_price').val();
                 var brand = get_filter('brand');
                 var size = get_filter('size');
                 var storage = get_filter('storage');
                 $.ajax({
                     url:"product",
                     method:"get",
                     data:{action:action, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand, size:size, storage:storage},
                     success:function(data){
                         $('.filter_data').html(data);
                     }
                 });
             }
         
             function get_filter(class_name)
             {
                 var filter = [];
                 $('.'+class_name+':checked').each(function(){
                     filter.push($(this).val());
                 });
                 return filter;
             }
         
             $('.common_selector').click(function(){
                 filter_data();
             });
         
             $('#price_range').slider({
                 range:true,
                 min:1000,
                 max:65000,
                 values:[1000, 65000],
                 step:500,
                 stop:function(event, ui)
                 {
                     $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
                     $('#hidden_minimum_price').val(ui.values[0]);
                     $('#hidden_maximum_price').val(ui.values[1]);
                     filter_data();
                 }
             });
         
         });
      </script>
   </body>
</html>