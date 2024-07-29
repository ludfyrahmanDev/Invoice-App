<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;

/**
 * model block
 */
class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = SubCategory::with('category', 'purchaseDetails')->orderBy('category_id', 'desc')->get();
        $title = 'List Data Sub Kategori';
        return view('pages.backoffice.sub_category.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $title = 'Tambah Data Sub Kategori';
        $data = (object)[
            'name'              => '',
            'description'       => '',
            'purchase_price'    => 0,
            'selling_price'     => 0,
            'category_id'       => '',
            'type'              => 'create',
        ];
        $categories = Category::all();
        return view('pages.backoffice.sub_category.form', compact('categories','title', 'data'));
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
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'purchase_price' => 'required',
            'selling_price' => 'required',
            'category_id' => 'required',
        ]);

        try {
            SubCategory::create([
                'name' => $request->name,
                'description' => $request->description ?? '-',
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
                'category_id' => $request->category_id,
            ]);
            return redirect('sub_category')->with('success', 'Berhasil menambah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal menambah data!'.$th->getMessage());
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
        $data = SubCategory::where('id', $id)->first();
        $title = 'Edit Data Sub Kategori';
        $categories = Category::all();
        return view('pages.backoffice.sub_category.form', compact('data', 'title', 'categories'));
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
        $request->validate([
            'name' => 'required',
            'purchase_price' => 'required',
            'selling_price' => 'required',
            'category_id' => 'required',
        ]);
        try {
            $data = ([
                'name' => $request->name,
                'description' => $request->description ?? '-',
                'category_id' => $request->category_id,
                'purchase_price' => $request->purchase_price,
                'selling_price' => $request->selling_price,
            ]);

            SubCategory::where('id', $id)->update($data);
            return redirect('sub_category')->with('success', 'Berhasil mengubah data!');
        } catch (\Throwable $th) {
            return back()->with('failed', 'Gagal mengubah data!');
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
        //
        SubCategory::find($id)->delete();
        return redirect('sub_category')->with('success', 'Berhasil mengubah data!');
    }
}
