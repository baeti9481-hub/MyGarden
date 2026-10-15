<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Autocomplete RajaOngkir dengan Select2</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: auto !important;
            min-width: 500px;
            max-width: 100%;
        }
    </style>

    <style>
        .spinner {
            margin: 0 auto 10px auto;
            width: 40px;
            height: 40px;
            border: 5px solid #ccc;
            border-top: 5px solid #28a745;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>
    <h3>Pilih Lokasi Otomatis</h3>

    <label for="originSelect">Kota Asal :</label><br>
    <select id="originSelect" style="width:auto"></select><br><br>

    <label for="destinationSelect">Kota Tujuan :</label><br>
    <select id="destinationSelect" style="width:auto"></select><br><br>

    <label for="weight">Berat :</label><br>
    <input type="number" name="weight" id="weight" placeholder="Berat (gram)"><br><br>

    <label for="kurir">Kurir :</label><br>
    <select name="kurir" id="kurir">
        <option value="">Pilih Kurir</option>
        <option value="jne">JNE</option>
        <option value="tiki">TIKI</option>
        <option value="pos">POS Indonesia</option>
    </select><br><br>

    <button type="button" id="checkShipping">Cek Ongkir</button><br><br>

    <div id="loading" style="display: none; text-align: center; margin-top: 20px;">
        <div class="spinner"></div>
        <p>Mohon tunggu, sedang memuat ongkir...</p>
    </div>

    <div id="ongkirResult" style="border: 1px solid #ddd; padding: 10px;"></div>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function initSelect2(id, placeholder) {
            $('#' + id).select2({
                width: 'resolve',
                placeholder: placeholder,
                minimumInputLength: 2,
                ajax: {
                    url: '/ongkir/get-destination',
                    dataType: 'json',
                    delay: 500,
                    data: function(params) {
                        return {
                            search: params.term
                        };
                    },
                    processResults: function(data) {
                        console.log("Response API untuk", id, data);
                        if (data.data) {
                            const results = data.data.slice(0, 10).map(item => ({
                                id: item.id,
                                text: item.label + " (" + item.id + ")"
                            }));
                            return {
                                results
                            };
                        } else {
                            console.warn("Data kosong:", data);
                            return {
                                results: []
                            };
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(`Error loading ${id}:`, error);
                    }
                }
            });
        }

        $(document).ready(function() {
            initSelect2('originSelect', 'Ketik kecamatan/kota asal...');
            initSelect2('destinationSelect', 'Ketik kecamatan/kota tujuan...');

            // ✅ Handler tombol PENGECEKAN ongkir DITARUH DI SINI
            $('#checkShipping').click(function() {
                const origin = $('#originSelect').val();
                const destination = $('#destinationSelect').val();
                const weight = $('#weight').val();
                const courier = $('#kurir').val();

                if (!origin || !destination || !weight || !courier) {
                    alert("Mohon lengkapi semua field.");
                    return;
                }

                const formData = `origin=${origin}&destination=${destination}&weight=${weight}&courier=${courier}&price=lowest`;
                console.log("Form Data:", formData);

                document.getElementById('loading').style.display = 'block'; //menampilkan loading

                $.ajax({
                    url: '/ongkir/calculate',
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        document.getElementById('loading').style.display = 'none'; //menutup loading

                        console.log("Hasil Ongkir:", response);
                        if (response.data) {
                            let html = `<strong>Daftar Layanan (${courier.toUpperCase()}):</strong><ul>`;

                            response.data.forEach(service => {
                                html += `<li>
                        <strong>${service.service}</strong> - ${service.description}
                        | <b>Rp${service.cost.toLocaleString()}</b> (${service.etd})
                    </li>`;
                            });
                            html += '</ul>';
                            $('#ongkirResult').html(html);
                        } else {
                            $('#ongkirResult').html("<em>Tidak ada data ongkir ditemukan.</em>");
                        }
                    },
                    error: function(xhr, status, error) {
                        document.getElementById('loading').style.display = 'none'; //menutup loading

                        console.error("Error ongkir:", error);
                        $('#ongkirResult').html("<em>Terjadi kesalahan saat mengambil ongkir.</em>");
                    }
                });
            });

        });
    </script>
</body>

</html>