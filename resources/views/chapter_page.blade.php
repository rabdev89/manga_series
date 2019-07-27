@extends('layouts.app')
@section('title', strtoupper(str_replace('-',' ',$slug)).' Chapter '.$chapterNo)

@section('content')
  <chapter-page slug="{{$slug}}" init-chapter-no="{{$chapterNo}}"></chapter-page>
@endsection