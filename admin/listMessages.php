<?php 

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}



$query = $bdd->prepare('SELECT * FROM message');
if ($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);

}


require_once 'header.php';

 ?>


 <?php if ($is_logged == 'admin'): ?>
    <div>
        <h2>Vos Messages:</h2>
        
            <table class="table">
                <thead>
                    <tr>
                        <th>Lu/Pas lu</th>
                        <th>Sujet</th>
                        <th>email</th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= ($user['read_msg'] == 0)? 'non lu': 'lu' ; ?></td>
                            <td><?=$user['subject']?></td>
                            <td><?=$user['email']?></td>

                            <td>
                                <a  href="view_message.php?id=<?=$user['id'];?>" title="Voir le message">Voir message</a>
                                &nbsp; - &nbsp;
                                <a href="delete_message.php?id=<?=$user['id'];?>" title="Editer cet utilisateur">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
    </div>

    <hr>
<?php endif; ?>