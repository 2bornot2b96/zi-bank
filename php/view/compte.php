<?php
if (isset($_SESSION['user_logged'])) {
  require_once('php/model/model.php');
  $compte = req_get_account($_SESSION['user_logged'], $_SESSION['user_pass']);
} else {
  header('location: index.php');
}
?>
<?php $title = 'Zi Banke - compte' ?>

<?php ob_start(); ?>

<section class="compte">
  <?php if (isset($_SESSION['notice'])) : ?>
    <p><span><?= $_SESSION['notice'] ?></span></p>
    <?php unset($_SESSION['notice']); ?>
  <?php endif; ?>
  <div class="block">
    <h2>bonjour <?= $compte['users_prenom'] ?> <?= $compte['users_nom'] ?></h2>
    <p>votre solde est de : <br><span><?= $compte['solde'] ?></span></p>
  </div>
  <!--accordeon-->
  <div class="accordion accordion-flush mt-4" id="accordionFlushExample">
    <!--virement-->
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingOne">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
          Effectuer un virement
        </button>
      </h2>
      <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
        <form action="index.php?action=virement" method="POST" class="accordion-body">
          <!--virement contenu-->
          <label for="select-beneficiaire">type de compte a crediter :</label>
          <select name="virage" id="select-beneficiare" title="choisissez" required>
            <option value="">--choisir--</option>
            <option value="autre">autre</option>
            <option value="compte-Zibanke">compte Zi banke</option>
          </select>
          <div class="mt-4">
            <label for="compte-beneficiaire">destinataire:</label>
            <input type="text" id="compte-beneficiaire" name="from" autocomplete="off" required>
          </div>
          <div class="mt-4">
            <label for="virage-amount">montant:</label>
            <input type="number" id="virage-amount" min="0" name="amount" autocomplete="off" required>
          </div>
          <input type="submit" value="Envoyer" class="button mt-4" id="virage-go">
        </form>
      </div>
    </div>
    <!--depôt-->
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingTwo">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
          Effectuer un depôt
        </button>
      </h2>
      <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
        <form action="index.php?action=depot" method="POST" class="accordion-body">
          <!--depôt contenu-->
          <label for="depose">montant à deposer:</label>
          <input type="number" min="0" id="depose" name="amount">
          <input type="submit" value="deposer" id="depot-go" class="button">
        </form>
      </div>
    </div>
    <!--historique-->
    <div class="accordion-item">
      <h2 class="accordion-header" id="flush-headingThree">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
          Historique
        </button>
      </h2>
      <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
        <div class="accordion-body">
          <!--historique contenu-->
          <h2>virement:</h2>
          <table>
            <thead>
              <tr>
                <td>en faveur de</td>
                <td>montant</td>
                <td>date</td>
              </tr>
            </thead>
            <tbody id="histoire">
              <?php $historicSend = req_get_send($compte['users_id']);
              foreach ($historicSend as $historic) : ?>
                <tr>
                  <td>
                    <?php if (!empty($historic['adds'])) : ?>
                      <?= $historic['adds'] ?>
                    <?php else : ?>
                      <?= $historic['prenom'] ?> <?= $historic['nom'] ?>
                    <?php endif; ?></td>
                  <td>- <?= $historic['amount'] ?></td>
                  <td><?= $historic['dates'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <!-- reçu -->
          <h2>depôt:</h2>
          <table>
            <thead>
              <tr>
                <td>de la pars de</td>
                <td>montant</td>
                <td>date</td>
              </tr>
            </thead>
            <tbody id="histoire">
              <?php $historicReceived = req_get_received($compte['users_id']);
              foreach ($historicReceived as $historic) : ?>
                <tr>
                  <td>
                    <?php if (!empty($historic['adds'])) : ?>
                      <?= $historic['adds'] ?>
                    <?php else : ?>
                      <?= $historic['prenom'] ?> <?= $historic['nom'] ?>
                    <?php endif; ?></td>
                  <td>+ <?= $historic['amount'] ?></td>
                  <td><?= $historic['dates'] ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--fin accordeon-->
</section>

<?php $content = ob_get_clean(); ?>
<?php require('php/template/template.php'); ?>