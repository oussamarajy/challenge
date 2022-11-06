<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\Category;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $products = Product::orderBy('price', 'DESC')->paginate(5);

            foreach($products as $product){
                $categories = ProductCategory::where("product_id",$product->id)->get();

                $ids = [];
               
                foreach($categories as $category){
                   
                    $cat = Category::find($category->category_id);

                    $ids[] = $cat->name;
                }

                $product["categories"] = $ids;

                
            }

            return response()->json([
                "products" => $products,
                "status" => 200,
               
                
            ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{

            $validator_product = Validator::make($request->all(), [
                "name" => ['required'],
                "description" => ['required'],
                "price" => ['required'],


            ]);

            if($validator_product->fails()){
                return response()->json([
                    'errors' => $validator_product->errors(),
                    'message' => 'Error'
                ]);
            }

            $product = Product::create([
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "image" => $request->image
 
             ]);

             if(sizeof($request->category) > 0){

                foreach($request->category as $category){


                ProductCategory::create([
                    "category_id" => $category,
                    "product_id" => $product->id
                ]);
            
             }

}

             

             return response()->json([
                "product" => $product,
                "message" => "Added successfully",
                "status" => 200,
               
             ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{

            $product = Product::findOrFail($id);

            $categories = ProductCategory::where("product_id",$product->id)->get();

                $ids = [];
               
                foreach($categories as $category){
                    $ids[] = $category->category_id;
                }

                $product["categories"] = $ids;

            return response()->json([
                "product" => $product,
                "status" => 200,
            ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validator_product = Validator::make($request->all(), [
                "name" => ['required'],
                "description" => ['required'],
                "price" => ['required', 'numeric'],


            ]);

            if($validator_product->fails()){
                return response()->json([
                    'errors' => $validator_product->errors(),
                    'message' => 'Error'
                ]);
            }

            $product = Product::findOrFail($id);

            $product->update([
                "name" => $request->name,
                "description" => $request->description,
                "price" => $request->price,
                "image" => $request->image

            ]);

            if(sizeof($request->category) > 0){

                $productCate = ProductCategory::where('product_id',$id);
                 $productCate->delete();

                foreach($request->category as $category){


                ProductCategory::create([
                    "category_id" => $category,
                    "product_id" => $product->id
                ]);
            
             }
            }

            


            return response()->json([
                "product" => $product,
                "massage" => "updated successfully",
                "status" => 200
            ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
         
            $product = Product::findOrFail($id);

            $product->delete();

            return response()->json([
                "product" => $product,
                "massage" => "updated successfully",
                "status" => 200
            ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }


    public function categories(){

        try{
         
            $categories = Category::all();

           

            return response()->json([
                "categories" => $categories,
                "status" => 200
            ]);

        }

        catch(\Throwable $ex){
            return response()->json([
                "message" => $ex->getMessage()

            ]);
        }
    }


    public function Filter(Request $request){
        try{
           
            $products = Product::select('products.*')->
            join('product_categories', 'products.id', 'product_categories.product_id')
            ->where('product_categories.category_id', $request->selectedCategory)->paginate(5);

            return response()->json([
                "products" => $products,
                "status" => 200
            ]);


        }

    

    catch(\Throwable $ex){
        return response()->json([
            "message" => $ex->getMessage()

        ]);
    
    }
}




public function SortByPrice(){
    try{
       
        $products = Product::select('products.*')->
        join('product_categories', 'products.id', 'product_categories.product_id')
        ->where('product_categories.category_id', $request->selectedCategory)->paginate(5);

        return response()->json([
            "products" => $products,
            "status" => 200
        ]);


    }



catch(\Throwable $ex){
    return response()->json([
        "message" => $ex->getMessage()

    ]);

}
}
}
