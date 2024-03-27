<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <header>
        <h3>LAPORAN RESTORAN</h3>
    </header>
    <section class="main">
        <table>
            <tr style="background-color:#7168f0">
                <th>NO</th>
                <th>ID TRANSAKSI</th>
                <th>ID PESANAN</th>
                <th>ID MENU</th>
                <th>NAMA MENU</th>
                <!-- <th>ID PELANGGAN</th>
                <th>NAMA PELANGGAN</th>
                <th>JUMLAH</th>
                <th>TOTAL</th>
                <th>BAYAR</th>
                <th>KEMBALIAN</th>-->
                <th>OPSI</th> 
            </tr>
            <?php
            include '../koneksi.php';

            $query_pesanan = "SELECT * FROM pesanan";
            $result_pesanan = $koneksi->query($query_pesanan);
            
            $query_transaksi = "SELECT total, bayar, id_transaksi, id_pesanan FROM transaksi";
            $result_transaksi = $koneksi->query($query_transaksi);
            
            $query_menu = "SELECT id_menu, nama_menu FROM menu";
            $result_menu = $koneksi->query($query_menu);
            
            $query_pelanggan = "SELECT id_pelanggan, nama_pelanggan FROM pelanggan";
            $result_pelanggan = $koneksi->query($query_pelanggan);
            
            if (!$result_pesanan || !$result_transaksi || !$result_menu || !$result_pelanggan) {
                // Jika query gagal dieksekusi, tampilkan pesan kesalahan
                echo "Error: " . $koneksi->error;
            } else {
                if ($result_pesanan->num_rows > 0) {
                    $no = 1;
                    while ($row_pesanan = $result_pesanan->fetch_assoc()) {
                        // Mencari data transaksi yang sesuai dengan id_pesanan pada pesanan
                        $total = "";
                        $bayar = "";
                        $id_transaksi = "";
                        $result_transaksi->data_seek(0); // Mengatur kursor kembali ke baris pertama
                        while ($row_transaksi = $result_transaksi->fetch_assoc()) {
                            if ($row_pesanan['id_pesanan'] == $row_transaksi['id_pesanan']) {
                                $total = $row_transaksi['total'];
                                $bayar = $row_transaksi['bayar'];
                                $id_transaksi = $row_transaksi['id_transaksi'];
                                break;
                            }
                        }
            
                        // Mencari data menu yang sesuai dengan id_menu pada pesanan
                        $nama_menu = "";
                        $result_menu->data_seek(0); // Mengatur kursor kembali ke baris pertama
                        while ($row_menu = $result_menu->fetch_assoc()) {
                            if ($row_pesanan['id_menu'] == $row_menu['id_menu']) {
                                $nama_menu = $row_menu['nama_menu'];
                                break;
                            }
                        }
            
                        // Mencari data pelanggan yang sesuai dengan id_pelanggan pada pesanan
                        $nama_pelanggan = "";
                        $result_pelanggan->data_seek(0); // Mengatur kursor kembali ke baris pertama
                        while ($row_pelanggan = $result_pelanggan->fetch_assoc()) {
                            if ($row_pesanan['id_pelanggan'] == $row_pelanggan['id_pelanggan']) {
                                $nama_pelanggan = $row_pelanggan['nama_pelanggan'];
                                break;
                            }
                        }
            
                        // Tampilkan data pesanan beserta data transaksi, menu, dan pelanggan
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row_pesanan['id_pesanan'] . "</td>";
                        echo "<td>" . $nama_menu . "</td>";
                        echo "<td>" . $nama_pelanggan . "</td>";
                        echo "<td>" . $row_pesanan['jumlah'] . "</td>";
                        echo "<td>" . $total . "</td>";
                        echo "<td>" . $bayar . "</td>";
                        echo "<td>" . $id_transaksi . "</td>";
                        echo "</tr>";

                        // Tampilkan data pesanan beserta data transaksi, menu, dan pelanggan
echo "<td>";
echo "<button class='btn-edit' onclick='editFunction(" . $row_pesanan['id_pesanan'] . ")'>Edit</button>";
echo "<button class='btn-delete' onclick='deleteFunction(" . $row_pesanan['id_pesanan'] . ")'>Hapus</button>";
echo "</td>";

                    }
                } else {
                    echo "Tidak ada data yang ditemukan.";
                }
            }
            

