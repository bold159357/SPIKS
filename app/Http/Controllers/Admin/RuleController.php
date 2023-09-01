<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
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
            'rules' => $this->getRule(),
        ];
        return view('admin.rule.rule', $data);
    }

    public function getRule()
    {
        $rules = Rule::with(['kepribadian' => function ($query) {
            $query->select('id', 'name');
        }, 'indikasi' => function ($query) {
            $query->select('id', 'name');
        }])->get(['id', 'kepribadian_id', 'indikasi_id', 'updated_at'])->map(function ($rule) {
            $rule['updated_at'] = $rule['updated_at'];
            $rule['kepribadian'] = $rule['kepribadian']->toArray();
            $rule['indikasi'] = $rule['indikasi']->toArray();
            return [
                'id' => $rule['id'],
                'updated_at' => $rule['updated_at'],
                'kepribadian' => $rule['kepribadian'],
                'indikasi' => $rule['indikasi'],
            ];
        })->values()->toArray();

        return $rules;
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

        return view('admin.rule.tambah', $data);
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
                Rule::create([
                    'kepribadian_id' => $request->input('kepribadian'),
                    'indikasi_id' => $value,
                ]);
            } catch (\Exception $e) {
                return redirect()->route('admin.rule')->with('error', 'Rule gagal ditambahkan');
            }
        }

        return redirect()->route('admin.rule')->with('success', 'Rule berhasil ditambahkan');
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
            $rule = Rule::with(['kepribadian' => function ($query) {
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
                'rule' => $rule,
            ];

            return view('admin.rule.edit', $data);
        } catch (\Exception $e) {
            return redirect()->route('admin.rule')->with('error', 'Rule tidak ditemukan');
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
            $rule = Rule::findOrFail($id);
            $rule->kepribadian_id = $request->input('kepribadian');
            $rule->indikasi_id = $request->input('indikasi');
            $rule->save();
        } catch (\Exception $e) {
            return redirect()->route('admin.rule')->with('error', 'Rule gagal diubah');
        }

        return redirect()->route('admin.rule')->with('success', 'Rule berhasil diubah');
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
            $rule = Rule::findOrFail($id);
            $rule->delete();
        } catch (\Exception $e) {
            return redirect()->route('admin.rule')->with('error', 'Rule gagal dihapus');
        }

        return redirect()->route('admin.rule')->with('success', 'Rule berhasil dihapus');
    }
}
