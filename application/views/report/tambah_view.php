<?php if (!defined('BASEPATH'))
    exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-plus" style="color:green"> </i>
            <?= $title_web; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
            <li class="active"><i class="fa fa-plus"></i>&nbsp;
                <?= $title_web; ?>
            </li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <form action="<?php echo base_url('index.php/data/prosesreport'); ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>Project</label>
                                        <select class="form-control select2" required="required" name="project_id">
                                            <option disabled selected value> -- Pilih Project -- </option>
                                            <?php foreach ($project as $isi) { ?>
                                                <option value="<?= $isi['project_id']; ?>"><?= $isi['project_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Report Date</label>
                                        <input type="date" class="form-control" name="report_date"
                                            placeholder="report_date">
                                    </div>
                                    <div class="form-group">
                                        <label>Report Time</label>
                                        <input type="time" class="form-control" name="report_time"
                                            placeholder="report_time">
                                    </div>


                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label>Report Progress <small style="color:green">(gambar) </small></label>
                                        <input type="file" accept="image/*" name="report_progress">
                                    </div>

                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label>Keterangan Progress </label>
                                        <input type="text" class="form-control" name="ket_progress"
                                            placeholder="keterangan progress">
                                    </div>

                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label>Report Nota <small style="color:green">(gambar) </small></label>
                                        <input type="file" accept="image/*" name="report_nota">
                                    </div>

                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label>Keterangan Nota </label>
                                        <input type="text" class="form-control" name="ket_nota"
                                            placeholder="keterangan nota">
                                    </div>

                                </div>
                            </div>
                            <div class="pull-right">
                                <input type="hidden" name="tambah" value="tambah">
                                <button type="submit" class="btn btn-primary btn-md">Submit</button>
                        </form>
                        <a href="<?= base_url('data/report'); ?>" class="btn btn-danger btn-md">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>