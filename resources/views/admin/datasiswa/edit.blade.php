@extends('layouts.admin.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Edit indikasi No {{ $indikasi->id }}</h1>
        </div>
        <div class="section-body">
            <div class="pb-4">
                <a href="{{ route('admin.indikasi') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.indikasi.update', ['id' => $indikasi->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">indikasi</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name', $indikasi->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
    </section>
@endsection

@push('jsCustom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var input = document.getElementById('image');
            input.addEventListener('change', function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    var img = document.getElementById('imagePreview');
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });
        });
    </script>
@endpush
