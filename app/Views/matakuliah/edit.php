<?= $this->extend('layouts/layout') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col">
        <form action="<?= base_url('/matakuliah/update') ?>" method="post">
            <input type="hidden" name="id" value="<?= $matakuliah->id ?>">
            <div class="form-group">
                <label form="nama_matakuliah">Nama Mata Kuliah</label>
                <input type="text" name="nama_matakuliah" id="nama_matakuliah" class="form-control <?= ($validation->hasError('nama_matakuliah')) ? 'is-invalid' : '' ?>" value="<?= $matakuliah->nama_matakuliah ?>">
                <div class="invalid-feedback">r
                    <?= $validation->getError('nama_matakuliah') ?>
                </div>
            </div>
            <div class="form-group">
                <label form="jadwal_absensi">Jadwal Absensi</label>
                <input type="time" name="jadwal_absensi" id="jadwal_absensi" class="form-control <?= ($validation->hasError('jadwal_absensi')) ? 'is-invalid' : '' ?>" value="<?= $matakuliah->jadwal_absensi ?>">
                <div class="invalid-feedback">
                    <?= $validation->getError('jadwal_absensi') ?>
                </div>
            </div>
            <div class="form-group">
                <label form="hari">Hari</label>
                <select class="form-control <?= ($validation->hasError('hari')) ? 'is-invalid' : '' ?>" name="hari" id="hari">
                    <option value="Senin">Senin</option>
                    <option value="Selasa">Selasa</option>
                    <option value="Rabu">Rabu</option>
                    <option value="Kamis">Kamis</option>
                    <option value="Jumat">Jum'at</option>
                    <option value="Sabtu">Sabtu</option>
                    <option value="Minggu">Minggu</option>
                </select>
                <div class="invalid-feedback">
                    <?= $validation->getError('hari') ?>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm mt-2">SAVE</button>
        </form>
    </div>
</div>
</div>
</div>

<?= $this->endSection() ?>