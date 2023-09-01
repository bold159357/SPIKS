@extends('layouts.pdf-layout')
@section('title', 'Data indikasi')
@section('content')
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>Nama</th>
                <th>Tanggal Dibuat/Diubah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($indikasi as $p)
                <tr>
                    <td>
                        {{ $p['id'] }}
                    </td>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
