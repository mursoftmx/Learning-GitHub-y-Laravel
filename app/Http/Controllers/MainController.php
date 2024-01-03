<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class MainController extends Controller
{
    public function index() {
        // $products = Product::available()->get(); ya se esta aplicando el scope de manera global y no es necesario el scope local

        // DB::connection()->enableQueryLog();

        $products = Product::all();                     // recuperamos todos los productos ya que se establece la relacion en el modelo (with)
        // $products = Product::with('images')->get();  // eager loading
        return view('welcome')->with(['products' => $products]);
    }
}
