@extends('layouts.pdf-layout')
@section('title', 'Data kepribadian')
@section('content')
    <table>
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>Nama</th>
                <th>Ciri ciri</th>
                <th>Solusi</th>
                <th>Tanggal Dibuat/Diubah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kepribadian as $p)
                <tr>
                    <td>
                        {{ $p['id'] }}
                    </td>
                    <td>{{ $p['name'] }}</td>
                    <td>{{ $p['reason'] }}</td>
                    <td>{{ $p['solution'] }}</td>
                    <td>{{ $p['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
