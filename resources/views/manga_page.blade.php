@extends('layouts.app')
@section('title', strtoupper(str_replace('-',' ',$slug)))

@section('content')
  <manga-page slug="{{$slug}}"></manga-page>
@endsection