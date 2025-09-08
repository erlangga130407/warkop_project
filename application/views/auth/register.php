<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Register — Warkop Abah</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Fonts & CSS -->
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="<?= base_url('assets/vendor/css/sb-admin-2.min.css'); ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">
  <div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-8 mx-auto">
      <div class="card-body p-0">
        <div class="row">
          <div class="col-lg">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
              </div>

              <?php if ($this->session->flashdata('message')): ?>
                <?= $this->session->flashdata('message'); ?>
              <?php endif; ?>

              <form class="user" method="post" action="<?= site_url('register'); ?>">
                <div class="form-group">
                  <input type="text"
                         class="form-control form-control-user"
                         id="name" name="name"
                         placeholder="Nama Lengkap"
                         value="<?= set_value('name'); ?>">
                  <?= form_error('name','<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <input type="text"
                         class="form-control form-control-user"
                         id="email" name="email"
                         placeholder="Alamat Email"
                         value="<?= set_value('email'); ?>">
                  <?= form_error('email','<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <select class="form-control form-control-user" id="role_id" name="role_id">
                    <option value="">Pilih Peran</option>
                    <?php foreach ($roles as $key => $role): ?>
                      <option value="<?= $key ?>" <?= set_select('role_id', $key) ?>><?= $role ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?= form_error('role_id','<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <input type="text"
                         class="form-control form-control-user"
                         id="phone" name="phone"
                         placeholder="Nomor Telepon (opsional)"
                         value="<?= set_value('phone'); ?>">
                  <?= form_error('phone','<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group">
                  <textarea class="form-control form-control-user"
                            id="address" name="address"
                            placeholder="Alamat (opsional)"
                            rows="2"><?= set_value('address'); ?></textarea>
                  <?= form_error('address','<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text"
                           class="form-control form-control-user"
                           id="city" name="city"
                           placeholder="Kota (opsional)"
                           value="<?= set_value('city'); ?>">
                    <?= form_error('city','<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="text"
                           class="form-control form-control-user"
                           id="postal_code" name="postal_code"
                           placeholder="Kode Pos (opsional)"
                           value="<?= set_value('postal_code'); ?>">
                    <?= form_error('postal_code','<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password"
                           class="form-control form-control-user"
                           id="password1" name="password1"
                           placeholder="Kata Sandi">
                    <?= form_error('password1','<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                  <div class="col-sm-6">
                    <input type="password"
                           class="form-control form-control-user"
                           id="password2" name="password2"
                           placeholder="Ulangi Kata Sandi">
                    <?= form_error('password2','<small class="text-danger pl-3">', '</small>'); ?>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">
                  Daftar Akun
                </button>
              </form>

              <hr>
              <div class="text-center">
                <a class="small" href="<?= site_url('masuk'); ?>">Sudah punya akun? Masuk!</a>
              </div>
            </div><!-- /.p-5 -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- JS -->
  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
</body>
</html>
