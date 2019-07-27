@extends('layouts.app')
@section('title', ucfirst(str_replace('-',' ',$slug)) .' Manga')

@section('content')
  <category-page cat="{{$slug}}"></category-page>
@endsection