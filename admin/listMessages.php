<?php 

require_once '../inc/connect.php';
require_once '../inc/session.php';
require_once '../vendor/autoload.php';

if (!isset($is_logged)) {
    header('Location:login.php');
    die;
}

$page = (isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;
$max = 10;

$debut = ($page - 1) * $max; 

    $count = $bdd->prepare('SELECT count(*) as total FROM message ');



$query = $bdd->prepare('SELECT * FROM message LIMIT  :max OFFSET :debut');

$query->bindValue(':debut',$debut,PDO::PARAM_INT);
$query->bindValue(':max',$max,PDO::PARAM_INT);

if ($query->execute()) {
	$users = $query->fetchAll(PDO::FETCH_ASSOC);

}

if($count->execute()){
    $total = $count->fetch(PDO::FETCH_ASSOC);
    $nb = $total['total'];
}
    else {
        var_dump($query->errorInfo());
        die;
    }


require_once 'header.php';

 ?>


 <?php if ($is_logged == 'admin'): ?>
    <div>
        <h2>Messages reçus</h2>
        
            <table class="table">
                <thead>
                    <tr>
                        <th>Lu/Non lu</th>
                        <th>Objet</th>
                        <th>Expéditeur</th>
                        <th>Action</th>

                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= ($user['read_msg'] == 0)? 'non lu': 'lu' ; ?></td>
                            <td><?=$user['subject']?></td>
                            <td><?=$user['email']?></td>

                            <td>
                                <a  href="view_message.php?id=<?=$user['id'];?>" title="Voir le message">Voir le message</a>
                                &nbsp; - &nbsp;
                                <a href="deleteMessage.php?id=<?=$user['id'];?>" title="Editer cet utilisateur">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php $search = (isset($_GET['search']))? 'search='. $_GET['search'].'&' :'';  ?>
                <div>Page <?= $page; ?> / <?= ceil($nb/$max); ?><?= ($page!=1) ? '<a href="?'. $search .'page='. ($page - 1) .'">Page précédente</a>':''; ?>
                <?= $page!= ceil($nb/$max) ? '<a href="?'. $search .'page='. ($page + 1) .'">Page suivante</a>':''; ?>

                </div>
    </div>

    <hr>
<?php endif; ?>