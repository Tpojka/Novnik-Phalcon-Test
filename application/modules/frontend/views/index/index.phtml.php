<h2><?= $h2Title ?></h2>
<form action="ajaxAddUser" method="POST">

	<input type="text" name="<?= $name_f_name ?>" placeholder="<?= $ph_f_name ?>">
    <input type="text" name="<?= $name_l_name ?>" placeholder="<?= $ph_l_name ?>">
    <input type="text" name="<?= $name_cc_number ?>" placeholder="<?= $ph_cc_number ?>">
    <input type="text" name="<?= $name_cc_cvv ?>" placeholder="<?= $ph_cc_cvv ?>">
    <input type="submit" placeholder="GO">

</form>