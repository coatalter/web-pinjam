@extends('layouts.admin')

@section('content')
    @include('admin.test-parameters.create', ['testParameter' => $testParameter])
@endsection
