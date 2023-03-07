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
                        <form action="<?php echo base_url('index.php/data/prosesproject'); ?>" method="POST"
                            enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label>PIC</label>
                                        <select class="form-control select2" required="required" name="pic_id">
                                            <option disabled selected value> -- Pilih Pic -- </option>
                                            <?php foreach ($pic_id as $isi) { ?>
                                                <option value="<?= $isi['pic_id']; ?>"><?= $isi['pic_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Member</label>
                                        <select name="member" class="form-control select2" required="required">
                                            <option disabled selected value> -- Member-- </option>
                                            <?php foreach ($member as $isi) { ?>
                                                <option value="<?= $isi['user_id']; ?>"><?= $isi['user_name']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Project Name</label>
                                        <input type="text" class="form-control" name="project_name"
                                            placeholder="project_name">
                                    </div>
                                    <div class="form-group">
                                        <label>Project Description</label>
                                        <input type="text" class="form-control" name="project_description"
                                            placeholder="project description">
                                    </div>
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" class="form-control" name="start_date"
                                            placeholder="dd/mm/yyyy">
                                    </div>
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" class="form-control" name="end_date"
                                            placeholder="dd/mm/yyyy">
                                    </div>

                                </div>
                                <div class="col-sm-6">


                                    <div class="form-group">
                                        <label>Project Picture <small style="color:green">(gambar) </small></label>
                                        <input type="file" accept="image/*" name="project_picture">
                                    </div>

                                </div>
                            </div>
                            <div class="pull-right">
                                <input type="hidden" name="tambah" value="tambah">
                                <button type="submit" class="btn btn-primary btn-md">Submit</button>
                        </form>
                        <a href="<?= base_url('data'); ?>" class="btn btn-danger btn-md">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>