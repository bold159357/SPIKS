@extends('layouts.admin.app')

@push('cssLibraries')
    <link rel="stylesheet" href="{{ asset('assets/select2/dist/css/select2.min.css') }}">
@endpush

@push('jsLibraries')
    <script src="{{ asset('assets/select2/dist/js/select2.full.min.js') }}"></script>
@endpush

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Cek Kepribadian</h1>
        </div>
        <div class="section-body">
            <div class="pb-4">
                <a href="{{ route('admin.cek') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.cek.store') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="form-label">Pilih siswa</label>
                            <select name="kepribadian" id="kepribadian" required
                                class="form-control select2 @error('kepribadian') is-invalid @enderror">
                                <option value="" disabled selected>Nama Siswa</option>
                                @foreach ($kepribadian as $k)
                                    <option value="{{ $k->id }}">{{ $k->name }}</option>
                                @endforeach
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- <div class="form-group">
                            <label class="form-label">indikasi</label>
                            <select name="indikasi[]" multiple id="indikasi" required
                                class="form-control select2 @error('indikasi') is-invalid @enderror">
                                @foreach ($indikasi as $i)
                                    <option value="{{ $i->id }}">I{{ $i->id }}, {{ $i->name }}</option>
                                @endforeach
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
