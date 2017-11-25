@extends('layouts.app')

@section('content')
  <artifact-table
    api-url="{{ route('api.v2.packs') }}"
  ></artifact-table>
@endsection
