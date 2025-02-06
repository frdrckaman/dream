<div class="row">
    <div class="col-sm-4">
        <label>10a. Was the participant treated for TB before?</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('yes_no_unknown', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tx_previous" id="tx_previous<?= $value['id']; ?>"
                            value="<?= $value['id']; ?>" <?php if ($clients['tx_previous'] == $value['id']) {
                                  echo 'checked';
                              } ?> required>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <button type="button" onclick="unsetRadio('tx_previous')">Unset</button>
    </div>
    <div class="col-sm-4" id="tb_category_section">
        <label>10b. What category is the previously treated patient </label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('tb_category', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tb_category" id="tb_category<?= $value['id']; ?>"
                            value="<?= $value['id']; ?>" <?php if ($clients['tb_category'] == $value['id']) {
                                  echo 'checked';
                              } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <button type="button" onclick="unsetRadio('tb_category')">Unset</button>
        </div>
        <input class="form-control" type="text" name="tb_category_specify" id="tb_category_specify"
            placeholder="Specify Here..." value="<?php if ($clients['tb_category_specify']) {
                print_r($clients['tb_category_specify']);
            } ?>" />
    </div>

    <div class="col-sm-4" id="tx_number_section">
        <div class="row-form clearfix">
            <div class="form-group">
                <label for="tx_month">10c. When did the patient’s last treatment
                    episode end?</label>

                <!-- Row for Month and Year -->
                <div class="row">
                    <!-- Month Input -->
                    <div class="col-sm-6">
                        <label for="tx_month" class="form-label">Month</label>
                        <input class="form-control" type="number" name="tx_month" id="tx_month"
                            placeholder="Type Month..." min="1" max="12" value="<?php if ($clients['tx_month']) {
                                print_r($clients['tx_month']);
                            } ?>" />

                        <!-- Unknown Month Checkbox -->
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="tx_unknown_month"
                                name="tx_unknown_month" value="1" <?php if ($clients['tx_unknown_month'] ?? false) {
                                    echo 'checked';
                                } ?>>
                            <label class="form-check-label" for="tx_unknown_month">if month unknown Check
                                Unknown, fill 99 for month on paper</label>
                        </div>
                    </div>

                    <!-- Year Input -->
                    <div class="col-sm-6">
                        <label for="tx_year" class="form-label">Year</label>
                        <input class="form-control" type="number" name="tx_year" id="tx_year" placeholder="Type Year..."
                            min="1970" max="2025" value="<?php if ($clients['tx_year']) {
                                print_r($clients['tx_year']);
                            } ?>" />

                        <!-- Unknown Year Checkbox -->
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="tx_unknown_year" name="tx_unknown_year"
                                value="1" <?php if ($clients['tx_unknown_year'] ?? false) {
                                    echo 'checked';
                                } ?>>
                            <label class="form-check-label" for="tx_unknown_year">Month and year
                                unknown</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tx_previous_section">
</div>