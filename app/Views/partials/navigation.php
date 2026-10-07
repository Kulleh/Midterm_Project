<nav>
    <a href="<?= base_url('products') ?>">Products</a> |
    <a href="<?= base_url('customers') ?>">Customers</a> |
    <a href="<?= base_url('users') ?>">Staff Accounts</a> |
    <a href="<?= base_url('sales/create') ?>">Record Sale</a> |
    <a href="<?= base_url('sales/history') ?>">Sale History</a>
</nav> <br>

<form action="<?= base_url('logout') ?>" method="post" style="display: inline;">
    <?= csrf_field() ?>
    <button type="submit">Log out</button>
</form>

<?php if (session()->getFlashdata('success')): ?>
    <p style="color: green;"><?= esc(session()->getFlashdata('success')) ?></p>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <p style="color: red;"><?= esc(session()->getFlashdata('error')) ?></p>
<?php endif; ?>