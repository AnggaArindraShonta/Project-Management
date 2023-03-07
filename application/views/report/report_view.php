<?php if (!defined('BASEPATH'))
    exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i>
            <?= $title_web; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp;
                    Dashboard</a></li>
            <li class="active"><i class="fa fa-file-text"></i>&nbsp;
                <?= $title_web; ?>
            </li>
        </ol>
    </section>
    <section class="content">
        <?php if (!empty($this->session->flashdata())) {
            echo $this->session->flashdata('pesan');
        } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <?php if ($this->session->userdata('role_id') == '1') { ?>
                            <a href="reporttambah"><button class="btn btn-primary">
                                    <i class="fa fa-plus"> </i> Tambah Report</button></a>
                        <?php } ?>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <br />
                        <div class="table-responsive">
                            <table id="example1" class="table table-bordered table-striped table" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Report Progress</th>
                                        <th>Keterangan Progress</th>
                                        <th>Report Nota</th>
                                        <th>Keterangan Nota</th>
                                        <th>Report Date</th>
                                        <th>Report Time</th>
                                        <th>Project</th>
                                        <th>Member</th>

                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($report as $isi) { ?>
                                        <tr>
                                            <td>
                                                <?= $no; ?>
                                            </td>
                                            <td>
                                                <center>
                                                    <?php if (!empty($isi['report_progress'] !== "0")) { ?>
                                                        <img src="<?php echo base_url(); ?>assets_style/image/report/<?php echo $isi['report_progress']; ?>"
                                                            alt="#" class="img-responsive" style="height:auto;width:100px;" />
                                                    <?php } else { ?>
                                                        <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
                                                        <i class="fa fa-book fa-3x" style="color:#333;"></i> <br /><br />
                                                        Tidak Report Progress
                                                    <?php } ?>
                                                </center>
                                            </td>
                                            <td>

                                                <?= $isi['ket_progress']; ?>
                                            </td>

                                            <td>
                                                <center>
                                                    <?php if (!empty($isi['report_nota'] !== "0")) { ?>
                                                        <img src="<?php echo base_url(); ?>assets_style/image/report/<?php echo $isi['report_nota']; ?>"
                                                            alt="#" class="img-responsive" style="height:auto;width:100px;" />
                                                    <?php } else { ?>
                                                        <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
                                                        <i class="fa fa-book fa-3x" style="color:#333;"></i> <br /><br />
                                                        Tidak Ada Report Nota
                                                    <?php } ?>
                                                    <!-- <?= $isi['report_nota']; ?> -->

                                                </center>
                                            </td>
                                            <td>

                                                <?= $isi['ket_nota']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['report_date']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['report_time']; ?>
                                            </td>

                                            <td>
                                                <?= $isi['project_name']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['user_name']; ?>
                                            </td>


                                            <td <?php if ($this->session->userdata('role_id') == '1') { ?>style="width:17%;"
                                                <?php } ?>>

                                                <?php if ($this->session->userdata('role_id') == '1') { ?>
                                                    </button></a>

                                                    <a href="<?= base_url('data/prosesreport?report_id=' . $isi['report_id']); ?>"
                                                        onclick="return confirm('Anda yakin Report ini akan dihapus ?');">
                                                        <button class="btn btn-danger"><i class="fa fa-trash"></i></button></a>
                                                <?php } else { ?>
                                                    <a href="<?= base_url('data/bukudetail/' . $isi['project_id']); ?>">
                                                        <button class="btn btn-primary"><i class="fa fa-sign-in"></i>
                                                            Detail</button></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php $no++;
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>