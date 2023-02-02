<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display</title>
    <link href="{{asset('display')}}/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{asset('display')}}/css/font-awesome.min.css" rel="stylesheet">
    <link href="{{asset('display')}}/css/style.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
	<style>
		.slider .slick-slide {
			padding: 20px;
		}
		.content-slide {
			height: 48vw;
			width: 70vw;
			position: fixed;
			top: 2vw;
    		right: 2vw;
		}
		#slideKas {
			font-size: 40px;
			color: #33cccc;
			font-weight: bold;
		}
		hr {
            background-color:white;
            border-width:0;
			margin: 3px 0;
        }
        hr.s1 {
            border-top:2px solid #33cccc;
        }
		.cop {
            padding: 0 0 15px 15px;
			height: 3.5vw;
    		width: auto;
			position: fixed;
			bottom: 2vh;
        }
        .tengah {
			padding-left: 20px;
        }
	</style>
</head>

<body>
    <div id="preloader">
      <div id="status">&nbsp;</div>
    </div>

	<div id="display-sholat" class="full-screen d-none">
		<div>
			<br/>
			<center>
				<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;" id="nama_sholat_time"></h1>
			</center>
		</div>
	</div>
	
	<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="">
	  	<!-- Overlay -->
		<div class="overlay"></div>
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
		</div> 
	</div>
	
	
	<div id="left-container">
		<div id="jam"></div>
		<div id="tgl"></div>
		<div id="jadwal"></div>
		<div class="cop">
			<table width="100%">
				<tr>
					<td width="10px">
						<img src="{{asset('vendor/adminlte/dist/img/logo.png')}}" width="50px">
					</td>
					<td class="tengah">
						<h5 style="font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">BKM Al-Furqan</h5>
						<h6 style="font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Beurawe - Banda Aceh</h6>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
    <div id="right-container">
		<div class="content-slide">
			<div class="slider" id="slider">
				<p>Loading Slide...</p>
			</div>
		</div>
		
		<div id="running-text">
			<div class="item">
				<marquee>
					<div id="runningText" style="font-weight: 900;"></div>
				</marquee>
			</div>
		</div>
	</div>

	<input type="hidden" value="" id="revision_id" required>
	<input type="hidden" value="" id="date_active" required>

	<input type="hidden" value="" id="time_subuh" required>
	<input type="hidden" value="" id="time_dzuhur" required>
	<input type="hidden" value="" id="time_ashar" required>
	<input type="hidden" value="" id="time_maghrib" required>
	<input type="hidden" value="" id="time_isya" required>
    
    <script src="{{asset('display')}}/js/jquery-3.4.1.min.js"></script>
    <script src="{{asset('display')}}/js/bootstrap.min.js"></script>
    <script src="{{asset('display')}}/js/custom.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $( document ).ready(function() {
            liveTime();
            liveDay();
            ajaxGetJadwalSholat();
			ajaxSlide();
			$('#preloader').delay(350).fadeOut('slow');
			
			setInterval(function(){
				checkUpdate();
			},10000);
        });

		function checkSholat(){
			// var t_subuh = '01:50';
			var t_subuh = $('#time_subuh').val();
			var t_dzuhur = $('#time_dzuhur').val();
			var t_ashar = $('#time_ashar').val();
			var t_maghrib = $('#time_maghrib').val();
			var t_isya = $('#time_isya').val();

			t_subuh = parseInt(t_subuh.replace(':', ''));
			t_dzuhur = parseInt(t_dzuhur.replace(':', ''));
			t_ashar = parseInt(t_ashar.replace(':', ''));
			t_maghrib = parseInt(t_maghrib.replace(':', ''));
			t_isya = parseInt(t_isya.replace(':', ''));

			var todays = new Date();
			var hh = todays.getHours();
			var mm = todays.getMinutes();

			var real = parseInt(checkTime(hh)+checkTime(mm));
			
			console.log(t_subuh);
			console.log(t_subuh+30);
			console.log(real);

			if (real >= t_subuh && real <= t_subuh+30){
				$('#display-sholat').removeClass('d-none');
				$('#nama_sholat_time').html('Waktunya Sholat Shubuh');
			} else {
				$('#display-sholat').addClass('d-none');
				$('#nama_sholat_time').html('');
			}
			
			// if (real >= t_dzuhur && real <= t_dzuhur+20){
			// 	$('#display-sholat').removeClass('d-none');
			// } else {
			// 	$('#display-sholat').addClass('d-none');
			// }

			setInterval(function(){
				checkSholat();
			},10000);

			
		}
		
		function checkUpdate(){
			var revId = $('#revision_id').val();
			var dateAct = $('#date_active').val();
			$.ajax({
				url: "{{route('revision')}}",
				type: "GET",
				success: function (result) {
					if(revId !== result.revision_id){
						location.reload();
					}

					if(dateAct !== result.date_active) {
						location.reload();
					}
				}
			});
		}


		function ajaxSlide() {
			setTimeout(function () {
				$("#slider").html('');
				$.ajax({
					type: "GET",
					url: "{{route('slide')}}",
					success: function (data) {
						$('#revision_id').val(data.revision_id);
						$('#date_active').val(data.date_active);
						var itemcaro = '';
						var tb_klr = '';
						var tb_msk = '';
						var tb_shltU = '';
						var dt_runningText = '';
						var lineUnder = '{{asset('display/img/hadist-line.png')}}';

						$.each(data.running_text, function (index, value) {
							dt_runningText +=
								`${value.text} ▓ `;
						});

						if(data.jadwal_sholat.length){
							$.each(data.jadwal_sholat, function (index, value) {
								tb_shltU +=
									`<div class="row">
									<div class="col-4">
										<p style="font-size: 30px; font-weight: 600; color: #33cccc;">${capitalize(value.sholat)}</p>
									</div>
									<div class="col-4">
										<p style="font-size: 30px; font-weight: 600; color: white;">${value.imam}</p>
									</div>
									<div class="col-4">
										<p style="font-size: 30px; font-weight: 600; color: white;">${value.muazin}</p>
									</div>
								</div>
								<hr class="s1">`;
							});

							itemcaro += `
								<div id="slideKas">
									<div class="row">
										<div class="col-12 text-center mb-2"> 
											<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Atribut Sholat 5 Waktu</h1>
											<h6 style="font-size: 2vw; font-weight: 900; color: #ffd700;">${formatDateFull(data.date_active)}</h6>
										</div
									</div
									<div class="row">
										<div class="col-4">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Sholat</p>
										</div>
										<div class="col-4">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Muazin</p>
										</div>
										<div class="col-4">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Imam</p>
										</div>
									</div>
									<hr class="s1">
									${tb_shltU}
								</div>
								`;
						}

						if(data.is_jumat == true){
							itemcaro += `
								<div id="slideKas">
									<div class="row">
										<div class="col-12 text-center mb-4"> 
											<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Atribut Sholat Jum'at</h1>
											<h6 style="font-size: 2vw; font-weight: 900; color: #ffd700;">${formatDateFull(data.date_active)}</h6>
											<center>
												<img src="${lineUnder}" width="70%">
											</center>
										</div
									</div
									<div class="row">
										<div class="col-12 text-center">
											<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Khatib</p>
										</div>
										<div class="col-12 text-center">
											<p style="font-size: 70px; font-weight: 900; color: white; line-height: 8px;">${data.khatib}</p>
											<p style="font-size: 30px; font-weight: 600; color: ffd700;">${data.keterangan_khatib}</p>
										</div>
									</div>
								</div>
								`;
						}

						if(data.pengeluaran_kas.length){
							$.each(data.pengeluaran_kas, function (index, value) {
								tb_klr +=
									`<div class="row">
									<div class="col-3">
										<p style="font-size: 25px; font-weight: 600; color: white;">${formatDate(value.tanggal_kas)}</p>
									</div>
									<div class="col-6">
										<p style="font-size: 25px; font-weight: 600; color: white;">${value.keterangan}</p>
									</div>
									<div class="col-3">
										<p style="font-size: 25px; font-weight: 600; color: white;">${rupiah(value.keluar)}</p>
									</div>
								</div>
								<hr class="s1">`;
							});

							itemcaro += `
								<div id="slideKas">
									<div class="row">
										<div class="col-12 text-center mb-2"> 
											<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Laporan Pengeluaran Kas</h1>
										</div
									</div
									<div class="row">
										<div class="col-3">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Tanggal</p>
										</div>
										<div class="col-6">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Keterangan</p>
										</div>
										<div class="col-3">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Nominal</p>
										</div>
									</div>
									<hr class="s1">
									${tb_klr}
								</div>
								`;
						}

						if(data.pemasukan_kas.length) {
							$.each(data.pemasukan_kas, function (index, value) {
								tb_msk +=
									`<div class="row">
									<div class="col-3">
										<p style="font-size: 25px; font-weight: 600; color: white;">${formatDate(value.tanggal_kas)}</p>
									</div>
									<div class="col-6">
										<p style="font-size: 25px; font-weight: 600; color: white;">${value.keterangan}</p>
									</div>
									<div class="col-3">
										<p style="font-size: 25px; font-weight: 600; color: white;">${rupiah(value.masuk)}</p>
									</div>
								</div>
								<hr class="s1">`;
							});

							itemcaro += `
								<div id="slideKas">
									<div class="row">
										<div class="col-12 text-center mb-2"> 
											<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Laporan Pemasukan Kas</h1>
										</div
									</div
									<div class="row">
										<div class="col-3">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Tanggal</p>
										</div>
										<div class="col-6">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Keterangan</p>
										</div>
										<div class="col-3">
											<p style="font-size: 30px; font-weight: 900; color: #ffd700;">Nominal</p>
										</div>
									</div>
									<hr class="s1">
									${tb_msk}
								</div>`;
						}

						itemcaro += `
								<div id="slideKas">
									<br/>
									<br/>
									<br/>
									<div class="row">
										<div class="col-12 text-center mb-2"> 
											<h1 style="font-size: 6vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Sisa Saldo Kas</h1>
										</div
									</div
									<hr class="s1">
									<div class="row">
										<div class="col-12">
											<center>
												<p style="font-size: 70px; font-weight: 900; color: #ffd700;">${rupiah(data.sisa_saldo_kas)}</p>
											</center>
										</div>
									</div>
									</div>
								</div>`;

						if(data.is_jumat){
						}

						if(data.pengajian_shubuh){
							itemcaro += `
							<div id="slideKas">
								<div class="row">
									<div class="col-12 text-center mb-4"> 
										<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Pengajian Ba'da Shubuh</h1>
										<h6 style="font-size: 2vw; font-weight: 900; color: #ffd700;">${formatDateFull(data.pengajian_shubuh.tanggal)} | ${data.pengajian_shubuh.waktu}</h6>
										<center>
											<img src="${lineUnder}" width="70%">
										</center>
									</div
								</div
								<div class="row">
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Pemateri</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 70px; font-weight: 900; color: white; line-height: 8px;">${data.pengajian_shubuh.pengisi_kajian}</p>
										<br/>
										<p style="font-size: 30px; font-weight: 600; color: ffd700;">${data.pengajian_shubuh.keterangan_pengisi_kajian}</p>
									</div>
									<div class="col-12 text-center mt-2">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Materi Kajian	</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: white;">"${data.pengajian_shubuh.topik_kajian}"</p>
									</div>
								</div>
							</div>
							`;
						}

						if(data.pengajian_magrib){
							itemcaro += `
							<div id="slideKas">
								<div class="row">
									<div class="col-12 text-center mb-4"> 
										<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Pengajian Ba'da Magrib</h1>
										<h6 style="font-size: 2vw; font-weight: 900; color: #ffd700;">${formatDateFull(data.pengajian_magrib.tanggal)} | ${data.pengajian_magrib.waktu}</h6>
										<center>
											<img src="${lineUnder}" width="70%">
										</center>
									</div
								</div
								<div class="row">
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Pemateri</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 70px; font-weight: 900; color: white; line-height: 8px;">${data.pengajian_magrib.pengisi_kajian}</p>
										<br/>
										<p style="font-size: 30px; font-weight: 600; color: ffd700;">${data.pengajian_magrib.keterangan_pengisi_kajian}</p>
									</div>
									<div class="col-12 text-center mt-2">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Materi Kajian	</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: white;">"${data.pengajian_magrib.topik_kajian}"</p>
									</div>
								</div>
							</div>
							`;
						}

						if(data.pengajian_wanita){
							itemcaro += `
							<div id="slideKas">
								<div class="row">
									<div class="col-12 text-center mb-4"> 
										<h1 style="font-size: 4vw; font-weight: 900; color: white; text-shadow:1px 1px 10px #fff, 1px 1px 10px #ccc;">Pengajian Wanita / Akhwat</h1>
										<h6 style="font-size: 2vw; font-weight: 900; color: #ffd700;">${formatDateFull(data.pengajian_wanita.tanggal)} | ${data.pengajian_wanita.waktu}</h6>
										<center>
											<img src="${lineUnder}" width="70%">
										</center>
									</div
								</div
								<div class="row">
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Pemateri</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 70px; font-weight: 900; color: white; line-height: 8px;">${data.pengajian_wanita.pengisi_kajian}</p>
										<br/>
										<p style="font-size: 30px; font-weight: 600; color: ffd700;">${data.pengajian_wanita.keterangan_pengisi_kajian}</p>
									</div>
									<div class="col-12 text-center mt-2">
										<p style="font-size: 50px; font-weight: 900; color: #ffd700;">Materi Kajian	</p>
									</div>
									<div class="col-12 text-center">
										<p style="font-size: 50px; font-weight: 900; color: white;">"${data.pengajian_wanita.topik_kajian}"</p>
									</div>
								</div>
							</div>
							`;
						}

						$("#slider").html(itemcaro);
						$("#runningText").html(dt_runningText);

						$('.slider').slick({
							infinite: true,
							autoplay: true,
							autoplaySpeed: data.slide_interval,
							prevArrow: false,
							nextArrow: false,

						});
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}, 2000);
		}

		function ajaxGetJadwalSholat() {
			var css = "";
			var jadwal = "";
			$.ajax({
				url: "{{route('jadwal')}}",
				beforeSend: function () {
					$('#jadwal').html("<center>Getting data from Kemenag Server...</center>");
				},
				success: function (result) {
					
					$('#time_subuh').val(result.subuh);
					$('#time_dzuhur').val(result.dzuhur);
					$('#time_ashar').val(result.ashar);
					$('#time_maghrib').val(result.maghrib);
					$('#time_isya').val(result.isya);
					jadwal = `<div class="row"><div class="col-xs-5">Subuh</div><div class="col-xs-7">${result.subuh}</div></div>`;
					jadwal += `<div class="row"><div class="col-xs-5">Dzuhur</div><div class="col-xs-7">${result.dzuhur}</div></div>`;
					jadwal += `<div div class="row" ><div class="col-xs-5">Ashar</div><div class="col-xs-7">${result.ashar}</div></div > `;
					jadwal += `<div class="row"><div class="col-xs-5">Magrib</div><div class="col-xs-7">${result.maghrib}</div></div>`;
					jadwal += `<div div class="row" ><div class="col-xs-5">Isya</div><div class="col-xs-7">${result.isya}</div></div >`;
					jadwal += `<p style="font-size: 10pt;">Source : Database Kemenag | ${result.tanggal}</p>`;
					$('#jadwal').html(jadwal);

					// checkSholat();
				},
				error: function () {
					$('#jadwal').html("<center>Your server is offline</center>");
				}
			});
		}
		
    </script>
</body>
</html>