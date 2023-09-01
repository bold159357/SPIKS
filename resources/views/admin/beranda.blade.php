@extends('layouts.admin.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Beranda</h1>
        </div>
        @if (session()->exists('success-login-admin'))
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="hero bg-primary text-white">
                        <div class="hero-inner">
                            <h2>Selamat datang kembali, {{ auth()->user()->name }}!</h2>
                            <p class="lead">Disini adalah tempat untuk mengelola kepribadian, indikasi, rule, dan diagnosis</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-12 align-self-center px-3 px-sm-5" data-aos="fade-left" data-aos-anchor="body"
                    id="col2">
                    <h1 class="text-start font-bold ">
                        Sistem Pakar Identifikasi Kepribadian Siswa 
                        <button id="btn-diagnosis" class="btn btn-custom1 py-2">
                                    Mulai Cek Kepribadian
                        </button>
                    </h1>
                </div> 
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-primary">
                        <i class="far fa-user"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Pengguna</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahPengguna }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-danger">
                        <i class="fas fa-laptop"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Kepribadian</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahkepribadian }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-warning">
                        <i class="fas fa-flag"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Jumlah Indikasi</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahindikasi }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <div class="card card-statistic-1">
                    <div class="card-icon bg-success">
                        <i class="fas fa-stethoscope"></i>
                    </div>
                    <div class="card-wrap">
                        <div class="card-header">
                            <h4>Total Diagnosis</h4>
                        </div>
                        <div class="card-body">
                            {{ $jumlahDiagnosis }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Kelas</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="myChart1" height="200"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Total kepribadian Hasil Diagnosis</h4>
                    </div>
                    <div class="card-body">
                        @foreach ($diagnosiskepribadian as $key => $value)
                            <div class="mb-4">
                                <div class="text-small float-right font-weight-bold text-muted">{{ $value['count'] }}
                                </div>
                                <div class="font-weight-bold mb-1">
                                    @if ($value['kepribadian_id'] == null)
                                        <span class="text-danger">Lihat Detail</span>
                                    @else
                                        {{ $value['kepribadian'] }}
                                    @endif
                                </div>
                                <div class="progress" data-height="10">
                                    <div class="progress-bar" role="progressbar" data-width="{{ $value['count'] }}%"
                                        aria-valuenow="{{ $value['count'] }}" aria-valuemin="0" aria-valuemax="100">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('jsLibraries')
    <script src="{{ asset('assets/chart.js/dist/Chart.min.js') }}"></script>
@endpush

@push('jsCustom')
    <script>
        const chartkelas = @json($chartkelas);
        const chartkelasCount = [];
        const chartkelasLabel = [];

        for (const [key, value] of Object.entries(chartkelas)) {
            if (value.kelas != null) {
                chartkelasCount.push(value.count);
                chartkelasLabel.push(value.kelas);
            }
        }

        var ctx = document.getElementById("myChart1").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                datasets: [{
                    data: chartkelasCount,
                    backgroundColor: [
                        '#191d21',
                        '#63ed7a',
                        '#ffa426',
                        '#fc544b',
                        '#6777ef',
                    ],
                    label: 'Dataset 1'
                }],
                labels: chartkelasLabel,
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                legend: {
                    position: 'bottom',
                },
            }
        });
    </script>
@endpush

@push('styleLibraries')
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
            <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scriptPerPage')
            <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
            <script src="{{ asset('assets/chart.js/dist/Chart.min.js') }}"></script>
            <script src="{{ asset('spesified-assets/user/profile-modal.js') }}"></script>
            <script src="{{ asset('spesified-assets/user/detail-diagnosis-modal.js') }}"></script>
@endpush


@push('scriptPerPage')
    <script type="text/javascript">
        const isUser = @json(Auth::check() && Auth::user()->email_verified_at != null && Gate::check('asUser'));
        const hasUserProfile = @json(Auth::user()->profile->id ?? false);
        let login = @json(session('success') ?? false);
        const csrfToken = '{{ csrf_token() }}';
        const assetStoragekepribadian = '{{ asset('/storage/kepribadian/') }}';
        const assetStorageindikasi = '{{ asset('/storage/indikasi/') }}';
    </script>
@endpush