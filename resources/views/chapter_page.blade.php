@extends('layouts.app')
@section('title', ucfirst(str_replace('-',' ',$slug)).' Chapter '.$chapterNo)

@section('content')
  <chapter-page slug="{{$slug}}" init-chapter-no="{{$chapterNo}}"></chapter-page>
@endsection