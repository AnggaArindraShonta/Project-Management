<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php
                $d = $this->db->query("SELECT * FROM user WHERE user_id='$idbo'")->row();
                ?>
            </div>
            <div class="pull-left info" style="margin-top: 5px;">
                <p>
                    <?php echo $d->user_name; ?>
                </p>
                <p>
                    <?= $d->role_id; ?>
                </p>
                <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
            </div>
            <br />
            <br />
            <br />
            <br />
        </div>
        <ul class="sidebar-menu" data-widget="tree">
            <?php if ($this->session->userdata('role_id') == '1') { ?>
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <li class="header">MAIN NAVIGATION</li>
                <li class="<?php if ($this->uri->uri_string() == 'dashboard') {
                    echo 'active';
                } ?>">
                    <a href="<?php echo base_url('dashboard'); ?>">
                        <!-- <i class="fa fa-dashboard"></i> <span>Dashboard</span> -->
                    </a>
                </li>
                <li
                    class="<?php if ($this->uri->uri_string() == 'user') {
                        echo 'active';
                    } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'user/tambah') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'user/edit/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">

                </li>
                <li
                    class="treeview <?php if ($this->uri->uri_string() == 'data/kategori') {
                        echo 'active';
                    } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data/rak') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data/bukutambah') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data/bukudetail/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data/bukuedit/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
                    <a href="#">
                        <i class="fa fa-pencil-square"></i>
                        <span>Project </span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li
                            class="<?php if ($this->uri->uri_string() == 'data') {
                                echo 'active';
                            } ?>
                                                                                                                                                                        <?php if ($this->uri->uri_string() == 'data/projecttambah') {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>
                                                                                                                                                                        <?php if ($this->uri->uri_string() == 'data/bukudetail/' . $this->uri->segment('3')) {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>
                                                                                                                                                                        <?php if ($this->uri->uri_string() == 'data/bukuedit/' . $this->uri->segment('3')) {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>">
                            <a href="<?php echo base_url("index.php/data"); ?>" class="cursor">
                                <span class="fa fa-book"></span> List Project

                            </a>
                        </li>
                        <li class=" <?php if ($this->uri->uri_string() == 'data/kategori') {
                            echo 'active';
                        } ?>">
                            <!-- <a href="<?php echo base_url("data/kategori"); ?>" class="cursor">
                                                                                                                                                <span class="fa fa-tags"></span> Kategori

                                                                                                                                            </a>
                                                                                                                                        </li>
                                                                                                                                        <li class=" <?php if ($this->uri->uri_string() == 'data/rak') {
                                                                                                                                            echo 'active';
                                                                                                                                        } ?>">
                                                                                                                                            <a href="<?php echo base_url("data/rak"); ?>" class="cursor">
                                                                                                                                                <span class="fa fa-list"></span> Rak

                                                                                                                                            </a> -->
                        </li>
                    </ul>
                </li>
                <li
                    class="treeview 
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'transaksi') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'transaksi/kembali') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'transaksi/pinjam') {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'transaksi/detailpinjam/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'transaksi/kembalipinjam/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">
                    <a href="#">
                        <i class="fa fa-exchange"></i>
                        <span>Report</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li
                            class="<?php if ($this->uri->uri_string() == 'index.php/data/report') {
                                echo 'active';
                            } ?>
                                                                                                                                                                        <?php if ($this->uri->uri_string() == 'data/reporttambah') {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>
                                                                                                                                                                        <?php if ($this->uri->uri_string() == '/report' . $this->uri->segment('3')) {
                                                                                                                                                                            echo 'active';
                                                                                                                                                                        } ?>">

                        </li>
                        <li class="<?php if ($this->uri->uri_string() == 'index.php/data/report') {
                            echo 'active';
                        } ?>">
                            <a href="<?php echo base_url("index.php/data/report"); ?>" class="cursor">
                                <span class="fa fa-download"></span> List Report
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="<?php if ($this->uri->uri_string() == 'transaksi/denda') {
                    echo 'active';
                } ?>">
                    <a href="<?php echo base_url("transaksi/denda"); ?>" class="cursor">
                    </a>
                </li>
            <?php } ?>
            <?php if ($this->session->userdata('level') == 'Anggota') { ?>
                <li class="<?php if ($this->uri->uri_string() == 'transaksi') {
                    echo 'active';
                } ?>">
                    <a href="<?php echo base_url("transaksi"); ?>" class="cursor">
                        <i class="fa fa-upload"></i> <span>Data Peminjaman </span>
                    </a>
                </li>
                <li class="<?php if ($this->uri->uri_string() == 'transaksi/kembali') {
                    echo 'active';
                } ?>">
                    <a href="<?php echo base_url("transaksi/kembali"); ?>" class="cursor">
                        <i class="fa fa-upload"></i> <span>Data Pengambilan</span>
                    </a>
                </li>
                <li
                    class="<?php if ($this->uri->uri_string() == 'data') {
                        echo 'active';
                    } ?>
                                                                                                                                                                <?php if ($this->uri->uri_string() == 'data/bukudetail/' . $this->uri->segment('3')) {
                                                                                                                                                                    echo 'active';
                                                                                                                                                                } ?>">

                </li>
                <li class="<?php if ($this->uri->uri_string() == 'user/edit/' . $this->uri->segment('3')) {
                    echo 'active';
                } ?>">
                    <a href="<?php echo base_url('user/edit/' . $this->session->userdata('ses_id')); ?>" class="cursor">
                        <i class="fa fa-user"></i> <span>Data Anggota</span>
                    </a>
                </li>
                <li class="">
                    <a href="<?php echo base_url('user/detail/' . $this->session->userdata('ses_id')); ?>" target="_blank"
                        class="cursor">
                        <i class="fa fa-print"></i> <span>Cetak kartu Anggota</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
        <div class="clearfix"></div>
        <br />
        <br />
    </section>
    <!-- /.sidebar -->
</aside>