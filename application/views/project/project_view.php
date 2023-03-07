<?php if (!defined('BASEPATH'))
    exit('No direct script acess allowed'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-edit" style="color:green"> </i>
            <?= $title_web; ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>&nbsp; Dashboard</a></li>
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
                            <a href="data/projecttambah"><button class="btn btn-primary">
                                    <i class="fa fa-plus"> </i> Tambah Project</button></a>
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
                                        <th>Project Name</th>
                                        <th>Project Picture</th>

                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Project Description</th>
                                        <th>PIC</th>
                                        <th>Member</th>
                                        <th>Aksi</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($project as $isi) { ?>
                                        <!-- foreach ($project->result_array() as $isi) { ?> -->
                                        <tr>
                                            <td>
                                                <?= $no; ?>
                                            </td>
                                            <td>
                                                <?= $isi['project_name']; ?>

                                            </td>
                                            <td>
                                                <center>
                                                    <?php if (!empty($isi['project_picture'] !== "0")) { ?>
                                                        <img src="<?php echo base_url(); ?>assets_style/image/projects/<?php echo $isi['project_picture']; ?>"
                                                            alt="#" class="img-responsive" style="height:auto;width:100px;" />
                                                    <?php } else { ?>
                                                        <!--<img src="" alt="#" class="user-image" style="border:2px solid #fff;"/>-->
                                                        <i class="fa fa-book fa-3x" style="color:#333;"></i> <br /><br />
                                                        Tidak Ada Sampul
                                                    <?php } ?>
                                                </center>
                                            </td>
                                            <td>
                                                <?= $isi['start_date']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['end_date']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['project_description']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['pic_name']; ?>
                                            </td>
                                            <td>
                                                <?= $isi['user_name']; ?>
                                            </td>


                                            <td <?php if ($this->session->userdata('role_id') == '1') { ?>style="width:17%;"
                                                <?php } ?>>

                                                <?php if ($this->session->userdata('role_id') == '1') { ?>
                                                    <!-- <a href="<?= base_url('data/bukuedit/' . $isi['project_id']); ?>"><button
                                                                                                                                                                    class="btn btn-success"><i class="fa fa-edit"></i></button></a>
                                                                                                                                                            <a href="<?= base_url('data/bukudetail/' . $isi['project_id']); ?>">
                                                                                                                                                                <button class="btn btn-primary"><i class="fa fa-sign-in"></i>
                                                                                                                                                                    Detail</button></a> -->
                                                    <a href="<?= base_url('data/prosesproject?project_id=' . $isi['project_id']); ?>"
                                                        onclick="return confirm('Anda yakin Buku ini akan dihapus ?');">
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