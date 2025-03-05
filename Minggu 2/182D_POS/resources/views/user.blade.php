<!DOCTYPE html>
<html>
<head>
    <title>Profil Pengguna</title>
</head>
<body>
    <h1>Profil Pengguna</h1>
    <p>ID: {{ $id }}</p>
    <p>Nama: {{ $name }}</p>
    <a href="{{ url('/') }}">< Kembali ke Home</a>
</body>
</html>
