<!DOCTYPE html>
<html lang="en">

@include('Back.layout_back._head')

<body class="g-sidenav-show  bg-gray-200">

    @include('Back.layout_back._sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        @include('Back.layout_back._navbar')

        <div class="container-fluid py-4">
            @yield('konten')
        </div>
    </main>
    @include('Back.layout_back._script')
</body>

</html>
