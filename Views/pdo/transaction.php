<h1>PDO and Database Transactions Setup</h1>
<hr />

<div class="invoices">

    <?php if (!empty($invoice)): ?>
        <p>
            <?= $invoice["full_name"] . ' ' . $invoice["id"] . ' ' . $invoice["amount"] ?>
        </p>
    <?php endif; ?>

</div>
