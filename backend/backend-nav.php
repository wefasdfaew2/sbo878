<div class="page-sidebar navbar-collapse collapse">
    <ul class="page-sidebar-menu">
        <li>
            <div class="sidebar-toggler hidden-phone"></div>
        </li>
        <li>
            <br />
        </li>
        <li class="<?php echo ($page_name == 'dashboard' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/dashboard'); ?>">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="<?php echo ($page_name == 'dashboard' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'deposit' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/deposit'); ?>">
                <i class="icon-download-alt"></i>
                <span class="title">รายการแจ้งฝาก</span>
                <span class="<?php echo ($page_name == 'deposit' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'withdraw' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/withdraw'); ?>">
                <i class="icon-upload-alt"></i>
                <span class="title">รายการแจ้งถอน</span>
                <span class="<?php echo ($page_name == 'withdraw' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'deposit_auto_fail' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/deposit_auto_fail'); ?>">
                <i class="icon-download-alt"></i>
                <span class="title">รายการแจ้งฝากอัตโนมัติที่ขัดข้อง</span>
                <span class="<?php echo ($page_name == 'deposit_auto_fail' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
		<?php /* ?>
        <li class="<?php echo ($page_name == 'member_type' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/member_type'); ?>">
                <i class="icon-group"></i>
                <span class="title">ประเภทสมาชิก</span>
                <span class="<?php echo ($page_name == 'member_type' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'member' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/member'); ?>">
                <i class="icon-user"></i>
                <span class="title">สมาชิก</span>
                <span class="<?php echo ($page_name == 'member' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'sbobet' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/sbobet'); ?>">
                <i class="icon-book"></i>
                <span class="title">บัญชีสโบเบ็ต</span>
                <span class="<?php echo ($page_name == 'sbobet' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'bank' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/bank'); ?>">
                <i class="icon-money"></i>
                <span class="title">บัญชีธนาคาร</span>
                <span class="<?php echo ($page_name == 'bank' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'account' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/account'); ?>">
                <i class="icon-user-md"></i>
                <span class="title">ผู้ดูแลระบบ</span>
                <span class="<?php echo ($page_name == 'account' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'sms' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/sms'); ?>">
                <i class="icon-envelope-alt"></i>
                <span class="title">ข้อความ sms</span>
                <span class="<?php echo ($page_name == 'sms' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
        <li class="<?php echo ($page_name == 'log' ? 'active' : ''); ?>">
            <a href="<?php echo base_url('backend/log'); ?>">
                <i class="icon-eye-open"></i>
                <span class="title">ประวัติการใช้งาน</span>
                <span class="<?php echo ($page_name == 'log' ? 'selected' : ''); ?>"></span>
            </a>
        </li>
		<?php */ ?>
    </ul>
</div>
