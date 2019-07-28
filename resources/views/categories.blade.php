@extends('layouts.app')
@section('title', isset($params) ? 'Search Results' : ucfirst(str_replace('-',' ',$slug)).' Manga')

@section('content')
  <category-page cat="{{$slug}}" :params="{{isset($params) ? $params : collect([])}}"></category-page>
@endsection