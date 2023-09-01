<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\indikasi;
use Illuminate\Http\Request;

class indikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $indikasi = indikasi::get(['id', 'name', 'updated_at']);

        $data = [
            'indikasi' => $indikasi,
            'loginDuration' =>  $this->LoginDuration()
        ];
        return view('admin.indikasi.indikasi', $data);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loginDuration = $this->LoginDuration();
        return view('admin.indikasi.tambah', compact('loginDuration'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $this->validate($request, [
                'name' => 'required',
            ]);

            $form_data = array(
                'name' => $request->name,
                
            );

            indikasi::create($form_data);
            //isi dengan blok kode dari function
            return redirect()->route('admin.indikasi')->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->route('admin.indikasi')->with('error', $e);
        }

        //return redirect(route('admin.indikasi'))->with('success', 'Data berhasil ditambahkan!');
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
        $indikasi = indikasi::findOrFail($id);
        $loginDuration = $this->LoginDuration();
        return view('admin.indikasi.edit', compact('indikasi', 'loginDuration'));
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
        try {
            $indikasi = indikasi::findOrFail($id);
            $this->validate($request, [
                'name' => 'required',
                // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


            if ($request->hasFile('image')) {
                $old_image = $indikasi->image;
                $image_path = "public/indikasi/" . $old_image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $image = $request->file('image');
                $new_name = rand() . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/indikasi', $new_name);
            }

            $form_data = array(
                'name' => $request->name,
                'image' => $new_name ?? $indikasi->image
            );

            $indikasi->update($form_data);

            return redirect()->route('admin.indikasi')->with('success', 'Berhasil');
        } catch (\Exception $e) {
            return redirect()->route('admin.indikasi')->with('error', $e);
        }


        //return redirect(route('admin.indikasi'))->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $indikasi = indikasi::findOrFail($id);
        $old_image = $indikasi->image;
        $image_path = "public/indikasi/" . $old_image;
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        $indikasi->delete();
        return redirect(route('admin.indikasi'))->with('success', 'Data berhasil dihapus!');
    }
}
