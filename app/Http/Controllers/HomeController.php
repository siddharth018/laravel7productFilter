<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data['brand'] = $product_brand = DB::table('products')
            ->select('product_brand')
            ->distinct('product_brand')
            ->get();
        $data['product_size'] = $product_brand = DB::table('products')
            ->select('product_size')
            ->distinct('product_size')
            ->get();

        return view('prodcut',$data);
    }
    public function product()
    {
        $result = DB::table('products')->get();
        if (isset($_GET["action"]))
        {
            if (isset($_GET["minimum_price"], $_GET["maximum_price"]) && !empty($_GET["minimum_price"]) && !empty($_GET["maximum_price"])) {
                $compare = [$_GET["minimum_price"], $_GET["maximum_price"]];
                $result = DB::table('products')
                    ->whereBetween('product_price', $compare)
                    ->paginate(12);
            }
          if(isset($_GET["brand"]))
           {
                $result = DB::table('products')
                        ->whereIn('product_brand', $_GET["brand"])
                        ->paginate(12);
           }
           if(isset($_GET["size"]))
           {
                $result = DB::table('products')
                        ->whereIn('product_size', $_GET["size"])
                        ->paginate(12);
           }
            $output = '';
            foreach ($result as $row)
                {
              $output .= '
               <div class="col-md-4 col-sm-6">
               <div class="product-grid">
                   <div class="product-image4">
                       <a href="#">
                           <img class="pic-1" src="images/' . $row->product_image . '">
                           <img class="pic-2" src="images/' . $row->product_image . '">
                       </a>
                       <ul class="social">
                           <li><a href="#" data-tip="Quick View"><i class="fa fa-eye"></i></a></li>
                           <li><a href="#" data-tip="Add to Wishlist"><i class="fa fa-shopping-bag"></i></a></li>
                           <li><a href="#" data-tip="Add to Cart"><i class="fa fa-shopping-cart"></i></a></li>
                       </ul>
                       <span class="product-new-label">New</span>
                       <span class="product-discount-label">-10%</span>
                   </div>
                   <div class="product-content">
                       <h3 class="title"><a href="#">' . $row->product_name . '</a></h3>
                       <div class="price">
                          $' . $row->product_price . '
                           <span>$' . $row->product_price . '</span>
                       </div>
                       
                        Brand : ' . $row->product_brand . ' <br />
                       
                       <a class="add-to-cart" href="">ADD TO CART</a>
                   </div>
               </div>
            </div>';
          }
            echo $output;
        }
    }
}

