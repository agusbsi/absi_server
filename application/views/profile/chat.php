<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>ABSI | Chats</title>
    <link href="<?= base_url() ?>/assets/img/app/icon_absi.png" rel="icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/dist/css/adminlte.min.css">

    <style>
        .footer {
            border-top: 1px solid #007bff;
        }

        .chat-button {
            display: none;
        }

        .breadcrumb {
            display: none;
        }

        .judul {
            width: 100%;
            height: auto;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Ensure the profile image and dropdown are styled appropriately */
        .img-profil {
            cursor: pointer;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .dropdown-menu {
            display: none;
            /* Initially hide the dropdown */
            position: absolute;
            right: 0;
            margin-top: 5px;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-menu.show {
            display: block;
            /* Show the dropdown when active */
        }


        .body-chat {
            display: flex;
            width: 100%;
            height: 500px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .sisiKiri {
            width: 30%;
            max-width: 350px;
            background-color: rgb(242, 242, 242, 0.3);
            border-right: 1px solid #DDD;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease-in-out;
        }

        .menu-bar {
            width: 40px;
            height: 40px;
            display: none;
            padding: 10px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            text-align: center;
            border-radius: 50%;
            margin: 10px;
        }

        .menu-tutup {
            display: none;
            color: #FFFFFF;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .sisiKiri {
                position: fixed;
                width: 95%;
                max-width: none;
                height: 100%;
                background-color: #FFF;
                z-index: 10;
                box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
                transform: translateX(-110%);
            }

            .chat-window {
                flex: 1;
            }

            .menu-bar {
                display: block;
            }

            .menu-tutup {
                display: block;
            }

            .sisiKiri-header {
                border-top-right-radius: 10px;
            }

            .chat-header {
                border-top-left-radius: 10px;
            }

            .body-chat {
                width: 100%;
            }
        }

        .sisiKiri-header {
            padding: 15px;
            background-color: rgb(0, 123, 255);
            border-bottom: 1px solid #DDD;
            font-weight: bold;
            font-size: 18px;
            border-top-left-radius: 10px;
            color: #f7f7f7;
            display: flex;
            justify-content: space-between;
        }

        .pencarian {
            padding: 10px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 5px;
        }

        .pencarian i {
            color: #a8a8a8;
        }

        .pencarian input {
            width: 100%;
            padding: 5px;
            border: 1px solid #CCC;
            font-size: 12px;
            border-radius: 5px;
        }

        .chat-list {
            flex: 1;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #888 #e0e0e0;
        }

        .chat-list::-webkit-scrollbar {
            width: 8px;
        }

        .chat-list::-webkit-scrollbar-thumb {
            background-color: #888;
            border-radius: 10px;
        }

        .chat-list::-webkit-scrollbar-thumb:hover {
            background-color: #555;
        }

        .chat-list::-webkit-scrollbar-track {
            background-color: #e0e0e0;
            border-radius: 10px;
        }

        .chat-item {
            padding: 10px 15px;
            border-bottom: 1px solid #DDD;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .chat-item:hover {
            background-color: #E0E0E0;
        }

        .chat-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .chat-item .chat-info {
            flex: 1;
        }

        .chat-item .chat-info .name.active {
            color: #007bff;
            font-weight: bold;
        }

        .chat-item .chat-info .name {
            font-weight: normal;
            font-size: 16px;
        }

        .chat-item .chat-info .last-message {
            color: #888;
            font-size: 14px;
        }

        .chat-item .chat-time {
            color: #888;
            font-size: 12px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .notification-badge {
            background-color: #007bff;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 10px;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 5px;
        }


        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            padding: 10px;
            background-color: rgb(0, 123, 255, 0.2);
            border-bottom: 1px solid #DDD;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            border-top-right-radius: 10px;
        }

        .chat-header img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .messages {
            flex: 1;
            padding: 20px;
            background-color: #EFEFEF;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            scrollbar-width: thin;
            scrollbar-color: #888 #e0e0e0;
        }

        .message {
            margin-bottom: 3px;
            max-width: 60%;
            padding: 8px;
            border-radius: 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            /* Atur flexbox untuk kolom */
        }

        .message.sent {
            background-color: #DCF8C6;
            align-self: flex-end;
        }

        .message.received {
            background-color: #FFFFFF;
            border: 1px solid #DDD;
            align-self: flex-start;
        }

        .message .text {
            font-size: 14px;
            margin-bottom: 3px;
        }

        .message .time {
            font-size: 12px;
            color: #888;
            align-self: flex-end;
            /* Pastikan time selalu di bagian bawah */
            margin-top: auto;
            /* Tambahkan margin top otomatis untuk mendorong time ke bawah */
        }


        .message.sent .Terkirim {
            color: #888;
        }

        .message.sent .Terbaca {
            color: #007bff;
        }


        .message-input {
            padding: 10px;
            background-color: #ECECEC;
            border-top: 1px solid #DDD;
            display: flex;
            align-items: center;
        }

        .message-input textarea {
            flex: 1;
            padding: 10px;
            border: 1px solid #CCC;
            border-radius: 10px;
            margin-right: 10px;
            font-size: 14px;
            resize: none;
        }

        .message-input button {
            background-color: #00A859;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 16px;
        }

        .mulai_chat {
            margin-top: 50px;
            padding: 20px;
        }

        .mulai_chat img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 10px;
            border: 3px solid #007bff;
            padding: 2px;
        }

        .mulai_chat strong {
            display: block;
        }

        /* mulai */
        .new-chat {
            width: 95%;
            height: auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 15px;
            font-family: Arial, sans-serif;
            top: 10px;
            left: 0;
            z-index: 1000;
        }

        .header {
            display: flex;
            justify-content: space-between;
        }

        .header h3 {
            font-size: 18px;
            color: #333;
        }

        .menu-options {
            margin-top: 15px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }

        .option-item {
            display: flex;
            align-items: center;
            margin-top: 10px;
            cursor: pointer;
        }

        .option-item i {
            font-size: 20px;
            margin-right: 10px;
            color: #007bff;
        }

        .option-item span {
            font-size: 16px;
            color: #007bff;
        }

        .contact-list {
            margin-top: 15px;
            margin-left: 13px;
            height: 300px;
            overflow-y: auto;
        }

        .new-chat h4 {
            margin: 10px 0;
            font-size: 14px;
            color: #555;
        }

        .contact-item {
            display: flex;
            align-items: center;
            margin-top: 10px;
            cursor: pointer;
        }

        .contact-item img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 1px solid #ddd;
        }

        .contact-info {
            flex: 1;
        }

        .contact-info .name {
            font-size: 13px;
            color: #333;
        }

        .contact-info .status {
            font-size: 12px;
            color: #777;
        }

        .contact-info .status span {
            color: red;
        }

        /* end */
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="judul">
                    <a href="<?= base_url('profile/dashboard') ?>"><i class="fas fa-arrow-left"></i> Dashboard</a>
                    <div class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <?php if (!empty($foto)) { ?>
                                <img src="<?= base_url('assets/img/user/' . $foto) ?>" alt="akun" class="img-profil" title="Akun Anda">
                            <?php } else { ?>
                                <img src="<?= base_url() ?>assets/img/user.png" alt="akun" class="img-profil" title="Akun Anda">
                            <?php } ?>
                            <i class="fas fa-caret-down ml-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right ">
                            <span class="dropdown-item dropdown-header">Akun</span>
                            <div class="dropdown-divider"></div>
                            <a href="<?= base_url('profile') ?>" class="dropdown-item">
                                <i class="fas fa-user mr-1"></i> Profil
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="javascript:void(0)" class="dropdown-item" onclick="logout()">
                                <i class="fas fa-sign-out-alt mr-1"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
                <div class="body-chat">
                    <div class="sisiKiri">
                        <div class="sisiKiri-header">Chats
                            <div class="row" style="gap: 30px;">
                                <div><i class="fas fa-edit" id="newChatIcon" title="Chat Baru" style="cursor:pointer;"></i></div>
                                <div class="menu-tutup mr-3">
                                    <i class="fas fa-times" title="Tutup"></i>
                                </div>
                            </div>
                        </div>
                        <!-- mulai -->
                        <div class="new-chat" id="chatListContainer" style="display:none;">
                            <div class="header">
                                <h3>Chat baru</h3>
                                <i class="fas fa-times" id="tutup_newchat" title="Tutup" style="cursor:pointer;"></i>
                            </div>
                            <div class="pencarian">
                                <input type="search" id="searchUser" placeholder="Cari Semua Kontak disini..." autocomplete="off">
                                <i class="fas fa-search"></i>
                            </div>
                            <h4>Saran Kontak</h4>
                            <div class="contact-list" id="chatList">
                            </div>
                        </div>
                        <!-- end -->
                        <div class="pencarian">
                            <input type="search" id="cariKontak" placeholder="Cari kontak yang pernah berkirim pesan.." autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                        <div class="chat-list" id="list_chat">

                        </div>
                    </div>
                    <div class="chat-window">
                        <div class="chat-header" id="chat-header">
                            <div class="menu-bar">
                                <i class="fas fa-bars"></i>
                            </div>
                            <div id="gbrHeader"></div>
                            <strong class="name"></strong>
                            <input type="hidden" name="penerima" id="penerima">
                        </div>
                        <div class="messages" id="messages">
                            <div class="text-center mulai_chat">
                                <img src="<?= base_url() ?>/assets/img/app/icon_absi.png" alt="">
                                <strong>ABSI CHAT</strong>
                                <small>Mulailah percakapan dengan tim ABSI</small>
                            </div>
                        </div>
                        <div class="message-input d-none" id="tempat_chat">
                            <textarea name="pesan" class="input_pesan" placeholder="Ketik pesan disini..." id="input_pesan"></textarea>
                            <button onclick="sendMessage()"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="<?= base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        let ws = new WebSocket("wss://absiwebsocket.pepri.site");
        const id_pengirim = "<?php echo $this->session->userdata('id'); ?>";

        // Ketika pesan baru diterima dari WebSocket server
        ws.onmessage = function(event) {
            let message = JSON.parse(event.data);
            let formattedTime = formatTime(new Date().toISOString());
            let tipe = message.pengirim == id_pengirim ? 'sent' : 'received';
            let status_pesan = 'Terkirim'; // Assuming status is part of the message
            appendMessage(message.pesan, formattedTime, tipe, status_pesan);
        };
        // Memuat pesan ketika halaman dimuat
        window.onload = function() {
            loadList();
        };

        function loadList() {
            fetch("<?= base_url('Profile/list_chat'); ?>")
                .then(response => response.json())
                .then(data => {
                    let chatList = document.getElementById('chatList');
                    chatList.innerHTML = ''; // Clear previous list
                    data.forEach(message => {
                        let formattedTime = formatTime(message.tanggal_terakhir);
                        listChat(message.foto_diri, message.user_id, message.nama_user, message.pesan_terakhir, formattedTime, message.unread_count);
                    });
                });
        }
        // Menambahkan pesan ke dalam tampilan chat
        function listChat(foto, id_user, nama_user, pesan, waktu, notif) {
            let chatList = document.getElementById('list_chat');
            if (!chatList) {
                console.error('Element with ID chat-list not found');
                return;
            }

            let fotoProfil = foto ? `<?= base_url('assets/img/user/') ?>${foto}` : 'https://via.placeholder.com/40';

            // Potong pesan jika lebih dari 25 karakter
            let truncatedPesan = pesan.length > 25 ? pesan.substring(0, 40) + '...' : pesan;

            let messageHtml = `
                <div class="chat-item" data-user-id="${id_user}" onclick="handleClick(${id_user})">
                    <img src="${fotoProfil}" alt="Profile">
                    <div class="chat-info">
                        <div class="name ${notif > 0 ? 'active' : ''}">${nama_user}</div>
                        <div class="last-message">${truncatedPesan}</div>
                    </div>
                    <div class="chat-time">
                        ${waktu}
                        <div class="notification-badge ${notif > 0 ? '' : 'd-none'}">${notif}</div>
                    </div>
                </div>`;
            chatList.innerHTML += messageHtml;
        }

        // Mengirim pesan dan menyimpannya ke database
        function sendMessage() {
            let penerima = document.getElementById('penerima').value;
            let message = document.getElementById('input_pesan').value;
            fetch("<?php echo site_url('Profile/send_message'); ?>", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'penerima=' + encodeURIComponent(penerima) + '&message=' + encodeURIComponent(message)
            }).then(response => response.json()).then(data => {
                if (data.status === 'success') {
                    // Kirim pesan melalui WebSocket setelah berhasil disimpan di database
                    ws.send(JSON.stringify({
                        pesan: data.pesan,
                        pengirim: id_pengirim,
                        status: data.status,
                        penerima: penerima
                    }));
                    document.getElementById('input_pesan').value = '';
                }
            });
        }
        // Menambahkan pesan ke dalam tampilan chat
        function appendMessage(pesan, time, tipe, status_pesan) {
            let messagesDiv = document.getElementById('messages');
            let messageHtml = `
                <div class="message ${tipe}">
                    <div class="text">${pesan}</div>
                    <div class="time">${time}
                    <small class="${status_pesan} ${tipe == 'received' ? 'd-none':''}">${status_pesan}</small>
                    </div>
                </div>`;
            messagesDiv.innerHTML += messageHtml;
            messagesDiv.scrollTop = messagesDiv.scrollHeight; // Auto-scroll ke bawah
        }

        function loadMessages(id_user) {
            fetch("<?= base_url('Profile/get_messages'); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        pengirim: id_user
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    let chatWindow = document.getElementById('messages');
                    chatWindow.innerHTML = ''; // Bersihkan pesan lama

                    // Ambil data pengirim dari response
                    let namaUser = data.pengirim || ''; // Nama pengirim
                    let fotoPengirim = data.foto_pengirim ? `<?= base_url('assets/img/user/') ?>${data.foto_pengirim}` : 'https://via.placeholder.com/40'; // Foto pengirim

                    // Set nama pengirim di chat header
                    document.querySelector('.chat-header .name').textContent = namaUser;

                    let gbrHeader = document.getElementById('gbrHeader');

                    // Tambahkan gambar ke chat header
                    let gbr = `<img src="${fotoPengirim}" alt="Profile" id="foto_pengirim">`;
                    gbrHeader.innerHTML = gbr;

                    document.getElementById('penerima').value = id_user;

                    // Tampilkan pesan-pesan
                    data.chat.forEach(message => {
                        let formattedTime = formatTime(message.waktu);
                        let tipe = message.pengirim == id_pengirim ? 'sent' : 'received';
                        let status_pesan = message.status == 0 ? 'Terkirim' : 'Terbaca';
                        appendMessage(message.pesan, formattedTime, tipe, status_pesan);
                    });
                })
                .catch(error => console.error('Error:', error));

        }
        // Optional: Menangani event "Enter" pada input untuk mengirim pesan
        document.getElementById('input_pesan').addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevents default behavior like adding a new line
                sendMessage();
            }
        });

        function handleClick(id_user) {
            // Menjalankan loadMessages
            loadMessages(id_user);
            $('#tempat_chat').removeClass('d-none');
            let chatListContainer = document.getElementById('chatListContainer');
            chatListContainer.style.display = 'none';
            // Memeriksa apakah lebar layar adalah untuk ponsel
            if (window.innerWidth <= 768) {
                const sisiKiri = document.querySelector('.sisiKiri');
                if (sisiKiri.style.transform === 'translateX(0%)') {
                    sisiKiri.style.transform = 'translateX(-110%)';
                } else {
                    sisiKiri.style.transform = 'translateX(0%)'; // Tampilkan sisiKiri
                }
            }
        }
    </script>
    <script>
        // Fungsi untuk memformat pesan
        function formatMessage(pesan) {
            if (pesan.length > 20) {
                return pesan.substring(0, 20) + '...';
            }
            return pesan || '';
        }

        function formatTime(dateString) {
            let date = new Date(dateString);
            let now = new Date();

            // Mengatur waktu ke tengah malam untuk perbandingan hari
            let today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            let yesterday = new Date(today);
            yesterday.setDate(today.getDate() - 1);

            let hours = date.getHours();
            let minutes = date.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12; // Jam 0 menjadi 12
            minutes = minutes < 10 ? '0' + minutes : minutes;
            let strTime = hours + ':' + minutes + ' ' + ampm;

            if (date >= today) {
                // Hari ini, tampilkan jam dan menit
                return strTime;
            } else if (date >= yesterday) {
                // Kemarin, tampilkan "Kemarin"
                return 'Kemarin ' + strTime;
            } else {
                // Lebih lama dari kemarin, tampilkan tanggal dan waktu
                let day = date.getDate();
                let month = date.getMonth() + 1; // Januari adalah 0!
                let year = date.getFullYear();
                let strDate = day + '/' + month + '/' + year;
                return strDate + ' ' + strTime;
            }
        }
    </script>
    <script>
        document.getElementById('cariKontak').addEventListener('input', function() {
            let filter = this.value.toLowerCase();
            let chatItems = document.querySelectorAll('#list_chat .chat-item');

            chatItems.forEach(function(item) {
                let userName = item.querySelector('.name').textContent.toLowerCase();
                if (userName.includes(filter)) {
                    item.style.display = ''; // Tampilkan chat-item
                } else {
                    item.style.display = 'none'; // Sembunyikan chat-item
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var profileImage = document.querySelector('.img-profil');
            var dropdownMenu = document.querySelector('.dropdown-menu');
            profileImage.addEventListener('click', function(event) {
                event.stopPropagation();
                dropdownMenu.classList.toggle('show');
            });
            document.addEventListener('click', function(event) {
                if (!profileImage.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
        document.querySelector('.menu-bar').addEventListener('click', function() {
            const sisiKiri = document.querySelector('.sisiKiri');
            if (sisiKiri.style.transform === 'translateX(0%)') {
                sisiKiri.style.transform = 'translateX(-110%)';
            } else {
                sisiKiri.style.transform = 'translateX(0%)'; // Tampilkan sisiKiri
            }
        });
        document.querySelector('.menu-tutup').addEventListener('click', function() {
            const sisiKiri = document.querySelector('.sisiKiri');
            if (sisiKiri.style.transform === 'translateX(0%)') {
                sisiKiri.style.transform = 'translateX(-110%)';
            } else {
                sisiKiri.style.transform = 'translateX(0%)'; // Tampilkan sisiKiri
            }
        });



        function logout() {
            let timerInterval;
            Swal.fire({
                title: 'Konfirmasi',
                text: 'Apakah anda yakin ingin keluar aplikasi?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yakin',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.value) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Berhasil Logout!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500,
                    }).then(() => {
                        window.location.href = '<?= base_url('profile/logout') ?>';

                    })
                }
            })
        }
    </script>
    <script>
        document.getElementById('newChatIcon').addEventListener('click', function() {
            fetch("<?= base_url('Profile/getUserList'); ?>")
                .then(response => response.json())
                .then(data => {
                    let chatListContainer = document.getElementById('chatListContainer');
                    chatListContainer.style.display = 'block'; // Menampilkan kolom list

                    let chatList = document.getElementById('chatList');
                    chatList.innerHTML = ''; // Kosongkan daftar sebelumnya
                    data.forEach(user => {
                        let listItem = `
                         <div class="contact-item" onclick="handleClick(${user.id_user})">
                         <img src="${user.foto_diri ? '<?= base_url('assets/img/user/') ?>' + user.foto_diri : 'https://via.placeholder.com/40'}" alt="Profile Image">
                                    <div class="contact-info">
                                        <div class="name">${user.nama_user}</div>
                                        <div class="status">${user.roleAkses}</div>
                                    </div>
                        </div>
                    `;
                        chatList.innerHTML += listItem;
                    });
                });
        });
        document.getElementById('tutup_newchat').addEventListener('click', function() {
            let chatListContainer = document.getElementById('chatListContainer');
            chatListContainer.style.display = 'none';
        });
        // Pencarian pengguna di daftar chat
        document.getElementById('searchUser').addEventListener('input', function() {
            var keyword = this.value;

            fetch('<?= base_url("Profile/search_user") ?>?keyword=' + keyword)
                .then(response => response.json())
                .then(users => {
                    let chatList = document.getElementById('chatList');
                    chatList.innerHTML = ''; // Kosongkan daftar sebelumnya

                    users.forEach(user => {
                        let listItem = `
                    <div class="contact-item" onclick="handleClick(${user.id_user})">
                        <img src="${user.foto_diri ? '<?= base_url('assets/img/user/') ?>' + user.foto_diri : 'https://via.placeholder.com/40'}" alt="Profile Image">
                        <div class="contact-info">
                            <div class="name">${user.nama_user}</div>
                            <div class="status">${user.roleAkses}</div>
                        </div>
                    </div>
                `;
                        chatList.innerHTML += listItem;
                    });
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>
<div class="text-center footer">
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#">ABSI</a>.</strong>
</div>

</html>