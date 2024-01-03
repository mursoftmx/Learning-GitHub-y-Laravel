<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\PanelProduct;            // antes utlizamos la clase Product 
use App\Scopes\AvailableScope;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware("auth")->except(['index','show']);
    }

    public function index() {
        // $products = DB::table("products")->get();
        // $products = Product::all();
        // return $products;
        // dd($products);
        // return view("products.index", ['$products' => []]);

        // return view('products.index')->with(['products' => PanelProduct::all()]);    // No necesitamos las imagenes
        return view('products.index')->with(['products' => PanelProduct::without('images')->get()]); 
    }

    public function create() {
        return view('products.create');
    }

    public function store(ProductRequest $request) {
        // $product = Product::create([
        //     'title' => request()->title,
        //     'description' => request()->description,
        //     'price' => request()->price,
        //     'stock' => request()->stock,
        //     'status' => request()->status
        // ]);

        /* Esta validacion se movio a la carpeta /app/Http/Request a ProductRequest.php
        $rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required','max:1000'],
            'price' => ['required','min:1'],
            'stock' => ['required','min:0'],
            'status' => ['required','in:available, unavailable']
        ];

        request()->validate($rules);
        */

        /* Accederemos al request directamente a traves de la inyeccion de dependencia en lugar del helper request()

        if (request()->status == 'available' && request()->stock == 0) { 
            // session()->put('error','if available must have stock');
            // session()->flash('error','if available must have stock');
            return redirect()->back()
                ->withInput(request()->all())
                ->withErrors('if available must have stock');
        }

        session()->forget('error');

        $product = Product::create(request()->all());
        */

        /* Esta validación se movio al metodo withValidator() de App/Http/ProductRequest.php
        if ($request->status == 'available' && $request->stock == 0) { 
            // session()->put('error','if available must have stock');
            // session()->flash('error','if available must have stock');
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors('if available must have stock');
        }
        */

        session()->forget('error');

        // Testing the request object, helper and validation fields.
        // dd(request()->all(), $request->all(), $request->validated());

        // $product = Product::create($request->all());
        $product = PanelProduct::create($request->validated());

        // session()->flash('success',"The product with the id: {$product->id} was created");

        // return redirect()->back();
        // return redirect()->action([MainController::class, 'index']);
        return redirect()->route('products.index')
            // ->with(['success' => "The product with the id: {$product->id} was created"]);
            ->withSuccess("The product with the id: {$product->id} was created");
    }

    public function show(PanelProduct $product) {    // findOrFail($product) implicit
        // $product = DB::table('products')->where('id', $product)->first();
        // $product = DB::table('products')->find($product);
        // $product = Product::find($product);
        // $product = Product::findOrFail($product);
        // return $product;
        // dd($product);
        return view('products.show')->with(['product' => $product, 'html'=> '<h2>Sub titulo</h2>']);
    }

    public function edit(PanelProduct $product) {
        return view('products.edit')->with([
            'product' => $product   // Product::findOrFail($product)
        ]);
    }

    public function update(ProductRequest $request, PanelProduct $product) {
        /* Esta validacion se movio a la carpeta /app/Http/Request a ProductRequest.php
        $rules = [
            'title' => ['required', 'max:255'],
            'description' => ['required','max:1000'],
            'price' => ['required','min:1'],
            'stock' => ['required','min:0'],
            'status' => ['required','in:available, unavailable']
        ];

        request()->validate($rules);
        */
        
        /* Esta validación se movio al metodo withValidator() de App/Http/ProductRequest.php
        if ($request->status == 'available' && $request->stock == 0) { 
            // session()->put('error','if available must have stock');
            // session()->flash('error','if available must have stock');
            return redirect()->back()
                ->withInput($request->all())
                ->withErrors('if available must have stock');
        }
        */

        // $product = Product::findOrFail($product);
        // Accederemos al request directamente a traves de la inyeccion de dependencia en lugar del helper request()
        // $product->update($request->all());

        $product->update($request->validated());

        // return $product;
        // return redirect()->back();
        // return redirect()->action([MainController::class, 'index']);
        return redirect()->route('products.index')
            ->withSuccess("The product with the id: {$product->id} was successfully updated");
    }

    public function destroy(PanelProduct $product) {     // findOrFail($product) implicit
        // $product = Product::findOrFail($product);
        $product->delete();

        // return $product;
        // return redirect()->back();
        // return redirect()->action([MainController::class, 'index']);
        return redirect()->route('products.index')
            ->withSuccess("The product with the id: {$product->id} was deleted");
    }
}
