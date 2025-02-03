from the above three files adjust this inputs from form with id "labForm_clinic" so it can work perfectly i will give
rest of forms inputs later start with this first"
<hr>
<div class="row">
    <div class="col-sm-4">
        <label for="sample_received" class="form-label">2. Is at least one
            sputum sample received?</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample_received"
                            id="sample_received<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_received'] == $value['id']) {
                                    echo 'checked';
                                } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <button type="button" onclick="unsetRadio('sample_received')">Unset</button>
    </div>

    <div class="col-sm-4" id="sample_reason">
        <label for="tested_this_month" class="form-label">2(c). If no give
            reason</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('sample_reason', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sample_reason"
                            id="sample_reason<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_reason'] == $value['id']) {
                                    echo 'checked';
                                } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <button type="button" onclick="unsetRadio('sample_reason')">Unset</button>
        </div>
        <input type="text" value="<?php if ($costing['other_reason']) {
            print_r($costing['other_reason']);
        } ?>" id="other_reason" name="other_reason" class="form-control"
            placeholder="If No give reasons here" />
    </div>

    <div class="col-sm-4" id="new_sample">
        <label for="new_sample" class="form-label">2(d). was a new sample
            collected?</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="new_sample" id="new_sample<?= $value['id']; ?>"
                            value="<?= $value['id']; ?>" <?php if ($costing['new_sample'] == $value['id']) {
                                  echo 'checked';
                              } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <button type="button" onclick="unsetRadio('new_sample')">Unset</button>
        </div>

        <input type="text" value="<?php if ($costing['new_reason']) {
            print_r($costing['new_reason']);
        } ?>" id="new_reason" name="new_reason" class="form-control"
            placeholder="If No give reasons here" />
    </div>

</div>
<hr>
<div class="row">
    <?php
    // Fetch enrollment_date from database
    $enrollment_date = ''; // Replace with actual query to fetch enrollment_date
    if ($enrollment['enrollment_date']) {
        $enrollment_date = $enrollment['enrollment_date'];
    }
    ?>
    <input type="hidden" id="enrollment_date_hidded" value="<?php echo $enrollment_date; ?>" />

    <div class="col-sm-6" id="date_collected">
        <div class="col-12">
            <label class="form-label">3. Date sample(s) collected?</label>
            <div class="mb-3">
                <input type="date" value="<?php echo $costing['date_collected'] ?? ''; ?>" id="date_collected_input"
                    name="date_collected" class="form-control" placeholder="Enter here" />
                <span id="date_collected_error" class="text-danger"></span>
            </div>
        </div>
    </div>

    <div class="col-sm-6" id="date_received">
        <label class="form-label">3. Date sample(s) Received?</label>
        <div class="mb-3">
            <input type="date" value="<?php echo $costing['date_received'] ?? ''; ?>" id="date_received_input"
                name="date_received" class="form-control" placeholder="Enter here" />
            <span id="date_received_error" class="text-danger"></span>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-4" id="appearance">
        <label for="appearance" class="form-label">7. Appearance</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('appearance', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="appearance" id="appearance<?= $value['id']; ?>"
                            value="<?= $value['id']; ?>" <?php if ($costing['appearance'] == $value['id']) {
                                  echo 'checked';
                              } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
            <button type="button" onclick="unsetRadio('appearance')">Unset</button>

        </div>
    </div>

    <div class="col-4" id="sample_volume">
        <div class="mb-3">
            <label for="sample_volume" class="form-label">8. Approximate
                volume
                sample</label>
            <input type="number" value="<?php if ($costing['sample_volume']) {
                print_r($costing['sample_volume']);
            } ?>" id="sample_volume" name="sample_volume" min="1" max="5"
                class="form-control" placeholder="Enter here" />
        </div>
        <span>mL</span>
    </div>

    <div class="col-4" id="afb_microscopy">
        <label for="afb_microscopy" class="form-label">6(a). Was AFB microscopy
            conducted at TB clinic?</label>
        <!-- radio -->
        <div class="row-form clearfix">
            <div class="form-group">
                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="afb_microscopy"
                            id="afb_microscopy<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['afb_microscopy'] == $value['id']) {
                                    echo 'checked';
                                } ?>>
                        <label class="form-check-label"><?= $value['name']; ?></label>
                    </div>
                <?php } ?>
            </div>
        </div>
        <button type="button" onclick="unsetRadio('afb_microscopy')">Unset</button>
    </div>
</div>
<hr>

"