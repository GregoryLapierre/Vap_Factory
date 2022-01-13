<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try
{
	// On se connecte à MySQL;
	$mysqlClient = new PDO('mysql:host=localhost;dbname=Vap_Factory;charset=utf8', 'admin', 'adminpwd');
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(Exception $e)
{
	// En cas d'erreur, on affiche un message et on arrête tout
        die('Erreur : '.$e->getMessage());
}


if(isset($_POST['reference' ]))
{
    $reference = $_POST['reference'];
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
    {echo 'Il faut remplir l\'ensemble des données pour soumettre le tableau.';
    return;
    }
// Si tout va bien, on peut continuer

// Ecriture de la requête pour insérer un article
$sqlQuery = "INSERT INTO Articles (Reference,Noms, Descriptions, Prix_achat_unitaire, Prix_vente_unitaire, Quantite_stock) 
VALUES ('$reference', '$nom', '$descriptions', $prix_achat, $prix_vente, $quantite)";

$mysqlClient->exec($sqlQuery);

}


 
// Je peux maintenant effectuer des requêtes préparées depuis l'objet $mysqlClient afin d'afficher mon tableau
// Préparation ...
$req = $mysqlClient->prepare('SELECT * FROM Articles');

// ... Exécution !
$req->execute();

//Création du tableau d'affichage et des titres de chaque colonne
echo '<table border="1" style="text-align: center">';
echo '<tr>
  <th>ID</th>
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
    <td>' . $data['ID'] . '</td>
    <td>' . $data['Reference'] . '</td>
    <td>' . $data['Noms'] . '</td>
    <td>' . $data['Descriptions'] . '</td>
    <td>' . $data['Prix_achat_unitaire'] . '</td>
    <td>' . $data['Prix_vente_unitaire'] . '</td>
    <td>' . $data['Quantite_stock'] . '</td>
    <td><a href="delete.php?ID='.$data['ID'].'">Effacer</a></td>
    </tr>';
}

echo '</table>';




?>