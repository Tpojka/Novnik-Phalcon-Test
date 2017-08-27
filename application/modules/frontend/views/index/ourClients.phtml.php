<div class="row">
	<h2><?= $ourClients ?></h2>
</div>
<div class="row">
	<?php if ($this->length($users)) { ?>
	<table class="table">
        <thead>
          <tr>
            <th><?= $f_name ?></th>
            <th><?= $l_name ?></th>
            <th><?= $cc_number ?></th>
            <th><?= $cc_cvv ?></th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $index => $user) { ?>
          <tr>
            <td>user.f_name</td>
            <td>user.l_name</td>
            <td>user.cc_number</td>
            <td>user.cc_cvv</td>
          </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <?php if ($this->length($users) < 1) { ?>
    	<p>There is no clients in database.</p>
    <?php } ?>
</div>