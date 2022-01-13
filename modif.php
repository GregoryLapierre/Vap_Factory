<?php 
echo "<form action='modif.php?ID=".$_GET['ID']."' method='post'>
<p>
    <label for='reference'>Référence :</label>
    <input type='number' name='reference' id='reference' min='0'>
</p>

<p>
    <label for='nom'>Nom :</label>
    <input type='text' name='nom' id='nom'>
</p>

<p>
    <label for='descriptions'>Description :</label>
    <input type='text' name='descriptions' id='descriptions'>
</p>

<p>
    <label for='prix_achat'>Prix d'achat unitaire en € :</label>
    <input type='number' name='prix_achat' id='prix_achat' min='0' step='0.01'>
</p>

<p>
<label for='prix_vente'>Prix de vente unitaire en € :</label>
    <input type='number' name='prix_vente' id='prix_vente' min='0' step='0.01'>
</p>

<p>
<label for='quantite'>Quantité :</label>
    <input type='number' name='quantite' id='quantite' min='0'>
</p>

<input type='submit' value='Modifier' />
<input type='reset' value='Effacer'/>
</form>";


$id=$_GET['ID'];

try
{   // On se connecte à MySQL;
	$mysqlClient = new PDO('mysql:host=localhost;dbname=Vap_Factory;charset=utf8', 'admin', 'adminpwd');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}

if(isset($_POST['reference']))
{   $reference = $_POST['reference'];
    $nom = $_POST['nom'];
    $descriptions = $_POST['descriptions'];
    $prix_achat = $_POST['prix_achat'];
    $prix_vente = $_POST['prix_vente'];
    $quantite = $_POST['quantite'];

    if (empty($reference)
    ||empty($nom)
    ||empty($descriptions)
    ||empty($prix_achat)
    ||empty($prix_vente)
    ||empty($quantite))
    {echo 'Il faut remplir l\'ensemble des données pour soumettre le tableau.<br><p></p>';
    }  

    else{$mysqlClient->query("UPDATE Articles SET Reference='$reference', Noms='$nom', Descriptions='$descriptions', Prix_achat_unitaire=$prix_achat, Prix_vente_unitaire=$prix_vente, Quantite_stock=$quantite 
WHERE ID = $id");

header('location:index.php');}
}

$req = $mysqlClient->query("SELECT * FROM Articles WHERE ID = $id");


//Création du tableau d'affichage et des titres de chaque colonne
echo '<table border="1" style="text-align: center">';
echo '<tr>
  <th>Références</th>
  <th>Noms</th>
  <th>Descriptions</th>
  <th>Prix d\'achat unitaire en €</th>
  <th>Prix de vente unitaire en €</th>
  <th>Quantité en stock</th>
    </tr>';

//Récupération de toutes les données avec fetch et insertion dans le tableau
  while ($data = $req->fetch(PDO:: FETCH_ASSOC)) {
  echo '<tr>
    <td>' . $data['Reference'] . '</td>
    <td>' . $data['Noms'] . '</td>
    <td>' . $data['Descriptions'] . '</td>
    <td>' . $data['Prix_achat_unitaire'] . '</td>
    <td>' . $data['Prix_vente_unitaire'] . '</td>
    <td>' . $data['Quantite_stock'] . '</td>
    </tr>';
}

echo '</table>';

?>