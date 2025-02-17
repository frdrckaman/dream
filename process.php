<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
header('Content-Type: application/json');


if ($_GET['content'] == 'xpert_mtb') {
    if ($_GET['xpert_mtb'] == 3 || $_GET['xpert_mtb'] == 4 || $_GET['xpert_mtb'] == 5 || $_GET['xpert_mtb'] == 6) {
        $rif_resistance = $override->get('rif_resistance', 'status', 1);
    } elseif ($_GET['xpert_mtb'] == 2) {
        $rif_resistance = $override->get('rif_resistance', 'status1', 1);
        ?>
        <div>
            <?php foreach ($rif_resistance as $value) { ?>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ward" id="ward<?= $ward['id']; ?>"
                        value="<?= $value['id']; ?>" <?php if ($_GET['ward_id'] == $value['id']) {
                              echo 'checked';
                          } ?>>
                    <label class="form-check-label" for="ward<?= $value['id']; ?>"><?= $value['name']; ?></label>
                </div>
            <?php } ?>
        </div>
        <?php
    }
}
?>