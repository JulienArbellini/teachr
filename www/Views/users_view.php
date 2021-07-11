<div class="row col-m-12 col-m-up-3 col-m-padding-12">
    <div class="col-m-3 col-m-center">
        <h1>Utilisateurs</h1>
    </div>
<div>
<div class="row col-m-12 col-m-padding-down-5 col-m-center">
    <div class="col-m-3 col-m-padding-1 col-m-center col-m-pull-3">
        <a href="#modal-add" class="js-modal invitation-link"><img src="../framework/img/add-user.png" alt="add-user" width="20" height="20"/> Inviter un utilisateur</a>
    </div>
    <div class="shadow-box-square col-m-12 col-s-12">
        <table id='tab' class="display">
            <thead>
                <tr><th>Identifiant</th><th>Nom</th><th>Prénom</th><th>Adresse email</th><th>Rôle</th><th>Dernière connexion</th><th>Modifier</th><th>Supprimer</th></tr>
            </thead>
            <tbody>
            <?php
                foreach($donnees as $key => $value){
                    $html = "<tr>
                                <td>".($value['pseudo'])."</td>
                                <td>".($value['lastname'])."</td>
                                <td>".($value['firstname'])."</td>
                                <td>".($value['email'])."</td>
                                <td>".($value['status'])."</td>
                                <td>".($value['createdAtUser'])."</td>
                                <td><a href=\"#modal-edit".($value['id'])."\" value=\"".($value['id'])."\" class=\"js-modal update\">&#9998</a></th>
                                <td><a href=\"#modal-delete".($value['id'])."\" class=\"js-modal supp\">&#x2717</a></td>
                            </tr> ";

                    echo $html;    
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<?php foreach($donnees as $key => $value)
    { ?>
        <aside id="modal-delete<?= $value['id']?>" class="modal modal-delete" aria-hidden="true" role="dialog" aria-labelledby="title-modal-delete" style="display:none;">
            <div class="modal-wrapper js-modal-stop title-modal">
                <div class="container1">
                    <h1 id="title-modal-delete">Êtes-vous sûr de vouloir supprimer cet utilisateur ?</h1>
                    <p><strong>Identifiant : </strong><?= $value['pseudo']; ?><p>
                    <p><strong>Adresse email : </strong><?= $value['email']; ?><p>
                    <p><strong>Rôle : </strong><?= $value['status']; ?><p>
                    <div class="container2">
                        <button class="js-modal-close">Annuler</button>
                        <button class="js-modal-stop" value="<?= $value['id']; ?>" onclick="window.location.href='/utilisateurs?deleteId=<?= $value['id']; ?>&module=base&action=users'">Supprimer</button>
                    </div>
                </div>
            </div>
        </aside>  


        <aside id="modal-edit<?= $value['id']?>" class="modal modal-edit" aria-hidden="true" role="dialog" aria-labelledby="title-modal-edit" style="display:none;">
            <div class="modal-wrapper js-modal-stop title-modal">
                <div class="container1">
                    <h1 id="title-modal-edit">Modifier l'utilisateur</h1>
                    <form class="form_update_user" method="POST" action="/utilisateurs?updateId=<?= $value['id']; ?>">
                        <div class="details-part">  
                            <label for="nom">Nom :</label>
                            <input type="text" id="nom" name="lastname" value="<?= $value['lastname']; ?>">
                        </div>
                        <div class="details-part">
                            <label for="prenom">Prenom :</label>
                            <input type="text" id="prenom" name="firstname" value="<?= $value['firstname']; ?>">
                        </div>
                        <div class="details-part">
                            <label for="rôle">Rôle :</label>
                            <select id="rôle" name="role">
                                <option value="<?= $value['Role_idRole'] ?>"><?php echo $value['status']; ?>
                                    <?php foreach($data as $key => $val){ ?>
                                        <option value="<?= $val['id']; ?>"><?= $val['status']; ?>
                                    <?php } ?>
                            </select>
                        </div>
                        <div class="container2">
                            <button class="js-modal-close">Annuler</button>
                            <button type="submit" class="js-modal-stop" value="<?= $value['id']; ?>">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </aside>      
<?php        
    }
?>


<aside id="modal-add" class="modal modal-add" aria-hidden="true" role="dialog" aria-labelledby="title-modal-add" style="display:none;">
    <div class="modal-wrapper js-modal-stop title-modal">
        <div class="container1">
            <h1 id="title-modal-add">Inviter un utilisateur</h1>
            
            <?php if(!empty($formErrors)):?>
                <?php foreach($formErrors as $error):?>
                    <li><?= $error ;?>
                <?php endforeach;?>
            <?php endif;?>

            <?php App\Core\Form::showFormUser($form, $data); ?>
        </div>
    </div>
</aside>   


<script src="../framework/src/js/int-datatables.js"></script>
<script src="../framework/src/js/modal.js"></script>
<script src="../framework/src/js/users.js"></script>