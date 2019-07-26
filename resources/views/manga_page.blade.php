@extends('layouts.app')
@section('title', $slug)

@section('content')
  <manga-page slug="{{$slug}}"></manga-page>
@endsection