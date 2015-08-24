@extends('pages.catalog.catalog')

@section('catalog')

	<h3 class="catalog_type">{{ $spec->title }}</h3>

	@include('inc.type', ['id' => 'catalog-types'])

	@include('inc.makes.makes', ['id' => 'catalog-specmakes'])

@stop