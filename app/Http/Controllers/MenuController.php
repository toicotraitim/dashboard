<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\MenuModel;
class MenuController extends Controller
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
        $menu = MenuModel::where("menu_parent","0")->paginate(10);
        return view('admin.menu.indexMenu',['menu' => $menu]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $htmlOption = $this->menuParent(0);
        return view('admin.menu.createMenu', ['htmlOption' => $htmlOption]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $val = $request->validate([
            'menu_name' => 'bail|unique:menus|required|min:6|max:255',
            'menu_description' => 'bail|required|max:1024',
            'menu_parent' => 'bail|required',
            'menu_icon' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        if($request->menu_active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = "";
        if ($request->hasFile('menu_icon')) {
            $nameImg = Str::random(20);
            $extension = $request->menu_icon->extension();
            $request->menu_icon->storeAs('/public/menu',$nameImg.'.'.$extension);
            $urlImg = Storage::url('menu/'.$nameImg.'.'.$extension);
        }
        MenuModel::create([
            'menu_name' => $val['menu_name'],
            'menu_description' => $val['menu_description'],
            'menu_parent' => $val['menu_parent'],
            'menu_active' => $active,
            'menu_icon' => $urlImg,
            'menu_slug' => Str::of($val['menu_name'])->slug('-'),
        ]);
        return redirect()->route("menu.create")->with('success',$val['menu_name']);
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
        if(MenuModel::where('id',$id)->count() == 0) abort(404);
        $menu = MenuModel::where("menu_parent","<>","0")
                                        ->where("menu_parent",$id)
                                        ->paginate(10);;
        return view('admin.menu.showMenu',['menu' => $menu,'menu_parent' => $this->getMenu($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        if(MenuModel::where('id',$id)->count() == 0) abort(404);
        if ($request->type == 'destroy'){
            return view('admin.menu.deleteMenu',['menu' => $this->getMenu($id)]);
        } else {
            $htmlOption = $this->menuParent(0);
            return view('admin.menu.editMenu',['htmlOption' => $htmlOption,'menu' => $this->getMenu($id)]);

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
        if(MenuModel::where('id',$id)->count() == 0) abort(404);
        $val = $request->validate([
            'menu_name' => 'bail|required|min:6|max:255',
            'menu_description' => 'bail|required|max:1024',
            'menu_parent' => 'bail|required',
            'menu_icon' => 'image|mimes:jpeg,jpg,png|max:1024'
        ]);
        if($request->menu_active == 'on') {
            $active = 1;
        } else {
            $active = 0;
        }
        $urlImg = $this->getMenu($id)['menu_icon'];
        if ($request->hasFile('menu_icon')) {
            //xoa anh cu
            if($urlImg != "") {
                $oldImg = explode("/",$urlImg)[3];
                Storage::delete('public/menu/'.$oldImg);
                echo $oldImg;
            }

            $nameImg = Str::random(20);
            $extension = $request->menu_icon->extension();
            $request->menu_icon->storeAs('/public/menu',$nameImg.'.'.$extension);
            $urlImg = Storage::url('menu/'.$nameImg.'.'.$extension);
            
            
        }
        MenuModel::where('id',$id)
                            ->update([
                                'menu_name' => $val['menu_name'],
                                'menu_description' => $val['menu_description'],
                                'menu_parent' => $val['menu_parent'],
                                'menu_active' => $active,
                                'menu_icon' => $urlImg,
                            ]);
        return redirect()->back()->with('success', $val['menu_name']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(MenuModel::where('id',$id)->count() == 0) abort(404);
        $menu = MenuModel::where('menu_parent',$id)->get();
        if($menu->count() > 0) {
            foreach ($menu as $key => $value) {
                MenuModel::where('id',$value['id'])->delete();
            }
        }
        MenuModel::where('id',$id)->delete();
        return redirect()->route("menu.index");
    }
    public function getMenu($id) {
        return MenuModel::where('id',$id)->first();
    }
    public function MenuParent($id, $text = '') {
        $par = explode("/",url()->current())[5];
        $cid = null;
        if($par != 'create') $cid = $par;
        $data = menuModel::where([
            'menu_parent' => $id,
            'menu_active' => 1
        ])->get();
        foreach ($data as $key => $value) {
            if ($value['menu_parent'] == $id) {
                $selected = isset($cid) ? ($this->getMenu($cid)['menu_parent'] == $value['id'] ? 'selected' : '') : ''; 
                $arrow = $text != '' ? $text.'> ' : $text.' ';
                $this->htmlSelect .= '<option value="'.$value['id'].'" '.$selected.'>'.$arrow.$value['menu_name'].'</p>';
                $this->menuParent($value['id'],$text.'----');
            }
            
        }
        return $this->htmlSelect;
    }
}
