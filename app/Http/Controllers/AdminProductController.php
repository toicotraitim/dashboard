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
    private $htmlSelect;
    public function __construct() {
        $this->htmlSelect = '';
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
        $htmlOption = $this->categoryParent(0);
        return view('admin.product.createProduct',['htmlOption' => $htmlOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $val = $request->validate([
            'name' => 'bail|required|unique:products|min:6|max:255',
            'price' => 'bail|required|integer',
            'content' => 'bail|required',
            'category_id' => 'bail|required',
            'tags.*' => 'bail|required',
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
            $request->feature_image->storeAs('/public/product',$nameImg.'.'.$extension);
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
    public function edit($id)
    {
        //
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
                $selected = isset($cid) ? ($this->getCategory($cid)['category_parent'] == $value['id'] ? 'selected' : '') : ''; 
                $arrow = $text != '' ? $text.'> ' : $text.' ';
                $this->htmlSelect .= '<option value="'.$value['id'].'" '.$selected.'>'.$arrow.$value['category_name'].'</p>';
                $this->categoryParent($value['id'],$text.'----');
            }
            
        }
        return $this->htmlSelect;
    }
}
