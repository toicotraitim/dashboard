<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
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
        $category = CategoryModel::where("category_parent","0")->paginate(10);
        return view("admin.category.categoryProduct",['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $htmlOption = $this->categoryParent(0);

        return view("admin.category.createCategory",['htmlOption' => $htmlOption]);
        //
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
            'category_name' => 'bail|unique:category_product|required|min:6|max:255',
            'category_description' => 'bail|required|max:1024',
            'category_parent' => 'bail|required',
            'category_thumb' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        if($request->category_active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = "";
        if ($request->hasFile('category_thumb')) {
            $nameImg = Str::random(20);
            $extension = $request->category_thumb->extension();
            $request->category_thumb->storeAs('/public',$nameImg.'.'.$extension);
            $urlImg = Storage::url($nameImg.'.'.$extension);
        }
        CategoryModel::create([
            'category_name' => $val['category_name'],
            'category_description' => $val['category_description'],
            'category_parent' => $val['category_parent'],
            'category_active' => $active,
            'category_thumb' => $urlImg,
        ]);
        return redirect()->route("category-product.create")->with('success',$val['category_name']);
        //
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
        if(CategoryModel::where('id',$id)->count() == 0) abort(404);
        $category = CategoryModel::where("category_parent","<>","0")
                                        ->where("category_parent",$id)
                                        ->paginate(10);;
        return view('admin.category.showCategory',['category' => $category,'category_parent' => $this->getCategory($id)]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        if(CategoryModel::where('id',$id)->count() == 0) abort(404);
        if ($request->type == 'destroy'){
            return view('admin.category.deleteCategory',['category' => $this->getCategory($id)]);
        } else {
            $htmlOption = $this->categoryParent(0);
            return view('admin.category.editCategory',['htmlOption' => $htmlOption,'category' => $this->getCategory($id)]);

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
        if(CategoryModel::where('id',$id)->count() == 0) abort(404);
        $val = $request->validate([
            'category_name' => 'bail|required|min:6|max:255',
            'category_description' => 'bail|required|max:1024',
            'category_parent' => 'bail|required',
            'category_thumb' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        if($request->category_active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = $this->getCategory($id)['category_thumb'];
        if ($request->hasFile('category_thumb')) {
            //xoa anh cu
            if($urlImg != "") {
                $oldImg = explode("/",$urlImg)[2];
                Storage::delete('public/'.$oldImg);
                echo $oldImg;
            }

            $nameImg = Str::random(20);
            $extension = $request->category_thumb->extension();
            $request->category_thumb->storeAs('/public',$nameImg.'.'.$extension);
            $urlImg = Storage::url($nameImg.'.'.$extension);
            
            
        }
        CategoryModel::where('id',$id)
                            ->update([
                                'category_name' => $val['category_name'],
                                'category_description' => $val['category_description'],
                                'category_parent' => $val['category_parent'],
                                'category_active' => $active,
                                'category_thumb' => $urlImg,
                            ]);
        return redirect()->back()->with('success', $val['category_name']);
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
        if(CategoryModel::where('id',$id)->count() == 0) abort(404);
        $category = CategoryModel::where('category_parent',$id)->get();
        if($category->count() > 0) {
            foreach ($category as $key => $value) {
                CategoryModel::where('id',$value['id'])->delete();
                echo $value['id'].'<br>';
            }
        }
        CategoryModel::where('id',$id)->delete();
        echo "đã xóa";
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
