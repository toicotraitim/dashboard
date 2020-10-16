<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductImagesModel;
use App\Models\TagsModel;
use App\Models\ProductTagsModel;
use Illuminate\Http\Request;
use Auth;


class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $htmlSelectCategory;
    public function __construct() {
        $this->htmlSelectCategory = '';
    }
    public function index()
    {
        //
        $products = ProductModel::paginate(10);
        return view('admin.product.indexProduct',['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $htmlOptionCategory = $this->categoryParent(0);
        return view('admin.product.createProduct',['htmlOptionCategory' => $htmlOptionCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->images = (isset($request->images) ? $request->images : []);
        $request->tags = (isset($request->tags) ? $request->images : []);
        $val = $request->validate([
            'name' => 'bail|required|unique:products,name|min:6|max:255',
            'price' => 'bail|required|integer',
            'content' => 'bail|required',
            'category_id' => 'bail|required|exists:category_product,id',
            'tags.*' => 'required',
            'feature_image' => 'bail|required|image|mimes:jpeg,jpg,png|max:5120',
            'images.*' => 'bail|required|image|mimes:jpeg,jpg,png|max:5120',

        ]);
        if($request->active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = "";
        if ($request->hasFile('feature_image')) {
            $nameImg = Str::random(20);
            $extension = $request->feature_image->extension();
            $request->feature_image->storeAs('/public/product',$nameImg.'.'.$extension);
            $urlImg = Storage::url('product/'.$nameImg.'.'.$extension);
        }
        $images = [];
        foreach ($request->images as $key => $value) {
            $nameImg = Str::random(20);
            $extension = $value->extension();
            $request->images[$key]->storeAs('/public/product',$nameImg.'.'.$extension);
            array_push($images,Storage::url('product/'.$nameImg.'.'.$extension));
        }
        $product_id = ProductModel::create([
            'name' => $val['name'],
            'price' => $val['price'],
            'content' => $val['content'],
            'category_id' => $val['category_id'],
            'user_id' => Auth::id(),
            'active' => $active,
            'feature_image' => $urlImg,
        ])->id;
        foreach($request->tags as $value) {
            $tag_id = TagsModel::firstOrCreate(['name' => $value])->id;
            ProductTagsModel::create([
                'product_id' => $product_id,
                'tag_id' => $tag_id
            ]);
        }
        foreach($images as $value) {
            ProductImagesModel::create([
                'image_path' => $value,
                'product_id' => $product_id,
            ]);
        }
        return redirect()->route("product-management.create")->with('success',$val['name']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        if(ProductModel::where('id',$id)->count() == 0) abort(404);
        if ($request->type == 'destroy'){
            return view('admin.product.deleteProduct',['product' => $this->getProduct($id)]);
        } else {
            $product_tags = ProductTagsModel::where('product_id',$id)->get();
            $htmlOptionTag = null;
            
            foreach ($product_tags as $val) {
                $tag = TagsModel::where('id',$val['tag_id'])->first();
                $htmlOptionTag .= '<option value="'.$tag['name'].'" selected> '.$tag['name'].'</option>';
            }
            $htmlOptionCategory = $this->categoryParent(0);
            $htmlImage = null;
            $product_images = ProductImagesModel::where("product_id",$id)->get();
            foreach ($product_images as $val) {
                $htmlImage .= '<img src="'.$val['image_path'].'" class="mt-2 mr-2" style="max-width: 200px; max-height: 200px; object-fit: cover">';
            }
            return view('admin.product.editProduct',[
                'htmlOptionCategory' => $htmlOptionCategory,
                'product' => $this->getProduct($id),
                'htmlOptionTag' => $htmlOptionTag,
                'htmlImage' => $htmlImage
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
        //
        $request->images = (isset($request->images) ? $request->images : []);
        $request->tags = (isset($request->tags) ? $request->images : []);
        $val = $request->validate([
            'name' => 'bail|required|min:6|max:255',
            'price' => 'bail|required|integer',
            'content' => 'bail|required',
            'category_id' => 'bail|required|exists:category_product,id',
            'tags.*' => 'required',
            'feature_image' => 'bail|image|mimes:jpeg,jpg,png|max:5120',
            'images.*' => 'bail|required|image|mimes:jpeg,jpg,png|max:5120',

        ]);
        if($request->active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = $this->getProduct($id)['feature_image'];
        if ($request->hasFile('feature_image')) {
            //xoa anh cu
            if($urlImg != "" && file_exists($urlImg)) {
                $oldImg = explode("/",$urlImg)[3];
                Storage::delete('public/product/'.$oldImg);
                echo $oldImg;
            }

            $nameImg = Str::random(20);
            $extension = $request->feature_image->extension();
            $request->feature_image->storeAs('/public/product/',$nameImg.'.'.$extension);
            $urlImg = Storage::url('product/'.$nameImg.'.'.$extension);
        }
        $productTags = ProductTagsModel::where('product_id',$id)->get();
        foreach ($productTags as $value) {
            ProductTagsModel::where('id',$value['id'])->delete();
        }
        if(isset($request->tags)) {
            foreach($request->tags as $value) {
                $tag_id = TagsModel::firstOrCreate(['name' => $value])->id;
                ProductTagsModel::firstOrCreate([
                    'product_id' => $id,
                    'tag_id' => $tag_id
                ]);
            }
        }
        
        ProductModel::where('id',$id)->update([
            'name' => $val['name'],
            'price' => $val['price'],
            'content' => $val['content'],
            'category_id' => $val['category_id'],
            'user_id' => Auth::id(),
            'active' => $active,
            'feature_image' => $urlImg,
        ]);
        $productImages = ProductImagesModel::where('product_id',$id)->get();
        foreach($productImages as $value) {
            $oldImg = explode("/",$value['image_path'])[3];
            Storage::delete('public/product/'.$oldImg);
            ProductImagesModel::where('id',$value['id'])->delete();

        }
        $images = [];
        foreach ($request->images as $key => $value) {
            $nameImg = Str::random(20);
            $extension = $value->extension();
            $request->images[$key]->storeAs('/public/product',$nameImg.'.'.$extension);
            array_push($images,Storage::url('product/'.$nameImg.'.'.$extension));
        }
        foreach($images as $value) {
            ProductImagesModel::create([
                'image_path' => $value,
                'product_id' => $id,
            ]);
        }
        return redirect()->back()->with('success', $val['name']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $productImages = ProductImagesModel::where("product_id",$id)->get();
        foreach($productImages as $value) {
            $oldImg = explode("/",$value['image_path'])[3];
            Storage::delete('public/product/'.$oldImg);
            ProductImagesModel::where('id',$value['id'])->delete();

        }
        $productTags = ProductTagsModel::where('product_id',$id)->get();
        foreach ($productTags as $value) {
            ProductTagsModel::where('id',$value['id'])->delete();
        }
        ProductModel::where("id",$id)->delete();
        return redirect()->route("product-management.index");
    }
    public function getCategory($id) {
        return CategoryModel::where('id',$id)->first();
    }
    public function categoryParent($id, $text = '') {
        $par = explode("/",url()->current())[5];
        $cid = null;
        if($par != 'create') $cid = $par;
        $data = CategoryModel::where([
            'category_parent' => $id,
            'category_active' => 1
        ])->get();
        foreach ($data as $key => $value) {
            if ($value['category_parent'] == $id) {
                $selected = isset($cid) ? ($this->getProduct($cid)['category_id'] == $value['id'] ? 'selected' : '') : ''; 
                $arrow = $text != '' ? $text.'> ' : $text.' ';
                $this->htmlSelectCategory .= '<option value="'.$value['id'].'" '.$selected.'>'.$arrow.$value['category_name'].'</p>';
                $this->categoryParent($value['id'],$text.'----');
            }
            
        }
        return $this->htmlSelectCategory;
    }
    public function getProduct($id) {
        return ProductModel::where('id',$id)->first();
    }
}
