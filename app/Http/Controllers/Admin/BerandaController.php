<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\sekolahController;
use App\Models\Diagnosis;
use App\Models\indikasi;
use App\Models\kepribadian;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request as HttpRequest;

class BerandaController extends Controller
{
    public function index()
    {
        $data = [
            'loginDuration' => $this->LoginDuration(),
            'jumlahPengguna' => $this->jumlahPengguna(),
            'jumlahkepribadian' => $this->jumlahkepribadian(),
            'jumlahindikasi' => $this->jumlahindikasi(),
            'jumlahDiagnosis' => $this->jumlahDiagnosis(),
            'chartkelas' => $this->chartkelas(),
            'diagnosiskepribadian' => $this->diagnosiskepribadian(),
        ];

        return view('admin.beranda', $data);
    }

    public function jumlahPengguna()
    {
        $jumlahPengguna = User::count();
        return $jumlahPengguna;
    }

    public function jumlahkepribadian()
    {
        $jumlahkepribadian = kepribadian::count();
        return $jumlahkepribadian;
    }

    public function jumlahindikasi()
    {
        $jumlahindikasi = indikasi::count();
        return $jumlahindikasi;
    }

    public function jumlahDiagnosis()
    {
        $jumlahDiagnosis = Diagnosis::count();
        return $jumlahDiagnosis;
    }

    // public function chartgender()
    // {
    //     $data = UserProfile::selectRaw('count(*) as count, gender')
    //         ->groupBy('gender')
    //         ->get()->toArray();
    //     $indexgender = new sekolahController();
    //     $gender = $indexgender->indexgender();
    //     $gender = json_decode(json_encode($gender), true);


    //     return $data;
    // }

    // public function chartCity()
    // {
    //     $data = UserProfile::selectRaw('count(*) as count, city')->groupBy('city')->get()->toArray();

    //     $userProfileCity = array_column($data, 'city'); // Mengambil semua id dari hasil query
    //     $userProfiles = UserProfile::whereIn('city', $userProfileCity)->get('gender')->toArray();
    //     $indexCity = new sekolahController();

    //     $request = new HttpRequest();

    //     return $data;
    // }

    public function chartkelas()
    {
        $data = UserProfile::selectRaw('count(*) as count, kelas')->groupBy('kelas')->get()->toArray();
        return $data;
    }

    public function diagnosiskepribadian()
    {
        $data = Diagnosis::selectRaw('count(*) as count, kepribadian_id')->groupBy('kepribadian_id')->get()->toArray();
        $kepribadian = kepribadian::get(['id', 'name'])->toArray();
        $kepribadian = array_column($kepribadian, 'name', 'id');
        $data = array_map(function ($item) use ($kepribadian) {
            $item['kepribadian'] = $kepribadian[$item['kepribadian_id']] ?? null;
            return $item;
        }, $data);
        return $data;
    }
}
