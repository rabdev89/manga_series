@extends('layouts.app')
@section('title', ucfirst(str_replace('-',' ',$slug)) . isset($params) ? 'Search Results' : ' Manga')

@section('content')
  <category-page cat="{{$slug}}" :params="{{isset($params) ? $params : collect([])}}"></category-page>
@endsection