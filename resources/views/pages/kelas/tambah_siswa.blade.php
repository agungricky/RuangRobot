{{-- Tambah Siswa Kelas --}}
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="add-items d-flex">
                    <x-button.button_add_modal message="Tambah Siswa" id="#form_kelas" />
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered border-dark mt-2 mb-3 text-center" id="example">
                        <thead>
                            <tr>
                                <th style="width: 5%;" class="text-center">No.</th>
                                <th style="width: 25%;" class="text-center">Nama Kelas</th>
                                <th style="width: 5%;" class="text-center">Jenis Kelas</th>
                                <th style="width: 10%;" class="text-center">Gaji Pengajar</th>
                                <th style="width: 10%;" class="text-center">Gaji Transport</th>
                                <th style="width: 10%;" class="text-center">Status Kelas</th>
                                <th style="width: 10%;" class="text-center">Dibuat Tanggal</th>
                                <th style="width: 20%;" class="text-center">Opsi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>