@extends('layouts.admin.app')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Halaman Edit kepribadian No {{ $kepribadian->id }}</h1>
        </div>
        <div class="section-body">
            <div class="pb-4">
                <a href="{{ route('admin.kepribadian') }}" class="btn btn-secondary">Kembali</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.kepribadian.update', ['id' => $kepribadian->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label class="form-label">Nama kepribadian</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                id="name" value="{{ old('name', $kepribadian->name) }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Ciri Ciri Kepribadian</label>
                            <input type="text" class="form-control @error('reason') is-invalid @enderror" name="reason"
                                id="reason" value="{{ old('reason', $kepribadian->reason) }}">
                            @error('reason')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Solusi</label>
                            <textarea name="solution" class="form-control" id="solution" style="height: 200px">{{ old('solution', $kepribadian->solution) }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
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
