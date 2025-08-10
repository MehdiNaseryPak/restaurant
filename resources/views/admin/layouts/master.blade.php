<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    @include('admin.layouts.head-tag')
</head>
<body class="small-navigation">
    @include('admin.layouts.sidebar')
	<!-- end::navigation -->
	<!-- begin::header -->
    @include('admin.layouts.header')
	<!-- end::header -->
	<!-- begin::main content -->
	<main class="main-content">
        @if ($errors->any())
        <div class="d-flex flex-column">
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endforeach
        </div>
        @endif
        @yield('content')
	</main>
    @include('admin.layouts.script')
</body>
</html>
