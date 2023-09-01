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
            <h1>Halaman Ubah Aturan No {{ $rule['id'] }}</h1>
        </div>
        <div class="section-body">
            <div class="pb-4">
                <a href="{{ route('admin.rule') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.rule.update', $rule['id']) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">kepribadian</label>
                            <select name="kepribadian" id="kepribadian" required
                                class="form-control select2 @error('kepribadian') is-invalid @enderror">
                                <option value="" disabled selected>Pilih kepribadian</option>
                                @foreach ($kepribadian as $p)
                                    <option value="{{ $p->id }}" @if ($p->id == $rule['kepribadian_id']) selected @endif>
                                        {{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">indikasi</label>
                            <select name="indikasi" id="indikasi" required
                                class="form-control select2 @error('indikasi') is-invalid @enderror">
                                @foreach ($indikasi as $g)
                                    <option value="{{ $g->id }}" @if ($g->id == $rule['indikasi_id']) selected @endif>
                                        G{{ $g->id }}, {{ $g->name }}</option>
                                @endforeach
                            </select>
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
