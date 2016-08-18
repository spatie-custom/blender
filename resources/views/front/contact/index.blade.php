@extends('front._layouts.master')

@section('title', $article->seo('title'))
@section('meta', $article->renderMetaTags())

@section('content')

    <h1>{{ $article->title }}</h1>
    @include('front.contact._partials.form')

@endsection
