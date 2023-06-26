<form method="POST" action="/address">
    <input type="text" name="firstname" placeholder="Imię min:3 - max:64" style="min-width: 12rem"/>
    <input type="text" name="lastname" placeholder="Nazwisko  min:3 - max:64" style="min-width: 12rem"/>
    <input type="tel" name="phone" pattern="[0-9]{3}-[0-9]{3}-[0-9]{3}" placeholder="Telefon: 123-123-123 unique" style="min-width: 12rem"/>
    <input type="text" name="email" placeholder="Email  min:3 - max:64 unique" style="min-width: 12rem"/>
    <input type="text" name="address" placeholder="Adres  min:3 - max:64" style="min-width: 12rem"/>
    <button>Dodaj</button>
</form>

<?php foreach ($addresses as $address): ?>
    <div style="display:flex; gap:1rem; align-items: center">
        <p><?= $address['firstname'] ?> <?= $address['lastname'] ?></p>
        <p><?= $address['phone'] ?></p>
        <p><?= $address['email'] ?></p>
        <p><?= $address['address'] ?></p>
        <form action="/address" method="POST">
            <input type="hidden" name="_method" value="DELETE"/>
            <input type="hidden" name="id" value="<?= $address['id'] ?>"/>
            <button>USUŃ</button>
        </form>
    </div>
<?php endforeach; ?>