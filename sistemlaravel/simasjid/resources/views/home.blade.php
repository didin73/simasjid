@include('layouts.header')
@include('layouts.navbar')

<!-- Main Content -->
<div class="main-content">
  <section class="section">
    <div class="section-header" style="margin-bottom: 17px;">
      <h1>Home</h1>
      <div></div>
    </div>
    <section class="section" style="margin-top: 10px;">
      <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px;">
        <div class="card">
          <div style="padding:30px;">
            <h3>
              <?php
              echo 'Selamat datang di Sistem Informasi Masjid Ibnu Sina!<br>';
              echo '<h5>Anda masuk dengan sebagai '.  $user->nama .'.</h5>';
              echo '<h5>Hak akses Anda adalah '. $user->jabatan . '.</h5>';
              ?>
            </h3>
            <img src="public/dist/assets/img/ibnusina.jpg" class="rounded mx-auto d-block" alt="...">
          </div>
        </div>
      </div>

    </section>


    <br>
</div>
<script>
  document.getElementById("home-link").classList.add("active");
</script>

@include('layouts.footer')