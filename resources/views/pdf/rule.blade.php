@extends('layouts.pdf-layout')
@section('title', 'Data Rule')
@section('content')
    <table>
        <thead>
            <tr>
                <th>
                    No
                </th>
                <th>Kepribadian</th>
                <th>Indikasi</th>
                <th>Tanggal Dibuat/Diubah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rules as $rule)
                <tr>
                    <td>
                        {{ $rule['id'] }}
                    </td>
                    <td>{{ $rule['kepribadian']['name'] }}</td>
                    <td>{{ $rule['indikasi']['name'] }}</td>
                    <td>{{ $rule['updated_at'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
