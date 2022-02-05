<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Seller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{

    public function index(Seller $seller)
    {
        $products = $seller->products()->with('category:id,name')->get();
        return $this->showAllResponse($products);
    }

    public function store(Request $request, Seller $seller)
    {
        $request->validate([
            'name'        => 'required|min:1|max:250',
            'description' => 'min:10',
            'quantity'    => 'required|integer|min:1',
            'price'       => 'required|numeric',
            'image'       => 'image|min:1|max:6000',
            'category_id' => 'required',
        ]);

        $this->validateCategory($request->category_id);

        $product = new Product();

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
            'price',
            'category_id',
        ]));

        $product->status    = Product::AVAILABLE;
        $product->seller_id = $seller->id; 

        if($request->hasFile('image')){
            $image = $request->file('image');
            $imageName = mt_rand(100000, 999999).'.'. $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(400, 400, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $image->save(public_path(Product::IMAGE_PATH).$imageName);
            $product->image = $imageName;
            $product->image_path = Product::IMAGE_PATH;
        }

        $product->save();

        return $this->showSingleResponse($product, 201);
    }

    public function update(Request $request, Seller $seller, Product $product)
    {
        $request->validate([
            'name'        => 'min:1|max:250',
            'description' => 'min:10',
            'quantity'    => 'integer|min:1',
            'price'       => 'numeric',
            'image'       => 'image|min:1|max:6000',
            'status'      => 'in:available,unavailable',
        ]);

        $this->checkSeller($seller, $product);

        $product->fill($request->only([
            'name',
            'description',
            'quantity',
            'price',
            'status',
        ]));

        if($request->has('category_id')){
            $this->validateCategory($request->category_id);
            $product->category_id = $request->category_id;
        }

        if($request->hasFile('image')){

            if($product->image!=null){
                if(File::exists(public_path($product->image_path).$product->image)){
                    File::delete(public_path($product->image_path).$product->image);
                }
            }

            $image = $request->file('image');
            $imageName = mt_rand(100000, 999999).'.'. $image->getClientOriginalExtension();
            $image = Image::make($image)->resize(400, 400, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            $image->save(public_path(Product::IMAGE_PATH).$imageName);
            $product->image = $imageName;
            $product->image_path = Product::IMAGE_PATH;
        }

        if($product->isClean()){
            return $this->errorResponse('No change', 422);
        }

        $product->save();

        return $this->showSingleResponse($product, 200);
    }

    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        if($product->image!=null){
            if(File::exists(public_path($product->image_path).$product->image)){
                File::delete(public_path($product->image_path).$product->image);
            }
        }

        $product->delete();
        return $this->showSingleResponse($product);
    }

    private function checkSeller(Seller $seller, Product $product){
        if($seller->id!=$product->seller_id){
           throw new HttpException(422, 'This seller does not own this product'); 
        }
    }

    private function validateCategory($id){
        if(is_null(Category::find($id))){
            throw new HttpException(404, 'Invalid category id');
        }
    }
}
