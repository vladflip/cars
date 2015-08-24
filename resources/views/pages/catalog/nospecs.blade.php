@extends('pages.catalog.catalog')

@section('catalog')

	<h3 class="catalog_type">Каталог</h3>

	@include('inc.type', ['id' => 'catalog-types'])

	@include('inc.makes.makes', ['id' => 'catalog-makes'])

@stop