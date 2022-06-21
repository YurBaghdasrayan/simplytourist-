<title>{{ isset($title) ? $title . ' - ' . config('app.name', 'Laravel') : config('app.name', 'SimplyTourIt') }}</title>
<meta name="description" content="{{ isset($description) ? $description : __('SimplyTourIt is a tour marketplace for travel enthusiasts, travel experts, and tour guides.') }}">
