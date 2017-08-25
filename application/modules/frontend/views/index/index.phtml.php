

<h2><?= $h2Title ?></h2>
<form action="/add-card" method="POST">

    <input type="text" name="firstName" placeholder="<?= $firstName ?>">
    <input type="text" name="lastName" placeholder="<?= $lastName ?>">
    <input type="text" name="creditCardNumber" placeholder="<?= $creditCardNumber ?>">
    <input type="text" name="creditCardCvv" placeholder="<?= $creditCardCvv ?>">
    <input type="submit" placeholder="GO">

</form>

