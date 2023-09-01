<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\cek;
use Illuminate\Http\Request;

class CekController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'loginDuration' => $this->LoginDuration(),
            'ceks' => $this->getCek(),
        ];
        return view('admin.cek.cek', $data);
    }

    public function getCek()
    {
        $ceks = cek::with(['kepribadian' => function ($query) {
            $query->select('id', 'name');
        }, 'indikasi' => function ($query) {
            $query->select('id', 'name');
        }])->get(['id', 'kepribadian_id', 'indikasi_id'])->map(function ($cek) {
            $cek['updated_at'] = $cek['updated_at'];
            $cek['kepribadian'] = $cek['kepribadian']->toArray();
            $cek['indikasi'] = $cek['indikasi']->toArray();
            return [
                'id' => $cek['id'],
                'updated_at' => $cek['updated_at'],
                'kepribadian' => $cek['kepribadian'],
                'indikasi' => $cek['indikasi'],
            ];
        })->values()->toArray();

        return $ceks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kepribadian = kepribadian::select('id', 'name')->orderByDesc('updated_at')->get();
        $indikasi = indikasi::select('id', 'name')->orderByDesc('updated_at')->get();

        $data = [
            'loginDuration' => $this->LoginDuration(),
            'kepribadian' => $kepribadian,
            'indikasi' => $indikasi,
        ];

        return view('admin.cek.tambah', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kepribadian' => 'required',
            'indikasi' => 'required',
        ]);

        $indikasi = $request->input('indikasi');
        foreach ($indikasi as $key => $value) {
            $indikasi[$key] = (int) $value;
        }

        foreach ($indikasi as $key => $value) {
            try {
                cek::create([
                    'kepribadian_id' => $request->input('kepribadian'),
                    'indikasi_id' => $value,
                ]);
            } catch (\Exception $e) {
                return redirect()->route('admin.cek')->with('error', 'cek gagal ditambahkan');
            }
        }

        return redirect()->route('admin.cek')->with('success', 'cek berhasil ditambahkan');
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
        try {
            $cek = cek::with(['kepribadian' => function ($query) {
                $query->select('id', 'name');
            }, 'indikasi' => function ($query) {
                $query->select('id', 'name');
            }])->findOrFail($id, ['id', 'kepribadian_id', 'indikasi_id', 'updated_at'])->toArray();

            $kepribadian = kepribadian::select('id', 'name')->orderByDesc('updated_at')->get();
            $indikasi = indikasi::select('id', 'name')->orderByDesc('updated_at')->get();

            $data = [
                'loginDuration' => $this->LoginDuration(),
                'kepribadian' => $kepribadian,
                'indikasi' => $indikasi,
                'cek' => $cek,
            ];

            return view('admin.cek.edit', $data);
        } catch (\Exception $e) {
            return redirect()->route('admin.cek')->with('error', 'cek tidak ditemukan');
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
        try {
            $cek = cek::findOrFail($id);
            $cek->kepribadian_id = $request->input('kepribadian');
            $cek->indikasi_id = $request->input('indikasi');
            $cek->save();
        } catch (\Exception $e) {
            return redirect()->route('admin.cek')->with('error', 'cek gagal diubah');
        }

        return redirect()->route('admin.cek')->with('success', 'cek berhasil diubah');
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
            $cek = cek::findOrFail($id);
            $cek->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.cek')->with('error', 'cek gagal dihapus');
        }

        return redirect()->route('admin.cek')->with('success', 'cek berhasil dihapus');
    }
}
