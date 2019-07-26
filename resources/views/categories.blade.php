@extends('layouts.app')
@section('title', $slug)

@section('content')
  <category-page cat="{{$slug}}"></category-page>
@endsection