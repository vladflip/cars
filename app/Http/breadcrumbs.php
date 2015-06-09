<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs)
{
	$breadcrumbs->push('Главная', route('home'));
});

// Home > Catalog
Breadcrumbs::register('catalog', function($breadcrumbs, $c)
{
	$breadcrumbs->parent('home');

	$breadcrumbs->push('Каталог', route('catalog'));

	if($c) {

		if(isset($c['allmake'])){
			$breadcrumbs->push($c['allmake']->title, route('allmake', $c['allmake']->name));
		}

		if(isset($c['spec'])){

			$breadcrumbs->push($c['spec']->title, route('specs', $c['spec']->name));

			if(isset($c['make'])) {
				$breadcrumbs->push($c['make']->title, route('make', $c['make']->name));
			}

		}

	}

});

// Home > Catalog > Specs
// Breadcrumbs::register('specs', function($breadcrumbs,)
// {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('Specs', route('specs', ));
// });

// // Home > Blog > [Category]
// Breadcrumbs::register('category', function($breadcrumbs, $category)
// {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Page]
// Breadcrumbs::register('page', function($breadcrumbs, $page)
// {
//     $breadcrumbs->parent('category', $page->category);
//     $breadcrumbs->push($page->title, route('page', $page->id));
// });