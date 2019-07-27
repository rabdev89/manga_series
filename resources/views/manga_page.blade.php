@extends('layouts.app')
@section('title', ucfirst(str_replace('-',' ',$slug)))

@section('content')
  <manga-page slug="{{$slug}}"></manga-page>
@endsection