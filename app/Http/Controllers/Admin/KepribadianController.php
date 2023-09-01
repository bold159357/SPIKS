<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\kepribadian;
use Illuminate\Http\Request;

class kepribadianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = [
            'kepribadian' => kepribadian::get(['id', 'name', 'reason', 'solution', 'updated_at']),
            'loginDuration' =>  $this->LoginDuration()
        ];
        return view('admin.kepribadian.kepribadian', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $loginDuration = $this->LoginDuration();
        return view('admin.kepribadian.tambah', compact('loginDuration'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'reason' => 'required',
            'solution' => 'required',
        ]);

        $form_data = array(
            'name' => $request->name,
            'reason' => $request->reason,
            'solution' => $request->solution,
        );
        kepribadian::create($form_data);

        return redirect(route('admin.kepribadian'))->with('success', 'Data berhasil ditambahkan!');
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
        $kepribadian = kepribadian::findOrFail($id);
        $loginDuration = $this->LoginDuration();
        return view('admin.kepribadian.edit', compact('kepribadian', 'loginDuration'));
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
        $kepribadian = kepribadian::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'reason' => 'required',
            'solution' => 'required',
        ]);


        $form_data = array(
            'name' => $request->name,
            'reason' => $request->reason,
            'solution' => $request->solution,
        );

        $kepribadian->update($form_data);

        return redirect(route('admin.kepribadian'))->with('success', 'Data berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $kepribadian = kepribadian::findOrFail($id);
            $old_image = $kepribadian->image;
        } catch (\Exception $th) {
            return redirect(route('admin.kepribadian'))->with('error', 'Data gagal dihapus!');
        }
    }
}
