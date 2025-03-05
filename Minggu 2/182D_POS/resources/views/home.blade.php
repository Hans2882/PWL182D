<!DOCTYPE html>
<html>
<head>
    <title>Home - POS</title>
</head>
<body>
    <h1>Selamat Datang di Web POS</h1>

    <nav>
        <ul>
            <li><a href="{{ url('/user/18/name/Gayuh') }}">Profil Saya</a></li>
            <li><a href="{{ url('/sales') }}">Halaman Penjualan</a></li>
            <li><a href="{{ url('/category/food-beverage') }}">Produk - Food & Beverage</a></li>
            <li><a href="{{ url('/category/beauty-health') }}">Produk - Beauty & Health</a></li>
            <li><a href="{{ url('/category/home-care') }}">Produk - Home Care</a></li>
            <li><a href="{{ url('/category/baby-kid') }}">Produk - Baby & Kid</a></li>
        </ul>
    </nav>
</body>
</html>
