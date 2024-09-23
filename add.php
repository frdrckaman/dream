<?php
require_once 'php/core/init.php';
$user = new User();
$override = new OverideData();
$email = new Email();
$random = new Random();
$validate = new validate();

$successMessage = null;
$pageError = null;
$errorMessage = null;
$numRec = 10;
if ($user->isLoggedIn()) {
    if (Input::exists('post')) {
        if (Input::get('add_user')) {
            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);
            if ($staff) {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'position' => array(
                        'required' => true,
                    ),
                    'site_id' => array(
                        'required' => true,
                    ),
                    'username' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'phone_number' => array(
                        'required' => true,
                        'unique' => 'user'
                    ),
                    'email_address' => array(
                        'unique' => 'user'
                    ),
                ));
            }
            if ($validate->passed()) {
                $salt = $random->get_rand_alphanumeric(32);
                $password = '12345678';
                switch (Input::get('position')) {
                    case 1:
                        $accessLevel = 1;
                        break;
                    case 2:
                        $accessLevel = 1;
                        break;
                    case 3:
                        $accessLevel = 2;
                        break;
                    case 4:
                        $accessLevel = 3;
                        break;
                    case 5:
                        $accessLevel = 3;
                        break;
                }
                try {

                    // $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

                    if ($staff) {
                        $user->updateRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => Input::get('accessLevel'),
                            'power' => Input::get('power'),
                            'site_id' => Input::get('site_id'),
                        ), $_GET['staff_id']);

                        $successMessage = 'Account Updated Successful';
                    } else {
                        $user->createRecord('user', array(
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'username' => Input::get('username'),
                            'phone_number' => Input::get('phone_number'),
                            'phone_number2' => Input::get('phone_number2'),
                            'email_address' => Input::get('email_address'),
                            'sex' => Input::get('sex'),
                            'position' => Input::get('position'),
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
                            'create_on' => date('Y-m-d'),
                            'last_login' => '',
                            'status' => 1,
                            'user_id' => $user->data()->id,
                            'site_id' => Input::get('site_id'),
                            'count' => 0,
                            'pswd' => 0,
                        ));
                        $successMessage = 'Account Created Successful';
                    }

                    Redirect::to('info.php?id=1&status=1');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_positions')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $position = $override->getNews('position', 'status', 1, 'id', $_GET['position_id']);
                    if ($position) {
                        $user->updateRecord('position', array(
                            'name' => Input::get('name'),
                        ), $_GET['position_id']);
                        $successMessage = 'Position Successful Updated';
                    } else {
                        $user->createRecord('position', array(
                            'name' => Input::get('name'),
                            'access_level' => 1,
                            'status' => 1,
                        ));
                        $successMessage = 'Position Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_sites')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id']);
                    if ($site) {
                        $user->updateRecord('sites', array(
                            'name' => Input::get('name'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['site_id']);
                        $successMessage = 'Site Successful Updated';
                    } else {
                        $user->createRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => date('Y-m-d'),
                            'arm' => 1,
                            'level' => 1,
                            'type' => 1,
                            'category' => 1,
                            'respondent' => 2,
                            'region' => 1,
                            'district' => 1,
                            'ward' => 1,
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));
                        $successMessage = 'Site Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_site')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id']);
                    if ($site) {
                        $user->updateRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $site[0]['id']);
                        $successMessage = 'Site Successful Updated';
                    } else {
                        $user->createRecord('sites', array(
                            'name' => Input::get('name'),
                            'entry_date' => Input::get('entry_date'),
                            'arm' => Input::get('arm'),
                            'level' => Input::get('level'),
                            'type' => Input::get('type'),
                            'category' => Input::get('category'),
                            'respondent' => Input::get('respondent'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));
                        $successMessage = 'Site Successful Added';
                    }

                    // $user->visit_delete1($_GET['site_id'], Input::get('visit_date'), $_GET['site_id'], $user->data()->id, $_GET['site_id'], $eligible, $sequence, $visit_code, $visit_name);

                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_client')) {
            $validate = $validate->check($_POST, array(
                'date_enrolled' => array(
                    'required' => true,
                ),
                'firstname' => array(
                    'required' => true,
                ),
                'lastname' => array(
                    'required' => true,
                ),
                'sex' => array(
                    'required' => true,
                ),
                'site' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $years = $user->dateDiffYears(Input::get('date_enrolled'), Input::get('dob'));
                    $age = $user->dateDiffYears(Input::get('date_enrolled'), Input::get('dob'));

                    if ($clients) {
                        $user->updateRecord('clients', array(
                            'sequence' => -1,
                            'visit_code' => 'RV',
                            'visit_name' => 'Registration Visit',
                            'clinician_firstname' => Input::get('clinician_firstname'),
                            'clinician_middlename' => Input::get('clinician_middlename'),
                            'clinician_lastname' => Input::get('clinician_lastname'),
                            'clinician_phone' => Input::get('clinician_phone'),
                            'site_id' => Input::get('site'),
                            'facility_district' => Input::get('facility_district'),
                            'date_enrolled' => Input::get('date_enrolled'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'patient_phone' => Input::get('patient_phone'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'comments' => Input::get('comments'),
                            'respondent' => 2,
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', 0);

                        if ($visit) {
                            $user->updateRecord('visit', array(
                                'sequence' => 0,
                                'visit_code' => 'SV',
                                'visit_name' => 'Screening Visit',
                                'respondent' => 2,
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('date_enrolled'),
                                'visit_date' => Input::get('date_enrolled'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => Input::get('site'),
                                'table_id' => $clients[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => Input::get('site'),
                            ), $visit[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'sequence' => 0,
                                'visit_code' => 'SV',
                                'visit_name' => 'Screening Visit',
                                'respondent' => 2,
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('date_enrolled'),
                                'visit_date' => Input::get('date_enrolled'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => Input::get('site'),
                                'table_id' => $clients[0]['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => Input::get('site'),
                            ));
                        }

                        $successMessage = 'Client Updated Successful';
                    } else {

                        // $std_id = $override->getNews('study_id', 'site_id', Input::get('site'), 'status', 0)[0];
                        $std_id = $override->get('study_id', 'status', 0)[0];


                        $user->createRecord('clients', array(
                            'sequence' => -1,
                            'visit_code' => 'RV',
                            'visit_name' => 'Registration Visit',
                            'clinician_firstname' => Input::get('clinician_firstname'),
                            'clinician_middlename' => Input::get('clinician_middlename'),
                            'clinician_lastname' => Input::get('clinician_lastname'),
                            'clinician_phone' => Input::get('clinician_phone'),
                            'site_id' => Input::get('site'),
                            'facility_district' => Input::get('facility_district'),
                            'study_id' => $std_id['study_id'],
                            'date_enrolled' => Input::get('date_enrolled'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'patient_phone' => Input::get('patient_phone'),
                            'region' => Input::get('region'),
                            'district' => Input::get('district'),
                            'ward' => Input::get('ward'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'comments' => Input::get('comments'),
                            'respondent' => 2,
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'visit_code' => 'SV',
                            'visit_name' => 'Screening Visit',
                            'respondent' => 2,
                            'study_id' => $std_id['study_id'],
                            'pid' => $std_id['study_id'],
                            'expected_date' => Input::get('date_enrolled'),
                            'visit_date' => Input::get('date_enrolled'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => Input::get('site'),
                            'table_id' => $last_row['id'],
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => Input::get('site'),
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_enrollment_form')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                    $enrollment_form = $override->getNews('enrollment_form', 'status', 1, 'patient_id', $_GET['cid']);

                    $diseases_medical = implode(',', Input::get('diseases_medical'));
                    $sputum_samples = implode(',', Input::get('sputum_samples'));
                    $dr_ds = implode(',', Input::get('dr_ds'));
                    print_r(Input::get('tb_otcome'));
                    if ($enrollment_form) {
                        $user->updateRecord('enrollment_form', array(
                            'visit_date' => Input::get('visit_date'),
                            'cough2weeks' => Input::get('cough2weeks'),
                            'cough_any' => Input::get('cough_any'),
                            'poor_weight' => Input::get('poor_weight'),
                            'coughing_blood' => Input::get('coughing_blood'),
                            'unexplained_fever' => Input::get('unexplained_fever'),
                            'night_sweats' => Input::get('night_sweats'),
                            'neck_lymph' => Input::get('neck_lymph'),
                            'history_tb' => Input::get('history_tb'),
                            'tx_previous' => Input::get('tx_previous'),
                            'tx_number' => Input::get('tx_number'),
                            'dr_ds' => $dr_ds,
                            'tb_category' => Input::get('tb_category'),
                            'relapse_years' => Input::get('relapse_years'),
                            'ltf_months' => Input::get('ltf_months'),
                            'tb_regimen' => Input::get('tb_regimen'),
                            'regimen_months' => Input::get('regimen_months'),
                            'regimen_changed' => Input::get('regimen_changed'),
                            'regimen_name' => Input::get('regimen_name'),
                            'tb_otcome' => Input::get('tb_otcome'),
                            'hiv_status' => Input::get('hiv_status'),
                            'immunosuppressive' => Input::get('immunosuppressive'),
                            'immunosuppressive_specify' => Input::get('immunosuppressive_specify'),
                            'other_diseases' => Input::get('other_diseases'),
                            'diseases_medical' => $diseases_medical,
                            'diseases_specify' => Input::get('diseases_specify'),
                            'sputum_collected' => Input::get('sputum_collected'),
                            'sample_date' => Input::get('sample_date'),
                            'other_samples' => Input::get('other_samples'),
                            'sputum_samples' => $sputum_samples,
                            'pleural_fluid_date' => Input::get('pleural_fluid_date'),
                            'csf_date' => Input::get('csf_date'),
                            'peritoneal_fluid_date' => Input::get('peritoneal_fluid_date'),
                            'pericardial_fluid_date' => Input::get('pericardial_fluid_date'),
                            'lymph_node_aspirate_date' => Input::get('lymph_node_aspirate_date'),
                            'stool_date' => Input::get('stool_date'),
                            'sputum_samples_date' => Input::get('sputum_samples_date'),
                            'chest_x_ray' => Input::get('chest_x_ray'),
                            'chest_x_ray_date' => Input::get('chest_x_ray_date'),
                            'enrollment_completed' => Input::get('enrollment_completed'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Enrollment Form Updated Successful';
                    } else {
                        $user->createRecord('enrollment_form', array(
                            'vid' => $_GET['vid'],
                            'sequence' => $_GET['sequence'],
                            'visit_code' => $_GET['visit_code'],
                            'pid' => $clients['study_id'],
                            'study_id' => $clients['study_id'],
                            'visit_date' => Input::get('visit_date'),
                            'cough2weeks' => Input::get('cough2weeks'),
                            'cough_any' => Input::get('cough_any'),
                            'poor_weight' => Input::get('poor_weight'),
                            'coughing_blood' => Input::get('coughing_blood'),
                            'unexplained_fever' => Input::get('unexplained_fever'),
                            'night_sweats' => Input::get('night_sweats'),
                            'neck_lymph' => Input::get('neck_lymph'),
                            'history_tb' => Input::get('history_tb'),
                            'tx_previous' => Input::get('tx_previous'),
                            'tx_number' => Input::get('tx_number'),
                            'dr_ds' => $dr_ds,
                            'tb_category' => Input::get('tb_category'),
                            'relapse_years' => Input::get('relapse_years'),
                            'ltf_months' => Input::get('ltf_months'),
                            'tb_regimen' => Input::get('tb_regimen'),
                            'regimen_months' => Input::get('regimen_months'),
                            'regimen_changed' => Input::get('regimen_changed'),
                            'regimen_name' => Input::get('regimen_name'),
                            'tb_otcome' => Input::get('tb_otcome'),
                            'hiv_status' => Input::get('hiv_status'),
                            'immunosuppressive' => Input::get('immunosuppressive'),
                            'immunosuppressive_specify' => Input::get('immunosuppressive_specify'),
                            'other_diseases' => Input::get('other_diseases'),
                            'diseases_medical' => $diseases_medical,
                            'diseases_specify' => Input::get('diseases_specify'),
                            'sputum_collected' => Input::get('sputum_collected'),
                            'sample_date' => Input::get('sample_date'),
                            'other_samples' => Input::get('other_samples'),
                            'sputum_samples' => $sputum_samples,
                            'pleural_fluid_date' => Input::get('pleural_fluid_date'),
                            'csf_date' => Input::get('csf_date'),
                            'peritoneal_fluid_date' => Input::get('peritoneal_fluid_date'),
                            'pericardial_fluid_date' => Input::get('pericardial_fluid_date'),
                            'lymph_node_aspirate_date' => Input::get('lymph_node_aspirate_date'),
                            'stool_date' => Input::get('stool_date'),
                            'sputum_samples_date' => Input::get('sputum_samples_date'),
                            'chest_x_ray' => Input::get('chest_x_ray'),
                            'chest_x_ray_date' => Input::get('chest_x_ray_date'),
                            'enrollment_completed' => Input::get('enrollment_completed'),
                            'respondent' => 2,
                            'patient_id' => $clients['id'],
                            'status' => 1,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients['site_id'],
                        ));

                        $successMessage = 'Enrollment Form  Added Successful';
                    }
                    Redirect::to('info.php?id=4&cid=' . $_GET['sequence'] . '&status=7&msg=' . $successMessage);
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_diagnosis_test')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'culture_done' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('diagnosis_test', 'status', 1, 'patient_id', $_GET['cid']);
                $first_line = 0;
                $second_line = 0;
                $third_line = 0;
                $sequence = '';
                $visit_code = '';
                $visit_name = '';

                if (Input::get('first_line')) {
                    $first_line = Input::get('first_line');
                }

                if (Input::get('second_line')) {
                    $second_line = Input::get('second_line');
                }

                if (Input::get('third_line')) {
                    $third_line = Input::get('third_line');
                }

                // $expected_date = date('Y-m-d', strtotime('+1 month', strtotime(Input::get('visit_date'))));

                // $last_visit = $override->getlastRow1('visit', 'patient_id', $clients['id'], 'sequence', $_GET['sequence'], 'id')[0];
                $sequence = intval($_GET['sequence']) + 1;
                if ($sequence) {
                    $visit_code = 'M' . $sequence;
                    $visit_name = 'Month ' . $sequence;
                }

                $enrolled = 0;
                $end_study = 0;
                if (Input::get('next_appointment') == 1) {
                    $enrolled = 1;
                }

                $sample_methods = implode(',', Input::get('sample_methods'));
                $genotyping_asay = implode(',', Input::get('genotyping_asay'));
                $nanopore_sequencing = implode(',', Input::get('nanopore_sequencing'));
                $_1st_line_drugs = implode(',', Input::get('_1st_line_drugs'));
                $_2st_line_drugs = implode(',', Input::get('_2st_line_drugs'));

                if ($individual) {
                    $user->updateRecord('diagnosis_test', array(
                        'visit_date' => Input::get('visit_date'),
                        'culture_done' => Input::get('culture_done'),
                        'sample_type2' => Input::get('sample_type2'),
                        'sample_type_other2' => Input::get('sample_type_other2'),
                        'sample_methods' => $sample_methods,
                        'lj_date' => Input::get('lj_date'),
                        'mgit_date' => Input::get('mgit_date'),
                        'lj_results' => Input::get('lj_results'),
                        'mgit_results' => Input::get('mgit_results'),
                        'phenotypic_method' => Input::get('phenotypic_method'),
                        'phenotypic_done' => Input::get('phenotypic_done'),
                        'apm_date' => Input::get('apm_date'),
                        'mgit_date2' => Input::get('mgit_date2'),
                        'rifampicin' => Input::get('rifampicin'),
                        'isoniazid' => Input::get('isoniazid'),
                        'levofloxacin' => Input::get('levofloxacin'),
                        'moxifloxacin' => Input::get('moxifloxacin'),
                        'bedaquiline' => Input::get('bedaquiline'),
                        'linezolid' => Input::get('linezolid'),
                        'clofazimine' => Input::get('clofazimine'),
                        'cycloserine' => Input::get('cycloserine'),
                        'terizidone' => Input::get('terizidone'),
                        'ethambutol' => Input::get('ethambutol'),
                        'delamanid' => Input::get('delamanid'),
                        'pyrazinamide' => Input::get('pyrazinamide'),
                        'imipenem' => Input::get('imipenem'),
                        'cilastatin' => Input::get('cilastatin'),
                        'meropenem' => Input::get('meropenem'),
                        'amikacin' => Input::get('amikacin'),
                        'streptomycin' => Input::get('streptomycin'),
                        'ethionamide' => Input::get('ethionamide'),
                        'prothionamide' => Input::get('prothionamide'),
                        'para_aminosalicylic_acid' => Input::get('para_aminosalicylic_acid'),
                        'genotyping_done' => Input::get('genotyping_done'),
                        'genotyping_asay' => $genotyping_asay,
                        'isoniazid2' => Input::get('isoniazid2'),
                        'fluoroquinolones' => Input::get('fluoroquinolones'),
                        'amikacin2' => Input::get('amikacin2'),
                        'kanamycin' => Input::get('kanamycin'),
                        'capreomycin' => Input::get('capreomycin'),
                        'ethionamide2' => Input::get('ethionamide2'),
                        'nanopore_sequencing_done' => Input::get('nanopore_sequencing_done'),
                        'nanopore_sequencing' => $nanopore_sequencing,
                        'rifampicin3' => Input::get('rifampicin3'),
                        'isoniazid3' => Input::get('isoniazid3'),
                        'levofloxacin3' => Input::get('levofloxacin3'),
                        'moxifloxacin3' => Input::get('moxifloxacin3'),
                        'bedaquiline3' => Input::get('bedaquiline3'),
                        'linezolid3' => Input::get('linezolid3'),
                        'clofazimine3' => Input::get('clofazimine3'),
                        'cycloserine3' => Input::get('cycloserine3'),
                        'terizidone3' => Input::get('terizidone3'),
                        'ethambutol3' => Input::get('ethambutol3'),
                        'delamanid3' => Input::get('delamanid3'),
                        'pyrazinamide3' => Input::get('pyrazinamide3'),
                        'imipenem3' => Input::get('imipenem3'),
                        'cilastatin3' => Input::get('cilastatin3'),
                        'meropenem3' => Input::get('meropenem3'),
                        'amikacin3' => Input::get('amikacin3'),
                        'streptomycin3' => Input::get('streptomycin3'),
                        'ethionamide3' => Input::get('ethionamide3'),
                        'prothionamide3' => Input::get('prothionamide3'),
                        'para_aminosalicylic_acid3' => Input::get('para_aminosalicylic_acid3'),
                        '_1st_line_drugs' => $_1st_line_drugs,
                        '_2st_line_drugs' => $_2st_line_drugs,
                        'version_number' => Input::get('version_number'),
                        'lot_number' => Input::get('lot_number'),
                        'mutations_detected_list' => Input::get('mutations_detected_list'),
                        'd_firstName' => Input::get('d_firstName'),
                        'd_middleName' => Input::get('d_middleName'),
                        'd_middleName' => Input::get('d_middleName'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual[0]['id']);

                    $successMessage = 'Diagnosis test  Successful Updated';
                } else {
                    $user->createRecord('diagnosis_test', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'culture_done' => Input::get('culture_done'),
                        'sample_type2' => Input::get('sample_type2'),
                        'sample_type_other2' => Input::get('sample_type_other2'),
                        'sample_methods' => $sample_methods,
                        'lj_date' => Input::get('lj_date'),
                        'mgit_date' => Input::get('mgit_date'),
                        'lj_results' => Input::get('lj_results'),
                        'mgit_results' => Input::get('mgit_results'),
                        'phenotypic_method' => Input::get('phenotypic_method'),
                        'phenotypic_done' => Input::get('phenotypic_done'),
                        'apm_date' => Input::get('apm_date'),
                        'mgit_date2' => Input::get('mgit_date2'),
                        'rifampicin' => Input::get('rifampicin'),
                        'isoniazid' => Input::get('isoniazid'),
                        'levofloxacin' => Input::get('levofloxacin'),
                        'moxifloxacin' => Input::get('moxifloxacin'),
                        'bedaquiline' => Input::get('bedaquiline'),
                        'linezolid' => Input::get('linezolid'),
                        'clofazimine' => Input::get('clofazimine'),
                        'cycloserine' => Input::get('cycloserine'),
                        'terizidone' => Input::get('terizidone'),
                        'ethambutol' => Input::get('ethambutol'),
                        'delamanid' => Input::get('delamanid'),
                        'pyrazinamide' => Input::get('pyrazinamide'),
                        'imipenem' => Input::get('imipenem'),
                        'cilastatin' => Input::get('cilastatin'),
                        'meropenem' => Input::get('meropenem'),
                        'amikacin' => Input::get('amikacin'),
                        'streptomycin' => Input::get('streptomycin'),
                        'ethionamide' => Input::get('ethionamide'),
                        'prothionamide' => Input::get('prothionamide'),
                        'para_aminosalicylic_acid' => Input::get('para_aminosalicylic_acid'),
                        'genotyping_done' => Input::get('genotyping_done'),
                        'genotyping_asay' => $genotyping_asay,
                        'isoniazid2' => Input::get('isoniazid2'),
                        'fluoroquinolones' => Input::get('fluoroquinolones'),
                        'amikacin2' => Input::get('amikacin2'),
                        'kanamycin' => Input::get('kanamycin'),
                        'capreomycin' => Input::get('capreomycin'),
                        'ethionamide2' => Input::get('ethionamide2'),
                        'nanopore_sequencing_done' => Input::get('nanopore_sequencing_done'),
                        'nanopore_sequencing' => $nanopore_sequencing,
                        'rifampicin3' => Input::get('rifampicin3'),
                        'isoniazid3' => Input::get('isoniazid3'),
                        'levofloxacin3' => Input::get('levofloxacin3'),
                        'moxifloxacin3' => Input::get('moxifloxacin3'),
                        'bedaquiline3' => Input::get('bedaquiline3'),
                        'linezolid3' => Input::get('linezolid3'),
                        'clofazimine3' => Input::get('clofazimine3'),
                        'cycloserine3' => Input::get('cycloserine3'),
                        'terizidone3' => Input::get('terizidone3'),
                        'ethambutol3' => Input::get('ethambutol3'),
                        'delamanid3' => Input::get('delamanid3'),
                        'pyrazinamide3' => Input::get('pyrazinamide3'),
                        'imipenem3' => Input::get('imipenem3'),
                        'cilastatin3' => Input::get('cilastatin3'),
                        'meropenem3' => Input::get('meropenem3'),
                        'amikacin3' => Input::get('amikacin3'),
                        'streptomycin3' => Input::get('streptomycin3'),
                        'ethionamide3' => Input::get('ethionamide3'),
                        'prothionamide3' => Input::get('prothionamide3'),
                        'para_aminosalicylic_acid3' => Input::get('para_aminosalicylic_acid3'),
                        '_1st_line_drugs' => $_1st_line_drugs,
                        '_2st_line_drugs' => $_2st_line_drugs,
                        'version_number' => Input::get('version_number'),
                        'lot_number' => Input::get('lot_number'),
                        'mutations_detected_list' => Input::get('mutations_detected_list'),
                        'd_firstName' => Input::get('d_firstName'),
                        'd_middleName' => Input::get('d_middleName'),
                        'd_middleName' => Input::get('d_middleName'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Diagnosis test  Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients['id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_respiratory')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'lab_name' => array(
                    'required' => true,
                ),
                'sample_received' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $costing = $override->get3('respiratory', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                $test_reasons = implode(',', Input::get('test_reasons'));

                if ($costing) {
                    $user->updateRecord('respiratory', array(
                        'visit_date' => Input::get('visit_date'),
                        'lab_name' => Input::get('lab_name'),
                        'sample_received' => Input::get('sample_received'),
                        'sample_amount' => Input::get('sample_amount'),
                        'sample_reason' => Input::get('sample_reason'),
                        'test_rejected' => Input::get('test_rejected'),
                        'test_reasons' => $test_reasons,
                        'test_reasons_other' => Input::get('test_reasons_other'),
                        'sample_date' => Input::get('sample_date'),
                        'sample_type' => Input::get('sample_type'),
                        'sample_type_other' => Input::get('sample_type_other'),
                        'sample_number' => Input::get('sample_number'),
                        'appearance' => Input::get('appearance'),
                        'sample_volume' => Input::get('sample_volume'),
                        'sample_accession' => Input::get('sample_accession'),
                        'afb_microscopy' => Input::get('afb_microscopy'),
                        'afb_microscopy_date' => Input::get('afb_microscopy_date'),
                        'zn_results_a' => Input::get('zn_results_a'),
                        'zn_results_b' => Input::get('zn_results_b'),
                        'fm_results_a' => Input::get('fm_results_a'),
                        'fm_results_b' => Input::get('fm_results_b'),
                        'wrd_test' => Input::get('wrd_test'),
                        'wrd_test_date' => Input::get('wrd_test_date'),
                        'sequence_done' => Input::get('sequence_done'),
                        'sequence_date' => Input::get('sequence_date'),
                        'sequence_type' => Input::get('sequence_type'),
                        'sequence_number' => Input::get('sequence_number'),
                        'mtb_detection' => Input::get('mtb_detection'),
                        'rif_resistance' => Input::get('rif_resistance'),
                        'ct_value' => Input::get('ct_value'),
                        'test_repeatition' => Input::get('test_repeatition'),
                        'microscopy_reason' => Input::get('microscopy_reason'),
                        'microscopy_reason_other' => Input::get('microscopy_reason_other'),
                        'respiratory_completness' => Input::get('respiratory_completness'),
                        'comments' => Input::get('comments'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ), $costing[0]['id']);

                    $successMessage = 'Respiratory Data  Successful Updated';
                } else {
                    $user->createRecord('respiratory', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'lab_name' => Input::get('lab_name'),
                        'sample_received' => Input::get('sample_received'),
                        'sample_amount' => Input::get('sample_amount'),
                        'sample_reason' => Input::get('sample_reason'),
                        'test_rejected' => Input::get('test_rejected'),
                        'test_reasons' => $test_reasons,
                        'test_reasons_other' => Input::get('test_reasons_other'),
                        'sample_date' => Input::get('sample_date'),
                        'sample_type' => Input::get('sample_type'),
                        'sample_type_other' => Input::get('sample_type_other'),
                        'sample_number' => Input::get('sample_number'),
                        'appearance' => Input::get('appearance'),
                        'sample_volume' => Input::get('sample_volume'),
                        'sample_accession' => Input::get('sample_accession'),
                        'afb_microscopy' => Input::get('afb_microscopy'),
                        'afb_microscopy_date' => Input::get('afb_microscopy_date'),
                        'zn_results_a' => Input::get('zn_results_a'),
                        'zn_results_b' => Input::get('zn_results_b'),
                        'fm_results_a' => Input::get('fm_results_a'),
                        'fm_results_b' => Input::get('fm_results_b'),
                        'wrd_test' => Input::get('wrd_test'),
                        'wrd_test_date' => Input::get('wrd_test_date'),
                        'sequence_done' => Input::get('sequence_done'),
                        'sequence_date' => Input::get('sequence_date'),
                        'sequence_type' => Input::get('sequence_type'),
                        'sequence_number' => Input::get('sequence_number'),
                        'mtb_detection' => Input::get('mtb_detection'),
                        'rif_resistance' => Input::get('rif_resistance'),
                        'ct_value' => Input::get('ct_value'),
                        'test_repeatition' => Input::get('test_repeatition'),
                        'microscopy_reason' => Input::get('microscopy_reason'),
                        'microscopy_reason_other' => Input::get('microscopy_reason_other'),
                        'respiratory_completness' => Input::get('respiratory_completness'),
                        'comments' => Input::get('comments'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Respiratory Data  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_non_respiratory')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'afb_microscopy' => array(
                    'required' => true,
                ),
                'wrd_test' => array(
                    'required' => true,
                ),
                'form_completness' => array(
                    'required' => true,
                ),
                'date_completed' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $costing = $override->get3('non_respiratory', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($costing) {
                    $user->updateRecord('non_respiratory', array(
                        'visit_date' => Input::get('visit_date'),
                        'afb_microscopy' => Input::get('afb_microscopy'),
                        'afb_microscopy_date' => Input::get('afb_microscopy_date'),
                        'zn_results_a' => Input::get('zn_results_a'),
                        'zn_results_b' => Input::get('zn_results_b'),
                        'fm_results_a' => Input::get('fm_results_a'),
                        'fm_results_b' => Input::get('fm_results_b'),
                        'wrd_test' => Input::get('wrd_test'),
                        'wrd_test_date' => Input::get('wrd_test_date'),
                        'sequence_done' => Input::get('sequence_done'),
                        'sequence_date' => Input::get('sequence_date'),
                        'sequence_type' => Input::get('sequence_type'),
                        'sequence_number' => Input::get('sequence_number'),
                        'mtb_detection' => Input::get('mtb_detection'),
                        'rif_resistance' => Input::get('rif_resistance'),
                        'ct_value' => Input::get('ct_value'),
                        'test_repeatition' => Input::get('test_repeatition'),
                        'microscopy_reason' => Input::get('microscopy_reason'),
                        'microscopy_reason_other' => Input::get('microscopy_reason_other'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $costing[0]['id']);

                    $successMessage = 'Non Respiratory Data  Successful Updated';
                } else {
                    $user->createRecord('non_respiratory', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'afb_microscopy' => Input::get('afb_microscopy'),
                        'afb_microscopy_date' => Input::get('afb_microscopy_date'),
                        'zn_results_a' => Input::get('zn_results_a'),
                        'zn_results_b' => Input::get('zn_results_b'),
                        'fm_results_a' => Input::get('fm_results_a'),
                        'fm_results_b' => Input::get('fm_results_b'),
                        'wrd_test' => Input::get('wrd_test'),
                        'wrd_test_date' => Input::get('wrd_test_date'),
                        'sequence_done' => Input::get('sequence_done'),
                        'sequence_date' => Input::get('sequence_date'),
                        'sequence_type' => Input::get('sequence_type'),
                        'sequence_number' => Input::get('sequence_number'),
                        'mtb_detection' => Input::get('mtb_detection'),
                        'rif_resistance' => Input::get('rif_resistance'),
                        'ct_value' => Input::get('ct_value'),
                        'test_repeatition' => Input::get('test_repeatition'),
                        'microscopy_reason' => Input::get('microscopy_reason'),
                        'microscopy_reason_other' => Input::get('microscopy_reason_other'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Non Respiratory Data  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_diagnosis')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'tb_diagnosis' => array(
                    'required' => true,
                ),
                'clinician_name' => array(
                    'required' => true,
                ),
                'form_completness' => array(
                    'required' => true,
                ),
                'date_completed' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $costing = $override->get3('diagnosis', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                $bacteriological_diagnosis = implode(',', Input::get('bacteriological_diagnosis'));
                $tb_diagnosed_clinically = implode(',', Input::get('tb_diagnosed_clinically'));
                $laboratory_test_used = implode(',', Input::get('laboratory_test_used'));
                $laboratory_test_used2 = implode(',', Input::get('laboratory_test_used2'));

                if ($costing) {
                    $user->updateRecord('diagnosis', array(
                        'visit_date' => Input::get('visit_date'),
                        'clinician_name' => Input::get('clinician_name'),
                        'tb_diagnosis' => Input::get('tb_diagnosis'),
                        'tb_diagnosis_made' => Input::get('tb_diagnosis_made'),
                        'diagnosis_made_other' => Input::get('diagnosis_made_other'),
                        'bacteriological_diagnosis' => $bacteriological_diagnosis,
                        'xpert_ultra_date' => Input::get('xpert_ultra_date'),
                        'truenat_date' => Input::get('truenat_date'),
                        'afb_microscope_date' => Input::get('afb_microscope_date'),
                        'other_bacteriological_date' => Input::get('other_bacteriological_date'),
                        'tb_diagnosed_clinically' => $tb_diagnosed_clinically,
                        'tb_clinically_other' => Input::get('tb_clinically_other'),
                        'tb_treatment' => Input::get('tb_treatment'),
                        'tb_treatment_date' => Input::get('tb_treatment_date'),
                        'tb_facility' => Input::get('tb_facility'),
                        'tb_reason' => Input::get('tb_reason'),
                        'tb_regimen' => Input::get('tb_regimen'),
                        'tb_regimen_other' => Input::get('tb_regimen_other'),
                        'tb_regimen_based' => Input::get('tb_regimen_based'),
                        'tb_regimen_based_other' => Input::get('tb_regimen_based_other'),
                        'regimen_changed' => Input::get('regimen_changed'),
                        'regimen_changed_other' => Input::get('regimen_changed_other'),
                        'regimen_changed__date' => Input::get('regimen_changed__date'),
                        'regimen_removed_name' => Input::get('regimen_removed_name'),
                        'regimen_added_name' => Input::get('regimen_added_name'),
                        'regimen_changed__reason' => Input::get('regimen_changed__reason'),
                        'tb_otcome2' => Input::get('tb_otcome2'),
                        'tb_other_diagnosis' => Input::get('tb_other_diagnosis'),
                        'tb_other_specify' => Input::get('tb_other_specify'),
                        'tb_diagnosis_made2' => Input::get('tb_diagnosis_made2'),
                        'laboratory_test_used' => $laboratory_test_used,
                        'laboratory_test_used2' => $laboratory_test_used2,
                        'clinician_firstname' => Input::get('clinician_firstname'),
                        'clinician_middlename' => Input::get('clinician_middlename'),
                        'clinician_lastname' => Input::get('clinician_lastname'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $costing[0]['id']);

                    $successMessage = 'Diagnosis Data  Successful Updated';
                } else {
                    $user->createRecord('diagnosis', array(
                        'vid' => $_GET['vid'],
                        'sequence' => $_GET['sequence'],
                        'visit_code' => $_GET['visit_code'],
                        'pid' => $clients['study_id'],
                        'study_id' => $clients['study_id'],
                        'visit_date' => Input::get('visit_date'),
                        'clinician_name' => Input::get('clinician_name'),
                        'tb_diagnosis' => Input::get('tb_diagnosis'),
                        'tb_diagnosis_made' => Input::get('tb_diagnosis_made'),
                        'diagnosis_made_other' => Input::get('diagnosis_made_other'),
                        'bacteriological_diagnosis' => $bacteriological_diagnosis,
                        'xpert_ultra_date' => Input::get('xpert_ultra_date'),
                        'truenat_date' => Input::get('truenat_date'),
                        'afb_microscope_date' => Input::get('afb_microscope_date'),
                        'other_bacteriological_date' => Input::get('other_bacteriological_date'),
                        'tb_diagnosed_clinically' => $tb_diagnosed_clinically,
                        'tb_clinically_other' => Input::get('tb_clinically_other'),
                        'tb_treatment' => Input::get('tb_treatment'),
                        'tb_treatment_date' => Input::get('tb_treatment_date'),
                        'tb_facility' => Input::get('tb_facility'),
                        'tb_reason' => Input::get('tb_reason'),
                        'tb_regimen' => Input::get('tb_regimen'),
                        'tb_regimen_other' => Input::get('tb_regimen_other'),
                        'tb_regimen_based' => Input::get('tb_regimen_based'),
                        'tb_regimen_based_other' => Input::get('tb_regimen_based_other'),
                        'regimen_changed' => Input::get('regimen_changed'),
                        'regimen_changed_other' => Input::get('regimen_changed_other'),
                        'regimen_changed__date' => Input::get('regimen_changed__date'),
                        'regimen_removed_name' => Input::get('regimen_removed_name'),
                        'regimen_added_name' => Input::get('regimen_added_name'),
                        'regimen_changed__reason' => Input::get('regimen_changed__reason'),
                        'tb_otcome2' => Input::get('tb_otcome2'),
                        'tb_other_diagnosis' => Input::get('tb_other_diagnosis'),
                        'tb_other_specify' => Input::get('tb_other_specify'),
                        'tb_diagnosis_made2' => Input::get('tb_diagnosis_made2'),
                        'laboratory_test_used' => $laboratory_test_used,
                        'laboratory_test_used2' => $laboratory_test_used2,
                        'clinician_firstname' => Input::get('clinician_firstname'),
                        'clinician_middlename' => Input::get('clinician_middlename'),
                        'clinician_lastname' => Input::get('clinician_lastname'),
                        'comments' => Input::get('comments'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        'patient_id' => $clients['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Diagnosis Data  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_validations')) {
            $validate = $validate->check($_POST, array(
                'date_collect' => array(
                    'required' => true,
                ),
                'date_receictrl' => array(
                    'required' => true,
                ),
                'lab_no' => array(
                    'required' => true,
                ),
                'form_completness' => array(
                    'required' => true,
                ),
                'transit_time' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                // print_r($_POST);
                // $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $individual = $override->getNews('validations', 'status', 1, 'id', $_GET['cid'])[0];
                $first_line = 0;
                $second_line = 0;
                $third_line = 0;
                $sequence = '';
                $visit_code = '';
                $visit_name = '';

                if (Input::get('first_line')) {
                    $first_line = Input::get('first_line');
                }

                if (Input::get('second_line')) {
                    $second_line = Input::get('second_line');
                }

                if (Input::get('third_line')) {
                    $third_line = Input::get('third_line');
                }

                // $expected_date = date('Y-m-d', strtotime('+1 month', strtotime(Input::get('visit_date'))));

                // $last_visit = $override->getlastRow1('visit', 'patient_id', $clients['id'], 'sequence', $_GET['sequence'], 'id')[0];
                $sequence = intval($_GET['sequence']) + 1;
                if ($sequence) {
                    $visit_code = 'M' . $sequence;
                    $visit_name = 'Month ' . $sequence;
                }

                $enrolled = 0;
                $end_study = 0;
                if (Input::get('next_appointment') == 1) {
                    $enrolled = 1;
                }

                $sample_methods = implode(',', Input::get('sample_methods'));
                $genotyping_asay = implode(',', Input::get('genotyping_asay'));
                $nanopore_sequencing = implode(',', Input::get('nanopore_sequencing'));
                $_1st_line_drugs = implode(',', Input::get('_1st_line_drugs'));
                $_2st_line_drugs = implode(',', Input::get('_2st_line_drugs'));

                if ($individual) {
                    $user->updateRecord('validations', array(
                        'pid' => $individual['study_id'],
                        'study_id' => $individual['study_id'],
                        'date_collect' => Input::get('date_collect'),
                        'date_receictrl' => Input::get('date_receictrl'),
                        'lab_no' => Input::get('lab_no'),
                        'transit_time' => Input::get('transit_time'),
                        'resid_distr' => Input::get('resid_distr'),
                        'h_facil' => Input::get('h_facil'),
                        'hf_district' => Input::get('hf_district'),
                        'tb_region' => Input::get('tb_region'),
                        'samplae_type' => Input::get('samplae_type'),
                        'pat_category' => Input::get('pat_category'),
                        'testrequest_reason' => Input::get('testrequest_reason'),
                        'follow_up_months' => Input::get('follow_up_months'),
                        'treatment_month' => Input::get('treatment_month'),
                        'hiv_status' => Input::get('hiv_status'),
                        'gx_results' => Input::get('gx_results'),
                        'gxmtb_ct' => Input::get('gxmtb_ct'),
                        'gx_mtbamount' => Input::get('gx_mtbamount'),
                        'fm_done' => Input::get('fm_done'),
                        'fm_date' => Input::get('fm_date'),
                        'fm_results' => Input::get('fm_results'),
                        'dec_date' => Input::get('dec_date'),
                        'cult_done' => Input::get('cult_done'),
                        'inno_date' => Input::get('inno_date'),
                        'ljcul_results' => Input::get('ljcul_results'),
                        'ljculres_date' => Input::get('ljculres_date'),
                        'mgitcul_resul' => Input::get('mgitcul_resul'),
                        'ljdst_rif' => Input::get('ljdst_rif'),
                        'ljdst_iso' => Input::get('ljdst_iso'),
                        'ljdst_ethamb' => Input::get('ljdst_ethamb'),
                        'mgitdst_stm' => Input::get('mgitdst_stm'),
                        'mgitdst_rif' => Input::get('mgitdst_rif'),
                        'mgitdst_iso' => Input::get('mgitdst_iso'),
                        'mgitdst_ethamb' => Input::get('mgitdst_ethamb'),
                        'mgitdst_bed' => Input::get('mgitdst_bed'),
                        'mgitdst_2cfz' => Input::get('mgitdst_2cfz'),
                        'mgitdst_2dlm' => Input::get('mgitdst_2dlm'),
                        'mgitdst_2levo' => Input::get('mgitdst_2levo'),
                        'mgitdst_2lzd' => Input::get('mgitdst_2lzd'),
                        'lpa1_mtbdetected' => Input::get('lpa1_mtbdetected'),
                        'lpaa1dst_rif' => Input::get('lpaa1dst_rif'),
                        'lpa1dst_inh' => Input::get('lpa1dst_inh'),
                        'lpa2_done' => Input::get('lpa2_done'),
                        'lpa2_date' => Input::get('lpa2_date'),
                        'lpa2_mtbdetected' => Input::get('lpa2_mtbdetected'),
                        'lpa2dst_lfx' => Input::get('lpa2dst_lfx'),
                        'lpa2dst_ag_cp' => Input::get('lpa2dst_ag_cp'),
                        'lpa2dstag_lowkan' => Input::get('lpa2dstag_lowkan'),
                        'nanop_done' => Input::get('nanop_done'),
                        'posnegcontrol' => Input::get('posnegcontrol'),
                        'sample_control' => Input::get('sample_control'),
                        'internalcontrol' => Input::get('internalcontrol'),
                        'hsp65' => Input::get('hsp65'),
                        'nanopseq_date' => Input::get('nanopseq_date'),
                        'myco_results' => Input::get('myco_results'),
                        'myco_type' => Input::get('myco_type'),
                        'myco_spp' => Input::get('myco_spp'),
                        'myco_lineage' => Input::get('myco_lineage'),
                        'nano_rif' => Input::get('nano_rif'),
                        'nano_inh' => Input::get('nano_inh'),
                        'nano_kan' => Input::get('nano_kan'),
                        'nano_mxf' => Input::get('nano_mxf'),
                        'nano_cap' => Input::get('nano_cap'),
                        'nano_emb' => Input::get('nano_emb'),
                        'nano_pza' => Input::get('nano_pza'),
                        'nano_amk' => Input::get('nano_amk'),
                        'nano_bdq' => Input::get('nano_bdq'),
                        'nano_cfz' => Input::get('nano_cfz'),
                        'nano_dlm' => Input::get('nano_dlm'),
                        'nano_eto' => Input::get('nano_eto'),
                        'nano_lfx' => Input::get('nano_lfx'),
                        'nano_lzd' => Input::get('nano_lzd'),
                        'nano_pmd' => Input::get('nano_pmd'),
                        'nano_stm' => Input::get('nano_stm'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $individual['id']);

                    $successMessage = 'Validations Data  Successful Updated';
                } else {

                    // $std_id = $override->getNews('study_id', 'site_id', Input::get('h_facil'), 'status', 0)[0];
                    $std_id = $override->get('study_id', 'status', 0)[0];


                    $user->createRecord('validations', array(
                        // 'vid' => $_GET['vid'],
                        // 'sequence' => $_GET['sequence'],
                        // 'visit_code' => $_GET['visit_code'],
                        'pid' => $std_id['study_id'],
                        'study_id' => $std_id['study_id'],
                        'date_collect' => Input::get('date_collect'),
                        'date_receictrl' => Input::get('date_receictrl'),
                        'lab_no' => Input::get('lab_no'),
                        'transit_time' => Input::get('transit_time'),
                        'resid_distr' => Input::get('resid_distr'),
                        'h_facil' => Input::get('h_facil'),
                        'hf_district' => Input::get('hf_district'),
                        'tb_region' => Input::get('tb_region'),
                        'samplae_type' => Input::get('samplae_type'),
                        'pat_category' => Input::get('pat_category'),
                        'testrequest_reason' => Input::get('testrequest_reason'),
                        'follow_up_months' => Input::get('follow_up_months'),
                        'treatment_month' => Input::get('treatment_month'),
                        'hiv_status' => Input::get('hiv_status'),
                        'gx_results' => Input::get('gx_results'),
                        'gxmtb_ct' => Input::get('gxmtb_ct'),
                        'gx_mtbamount' => Input::get('gx_mtbamount'),
                        'fm_done' => Input::get('fm_done'),
                        'fm_date' => Input::get('fm_date'),
                        'fm_results' => Input::get('fm_results'),
                        'dec_date' => Input::get('dec_date'),
                        'cult_done' => Input::get('cult_done'),
                        'inno_date' => Input::get('inno_date'),
                        'ljcul_results' => Input::get('ljcul_results'),
                        'ljculres_date' => Input::get('ljculres_date'),
                        'mgitcul_resul' => Input::get('mgitcul_resul'),
                        'ljdst_rif' => Input::get('ljdst_rif'),
                        'ljdst_iso' => Input::get('ljdst_iso'),
                        'ljdst_ethamb' => Input::get('ljdst_ethamb'),
                        'mgitdst_stm' => Input::get('mgitdst_stm'),
                        'mgitdst_rif' => Input::get('mgitdst_rif'),
                        'mgitdst_iso' => Input::get('mgitdst_iso'),
                        'mgitdst_ethamb' => Input::get('mgitdst_ethamb'),
                        'mgitdst_bed' => Input::get('mgitdst_bed'),
                        'mgitdst_2cfz' => Input::get('mgitdst_2cfz'),
                        'mgitdst_2dlm' => Input::get('mgitdst_2dlm'),
                        'mgitdst_2levo' => Input::get('mgitdst_2levo'),
                        'mgitdst_2lzd' => Input::get('mgitdst_2lzd'),
                        'lpa1_mtbdetected' => Input::get('lpa1_mtbdetected'),
                        'lpaa1dst_rif' => Input::get('lpaa1dst_rif'),
                        'lpa1dst_inh' => Input::get('lpa1dst_inh'),
                        'lpa2_done' => Input::get('lpa2_done'),
                        'lpa2_date' => Input::get('lpa2_date'),
                        'lpa2_mtbdetected' => Input::get('lpa2_mtbdetected'),
                        'lpa2dst_lfx' => Input::get('lpa2dst_lfx'),
                        'lpa2dst_ag_cp' => Input::get('lpa2dst_ag_cp'),
                        'lpa2dstag_lowkan' => Input::get('lpa2dstag_lowkan'),
                        'nanop_done' => Input::get('nanop_done'),
                        'posnegcontrol' => Input::get('posnegcontrol'),
                        'sample_control' => Input::get('sample_control'),
                        'internalcontrol' => Input::get('internalcontrol'),
                        'hsp65' => Input::get('hsp65'),
                        'nanopseq_date' => Input::get('nanopseq_date'),
                        'myco_results' => Input::get('myco_results'),
                        'myco_type' => Input::get('myco_type'),
                        'myco_spp' => Input::get('myco_spp'),
                        'myco_lineage' => Input::get('myco_lineage'),
                        'nano_rif' => Input::get('nano_rif'),
                        'nano_inh' => Input::get('nano_inh'),
                        'nano_kan' => Input::get('nano_kan'),
                        'nano_mxf' => Input::get('nano_mxf'),
                        'nano_cap' => Input::get('nano_cap'),
                        'nano_emb' => Input::get('nano_emb'),
                        'nano_pza' => Input::get('nano_pza'),
                        'nano_amk' => Input::get('nano_amk'),
                        'nano_bdq' => Input::get('nano_bdq'),
                        'nano_cfz' => Input::get('nano_cfz'),
                        'nano_dlm' => Input::get('nano_dlm'),
                        'nano_eto' => Input::get('nano_eto'),
                        'nano_lfx' => Input::get('nano_lfx'),
                        'nano_lzd' => Input::get('nano_lzd'),
                        'nano_pmd' => Input::get('nano_pmd'),
                        'nano_stm' => Input::get('nano_stm'),
                        'form_completness' => Input::get('form_completness'),
                        'date_completed' => Input::get('date_completed'),
                        'status' => 1,
                        // 'patient_id' => $individual['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => Input::get('h_facil'),
                    ));

                    $successMessage = 'Validations Data  Successful Added';
                }

                // $user->updateRecord('clients', array(
                //     'enrolled' => 1,
                // ), $clients['id']);
                Redirect::to('info.php?id=16' . '&status=' . $_GET['status']);
                // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_visit')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $user->updateRecord('visit', array(
                    'visit_date' => Input::get('visit_date'),
                    'visit_status' => Input::get('visit_status'),
                    'comments' => Input::get('comments'),
                    'status' => 1,
                    'patient_id' => Input::get('cid'),
                    'update_on' => date('Y-m-d H:i:s'),
                    'update_id' => $user->data()->id,
                ), Input::get('id'));

                $successMessage = 'Visit Updates  Successful';
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_screening')) {
            $validate = $validate->check($_POST, array(
                'screening_date' => array(
                    'required' => true,
                ),
                'conset' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                $screening = $override->getNews('screening', 'status', 1, 'patient_id', $_GET['cid']);
                $eligible = 0;
                $pregnant = 0;
                if ($clients[0]['sex'] == 2) {
                    $pregnant = Input::get('pregnant');
                } else {
                    $pregnant = '98';
                }

                if (Input::get('conset') == 1) {
                    $eligible = 1;
                } else {
                    $eligible = 2;
                }

                if (Input::get('screening_date') < $clients[0]['date_registered']) {
                    $errorMessage = 'Screaning Date Can not be less than Registration date';
                } elseif (Input::get('conset') == 2 && !empty(trim(Input::get('conset_date')))) {
                    $errorMessage = 'Please Remove Screening date before Submit again';
                } else {

                    if ($screening) {
                        $user->updateRecord('screening', array(
                            'sequence' => 0,
                            'visit_code' => 'Sv',
                            'visit_name' => 'Screening Visit',
                            'screening_date' => Input::get('screening_date'),
                            'conset' => Input::get('conset'),
                            'conset_date' => Input::get('conset_date'),
                            'hiv_date' => 1,
                            'date_status' => 1,
                            'receive_art' => 1,
                            'start_art' => 1,
                            'stay' => 1,
                            'severely' => 1,
                            'pregnant' => $pregnant,
                            'comments' => Input::get('comments'),
                            'eligible' => $eligible,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $screening[0]['id']);

                        $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', 1);

                        if ($eligible == 1) {
                            if ($visit) {
                                $user->updateRecord('visit', array(
                                    'sequence' => 1,
                                    'visit_code' => 'EV',
                                    'visit_name' => 'Enrollment Visit',
                                    'respondent' => $clients[0]['respondent'],
                                    'study_id' => $clients[0]['study_id'],
                                    'pid' => $clients[0]['study_id'],
                                    'expected_date' => Input::get('screening_date'),
                                    'visit_date' => Input::get('screening_date'),
                                    'visit_status' => 1,
                                    'comments' => Input::get('comments'),
                                    'status' => 1,
                                    'facility_id' => $clients[0]['site_id'],
                                    'table_id' => $screening[0]['id'],
                                    'patient_id' => $clients[0]['id'],
                                    'create_on' => date('Y-m-d H:i:s'),
                                    'staff_id' => $user->data()->id,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                    'site_id' => $clients[0]['site_id'],
                                ), $visit[0]['id']);
                            } else {
                                $user->createRecord('visit', array(
                                    'sequence' => 1,
                                    'visit_code' => 'EV',
                                    'visit_name' => 'Enrollment Visit',
                                    'respondent' => $clients[0]['respondent'],
                                    'study_id' => $clients[0]['study_id'],
                                    'pid' => $clients[0]['study_id'],
                                    'expected_date' => Input::get('screening_date'),
                                    'visit_date' => Input::get('screening_date'),
                                    'visit_status' => 1,
                                    'comments' => Input::get('comments'),
                                    'status' => 1,
                                    'facility_id' => $clients[0]['site_id'],
                                    'table_id' => $screening[0]['id'],
                                    'patient_id' => $clients[0]['id'],
                                    'create_on' => date('Y-m-d H:i:s'),
                                    'staff_id' => $user->data()->id,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                    'site_id' => $clients[0]['site_id'],
                                ));
                            }
                        }


                        $successMessage = 'Screening  Successful Updated';
                    } else {
                        $user->createRecord('screening', array(
                            'sequence' => 0,
                            'visit_code' => 'Sv',
                            'visit_name' => 'Screening Visit',
                            'pid' => $clients[0]['study_id'],
                            'study_id' => $clients[0]['study_id'],
                            'screening_date' => Input::get('screening_date'),
                            'conset' => Input::get('conset'),
                            'conset_date' => Input::get('conset_date'),
                            'hiv_date' => 1,
                            'date_status' => 1,
                            'receive_art' => 1,
                            'start_art' => 1,
                            'stay' => 1,
                            'severely' => 1,
                            'pregnant' => $pregnant,
                            'comments' => Input::get('comments'),
                            'eligible' => $eligible,
                            'status' => 1,
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ));

                        if ($eligible == 1) {

                            $user->createRecord('visit', array(
                                'sequence' => 1,
                                'visit_code' => 'EV',
                                'visit_name' => 'Enrollment Visit',
                                'respondent' => $clients[0]['respondent'],
                                'study_id' => $clients[0]['study_id'],
                                'pid' => $clients[0]['study_id'],
                                'expected_date' => Input::get('screening_date'),
                                'visit_date' => Input::get('screening_date'),
                                'visit_status' => 1,
                                'comments' => Input::get('comments'),
                                'status' => 1,
                                'facility_id' => $clients[0]['site_id'],
                                'table_id' => $last_row['id'],
                                'patient_id' => $clients[0]['id'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients[0]['site_id'],
                            ));
                        }


                        $successMessage = 'Screening  Successful Added';
                    }


                    $user->updateRecord('clients', array(
                        'screened' => 1,
                        'eligible' => $eligible,
                    ), $clients[0]['id']);

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_enrollment')) {
            $validate = $validate->check($_POST, array(
                'enrollment_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);
                $screening = $override->get3('screening', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', -1);
                $enrollment = $override->get3('enrollment', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', 0);
                if ($enrollment) {
                    $user->updateRecord('enrollment', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'screening_id' => $screening[0]['id'],
                        'pid' => $clients[0]['study_id'],
                        'study_id' => $clients[0]['study_id'],
                        'enrollment_date' => Input::get('enrollment_date'),
                        'comments' => Input::get('comments'),
                        'patient_id' => $clients[0]['id'],
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ), $enrollment[0]['id']);

                    $visit = $override->get3('visit', 'status', 1, 'patient_id', $clients[0]['id'], 'sequence', 0);

                    if ($visit) {
                        $user->updateRecord('visit', array(
                            'sequence' => 0,
                            'visit_code' => 'EV',
                            'visit_name' => 'Enrolment Visit',
                            'respondent' => $clients[0]['respondent'],
                            'study_id' => $clients[0]['study_id'],
                            'pid' => $clients[0]['study_id'],
                            'expected_date' => Input::get('enrollment_date'),
                            'visit_date' => Input::get('enrollment_date'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => $clients[0]['site_id'],
                            'table_id' => $enrollment[0]['id'],
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ), $visit[0]['id']);
                    } else {
                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'visit_code' => 'EV',
                            'visit_name' => 'Enrolment Visit',
                            'respondent' => $clients[0]['respondent'],
                            'study_id' => $clients[0]['study_id'],
                            'pid' => $clients[0]['study_id'],
                            'expected_date' => Input::get('enrollment_date'),
                            'visit_date' => Input::get('enrollment_date'),
                            'visit_status' => 1,
                            'comments' => Input::get('comments'),
                            'status' => 1,
                            'facility_id' => $clients[0]['site_id'],
                            'table_id' => $enrollment[0]['id'],
                            'patient_id' => $clients[0]['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients[0]['site_id'],
                        ));
                    }

                    $successMessage = 'Enrollment  Successful Updated';
                } else {
                    $user->createRecord('enrollment', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'screening_id' => $screening[0]['id'],
                        'pid' => $clients[0]['study_id'],
                        'study_id' => $clients[0]['study_id'],
                        'enrollment_date' => Input::get('enrollment_date'),
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'patient_id' => $clients[0]['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ));


                    $user->createRecord('visit', array(
                        'sequence' => 0,
                        'visit_code' => 'EV',
                        'visit_name' => 'Enrolment Visit',
                        'respondent' => $clients[0]['respondent'],
                        'study_id' => $clients[0]['study_id'],
                        'pid' => $clients[0]['study_id'],
                        'expected_date' => Input::get('enrollment_date'),
                        'visit_date' => Input::get('enrollment_date'),
                        'visit_status' => 1,
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'facility_id' => $clients[0]['site_id'],
                        'table_id' => $enrollment[0]['id'],
                        'patient_id' => $clients[0]['id'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients[0]['site_id'],
                    ));

                    $successMessage = 'Enrollment  Successful Added';
                }

                $user->updateRecord('clients', array(
                    'enrolled' => 1,
                ), $clients[0]['id']);

                // $user->visit_delete1($clients['id'], Input::get('enrollment_date'), $clients['study_id'], $user->data()->id, $clients['site_id'], $eligible, 0, $visit_code, $visit_name, $clients['respondent'], 1, $clients['site_id']);

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_region')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $regions = $override->get('regions', 'id', $_GET['region_id']);
                    if ($regions) {
                        $user->updateRecord('regions', array(
                            'name' => Input::get('name'),
                        ), $_GET['region_id']);
                        $successMessage = 'Region Successful Updated';
                    } else {
                        $user->createRecord('regions', array(
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Region Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_district')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $districts = $override->get('districts', 'id', $_GET['district_id']);
                    if ($districts) {
                        $user->updateRecord('districts', array(
                            'region_id' => $_GET['region_id'],
                            'name' => Input::get('name'),
                        ), $_GET['district_id']);
                        $successMessage = 'District Successful Updated';
                    } else {
                        $user->createRecord('districts', array(
                            'region_id' => Input::get('region_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'District Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_ward')) {
            $validate = $validate->check($_POST, array(
                'region_id' => array(
                    'required' => true,
                ),
                'district_id' => array(
                    'required' => true,
                ),
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $wards = $override->get('wards', 'id', $_GET['ward_id']);
                    if ($wards) {
                        $user->updateRecord('wards', array(
                            'region_id' => $_GET['region_id'],
                            'district_id' => $_GET['district_id'],
                            'name' => Input::get('name'),
                        ), $_GET['ward_id']);
                        $successMessage = 'Ward Successful Updated';
                    } else {
                        $user->createRecord('wards', array(
                            'region_id' => Input::get('region_id'),
                            'district_id' => Input::get('district_id'),
                            'name' => Input::get('name'),
                            'status' => 1,
                        ));
                        $successMessage = 'Ward Successful Added';
                    }
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        }
    }
} else {
    Redirect::to('index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dream Fund Sub-Studies Database | Add Page</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <!-- BS Stepper -->
    <link rel="stylesheet" href="plugins/bs-stepper/css/bs-stepper.min.css">
    <!-- dropzonejs -->
    <link rel="stylesheet" href="plugins/dropzone/min/dropzone.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">

    <style>
        .hidden {
            display: none;
        }


        #medication_table {
            border-collapse: collapse;
        }

        #medication_table th,
        #medication_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #medication_table {
            border-collapse: collapse;
        }

        #medication_list th,
        #medication_list td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #medication_list th {
            text-align: left;
            background-color: #f2f2f2;
        }

        .remove-row {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .remove-row:hover {
            background-color: #da190b;
        }

        .edit-row {
            background-color: #3FF22F;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .edit-row:hover {
            background-color: #da190b;
        }

        #hospitalization_details_table {
            border-collapse: collapse;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th,
        #hospitalization_details_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #hospitalization_details_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        #sickle_cell_table {
            border-collapse: collapse;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th,
        #sickle_cell_table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        #sickle_cell_table th {
            text-align: left;
            background-color: #f2f2f2;
        }

        /* .hidden {
            display: none;
        } */
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include 'sidemenu.php'; ?>

        <?php if ($errorMessage) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?= $errorMessage ?>
            </div>
        <?php } elseif ($pageError) { ?>
            <div class="alert alert-danger text-center">
                <h4>Error!</h4>
                <?php foreach ($pageError as $error) {
                    echo $error . ' , ';
                } ?>
            </div>
        <?php } elseif ($_GET['msg']) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $_GET['msg'] ?>
            </div>
        <?php } elseif ($successMessage) { ?>
            <div class="alert alert-success text-center">
                <h4>Success!</h4>
                <?= $successMessage ?>
            </div>
        <?php } ?>

        <?php if ($_GET['id'] == 1 && ($user->data()->position == 1 || $user->data()->position == 2)) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Staff</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            < Back </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=1">
                                            Go to staff list >
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Staff</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id'])[0];
                            $site = $override->get('sites', 'id', $staff['site_id'])[0];
                            $position = $override->get('position', 'id', $staff['position'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" value="<?php if ($staff['firstname']) {
                                                                                                                                                print_r($staff['firstname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" value="<?php if ($staff['middlename']) {
                                                                                                                                                    print_r($staff['middlename']);
                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" value="<?php if ($staff['lastname']) {
                                                                                                                                                print_r($staff['lastname']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>User Name</label>
                                                            <input class="form-control" type="text" name="username" id="username" value="<?php if ($staff['username']) {
                                                                                                                                                print_r($staff['username']);
                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Contacts</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number" id="phone_number" value="<?php if ($staff['phone_number']) {
                                                                                                                                                                                                            print_r($staff['phone_number']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Phone Number 2</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="phone_number2" id="phone_number2" value="<?php if ($staff['phone_number2']) {
                                                                                                                                                                                                            print_r($staff['phone_number2']);
                                                                                                                                                                                                        }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>E-mail Address</label>
                                                            <input class="form-control" type="email" name="email_address" id="email_address" value="<?php if ($staff['email_address']) {
                                                                                                                                                        print_r($staff['email_address']);
                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>SEX</label>
                                                            <select class="form-control" name="sex" style="width: 100%;" required>
                                                                <option value="<?= $staff['sex'] ?>"><?php if ($staff['sex']) {
                                                                                                            if ($staff['sex'] == 1) {
                                                                                                                echo 'Male';
                                                                                                            } elseif ($staff['sex'] == 2) {
                                                                                                                echo 'Female';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?></option>
                                                                <option value="1">Male</option>
                                                                <option value="2">Female</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Staff Location And Access Levels</h3>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Site</label>
                                                            <select class="form-control" name="site_id" style="width: 100%;" required>
                                                                <option value="<?= $site['id'] ?>"><?php if ($staff['site_id']) {
                                                                                                        print_r($site['name']);
                                                                                                    } else {
                                                                                                        echo 'Select';
                                                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->getData('sites') as $site) { ?>
                                                                    <option value="<?= $site['id'] ?>"><?= $site['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Position</label>
                                                            <select class="form-control" name="position" style="width: 100%;" required>
                                                                <option value="<?= $position['id'] ?>"><?php if ($staff['position']) {
                                                                                                            print_r($position['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('position', 'status', 1) as $position) { ?>
                                                                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Access Level</label>
                                                            <input class="form-control" type="number" min="0" max="3" name="accessLevel" id="accessLevel" value="<?php if ($staff['accessLevel']) {
                                                                                                                                                                        print_r($staff['accessLevel']);
                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Power</label>
                                                            <input class="form-control" type="number" min="0" max="2" name="power" id="power" value="0" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=1" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_user" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 2) { ?>
            <?php
            $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($sites) { ?>
                                    <h1>Add New Site</h1>
                                <?php } else { ?>
                                    <h1>Update Site</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to sites list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($sites) { ?>
                                        <li class="breadcrumb-item active">Add New Site</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Site</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Name</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($sites['name']) {
                                                                                        print_r($sites['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter here name" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=2&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_sites" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 3) { ?>
            <?php
            $sites = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            $regions = $override->get('regions', 'id', $_GET['region_id']);
            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
            $wards = $override->get('wards', 'id', $_GET['ward_id']);
            // print_r($regions)
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($sites) { ?>
                                    <h1>Add New Site</h1>
                                <?php } else { ?>
                                    <h1>Update Site</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($sites) { ?>
                                        <li class="breadcrumb-item active">Add New Site</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Site</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Name & Date</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="entry_date" class="form-label">Date of Entry</label>
                                                        <input type="date" value="<?php if ($sites['entry_date']) {
                                                                                        print_r($sites['entry_date']);
                                                                                    } ?>" id="entry_date" name="entry_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($sites['name']) {
                                                                                        print_r($sites['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter here name" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ARMS, LEVEL , TYPE & CATEGORY</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label for="arm" class="form-label">Arm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_arm', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="arm" id="arm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['arm'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="level" class="form-label">Level</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_level', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="level" id="level<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['level'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="type" class="form-label">Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="type" id="type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['type'] == $value['id']) {
                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label for="category" class="form-label">Category</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('facility_category', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="category" id="category<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['category'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label for="category" class="form-label">Respondent Type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->getNews('respondent_type', 'status', 1, 'respondent', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="respondent" id="respondent<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($sites['respondent'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Adress</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($sites['region']) {
                                                                                                            print_r($regions[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($sites['district']) {
                                                                                                            print_r($districts[0]['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($sites['ward']) {
                                                                                                        print_r($wards[0]['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $sites['id'] ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="site_id" value="<?= $sites['id'] ?>">
                                            <input type="submit" name="add_site" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 4) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add Participant enrolment form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            <?php if ($_GET['status'] == 1) { ?>
                                                Go to screening list >
                                            <?php } elseif ($_GET['status'] == 2) { ?>
                                                Go to eligible list >
                                            <?php } elseif ($_GET['status'] == 3) { ?>
                                                Go to enrollment list >
                                            <?php } elseif ($_GET['status'] == 4) { ?>
                                                Go to terminated / end study list >
                                            <?php } elseif ($_GET['status'] == 5) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 6) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 7) { ?>
                                                Go to registered list >
                                            <?php } ?>
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Client</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                            // $relation = $override->get('relation', 'id', $clients['relation_patient'])[0];
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            // $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            // $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            // $household = $override->get('household', 'id', $clients['head_household'])[0];

                            $regions = $override->get('regions', 'id', $clients['region'])[0];
                            $districts = $override->get('districts', 'id', $clients['district'])[0];
                            $wards = $override->get('wards', 'id', $clients['ward'])[0];
                            $facility = $override->get('districts', 'id', $clients['facility_district'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Details of enrolment and patient demographics</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">CLINICIAN DETAILS</h3>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name of the clinician </label>
                                                            <input class="form-control" type="text" name="clinician_firstname" id="clinician_firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['clinician_firstname']) {
                                                                                                                                                                                                                            print_r($clients['clinician_firstname']);
                                                                                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name of the clinician</label>
                                                            <input class="form-control" type="text" name="clinician_middlename" id="clinician_middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['clinician_middlename']) {
                                                                                                                                                                                                                            print_r($clients['clinician_middlename']);
                                                                                                                                                                                                                        }  ?>" />
                                                            <span>(Optional)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name of the clinician</label>
                                                            <input class="form-control" type="text" name="clinician_lastname" id="clinician_lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['clinician_lastname']) {
                                                                                                                                                                                                                        print_r($clients['clinician_lastname']);
                                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Clinician Phone Number</label>
                                                            <input class="form-control" type="text" name="clinician_phone" id="clinician_phone" value="<?php if ($clients['clinician_phone']) {
                                                                                                                                                            print_r($clients['clinician_phone']);
                                                                                                                                                        }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="site">
                                                    <label>Name of Health facility:</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sites', 'status', 1) as $site) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="site" id="site<?= $site['id']; ?>" value="<?= $site['id']; ?>" <?php if ($clients['site_id'] == $site['id']) {
                                                                                                                                                                                            echo 'checked' . ' ' . 'required';
                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $site['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Facility District</label>
                                                            <select name="facility_district" class="form-control" required>
                                                                <option value="<?= $facility['id'] ?>"><?php if ($clients['facility_district']) {
                                                                                                            print_r($facility['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('districts', 'status', 1) as $district) { ?>
                                                                    <option value="<?= $district['id'] ?>"><?= $district['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">PATIENT DETAILS</h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>STUDY ID </label>
                                                            <input class="form-control" type="text" value="<?php if ($clients['study_id']) {
                                                                                                                print_r($clients['study_id']);
                                                                                                            }  ?>" readonly />
                                                            <!-- <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="ctc_id" id="ctc_id" placeholder="Type CTC ID..."/> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of enrolment:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_enrolled" id="date_enrolled" value="<?php if ($clients['date_enrolled']) {
                                                                                                                                                                                    print_r($clients['date_enrolled']);
                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['firstname']) {
                                                                                                                                                                                                        print_r($clients['firstname']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['middlename']) {
                                                                                                                                                                                                        print_r($clients['middlename']);
                                                                                                                                                                                                    }  ?>" />
                                                            <span>(Optional)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['lastname']) {
                                                                                                                                                                                                    print_r($clients['lastname']);
                                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="text" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                        print_r($clients['patient_phone']);
                                                                                                                                                    }  ?>" /> <span>Example: 0700 000 111</span>
                                                            <!-- <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone" id="patient_phone" value="" required /> <span>Example: 0700 000 111</span> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Level of education</label>
                                                            <select id="education" name="education" class="form-control" required>
                                                                <option value="<?= $education['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($education['name']);
                                                                                                        } else {
                                                                                                            echo 'Select education';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('education', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Occupation</label>
                                                            <select id="occupation" name="occupation" class="form-control" required>
                                                                <option value="<?= $occupation['id'] ?>"><?php if ($clients) {
                                                                                                                print_r($occupation['name']);
                                                                                                            } else {
                                                                                                                echo 'Select Occupation';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('occupation', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                            <hr>

                                            <div class="row">


                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of birth:</label>
                                                            <input class="form-control" max="<?= date('Y-m-d'); ?>" type="date" name="dob" id="dob" style="width: 100%;" value="<?php if ($clients['dob']) {
                                                                                                                                                                                    print_r($clients['dob']);
                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Age</label>
                                                            <input class="form-control" type="number" name="age" value="<?php if ($clients['age']) {
                                                                                                                            print_r($clients['age']);
                                                                                                                        }  ?>" readonly />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>SEX</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="1" <?php if ($clients['sex'] == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?> required>
                                                                <label class="form-check-label">Male</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="2" <?php if ($clients['sex'] == 2) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Female</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Patient Adress</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Patient’s Residence address (Region)</label>
                                                            <select id="region" name="region" class="form-control" required>
                                                                <option value="<?= $regions['id'] ?>"><?php if ($clients['region']) {
                                                                                                            print_r($regions['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Patient’s Residence address (District)</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $districts['id'] ?>"><?php if ($clients['district']) {
                                                                                                            print_r($districts['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Patient’s Residence address (Ward)</label>
                                                            <select id="ward" name="ward" class="form-control" required>
                                                                <option value="<?= $wards['id'] ?>"><?php if ($clients['ward']) {
                                                                                                        print_r($wards['name']);
                                                                                                    } else {
                                                                                                        echo 'Select district';
                                                                                                    } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Residence street</label>
                                                            <input class="form-control" type="text" name="street" id="street" value="<?php if ($clients['street']) {
                                                                                                                                            print_r($clients['street']);
                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Physical Address ( Location )</label>
                                                            <textarea class="form-control" id="location" placeholder="Type physical address here" name="location" rows="3" style="width: 100%;">
                                                                    <?php if ($clients['location']) {
                                                                        print_r($clients['location']);
                                                                    }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>House number, if any</label>
                                                            <input class="form-control" type="text" name="house_number" id="house_number" value="<?php if ($clients['house_number']) {
                                                                                                                                                        print_r($clients['house_number']);
                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($clients['comments']) {
                                                                                                                                                            print_r($clients['comments']);
                                                                                                                                                        }  ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=3&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_client" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 5) { ?>
            <?php
            $sites = $override->getNews('position', 'status', 1, 'id', $_GET['position_id'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($sites) { ?>
                                    <h1>Add New positions</h1>
                                <?php } else { ?>
                                    <h1>Update positions</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to positions list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($sites) { ?>
                                        <li class="breadcrumb-item active">Add New positions</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update positions</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Name</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="name" class="form-label">Name</label>
                                                        <input type="text" value="<?php if ($sites['name']) {
                                                                                        print_r($sites['name']);
                                                                                    } ?>" id="name" name="name" class="form-control" placeholder="Enter here name" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=5" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_positions" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 6) { ?>
            <?php
            $facility = $override->get3('facility', 'status', 1, 'sequence', $_GET['sequence'], 'site_id', $_GET['site_id'])[0];
            $site = $override->getNews('sites', 'status', 1, 'id', $_GET['site_id'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($facility) { ?>
                                    <h1>Add New Facility</h1>
                                <?php } else { ?>
                                    <h1>Update Facility</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=12&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=11&status=<?= $_GET['status']; ?>">
                                            Go to Facilities list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($facility) { ?>
                                        <li class="breadcrumb-item active">Add New Facility</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Facility</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Section 1: Facility PIVLO-Test list details (to be completed monthly in clinic)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="mb-2">
                                                        <label for="extraction_date" class="form-label">Date of Extraction</label>
                                                        <input type="date" value="<?php if ($facility['extraction_date']) {
                                                                                        print_r($facility['extraction_date']);
                                                                                    } ?>" id="extraction_date" name="extraction_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="month_name" class="form-label">Month (Name)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('months', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="month_name" id="month_name<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['month_name'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="appointments" class="form-label">Total number of test appointment in a
                                                            month.</label>
                                                        <input type="number" value="<?php if ($facility['appointments']) {
                                                                                        print_r($facility['appointments']);
                                                                                    } ?>" id="appointments" name="appointments" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="patients_tested" class="form-label">Total patients got tested this month</label>
                                                        <input type="number" value="<?php if ($facility['patients_tested']) {
                                                                                        print_r($facility['patients_tested']);
                                                                                    } ?>" id="patients_tested" name="patients_tested" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="results_soft_copy" class="form-label">Total VL test results made available for
                                                            this month</label>
                                                        <input type="number" value="<?php if ($facility['results_soft_copy']) {
                                                                                        print_r($facility['results_soft_copy']);
                                                                                    } ?>" id="results_soft_copy" name="results_soft_copy" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>From Soft Copy ( Excel )</span>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="results_hard_copy" class="form-label">Total VL test results made available for
                                                            this month</label>
                                                        <input type="number" value="<?php if ($facility['results_hard_copy']) {
                                                                                        print_r($facility['results_hard_copy']);
                                                                                    } ?>" id="results_hard_copy" name="results_hard_copy" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                    <span>From Hard Copy</span>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Reason for those who were not tested.</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ltf" class="form-label">Loss to Follow Up </label>
                                                        <input type="number" value="<?php if ($facility['ltf']) {
                                                                                        print_r($facility['ltf']);
                                                                                    } ?>" id="ltf" name="ltf" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="transferred_out" class="form-label">TRANSFERRED OUT </label>
                                                        <input type="number" value="<?php if ($facility['transferred_out']) {
                                                                                        print_r($facility['transferred_out']);
                                                                                    } ?>" id="transferred_out" name="transferred_out" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="admitted" class="form-label">ADMITTED ELSE WHERE </label>
                                                        <input type="number" value="<?php if ($facility['admitted']) {
                                                                                        print_r($facility['admitted']);
                                                                                    } ?>" id="admitted" name="admitted" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="death" class="form-label">DEATH </label>
                                                        <input type="number" value="<?php if ($facility['death']) {
                                                                                        print_r($facility['death']);
                                                                                    } ?>" id="death" name="death" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="inability_transport" class="form-label">INABILITY TO PAY TRANSPORT COST</label>
                                                        <input type="number" value="<?php if ($facility['inability_transport']) {
                                                                                        print_r($facility['inability_transport']);
                                                                                    } ?>" id="inability_transport" name="inability_transport" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lack_accompany" class="form-label">LACK OF ACCOMPANY PERSON</label>
                                                        <input type="number" value="<?php if ($facility['lack_accompany']) {
                                                                                        print_r($facility['lack_accompany']);
                                                                                    } ?>" id="lack_accompany" name="lack_accompany" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="incompatibility_time" class="form-label">INCOMPATIBILITY OF TESTING TIME </label>
                                                        <input type="number" value="<?php if ($facility['incompatibility_time']) {
                                                                                        print_r($facility['incompatibility_time']);
                                                                                    } ?>" id="incompatibility_time" name="incompatibility_time" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="tosa" class="form-label">TRAVELLED OUSTSIDE STUDY AREA</label>
                                                        <input type="number" value="<?php if ($facility['tosa']) {
                                                                                        print_r($facility['tosa']);
                                                                                    } ?>" id="tosa" name="tosa" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="mourning" class="form-label">MOURNING</label>
                                                        <input type="number" value="<?php if ($facility['mourning']) {
                                                                                        print_r($facility['mourning']);
                                                                                    } ?>" id="mourning" name="mourning" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="forgot" class="form-label">FORGOT</label>
                                                        <input type="number" value="<?php if ($facility['forgot']) {
                                                                                        print_r($facility['forgot']);
                                                                                    } ?>" id="forgot" name="forgot" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="unknown" class="form-label">UNKNOWN</label>
                                                        <input type="number" value="<?php if ($facility['unknown']) {
                                                                                        print_r($facility['unknown']);
                                                                                    } ?>" id="unknown" name="unknown" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="extra_pills" class="form-label">PATIENT STILL HAVE ARV PILLS AT HOME</label>
                                                        <input type="number" value="<?php if ($facility['extra_pills']) {
                                                                                        print_r($facility['extra_pills']);
                                                                                    } ?>" id="extra_pills" name="extra_pills" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="others" class="form-label">OTHERS</label>
                                                        <input type="number" value="<?php if ($facility['others']) {
                                                                                        print_r($facility['others']);
                                                                                    } ?>" id="others" name="others" min="0" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="comments" class="form-label">Any Comments ( If Available ):</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter comments here">
                                                                                            <?php if ($facility['comments']) {
                                                                                                print_r($facility['comments']);
                                                                                            } ?>
                                                                                            </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="facility_completed">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="facility_completed" id="facility_completed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($facility['facility_completed'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($facility['date_completed']) {
                                                                                        print_r($facility['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=11&site_id=<?= $_GET['site_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="facility_id" value="<?= $site['id'] ?>">
                                            <input type="hidden" name="facility_arm" value="<?= $site['arm'] ?>">
                                            <input type="hidden" name="facility_level" value="<?= $site['level'] ?>">
                                            <input type="hidden" name="facility_type" value="<?= $site['type'] ?>">
                                            <input type="submit" name="add_facility" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 7) { ?>
            <?php
            $screening = $override->get3('screening', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($screening) { ?>
                                    <h1>Add New Screening</h1>
                                <?php } else { ?>
                                    <h1>Update Screening</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Screening</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Screening</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Inclusion Criteria</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Screening</label>
                                                        <input type="date" value="<?php if ($screening['screening_date']) {
                                                                                        print_r($screening['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4" id="conset_date1">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening['conset_date']) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter here" required>
                                                            <?php if ($screening['comments']) {
                                                                print_r($screening['comments']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_screening" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 8) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Region Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Region Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php $regions = $override->get('regions', 'id', $_GET['region_id']); ?>
                            <!-- right column -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Region</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type region..." onkeyup="fetchData()" value="<?php if ($regions['0']['name']) {
                                                                                                                                                                                        print_r($regions['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="hidden" name="region_id" value="<?= $regions['0']['id'] ?>">
                                            <input type="submit" name="add_region" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Regions
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('regions', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }
                                    $regions = $override->getWithLimit('regions', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($regions as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=24&region_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=24&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=24&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 9) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>District Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">District Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->get('districts', 'id', $_GET['district_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">District</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="region_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type district..." onkeyup="fetchData()" value="<?php if ($districts['0']['name']) {
                                                                                                                                                                                            print_r($districts['0']['name']);
                                                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_district" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Districts
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('districts', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $districts = $override->getWithLimit('districts', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($districts as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=25&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['id'] ?>" class="btn btn-info">Update</a>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=25&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=25&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 10) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Wards Form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active">Wards Form</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $regions = $override->get('regions', 'id', $_GET['region_id']);
                            $districts = $override->getNews('districts', 'region_id', $_GET['region_id'], 'id', $_GET['district_id']);
                            $wards = $override->get('wards', 'id', $_GET['ward_id']);
                            ?>
                            <!-- right left -->
                            <div class="col-md-6">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Ward</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Region</label>
                                                            <select id="regions_id" name="region_id" class="form-control" required <?php if ($_GET['region_id']) {
                                                                                                                                        echo 'disabled';
                                                                                                                                    } ?>>
                                                                <option value="<?= $regions[0]['id'] ?>"><?php if ($regions[0]['name']) {
                                                                                                                print_r($regions[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select region';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('regions', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="districts_id" name="district_id" class="form-control" required <?php if ($_GET['district_id']) {
                                                                                                                                            echo 'disabled';
                                                                                                                                        } ?>>
                                                                <option value="<?= $districts[0]['id'] ?>"><?php if ($districts[0]['name']) {
                                                                                                                print_r($districts[0]['name']);
                                                                                                            } else {
                                                                                                                echo 'Select District';
                                                                                                            } ?>
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Ward Name</label>
                                                            <input class="form-control" type="text" name="name" id="name" placeholder="Type ward..." onkeyup="fetchData()" value="<?php if ($wards['0']['name']) {
                                                                                                                                                                                        print_r($wards['0']['name']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href='index1.php' class="btn btn-default">Back</a>
                                            <input type="submit" name="add_ward" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (left) -->

                            <div class="col-6">
                                <div class="card">
                                    <section class="content-header">
                                        <div class="container-fluid">
                                            <div class="row mb-2">
                                                <div class="col-sm-6">
                                                    <div class="card-header">
                                                        List of Wards
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ol class="breadcrumb float-sm-right">
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                < Back</a>
                                                        </li>
                                                        &nbsp;
                                                        <li class="breadcrumb-item">
                                                            <a href="index1.php">
                                                                Go Home > </a>
                                                        </li>
                                                    </ol>
                                                </div>
                                            </div>
                                            <hr>
                                        </div><!-- /.container-fluid -->
                                    </section>
                                    <?php
                                    $pagNum = 0;
                                    $pagNum = $override->getCount('wards', 'status', 1);
                                    $pages = ceil($pagNum / $numRec);
                                    if (!$_GET['page'] || $_GET['page'] == 1) {
                                        $page = 0;
                                    } else {
                                        $page = ($_GET['page'] * $numRec) - $numRec;
                                    }

                                    $ward = $override->getWithLimit('wards', 'status', 1, $page, $numRec);
                                    ?>
                                    <!-- /.card-header -->
                                    <div class="card-body">
                                        <table id="search-results" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $x = 1;
                                                foreach ($ward as $value) {
                                                    $regions = $override->get('regions', 'id', $value['region_id'])[0];
                                                    $districts = $override->get('districts', 'id', $value['district_id'])[0];
                                                ?>
                                                    <tr>
                                                        <td class="table-user">
                                                            <?= $x; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $regions['name']; ?>
                                                        </td>

                                                        <td class="table-user">
                                                            <?= $districts['name']; ?>
                                                        </td>
                                                        <td class="table-user">
                                                            <?= $value['name']; ?>
                                                        </td>

                                                        <?php if ($value['status'] == 1) { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Active
                                                                </a>
                                                            </td>
                                                        <?php  } else { ?>
                                                            <td class="text-center">
                                                                <a href="#" class="btn btn-success">
                                                                    <i class="ri-edit-box-line">
                                                                    </i>Not Active
                                                                </a>
                                                            </td>
                                                        <?php } ?>
                                                        <td>
                                                            <a href="add.php?id=26&region_id=<?= $value['region_id'] ?>&district_id=<?= $value['district_id'] ?>&ward_id=<?= $value['id'] ?>" class="btn btn-info">Update</a> <br><br>
                                                            <?php if ($user->data()->power == 1) { ?>
                                                                <a href="#delete<?= $staff['id'] ?>" role="button" class="btn btn-danger" data-toggle="modal">Delete</a>
                                                                <a href="#restore<?= $staff['id'] ?>" role="button" class="btn btn-secondary" data-toggle="modal">Restore</a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="delete<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Delete User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: red">
                                                                            <p>Are you sure you want to delete this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="delete_staff" value="Delete" class="btn btn-danger">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <div class="modal fade" id="restore<?= $staff['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <form method="post">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                        <h4>Restore User</h4>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <strong style="font-weight: bold;color: green">
                                                                            <p>Are you sure you want to restore this user</p>
                                                                        </strong>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <input type="hidden" name="id" value="<?= $staff['id'] ?>">
                                                                        <input type="submit" name="restore_staff" value="Restore" class="btn btn-success">
                                                                        <button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>

                                                <?php $x++;
                                                } ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Region Name</th>
                                                    <th>District Name</th>
                                                    <th>Ward Name</th>
                                                    <th>Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer clearfix">
                                        <ul class="pagination pagination-sm m-0 float-right">
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] - 1) > 0) {
                                                                                                    echo $_GET['page'] - 1;
                                                                                                } else {
                                                                                                    echo 1;
                                                                                                } ?>">&laquo;
                                                </a>
                                            </li>
                                            <?php for ($i = 1; $i <= $pages; $i++) { ?>
                                                <li class="page-item">
                                                    <a class="page-link <?php if ($i == $_GET['page']) {
                                                                            echo 'active';
                                                                        } ?>" href="add.php?id=26&page=<?= $i ?>"><?= $i ?>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <li class="page-item">
                                                <a class="page-link" href="add.php?id=26&page=<?php if (($_GET['page'] + 1) <= $pages) {
                                                                                                    echo $_GET['page'] + 1;
                                                                                                } else {
                                                                                                    echo $i - 1;
                                                                                                } ?>">&raquo;
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 11) { ?>
            <?php
            $costing = $override->get3('respiratory', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New Respiratory sample Data</h1>
                                <?php } else { ?>
                                    <h1>Update Respiratory sample Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New Respiratory sample Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Respiratory sample Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">General information Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($costing['visit_date']) {
                                                                                        print_r($costing['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="lab_name" class="form-label">40. Name of laboratory</label>
                                                        <input type="text" value="<?php if ($costing['lab_name']) {
                                                                                        print_r($costing['lab_name']);
                                                                                    } ?>" id="lab_name" name="lab_name" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>
                                            </div>


                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Respiratory sample</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-3" id="sample_received">
                                                    <label for="sample_received" class="form-label">46. Is at least one respiratory sample received?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_received" id="sample_received<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_received'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sample_amount">
                                                    <label for="sample_amount" class="form-label">47. If yes, how many;</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_amount', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_amount" id="sample_amount<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_amount'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('sample_amount')">Unset</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sample_reason">
                                                    <label for="tested_this_month" class="form-label">48. If no give reason</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_reason', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_reason" id="sample_reason<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_reason'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('sample_reason')">Unset</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="test_rejected">
                                                    <label for="test_rejected" class="form-label">49. Was test rejected</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="test_rejected" id="test_rejected<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['test_rejected'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('test_rejected')">Unset</button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="test_reasons">
                                                    <label for="new_vl_date" class="form-label">50. If yes, reason (multiple selection)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('test_reasons', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="test_reasons[]" id="test_reasons<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['test_reasons']) as $values) {
                                                                                                                                                                                                                    if ($values == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="test_reasons_other" class="form-label">50. If Other Mention</label>
                                                            <input type="text" value="<?php if ($costing['test_reasons_other']) {
                                                                                            print_r($costing['test_reasons_other']);
                                                                                        } ?>" id="test_reasons_other" name="test_reasons_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" id="sample_received_hides1">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="sample_date" class="form-label">51. Date sample(s) received in the laboratory</label>
                                                        <input type="date" value="<?php if ($costing['sample_date']) {
                                                                                        print_r($costing['sample_date']);
                                                                                    } ?>" id="sample_date" name="sample_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="sample_type">
                                                    <label for="sample_type" class="form-label">52. Type of sample(s) received (multiple selection)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_type" id="sample_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_type'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="sample_type_other" id="sample_type_other1" class="form-label">52. Explain</label>
                                                            <input type="text" value="<?php if ($costing['sample_type_other']) {
                                                                                            print_r($costing['sample_type_other']);
                                                                                        } ?>" id="sample_type_other" name="sample_type_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                        <button onclick="unsetRadio('sample_type')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="sample_number" class="form-label">53. Number of samples received</label>
                                                        <input type="number" value="<?php if ($costing['sample_number']) {
                                                                                        print_r($costing['sample_number']);
                                                                                    } ?>" id="sample_number" name="sample_number" min="0" max="100000000" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" id="sample_received_hides2">
                                                <div class="col-4">
                                                    <label for="appearance" class="form-label">54. Appearance</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('appearance', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="appearance" id="appearance<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['appearance'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('appearance')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="sample_volume" class="form-label">55. Approximate volume sample (number, two digits)</label>
                                                        <input type="number" value="<?php if ($costing['sample_volume']) {
                                                                                        print_r($costing['sample_volume']);
                                                                                    } ?>" id="sample_volume" name="sample_volume" min="0" max="100000000" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <span>mL</span>
                                                </div>

                                                <div class="col-4">
                                                    <label for="sample_accession" class="form-label">56. Sample accession status</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_accession', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_accession" id="sample_accession<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_accession'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('sample_accession')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="afb_microscopy" class="form-label">57. AFB microscopy</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_microscopy', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="afb_microscopy" id="afb_microscopy<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['afb_microscopy'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('afb_microscopy')">Unset</button>
                                                </div>

                                                <div class="col-6" id="afb_microscopy_date0">
                                                    <div class="mb-3">
                                                        <label for="afb_microscopy_date" id="afb_microscopy_date1" class="form-label">If ZN what date?</label>
                                                        <label for="afb_microscopy_date" id="afb_microscopy_date2" class="form-label">If FM what date?</label>
                                                        <input type="date" value="<?php if ($costing['afb_microscopy_date']) {
                                                                                        print_r($costing['afb_microscopy_date']);
                                                                                    } ?>" id="afb_microscopy_date" name="afb_microscopy_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <label for="zn" id="zn" class="form-label text-center">58. If ZN </label>
                                            <hr>

                                            <div class="row" id="zn_results">
                                                <div class="col-sm-6" id="zn_results_a">
                                                    <label for="zn_results_a" class="form-label">Results A </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="zn_results_a" id="zn_results_a<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['zn_results_a'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('zn_results_a')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="zn_results_b">
                                                    <label for="zn_results_b" class="form-label">Results B </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="zn_results_b" id="zn_results_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['zn_results_b'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <span>(Not mandatory)</span>
                                                        <button onclick="unsetRadio('zn_results_b')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <label for="fm" id="fm" class="form-label text-center">59. If FM </label>
                                            <hr>

                                            <div class="row" id="fm_results">
                                                <div class="col-sm-6" id="fm_results_a">
                                                    <label for="fm_results_a" class="form-label">Results A </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="fm_results_a" id="fm_results_a<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fm_results_a'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('fm_results_a')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="fm_results_b">
                                                    <label for="fm_results_b" class="form-label">Results B </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="fm_results_b" id="fm_results_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fm_results_b'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <span>(Not mandatory)</span>
                                                        <button onclick="unsetRadio('fm_results_b')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="wrd_test">
                                                    <label for="wrd_test" class="form-label">60. WRD test done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('wrd_test', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="wrd_test" id="wrd_test<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['wrd_test'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label id="wrd_test_date1" for="wrd_test_date" class="form-label">what date ?</label>
                                                            <input type="date" value="<?php if ($costing['wrd_test_date']) {
                                                                                            print_r($costing['wrd_test_date']);
                                                                                        } ?>" id="wrd_test_date" name="wrd_test_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                        <button onclick="unsetRadio('wrd_test')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sequence_done">
                                                    <label for="sequence_done" class="form-label">61. If none at the facility has it been done at sequence lab?
                                                    </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sequence_done" id="sequence_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sequence_done'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label for="sequence_date" id="sequence_date1" class="form-label">what date ?</label>
                                                        <input type="date" value="<?php if ($costing['sequence_date']) {
                                                                                        print_r($costing['sequence_date']);
                                                                                    } ?>" id="sequence_date" name="sequence_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <button onclick="unsetRadio('sequence_done')">Unset</button>

                                                </div>


                                                <div class="col-sm-3" id="sequence_type">
                                                    <label for="sequence_type" class="form-label">62. If yes (If Invalid/Error/No results skip next two qtn)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sequence_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sequence_type" id="sequence_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sequence_type'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label for="sequence_number" id="sequence_number1" class="form-label">(If error, what code/number??) </label>
                                                        <input type="text" value="<?php if ($costing['sequence_number']) {
                                                                                        print_r($costing['sequence_number']);
                                                                                    } ?>" id="sequence_number" name="sequence_number" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                    <button onclick="unsetRadio('sequence_type')">Unset</button>

                                                </div>

                                                <div class="col-sm-3" id="mtb_detection">
                                                    <label for="mtb_detection" class="form-label">63. If MTB detected </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mtb_detection', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mtb_detection" id="mtb_detection<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mtb_detection'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mtb_detection')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="rif_resistance">
                                                    <label for="rif_resistance" class="form-label">64. If MTB detected, RIF resistance </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('rif_resistance', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rif_resistance" id="rif_resistance<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['rif_resistance'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('rif_resistance')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="ct_value" class="form-label">65. Sample Cycle threshold (Ct) Value (number, two digits)</label>
                                                        <input type="number" value="<?php if ($costing['ct_value']) {
                                                                                        print_r($costing['ct_value']);
                                                                                    } ?>" id="ct_value" name="ct_value" min="0" max="99" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="test_repeatition">
                                                    <label for="test_repeatition" class="form-label">66. If Invalid/Error/No result/Indeterminate, was the test repeated?
                                                    </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="test_repeatition" id="test_repeatition<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['test_repeatition'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('test_repeatition')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="microscopy_reason">
                                                    <label for="microscopy_reason" class="form-label">67. If no reason(s) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('microscopy_reason', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="microscopy_reason" id="microscopy_reason<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['microscopy_reason'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="microscopy_reason_other" id="microscopy_reason_other1" class="form-label">If Other Mention</label>
                                                            <input type="text" value="<?php if ($costing['microscopy_reason_other']) {
                                                                                            print_r($costing['microscopy_reason_other']);
                                                                                        } ?>" id="microscopy_reason_other" name="microscopy_reason_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('microscopy_reason')">Unset</button>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($costing['comments']) {
                                                                                                                                                            print_r($costing['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="respiratory_completness">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="respiratory_completness" id="respiratory_completness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['respiratory_completness'] == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('respiratory_completness')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($costing['date_completed']) {
                                                                                        print_r($costing['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>

                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_respiratory" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 12) { ?>
            <?php
            $costing = $override->get3('non_respiratory', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New Non Respiratory sample Data</h1>
                                <?php } else { ?>
                                    <h1>Update Non Respiratory sample Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New Non Respiratory sample Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Non Respiratory sample Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Diagnostic tests done for this participant on non-respiratory samples Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($costing['visit_date']) {
                                                                                        print_r($costing['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <label for="afb_microscopy" class="form-label">68. AFB microscopy</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_microscopy', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="afb_microscopy" id="n_afb_microscopy<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['afb_microscopy'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-4" id="n_afb_microscopy_date1">
                                                    <div class="mb-2">
                                                        <label for="n_afb_microscopy_date" id="n_zn_microscopy_date1" class="form-label">If ZN what date?</label>
                                                        <label for="n_afb_microscopy_date" id="n_fm_microscopy_date1" class="form-label">If FM what date?</label>
                                                        <input type="date" value="<?php if ($costing['afb_microscopy_date']) {
                                                                                        print_r($costing['afb_microscopy_date']);
                                                                                    } ?>" id="n_afb_microscopy_date" name="afb_microscopy_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <label for="zn" class="form-label text-center">69. If ZN </label>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="zn_results_a">
                                                    <label for="zn_results_a" class="form-label">Results A </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="zn_results_a" id="zn_results_a<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['zn_results_a'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="zn_results_b">
                                                    <label for="zn_results_b" class="form-label">Results B </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="zn_results_b" id="zn_results_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['zn_results_b'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <span>(Not mandatory)</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <label for="zn" class="form-label text-center">70. If FM </label>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="fm_results_a">
                                                    <label for="fm_results_a" class="form-label">Results A </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="fm_results_a" id="fm_results_a<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fm_results_a'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="fm_results_b">
                                                    <label for="fm_results_b" class="form-label">Results B </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('afb_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="fm_results_b" id="fm_results_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fm_results_b'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <span>(Not mandatory)</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="wrd_test">
                                                    <label for="wrd_test" class="form-label">71. WRD test done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('wrd_test', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="wrd_test" id="n_wrd_test<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['wrd_test'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="wrd_test_date" class="form-label">what date ?</label>
                                                            <input type="date" value="<?php if ($costing['wrd_test_date']) {
                                                                                            print_r($costing['wrd_test_date']);
                                                                                        } ?>" id="wrd_test_date" name="wrd_test_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sequence_done">
                                                    <label for="sequence_done" class="form-label">72. If none at the facility has it been done at sequence lab?
                                                    </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sequence_done" id="sequence_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sequence_done'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label for="sequence_date" class="form-label">what date ?</label>
                                                        <input type="date" value="<?php if ($costing['sequence_date']) {
                                                                                        print_r($costing['sequence_date']);
                                                                                    } ?>" id="sequence_date" name="sequence_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="sequence_type">
                                                    <label for="sequence_type" class="form-label">73. If yes (If Invalid/Error/No results skip next two qtn)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sequence_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sequence_type" id="sequence_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sequence_type'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <label for="sequence_number" class="form-label">(If error, what code/number??) </label>
                                                        <input type="text" value="<?php if ($costing['sequence_number']) {
                                                                                        print_r($costing['sequence_number']);
                                                                                    } ?>" id="sequence_number" name="sequence_number" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="mtb_detection">
                                                    <label for="mtb_detection" class="form-label">74. If MTB detected </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mtb_detection', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mtb_detection" id="mtb_detection<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mtb_detection'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="rif_resistance">
                                                    <label for="rif_resistance" class="form-label">75. If MTB detected, RIF resistance </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('rif_resistance', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="rif_resistance" id="rif_resistance<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['rif_resistance'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="ct_value" class="form-label">76. Sample Cycle threshold (Ct) Value (number, two digits)</label>
                                                        <input type="number" value="<?php if ($costing['ct_value']) {
                                                                                        print_r($costing['ct_value']);
                                                                                    } ?>" id="ct_value" name="ct_value" min="0" max="99" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="test_repeatition">
                                                    <label for="test_repeatition" class="form-label">77. If Invalid/Error/No result/Indeterminate, was the test repeated?
                                                    </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="test_repeatition" id="test_repeatition<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['test_repeatition'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="microscopy_reason">
                                                    <label for="microscopy_reason" class="form-label">78. If no reason(s) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('microscopy_reason', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="microscopy_reason" id="microscopy_reason<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['microscopy_reason'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="microscopy_reason_other" class="form-label">If Other Mention</label>
                                                            <input type="text" value="<?php if ($costing['microscopy_reason_other']) {
                                                                                            print_r($costing['microscopy_reason_other']);
                                                                                        } ?>" id="microscopy_reason_other" name="microscopy_reason_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($costing['comments']) {
                                                                                                                                                            print_r($costing['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="form_completness">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="form_completness" id="form_completness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['form_completness'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($costing['date_completed']) {
                                                                                        print_r($costing['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_non_respiratory" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 13) { ?>

            <?php
            $screening = $override->get3('screening', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($screening) { ?>
                                    <h1>Add New Screening</h1>
                                <?php } else { ?>
                                    <h1>Update Screening</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="index1.php">Home</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New Screening</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Screening</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Screeing Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Screening</label>
                                                        <input type="date" value="<?php if ($screening['screening_date']) {
                                                                                        print_r($screening['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label for="conset" class="form-label">Patient Conset?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="conset" id="conset<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($screening['conset'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Conset</label>
                                                        <input type="date" value="<?php if ($screening) {
                                                                                        print_r($screening['conset_date']);
                                                                                    } ?>" id="conset_date" name="conset_date" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">Comments</label>
                                                        <textarea class="form-control" name="comments" id="comments" rows="4" placeholder="Enter here" required>
                                                            <?php if ($screening['comments']) {
                                                                print_r($screening['comments']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_enrollment" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 14) { ?>
            <?php
            $costing = $override->get3('diagnosis_test', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New Diagnostic Test DST Data</h1>
                                <?php } else { ?>
                                    <h1>Update Diagnostic Test DST Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New Diagnostic Test DST Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Diagnostic Test DST Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Culture and Drug susceptibility test (DST) Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($costing['visit_date']) {
                                                                                        print_r($costing['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <label for="culture_done" class="form-label">79. Culture done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="culture_done" id="culture_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['culture_done'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('culture_done')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="sample_type2">
                                                    <label for="sample_type2" class="form-label">80.Sample type </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_type', 'status2', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_type2" id="sample_type2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_type2'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="sample_type_other2" id="sample_type_other2_1" class="form-label">Specify</label>
                                                            <input type="text" value="<?php if ($costing['sample_type_other2']) {
                                                                                            print_r($costing['sample_type_other2']);
                                                                                        } ?>" id="sample_type_other2_22" name="sample_type_other2" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('sample_type2')">Unset</button>

                                                </div>

                                                <div class="col-sm-3" id="sample_methods">
                                                    <label for="sample_methods" class="form-label">81.If yes above, then method used (Multiple options) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_methods', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="sample_methods[]" id="sample_methods<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['sample_methods']) as $values) {
                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3" id="lj_date1">
                                                    <div class="mb-2">
                                                        <label for="lj_date" class="form-label">LJ Date?</label>
                                                        <input type="date" value="<?php if ($costing['lj_date']) {
                                                                                        print_r($costing['lj_date']);
                                                                                    } ?>" id="lj_date" name="lj_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="lj_results">
                                                    <label for="lj_results" class="form-label">82.Results LJ (Only If was selected above) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('lj_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lj_results" id="lj_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lj_results'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lj_results')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-3" id="mgit_date1">
                                                    <div class="mb-2">
                                                        <label for="mgit_date" class="form-label">MGIT Date?</label>
                                                        <input type="date" value="<?php if ($costing['mgit_date']) {
                                                                                        print_r($costing['mgit_date']);
                                                                                    } ?>" id="mgit_date" name="mgit_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="mgit_results">
                                                    <label for="mgit_results" class="form-label">83.Results MGIT (Only If was selected above) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mgit_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgit_results" id="mgit_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgit_results'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgit_results')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-4" id="phenotypic_done">
                                                    <label for="phenotypic_done" class="form-label">84. Phenotypic DST was done?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="phenotypic_done" id="phenotypic_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['phenotypic_done'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                        <button onclick="unsetRadio('phenotypic_done')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="phenotypic_method">
                                                    <label for="phenotypic_method" class="form-label">85. If yes above, then method used? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_methods', 'status2', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="phenotypic_method" id="phenotypic_method<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['phenotypic_method'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('phenotypic_method')">Unset</button>

                                                </div>

                                                <div class="col-4" id="apm_date_1">
                                                    <div class="mb-2">
                                                        <label for="apm_date" class="form-label">APM date ?</label>
                                                        <input type="date" value="<?php if ($costing['apm_date']) {
                                                                                        print_r($costing['apm_date']);
                                                                                    } ?>" id="apm_date" name="apm_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-4" id="mgit_date2_1">
                                                    <div class="mb-2">
                                                        <label for="mgit_date2" class="form-label">MGIT date ?</label>
                                                        <input type="date" value="<?php if ($costing['mgit_date2']) {
                                                                                        print_r($costing['mgit_date2']);
                                                                                    } ?>" id="mgit_date2" name="mgit_date2" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                            </div>

                                            <div id="phenotypic_done00">
                                                <hr>
                                                Phenotypic DST
                                                (Can selected multiple items on the right column but only one option from the last column on the right with the respect to each item selected)
                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3" id="rifampicin">
                                                        <label for="rifampicin" class="form-label">Rifampicin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="rifampicin" id="rifampicin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['rifampicin'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('rifampicin')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="isoniazid">
                                                        <label for="isoniazid" class="form-label">Isoniazid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="isoniazid" id="isoniazid<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['isoniazid'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('isoniazid')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="levofloxacin">
                                                        <label for="levofloxacin" class="form-label">Levofloxacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="levofloxacin" id="levofloxacin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['levofloxacin'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('levofloxacin')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="moxifloxacin">
                                                        <label for="moxifloxacin" class="form-label">Moxifloxacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="moxifloxacin" id="moxifloxacin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['moxifloxacin'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('moxifloxacin')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3" id="bedaquiline">
                                                        <label for="bedaquiline" class="form-label">Bedaquiline</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="bedaquiline" id="bedaquiline<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['bedaquiline'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('bedaquiline')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="linezolid">
                                                        <label for="linezolid" class="form-label">Linezolid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="linezolid" id="linezolid<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['linezolid'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('linezolid')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="clofazimine">
                                                        <label for="clofazimine" class="form-label">Clofazimine</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="clofazimine" id="clofazimine<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['clofazimine'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('clofazimine')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="cycloserine">
                                                        <label for="cycloserine" class="form-label">Cycloserine</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cycloserine" id="cycloserine<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['cycloserine'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('cycloserine')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="terizidone">
                                                        <label for="terizidone" class="form-label">Terizidone</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="terizidone" id="terizidone<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['terizidone'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('terizidone')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="ethambutol">
                                                        <label for="ethambutol" class="form-label">Ethambutol</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ethambutol" id="ethambutol<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ethambutol'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('ethambutol')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="delamanid">
                                                        <label for="clofazimine" class="form-label">Delamanid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="delamanid" id="delamanid<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['delamanid'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('delamanid')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="pyrazinamide">
                                                        <label for="pyrazinamide" class="form-label">Pyrazinamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pyrazinamide" id="pyrazinamide<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['pyrazinamide'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('pyrazinamide')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="imipenem">
                                                        <label for="imipenem" class="form-label">Imipenem</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="imipenem" id="imipenem<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['imipenem'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('imipenem')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="cilastatin">
                                                        <label for="cilastatin" class="form-label">Cilastatin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cilastatin" id="cilastatin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['cilastatin'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('cilastatin')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="meropenem">
                                                        <label for="meropenem" class="form-label">Meropenem</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="meropenem" id="meropenem<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['meropenem'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('meropenem')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="amikacin">
                                                        <label for="amikacin" class="form-label">Amikacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="amikacin" id="amikacin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['amikacin'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('amikacin')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="streptomycin">
                                                        <label for="streptomycin" class="form-label">Streptomycin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="streptomycin" id="streptomycin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['streptomycin'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('streptomycin')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="ethionamide">
                                                        <label for="ethionamide" class="form-label">Ethionamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ethionamide" id="ethionamide<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ethionamide'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('ethionamide')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="prothionamide">
                                                        <label for="prothionamide" class="form-label">Prothionamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="prothionamide" id="prothionamide<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['prothionamide'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('prothionamide')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="para_aminosalicylic_acid">
                                                        <label for="para_aminosalicylic_acid" class="form-label">Para- aminosalicylic acid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('phenotypic_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="para_aminosalicylic_acid" id="para_aminosalicylic_acid<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['para_aminosalicylic_acid'] == $value['id']) {
                                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('para_aminosalicylic_acid')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Genotyping</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" id="genotyping_done">
                                                    <label for="genotyping_done" class="form-label">87. Genotyping DST was done? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="genotyping_done" id="genotyping_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['genotyping_done'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('genotyping_done')">Unset</button>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="genotyping_asay">
                                                    <label for="genotyping_asay" class="form-label">88. If yes, which assay (Multiple options) </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('genotyping_tests', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="genotyping_asay[]" id="genotyping_asay<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['genotyping_asay']) as $values) {
                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('genotyping_asay')">Unset</button>
                                                    </div>
                                                </div>
                                            </div>


                                            <div id="genotyping_done00">
                                                <hr>
                                                89. If Xpert XDR selected above
                                                (Can selected multiple items on the right column but only one option from the last column on the right with the respect to each item selected)
                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-4" id="isoniazid2">
                                                        <label for="isoniazid2" class="form-label">Isoniazid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="isoniazid2" id="isoniazid2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['isoniazid2'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('isoniazid2')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4" id="fluoroquinolones">
                                                        <label for="fluoroquinolones" class="form-label">Fluoroquinolones</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="fluoroquinolones" id="fluoroquinolones<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fluoroquinolones'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('fluoroquinolones')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4" id="amikacin2">
                                                        <label for="amikacin2" class="form-label">Amikacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="amikacin2" id="amikacin2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['amikacin2'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('amikacin2')">Unset</button>

                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-4" id="kanamycin">
                                                        <label for="kanamycin" class="form-label">Kanamycin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="kanamycin" id="kanamycin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['kanamycin'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('kanamycin')">Unset</button>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" id="capreomycin">
                                                        <label for="capreomycin" class="form-label">Capreomycin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="capreomycin" id="capreomycin<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['capreomycin'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('capreomycin')">Unset</button>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-4" id="ethionamide2">
                                                        <label for="ethionamide2" class="form-label">89. Ethionamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('genotyping_dst', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ethionamide2" id="ethionamide2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ethionamide2'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('ethionamide2')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <hr>


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Nanopore sequencing</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" id="nanopore_sequencing_done">
                                                    <label for="nanopore_sequencing_done" class="form-label">90. Nanopore sequencing</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nanopore_sequencing_done" id="nanopore_sequencing_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nanopore_sequencing_done'] == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nanopore_sequencing_done')">Unset</button>
                                                    </div>
                                                </div>


                                                <div class="col-sm-6" id="nanopore_sequencing">
                                                    <label for="nanopore_sequencing" class="form-label">91. If yes, what were results (multiple options)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nanopore_sequencing', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="nanopore_sequencing[]" id="nanopore_sequencing<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['nanopore_sequencing']) as $values) {
                                                                                                                                                                                                                                if ($values == $value['id']) {
                                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                                }
                                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nanopore_sequencing')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>

                                            <div id="nanopore_sequencing_done00">
                                                <hr>
                                                91. If positive for MTBC
                                                (Can selected multiple items on the right column but only one option from the last column on the right with the respect to each item selected)
                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="rifampicin3">
                                                        <label for="rifampicin3" class="form-label">Rifampicin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="rifampicin3" id="rifampicin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['rifampicin3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('rifampicin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="isoniazid3">
                                                        <label for="isoniazid3" class="form-label">Isoniazid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="isoniazid3" id="isoniazid3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['isoniazid3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('isoniazid3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="levofloxacin3">
                                                        <label for="levofloxacin3" class="form-label">Levofloxacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="levofloxacin3" id="levofloxacin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['levofloxacin3'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('levofloxacin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="moxifloxacin3">
                                                        <label for="moxifloxacin3" class="form-label">Moxifloxacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="moxifloxacin3" id="moxifloxacin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['moxifloxacin3'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('moxifloxacin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>
                                                <div class="row">
                                                    <div class="col-sm-3" id="bedaquiline3">
                                                        <label for="bedaquiline3" class="form-label">Bedaquiline</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="bedaquiline3" id="bedaquiline3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['bedaquiline3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('bedaquiline3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="linezolid3">
                                                        <label for="linezolid3" class="form-label">Linezolid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="linezolid3" id="linezolid3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['linezolid3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('linezolid3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="clofazimine3">
                                                        <label for="clofazimine3" class="form-label">Clofazimine</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="clofazimine3" id="clofazimine3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['clofazimine3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('clofazimine3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="cycloserine3">
                                                        <label for="cycloserine3" class="form-label">Cycloserine</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cycloserine3" id="cycloserine3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['cycloserine3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('cycloserine3')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="terizidone3">
                                                        <label for="terizidone3" class="form-label">Terizidone</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="terizidone3" id="terizidone3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['terizidone3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('terizidone3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="ethambutol3">
                                                        <label for="ethambutol3" class="form-label">Ethambutol</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ethambutol3" id="ethambutol3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ethambutol3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('ethambutol3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="delamanid3">
                                                        <label for="delamanid3" class="form-label">Delamanid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="delamanid3" id="delamanid3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['delamanid3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('delamanid3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="pyrazinamide3">
                                                        <label for="pyrazinamide3" class="form-label">Pyrazinamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="pyrazinamide3" id="pyrazinamide3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['pyrazinamide3'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('pyrazinamide3')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="imipenem3">
                                                        <label for="imipenem3" class="form-label">Imipenem</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="imipenem3" id="imipenem3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['imipenem3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('imipenem3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="cilastatin3">
                                                        <label for="cilastatin3" class="form-label">Cilastatin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="cilastatin3" id="cilastatin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['cilastatin3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('cilastatin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="meropenem3">
                                                        <label for="meropenem3" class="form-label">Meropenem</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="meropenem3" id="meropenem3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['meropenem3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('meropenem3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="amikacin3">
                                                        <label for="amikacin3" class="form-label">Amikacin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="amikacin3" id="amikacin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['amikacin3'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('amikacin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>

                                                <hr>

                                                <div class="row">
                                                    <div class="col-sm-3" id="streptomycin3">
                                                        <label for="streptomycin3" class="form-label">Streptomycin</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="streptomycin3" id="streptomycin3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['streptomycin3'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('streptomycin3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="ethionamide3">
                                                        <label for="ethionamide3" class="form-label">Ethionamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="ethionamide3" id="ethionamide3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ethionamide3'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('ethionamide3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="prothionamide3">
                                                        <label for="prothionamide3" class="form-label">Prothionamide</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="prothionamide3" id="prothionamide3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['prothionamide3'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('prothionamide3')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3" id="para_aminosalicylic_acid3">
                                                        <label for="para_aminosalicylic_acid3" class="form-label">Para- aminosalicylic acid</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('nanopore_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="para_aminosalicylic_acid3" id="para_aminosalicylic_acid3<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['para_aminosalicylic_acid3'] == $value['id']) {
                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('para_aminosalicylic_acid3')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr>
                                            <label class="form-label text-center"> Indicate all bands visible on the strip:</label>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="_1st_line_drugs">
                                                    <label for="_1st_line_drugs" class="form-label">92. Line probe assay (1st line drugs). (GenoType MTBDRplus V2 )</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('_1st_line_drugs', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="_1st_line_drugs[]" id="_1st_line_drugs<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['_1st_line_drugs']) as $values) {
                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6" id="_2st_line_drugs">
                                                    <label for="_1st_line_drugs" class="form-label">93. Line probe assay (2nd line drugs).
                                                        (GenoType MTBDRsl V2).</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('_2st_line_drugs', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="_2st_line_drugs[]" id="_2st_line_drugs<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['_2st_line_drugs']) as $values) {
                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">94. Nanopore sequencing</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="version_number" class="form-label">Version number:</label>
                                                        <input type="text" value="<?php if ($costing['version_number']) {
                                                                                        print_r($costing['version_number']);
                                                                                    } ?>" id="version_number" name="version_number" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="lot_number" class="form-label">Lot number:</label>
                                                        <input type="text" value="<?php if ($costing['lot_number']) {
                                                                                        print_r($costing['lot_number']);
                                                                                    } ?>" id="lot_number" name="lot_number" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>List drug resistance mutations detected</label>
                                                            <textarea class="form-control" name="mutations_detected_list" rows="3" placeholder="Type here..."><?php if ($costing['mutations_detected_list']) {
                                                                                                                                                                    print_r($costing['mutations_detected_list']);
                                                                                                                                                                }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">95. This form was completed by (name)</h3>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="d_firstName" class="form-label">First NAME</label>
                                                        <input type="text" value="<?php if ($costing['d_firstName']) {
                                                                                        print_r($costing['d_firstName']);
                                                                                    } ?>" id="d_firstName" name="d_firstName" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="d_middleName" class="form-label">Middle (Optional)</label>
                                                        <input type="text" value="<?php if ($costing['d_middleName']) {
                                                                                        print_r($costing['d_middleName']);
                                                                                    } ?>" id="d_middleName" name="d_middleName" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="d_surname" class="form-label">Surname:</label>
                                                        <input type="text" value="<?php if ($costing['d_surname']) {
                                                                                        print_r($costing['d_surname']);
                                                                                    } ?>" id="d_surname" name="d_surname" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>



                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($costing['comments']) {
                                                                                                                                                            print_r($costing['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="form_completness">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="form_completness" id="form_completness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['form_completness'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('form_completness')">Unset</button>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($costing['date_completed']) {
                                                                                        print_r($costing['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_diagnosis_test" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

        <?php } elseif ($_GET['id'] == 15) { ?>
            <?php
            $costing = $override->get3('diagnosis', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New Diagnosis Data</h1>
                                <?php } else { ?>
                                    <h1>Update Diagnosis Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New Diagnosis Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update Diagnosis Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Diagnosis Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Visit Date</label>
                                                        <input type="date" value="<?php if ($costing['visit_date']) {
                                                                                        print_r($costing['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="clinician_name" class="form-label">96. Name of clinician</label>
                                                        <input type="text" value="<?php if ($costing['clinician_name']) {
                                                                                        print_r($costing['clinician_name']);
                                                                                    } ?>" id="clinician_name" name="clinician_name" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Final diagnosis</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label for="tb_diagnosis" class="form-label">101. Was a TB diagnosis made?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_diagnosis" id="tb_diagnosis<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_diagnosis'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('tb_diagnosis')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="tb_diagnosis_made">
                                                    <label for="tb_diagnosis_made" class="form-label">102. How was the TB diagnosis made? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_diagnosis_made', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_diagnosis_made" id="zn_results_b<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_diagnosis_made'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="diagnosis_made_other" class="form-label">what date ?</label>
                                                            <input type="text" value="<?php if ($costing['diagnosis_made_other']) {
                                                                                            print_r($costing['diagnosis_made_other']);
                                                                                        } ?>" id="diagnosis_made_other" name="diagnosis_made_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('tb_diagnosis_made')">Unset</button>

                                                </div>

                                                <div class="col-sm-4" id="bacteriological_diagnosis">
                                                    <label for="bacteriological_diagnosis" class="form-label">103. On what test result(s) was the bacteriological diagnosis based?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('bacteriological_diagnosis', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="bacteriological_diagnosis[]" id="bacteriological_diagnosis<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['bacteriological_diagnosis']) as $values) {
                                                                                                                                                                                                                                            if ($values == $value['id']) {
                                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="tb_diagnosis_hides">
                                                <hr>
                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="xpert_ultra_date" class="form-label">103. If Xpert Ultra (Date?)</label>
                                                            <input type="date" value="<?php if ($costing['xpert_ultra_date']) {
                                                                                            print_r($costing['xpert_ultra_date']);
                                                                                        } ?>" id="xpert_ultra_date" name="xpert_ultra_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="truenat_date" class="form-label">103. If Truenat (Date?)</label>
                                                            <input type="date" value="<?php if ($costing['truenat_date']) {
                                                                                            print_r($costing['truenat_date']);
                                                                                        } ?>" id="truenat_date" name="truenat_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="afb_microscope_date" class="form-label">103. If AFB Microscope (Date?)</label>
                                                            <input type="date" value="<?php if ($costing['afb_microscope_date']) {
                                                                                            print_r($costing['afb_microscope_date']);
                                                                                        } ?>" id="afb_microscope_date" name="afb_microscope_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="other_bacteriological_date" class="form-label">103. If Other test(s),(Date?)</label>
                                                            <input type="date" value="<?php if ($costing['other_bacteriological_date']) {
                                                                                            print_r($costing['other_bacteriological_date']);
                                                                                        } ?>" id="other_bacteriological_date" name="other_bacteriological_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">

                                                    <div class="col-sm-4" id="tb_diagnosed_clinically">
                                                        <label for="tb_diagnosed_clinically" class="form-label">104. In case TB was diagnosed clinically, based on what information was the diagnosis made? </label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('tb_diagnosed_clinically', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="tb_diagnosed_clinically[]" id="tb_diagnosed_clinically<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['tb_diagnosed_clinically']) as $values) {
                                                                                                                                                                                                                                            if ($values == $value['id']) {
                                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                                <label for="tb_clinically_other" class="form-label">Other Specify ?</label>
                                                                <input type="text" value="<?php if ($costing['tb_clinically_other']) {
                                                                                                print_r($costing['tb_clinically_other']);
                                                                                            } ?>" id="tb_clinically_other" name="tb_clinically_other" class="form-control" placeholder="Enter here" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4" id="tb_treatment">
                                                        <label for="tb_treatment" class="form-label">105. Was TB treatment started?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('tb_treatment', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tb_treatment" id="tb_treatment<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_treatment'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                                <label for="tb_treatment_date" class="form-label">What was treatment start date ?</label>
                                                                <input type="date" value="<?php if ($costing['tb_treatment_date']) {
                                                                                                print_r($costing['tb_treatment_date']);
                                                                                            } ?>" id="tb_treatment_date" name="tb_treatment_date" class="form-control" placeholder="Enter here" />
                                                                <label for="tb_facility" class="form-label">(Name health facility):</label>
                                                                <input type="text" value="<?php if ($costing['tb_facility']) {
                                                                                                print_r($costing['tb_facility']);
                                                                                            } ?>" id="tb_facility" name="tb_facility" class="form-control" placeholder="Enter here" />
                                                                <label for="tb_reason" class="form-label">reason (specify):</label>
                                                                <input type="text" value="<?php if ($costing['tb_reason']) {
                                                                                                print_r($costing['tb_reason']);
                                                                                            } ?>" id="tb_reason" name="tb_reason" class="form-control" placeholder="Enter here" />

                                                            </div>
                                                        </div>
                                                        <button onclick="unsetRadio('tb_treatment')">Unset</button>

                                                    </div>

                                                    <div class="col-sm-4" id="tb_regimen">
                                                        <label for="tb_regimen" class="form-label">106. What treatment regimen was prescribed? </label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('tb_regimen2', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tb_regimen" id="tb_regimen<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_regimen'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <label for="tb_regimen_other" class="form-label">Regimens specify</label>
                                                            <input type="text" value="<?php if ($costing['tb_regimen_other']) {
                                                                                            print_r($costing['tb_regimen_other']);
                                                                                        } ?>" id="tb_regimen_other" name="tb_regimen_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                        <button onclick="unsetRadio('tb_regimen')">Unset</button>

                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">


                                                    <div class="col-sm-4" id="laboratory_test_used">
                                                        <label for="laboratory_test_used" class="form-label">107. On what test result was the treatment regimen based and when did this test result become available to you? (dd / mm / yyyy)</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('laboratory_test_used', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="checkbox" name="laboratory_test_used[]" id="laboratory_test_used<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $costing['laboratory_test_used']) as $values) {
                                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4" id="regimen_changed">
                                                        <label for="regimen_changed" class="form-label">108. Was the regimen changed during the treatment and if so, what were the changes?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="regimen_changed" id="regimen_changed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['regimen_changed'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                                <label for="regimen_changed__date" class="form-label">1st (Date??), </label>
                                                                <input type="text" value="<?php if ($costing['regimen_changed__date']) {
                                                                                                print_r($costing['regimen_changed__date']);
                                                                                            } ?>" id="regimen_changed__date" name="regimen_changed__date" class="form-control" placeholder="Enter here" />
                                                                <label for="regimen_removed_name" class="form-label">Drug(s) removed </label>
                                                                <input type="text" value="<?php if ($costing['regimen_removed_name']) {
                                                                                                print_r($costing['regimen_removed_name']);
                                                                                            } ?>" id="regimen_removed_name" name="regimen_removed_name" class="form-control" placeholder="Enter here" />
                                                                <label for="regimen_added_name" class="form-label">Drugs added </label>
                                                                <input type="text" value="<?php if ($costing['regimen_added_name']) {
                                                                                                print_r($costing['regimen_added_name']);
                                                                                            } ?>" id="regimen_added_name" name="regimen_added_name" class="form-control" placeholder="Enter here" />
                                                                <label for="regimen_changed__reason" class="form-label">Reason for change </label>
                                                                <input type="text" value="<?php if ($costing['regimen_changed__reason']) {
                                                                                                print_r($costing['regimen_changed__reason']);
                                                                                            } ?>" id="regimen_changed__reason" name="regimen_changed__reason" class="form-control" placeholder="Enter here" />
                                                            </div>
                                                            <button onclick="unsetRadio('regimen_changed')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4" id="tb_otcome2">
                                                        <label for="tb_otcome2" class="form-label">109. Treatment outcome at the end of treatment</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('tb_otcome2', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tb_otcome2" id="tb_otcome2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_otcome2'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('tb_otcome2')">Unset</button>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>


                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Diagnosis other than TB</h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-4" id="tb_other_diagnosis">
                                                    <label for="tb_other_diagnosis" class="form-label">110. What diagnosis other than TB was made? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_other_diagnosis', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_other_diagnosis" id="tb_other_diagnosis<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_other_diagnosis'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="tb_other_specify" class="form-label">If Other Mention</label>
                                                            <input type="text" value="<?php if ($costing['tb_other_specify']) {
                                                                                            print_r($costing['tb_other_specify']);
                                                                                        } ?>" id="tb_other_specify" name="tb_other_specify" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('tb_other_diagnosis')">Unset</button>

                                                </div>

                                                <div class="col-sm-4" id="tb_diagnosis_made2">
                                                    <label for="tb_diagnosis_made" class="form-label">111. How was this diagnosis made?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_diagnosis_made3', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_diagnosis_made2" id="tb_diagnosis_made2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['tb_diagnosis_made2'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('tb_diagnosis_made2')">Unset</button>

                                                </div>


                                                <div class="col-sm-4" id="laboratory_test_used2">
                                                    <label for="microscopy_reason" class="form-label">112. If laboratory, which test used </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('laboratory_test_used2', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="laboratory_test_used2" id="laboratory_test_used2<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['laboratory_test_used2'] == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label for="microscopy_reason_other" class="form-label">If Other Mention</label>
                                                            <input type="text" value="<?php if ($costing['microscopy_reason_other']) {
                                                                                            print_r($costing['microscopy_reason_other']);
                                                                                        } ?>" id="microscopy_reason_other" name="microscopy_reason_other" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('laboratory_test_used2')">Unset</button>

                                                </div>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <label for="ct_value" class="form-label">113. This form was completed by (name)</label>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="clinician_firstname" class="form-label">First NAME</label>
                                                        <input type="text" value="<?php if ($costing['clinician_firstname']) {
                                                                                        print_r($costing['clinician_firstname']);
                                                                                    } ?>" id="clinician_firstname" name="clinician_firstname" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="clinician_middlename" class="form-label">Middle (Optional)</label>
                                                        <input type="text" value="<?php if ($costing['clinician_middlename']) {
                                                                                        print_r($costing['clinician_middlename']);
                                                                                    } ?>" id="clinician_middlename" name="clinician_middlename" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="clinician_lastname" class="form-label">Surname:</label>
                                                        <input type="text" value="<?php if ($costing['clinician_lastname']) {
                                                                                        print_r($costing['clinician_lastname']);
                                                                                    } ?>" id="clinician_lastname" name="clinician_lastname" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($costing['comments']) {
                                                                                                                                                            print_r($costing['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="form_completness">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="form_completness" id="form_completness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['form_completness'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('form_completness')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($costing['date_completed']) {
                                                                                        print_r($costing['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_diagnosis" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 16) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add Participant enrolment form</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item">
                                        <a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            <?php if ($_GET['status'] == 1) { ?>
                                                Go to screening list >
                                            <?php } elseif ($_GET['status'] == 2) { ?>
                                                Go to eligible list >
                                            <?php } elseif ($_GET['status'] == 3) { ?>
                                                Go to enrollment list >
                                            <?php } elseif ($_GET['status'] == 4) { ?>
                                                Go to terminated / end study list >
                                            <?php } elseif ($_GET['status'] == 5) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 6) { ?>
                                                Go to registered list >
                                            <?php } elseif ($_GET['status'] == 7) { ?>
                                                Go to registered list >
                                            <?php } ?>
                                        </a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item active">Add New Client</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <?php
                            $clients = $override->get3('enrollment_form', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Reason(s) for being regarded a presumptive TB patient at initial assessment (Multiple selection)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Date of Visit:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="visit_date" id="visit_date" value="<?php if ($clients['visit_date']) {
                                                                                                                                                                                print_r($clients['visit_date']);
                                                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>12. Cough of >2 weeks</label>
                                                            <select id="cough2weeks" name="cough2weeks" class="form-control" required>
                                                                <?php $cough2weeks = $override->get('yes_no', 'id', $clients['cough2weeks'])[0]; ?>
                                                                <option value="<?= $cough2weeks['id'] ?>"><?php if ($clients['cough2weeks']) {
                                                                                                                print_r($cough2weeks['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>13. Cough any duration for PLHIV</label>
                                                            <select id="cough_any" name="cough_any" class="form-control" required>
                                                                <?php $cough_any = $override->get('yes_no', 'id', $clients['cough_any'])[0]; ?>
                                                                <option value="<?= $cough_any['id'] ?>"><?php if ($clients['cough_any']) {
                                                                                                            print_r($cough_any['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>14. Poor weight gain or loss of weight</label>
                                                            <select id="poor_weight" name="poor_weight" class="form-control" required>
                                                                <?php $poor_weight = $override->get('yes_no', 'id', $clients['poor_weight'])[0]; ?>
                                                                <option value="<?= $poor_weight['id'] ?>"><?php if ($clients['poor_weight']) {
                                                                                                                print_r($poor_weight['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>15. Coughing up blood</label>
                                                            <select id="coughing_blood" name="coughing_blood" class="form-control" required>
                                                                <?php $coughing_blood = $override->get('yes_no', 'id', $clients['coughing_blood'])[0]; ?>
                                                                <option value="<?= $coughing_blood['id'] ?>"><?php if ($clients['coughing_blood']) {
                                                                                                                    print_r($coughing_blood['name']);
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>16. Unexplained fever</label>
                                                            <select id="unexplained_fever" name="unexplained_fever" class="form-control" required>
                                                                <?php $unexplained_fever = $override->get('yes_no', 'id', $clients['unexplained_fever'])[0]; ?>
                                                                <option value="<?= $unexplained_fever['id'] ?>"><?php if ($clients['unexplained_fever']) {
                                                                                                                    print_r($unexplained_fever['name']);
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>17. Drenching night sweats</label>
                                                            <select id="night_sweats" name="night_sweats" class="form-control" required>
                                                                <?php $night_sweats = $override->get('yes_no', 'id', $clients['night_sweats'])[0]; ?>
                                                                <option value="<?= $night_sweats['id'] ?>"><?php if ($clients['night_sweats']) {
                                                                                                                print_r($night_sweats['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>18. Enlarged neck lymph nodes</label>
                                                            <select id="neck_lymph" name="neck_lymph" class="form-control" required>
                                                                <?php $neck_lymph = $override->get('yes_no', 'id', $clients['neck_lymph'])[0]; ?>
                                                                <option value="<?= $neck_lymph['id'] ?>"><?php if ($clients['neck_lymph']) {
                                                                                                                print_r($neck_lymph['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>19. Contact history with infectious TB patient</label>
                                                            <select id="history_tb" name="history_tb" class="form-control" required>
                                                                <?php $history_tb = $override->get('yes_no', 'id', $clients['history_tb'])[0]; ?>
                                                                <option value="<?= $history_tb['id'] ?>"><?php if ($clients['history_tb']) {
                                                                                                                print_r($history_tb['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">History of TB and previous treatment</h3>
                                                </div>
                                            </div>

                                            <hr>


                                            <div class="row">

                                                <div class="col-sm-4">
                                                    <label>20. Was the participant treated for TB before?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tx_previous" id="tx_previous<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['tx_previous'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="tx_number1">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>21. If yes, how many times</label>
                                                            <input class="form-control" type="number" name="tx_number" id="tx_number" placeholder="Type how many ... " value="<?php if ($clients['tx_number']) {
                                                                                                                                                                                    print_r($clients['tx_number']);
                                                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="dr_ds1">
                                                    <label>22. Was it DR or DS TB (Multiple options)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dr_ds', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="dr_ds[]" id="dr_ds<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $clients['dr_ds']) as $values) {
                                                                                                                                                                                                    if ($values == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    }
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row" id="tx_previous_hide1">
                                                <div class="col-sm-4" id="tb_category">
                                                    <label>23. What category is the previously treated patient </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('tb_category', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="tb_category" id="tb_category<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['tb_category'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetTb_category()">Unset</button>
                                                </div>

                                                <div class="col-sm-4" id="relapse_years1">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>24. If relapse how long ago was the participant treated for TB? (years)</label>
                                                            <input class="form-control" type="number" name="relapse_years" id="relapse_years" placeholder="Type years..." value="<?php if ($clients['relapse_years']) {
                                                                                                                                                                                        print_r($clients['relapse_years']);
                                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="ltf_months1">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>25. If LTF for how long the participant received TB treatment? (months)</label>
                                                            <input class="form-control" type="number" name="ltf_months" id="ltf_months" placeholder="Type years..." value="<?php if ($clients['ltf_months']) {
                                                                                                                                                                                print_r($clients['ltf_months']);
                                                                                                                                                                            }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>26. Which treatment regimen was initiated </label>
                                                            <select id="tb_regimen" name="tb_regimen" class="form-control">
                                                                <?php $tb_regimen = $override->get('tb_regimen', 'id', $clients['tb_regimen'])[0]; ?>
                                                                <option value="<?= $tb_regimen['id'] ?>"><?php if ($clients['tb_regimen']) {
                                                                                                                print_r($tb_regimen['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <option value="">Select</option>
                                                                <?php foreach ($override->get('tb_regimen', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row" id="tx_previous_hide2">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>27. How long was the treatment regimen (months)</label>
                                                            <input class="form-control" type="number" name="regimen_months" id="regimen_months" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['regimen_months']) {
                                                                                                                                                                                                                print_r($clients['regimen_months']);
                                                                                                                                                                                                            }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="regimen_changed">
                                                    <label>28. Was the regimen changed during treatment (individualized?)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="regimen_changed" id="regimen_changed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['regimen_changed'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRegimen_changed()">Unset</button>
                                                </div>


                                                <div class="col-sm-3" id="regimen_name1">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>29. If yes, the treatment regimen was changed what was the new regimen</label>
                                                            <input class="form-control" type="text" name="regimen_name" id="regimen_name" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['regimen_name']) {
                                                                                                                                                                                                            print_r($clients['regimen_name']);
                                                                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>30. What was the treatment outcome?</label>
                                                            <select id="tb_otcome" name="tb_otcome" class="form-control">
                                                                <?php $tb_otcome = $override->get('tb_otcome', 'id', $clients['tb_otcome'])[0]; ?>
                                                                <option value="<?= $tb_otcome['id'] ?>"><?php if ($clients['tb_otcome']) {
                                                                                                            print_r($tb_otcome['name']);
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                                </option>
                                                                <option value="">Select</option>
                                                                <?php foreach ($override->get('tb_otcome', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Health-related conditions</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>31. HIV status </label>
                                                            <select id="hiv_status" name="hiv_status" class="form-control" required>
                                                                <?php $hiv_status = $override->get('hiv_status', 'id', $clients['hiv_status'])[0]; ?>
                                                                <option value="<?= $hiv_status['id'] ?>"><?php if ($clients['hiv_status']) {
                                                                                                                print_r($hiv_status['name']);
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                                </option>
                                                                <?php foreach ($override->get('hiv_status', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="immunosuppressive">
                                                    <label>32. Do you have other immunosuppressive diseases?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_unknown', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="immunosuppressive" id="immunosuppressive<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['immunosuppressive'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked' . ' ' . 'required';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div id="immunosuppressive_specify1">
                                                            <label>33. If yes specify</label>
                                                            <input class="form-control" type="number" name="immunosuppressive_specify" id="immunosuppressive_specify" placeholder="Type here..." value="<?php if ($clients['immunosuppressive_specify']) {
                                                                                                                                                                                                            print_r($clients['immunosuppressive_specify']);
                                                                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="other_diseases">
                                                    <label>34. Other relevant diseases/medical conditions</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_unknown', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="other_diseases" id="other_diseases<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['other_diseases'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked' . ' ' . 'required';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="diseases_medical">
                                                    <label>34. If yes, Select relevant diseases/medical conditions</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('diseases_medical', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="diseases_medical[]" id="diseases_medical<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $clients['diseases_medical']) as $values) {
                                                                                                                                                                                                                            if ($values == $value['id']) {
                                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                            <label id="diseases_specify1">34. If Other specify</label>
                                                            <input class="form-control" type="number" name="diseases_specify" id="diseases_specify" placeholder="Type here..." value="<?php if ($clients['diseases_specify']) {
                                                                                                                                                                                            print_r($clients['diseases_specify']);
                                                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Samples collected</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="sputum_collected">
                                                    <label>35. Were two sputum samples collected? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sputum_collected" id="sputum_collected<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['sputum_collected'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked' . ' ' . 'required';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sample_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>36. Date of respiratory sample collection </label>
                                                            <input class="form-control" type="date" name="sample_date" id="sample_date" value="<?php if ($clients['sample_date']) {
                                                                                                                                                    print_r($clients['sample_date']);
                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="other_samples">
                                                    <label>37. Were any other diagnostic samples requested? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no_sample', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="other_samples" id="other_samples<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['other_samples'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="sputum_samples">
                                                    <label>38. Tick all that apply and fill date for each sample ticked </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sputum_samples', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="sputum_samples[]" id="sputum_samples<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php foreach (explode(',', $clients['sputum_samples']) as $values) {
                                                                                                                                                                                                                        if ($values == $value['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        }
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="pleural_fluid_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Pleural fluid Date</label>
                                                            <input class="form-control" type="date" name="pleural_fluid_date" id="pleural_fluid_date" value="<?php if ($clients['pleural_fluid_date']) {
                                                                                                                                                                    print_r($clients['pleural_fluid_date']);
                                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="csf_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Cerebral spinal fluid (CSF) Date</label>
                                                            <input class="form-control" type="date" name="csf_date" id="csf_date" value="<?php if ($clients['csf_date']) {
                                                                                                                                                print_r($clients['csf_date']);
                                                                                                                                            }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="peritoneal_fluid_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Peritoneal fluid Date</label>
                                                            <input class="form-control" type="date" name="peritoneal_fluid_date" id="peritoneal_fluid_date" value="<?php if ($clients['peritoneal_fluid_date']) {
                                                                                                                                                                        print_r($clients['peritoneal_fluid_date']);
                                                                                                                                                                    }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="pericardial_fluid_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Pericardial fluid Date</label>
                                                            <input class="form-control" type="date" name="pericardial_fluid_date" id="pericardial_fluid_date" value="<?php if ($clients['pericardial_fluid_date']) {
                                                                                                                                                                            print_r($clients['pericardial_fluid_date']);
                                                                                                                                                                        }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="lymph_node_aspirate_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Lymph node aspirate Date</label>
                                                            <input class="form-control" type="date" name="lymph_node_aspirate_date" id="lymph_node_aspirate_date" value="<?php if ($clients['lymph_node_aspirate_date']) {
                                                                                                                                                                                print_r($clients['lymph_node_aspirate_date']);
                                                                                                                                                                            }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="stool_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Stool Date</label>
                                                            <input class="form-control" type="date" name="stool_date" id="stool_date" value="<?php if ($clients['stool_date']) {
                                                                                                                                                    print_r($clients['stool_date']);
                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="sputum_samples_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>38. Other, specify Date</label>
                                                            <input class="form-control" type="date" name="sputum_samples_date" id="sputum_samples_date" value="<?php if ($clients['sputum_samples_date']) {
                                                                                                                                                                    print_r($clients['sputum_samples_date']);
                                                                                                                                                                }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-4" id="chest_x_ray">
                                                    <label>39. Was chest X-ray requested? </label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="chest_x_ray" id="chest_x_ray<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($clients['chest_x_ray'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked' . ' ' . 'required';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="chest_x_ray_date1">
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>39.If yes,Specify Date</label>
                                                            <input class="form-control" type="date" name="chest_x_ray_date" id="chest_x_ray_date" value="<?php if ($clients['chest_x_ray_date']) {
                                                                                                                                                                print_r($clients['chest_x_ray_date']);
                                                                                                                                                            }  ?>" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="enrollment_completed">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>40. This form was completed by (name) </label>
                                                            <select id="enrollment_completed" name="enrollment_completed" class="form-control" required>
                                                                <?php $enrollment_completed = $override->get('user', 'id', $clients['enrollment_completed'])[0]; ?>
                                                                <option value="<?= $enrollment_completed['id'] ?>"><?php if ($clients['enrollment_completed']) {
                                                                                                                        print_r($enrollment_completed['firstname'] . ' ' . $enrollment_completed['lastname']);
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                                </option>
                                                                <?php foreach ($override->get('user', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['firstname'] . ' ' . $value['lastname'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->

                                        <div class="card-footer">
                                            <a href="info.php?id=3&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_enrollment_form" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div> <!-- /.card -->
                            </div> <!--/.col (right) -->
                        </div> <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 17) { ?>
            <?php
            $costing = $override->getNews('validations', 'status', 1, 'id', $_GET['cid'])[0];
            $facility = $override->get('sites', 'id', $costing['site_id'])[0];

            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$costing) { ?>
                                    <h1>Add New validations Data</h1>
                                <?php } else { ?>
                                    <h1>Update validations Data</h1>
                                <?php } ?>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>">
                                            < Back</a>
                                    </li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="index1.php">Home</a></li>&nbsp;&nbsp;
                                    <li class="breadcrumb-item"><a href="info.php?id=3&status=<?= $_GET['status']; ?>">
                                            Go to screening list > </a>
                                    </li>&nbsp;&nbsp;
                                    <?php if (!$costing) { ?>
                                        <li class="breadcrumb-item active">Add New validations Data</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update validations Data</li>
                                    <?php } ?>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">validations Form</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="date_collect" class="form-label">Collection Date</label>
                                                        <input type="date" value="<?php if ($costing['date_collect']) {
                                                                                        print_r($costing['date_collect']);
                                                                                    } ?>" id="date_collect" name="date_collect" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="date_receictrl" class="form-label">Date CTRL Received</label>
                                                        <input type="date" value="<?php if ($costing['date_receictrl']) {
                                                                                        print_r($costing['date_receictrl']);
                                                                                    } ?>" id="date_receictrl" name="date_receictrl" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="lab_no" class="form-label">lab_no</label>
                                                        <input type="text" value="<?php if ($costing['lab_no']) {
                                                                                        print_r($costing['lab_no']);
                                                                                    } ?>" id="lab_no" name="lab_no" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="transit_time" class="form-label">transit_time (If N / A Put '99')</label>
                                                        <input type="number" value="<?php if ($costing['transit_time']) {
                                                                                        print_r($costing['transit_time']);
                                                                                    } ?>" id="transit_time" name="transit_time" min="0" max="100" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="date_collect" class="form-label">resid_distr</label>
                                                        <input type="text" value="<?php if ($costing['resid_distr']) {
                                                                                        print_r($costing['resid_distr']);
                                                                                    } ?>" id="resid_distr" name="resid_distr" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>h_facil</label>
                                                            <select id="h_facil" name="h_facil" class="form-control" required>
                                                                <option value="<?= $facility['id'] ?>"><?php if ($costing['h_facil']) {
                                                                                                            print_r($facility['name']);
                                                                                                        } else {
                                                                                                            echo 'Select region';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('sites', 'status', 1) as $region) { ?>
                                                                    <option value="<?= $region['id'] ?>"><?= $region['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="hf_district" class="form-label">hf_district</label>
                                                        <input type="text" value="<?php if ($costing['hf_district']) {
                                                                                        print_r($costing['hf_district']);
                                                                                    } ?>" id="hf_district" name="hf_district" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="tb_region" class="form-label">tb_region</label>
                                                        <input type="text" value="<?php if ($costing['tb_region']) {
                                                                                        print_r($costing['tb_region']);
                                                                                    } ?>" id="tb_region" name="tb_region" class="form-control" placeholder="Enter here" required />
                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label for="samplae_type" class="form-label">Sample type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sample_type2', 'status2', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="samplae_type" id="samplae_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['samplae_type'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('samplae_type')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="pat_category">
                                                    <label for="pat_category" class="form-label">Patient Category</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('patient_category', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="pat_category" id="pat_category<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['pat_category'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('pat_category')">Unset</button>
                                                </div>

                                                <div class="col-sm-3" id="testrequest_reason">
                                                    <label for="testrequest_reason" class="form-label">Testrequest Reason</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('testrequest_reason', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="testrequest_reason" id="testrequest_reason<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['testrequest_reason'] == $value['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('testrequest_reason')">Unset</button>
                                                </div>
                                                <div class="col-sm-3" id="follow_up_months1">
                                                    <div class="mb-3">
                                                        <label for="follow_up_months" class="form-label">Follow up at months ?</label>
                                                        <input type="number" value="<?php if ($costing['follow_up_months']) {
                                                                                        print_r($costing['follow_up_months']);
                                                                                    } ?>" id="follow_up_months" name="follow_up_months" min="1" max="20" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="tb_diagnosis_hides2222">
                                                <hr>
                                                <div class="row">

                                                    <div class="col-sm-3">
                                                        <div class="mb-3">
                                                            <label for="treatment_month" class="form-label">Treatment Month (If N/A put '99' ,If Not provided put '98')</label>
                                                            <input type="number" value="<?php if ($costing['treatment_month']) {
                                                                                            print_r($costing['treatment_month']);
                                                                                        } ?>" id="treatment_month" name="treatment_month" min="1" max="20" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3" id="hiv_status">
                                                        <label for="hiv_status" class="form-label">Hiv Status</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('hiv_status2', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="hiv_status" id="hiv_status<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['hiv_status'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <button onclick="unsetRadio('hiv_status')">Unset</button>

                                                    </div>

                                                    <div class="col-sm-2" id="gx_results">
                                                        <label for="gx_results" class="form-label">GX results</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('gx_results', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="gx_results" id="gx_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['gx_results'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <button onclick="unsetRadio('gx_results')">Unset</button>

                                                    </div>

                                                    <div class="col-2">
                                                        <div class="mb-2">
                                                            <label for="gxmtb_ct" class="form-label">gxmtb_ct</label>
                                                            <input type="text" value="<?php if ($costing['gxmtb_ct']) {
                                                                                            print_r($costing['gxmtb_ct']);
                                                                                        } ?>" id="gxmtb_ct" name="gxmtb_ct" min="0" max="40" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-2" id="gx_mtbamount">
                                                        <label for="gx_mtbamount" class="form-label">GX MTB Amount</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('gxmtbamount', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="gx_mtbamount" id="gx_mtbamount<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['gx_mtbamount'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <button onclick="unsetRadio('gx_mtbamount')">Unset</button>

                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="row">

                                                    <div class="col-sm-3" id="fm_done">
                                                        <label for="fm_done" class="form-label">Fm done ?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="fm_done" id="fm_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['fm_done'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                        <label class="form-check-label"><?= $value['name']; ?></label>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <button onclick="unsetRadio('fm_done')">Unset</button>

                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="fm_date" class="form-label">Fm date</label>
                                                            <input type="date" value="<?php if ($costing['fm_date']) {
                                                                                            print_r($costing['fm_date']);
                                                                                        } ?>" id="fm_date" name="fm_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="fm_results" class="form-label">Fm results</label>
                                                            <input type="text" value="<?php if ($costing['fm_results']) {
                                                                                            print_r($costing['fm_results']);
                                                                                        } ?>" id="fm_results" name="fm_results" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="mb-2">
                                                            <label for="dec_date" class="form-label">dec_date</label>
                                                            <input type="date" value="<?php if ($costing['dec_date']) {
                                                                                            print_r($costing['dec_date']);
                                                                                        } ?>" id="dec_date" name="dec_date" class="form-control" placeholder="Enter here" />
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-sm-3" id="cult_done">
                                                    <label for="cult_done" class="form-label">cult_done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="cult_done" id="cult_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['cult_done'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('cult_done')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="inno_date" class="form-label">inno_date</label>
                                                        <input type="date" value="<?php if ($costing['inno_date']) {
                                                                                        print_r($costing['inno_date']);
                                                                                    } ?>" id="inno_date" name="inno_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="ljcul_results">
                                                    <label for="ljcul_results" class="form-label">ljcul_results</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('ljcul_results', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="ljcul_results" id="ljcul_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ljcul_results'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                    <button onclick="unsetRadio('ljcul_results')">Unset</button>

                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="ljculres_date" class="form-label">ljculres_date</label>
                                                        <input type="date" value="<?php if ($costing['ljculres_date']) {
                                                                                        print_r($costing['ljculres_date']);
                                                                                    } ?>" id="ljculres_date" name="ljculres_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" id="mgitcul_resul">
                                                    <label for="mgitcul_resul" class="form-label">mgitcul_resul</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mgitcul_resul', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitcul_resul" id="mgitcul_resul<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitcul_resul'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitcul_resul')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3" id="ljdst_rif">
                                                    <label for="ljdst_rif" class="form-label">ljdst_rif</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="ljdst_rif" id="ljdst_rif<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ljdst_rif'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('ljdst_rif')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="ljdst_iso">
                                                    <label for="ljdst_iso" class="form-label">ljdst_iso</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="ljdst_iso" id="ljdst_iso<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ljdst_iso'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('ljdst_iso')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="ljdst_ethamb">
                                                    <label for="ljdst_ethamb" class="form-label">ljdst_ethamb</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="ljdst_ethamb" id="ljdst_ethamb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['ljdst_ethamb'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('ljdst_ethamb')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_stm">
                                                    <label for="mgitdst_stm" class="form-label">mgitdst_stm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_stm" id="mgitdst_stm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_stm'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_stm')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="mgitdst_rif">
                                                    <label for="mgitdst_rif" class="form-label">mgitdst_rif</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_rif" id="mgitdst_rif<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_rif'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_rif')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_iso">
                                                    <label for="mgitdst_iso" class="form-label">ljdst_iso</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_iso" id="ljdst_iso<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_iso'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_iso')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_ethamb">
                                                    <label for="mgitdst_ethamb" class="form-label">mgitcul_resul</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_ethamb" id="mgitdst_ethamb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_ethamb'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_ethamb')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_bed">
                                                    <label for="mgitdst_bed" class="form-label">mgitdst_stm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_bed" id="mgitdst_bed<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_bed'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_bed')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="mgitdst_2cfz">
                                                    <label for="mgitdst_2cfz" class="form-label">mgitdst_2cfz</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_2cfz" id="mgitdst_2cfz<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_2cfz'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_2cfz')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_2dlm">
                                                    <label for="mgitdst_2dlm" class="form-label">mgitdst_2dlm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_2dlm" id="mgitdst_2dlm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_2dlm'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_2dlm')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_2levo">
                                                    <label for="mgitdst_2levo" class="form-label">mgitdst_2levo</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_2levo" id="mgitdst_2levo<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_2levo'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_2levo')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="mgitdst_2lzd">
                                                    <label for="mgitdst_2lzd" class="form-label">mgitdst_2lzd</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="mgitdst_2lzd" id="mgitdst_2lzd<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['mgitdst_2lzd'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('mgitdst_2lzd')">Unset</button>

                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="lpa1_mtbdetected">
                                                    <label for="lpa1_mtbdetected" class="form-label">lpa1_mtbdetected</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mtb_detected_not', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa1_mtbdetected" id="lpa1_mtbdetected<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa1_mtbdetected'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa1_mtbdetected')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="lpaa1dst_rif">
                                                    <label for="lpaa1dst_rif" class="form-label">lpaa1dst_rif</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpaa1dst_rif" id="lpaa1dst_rif<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpaa1dst_rif'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpaa1dst_rif')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="lpa1dst_inh">
                                                    <label for="lpa1dst_inh" class="form-label">mgitdst_2levo</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('dst', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa1dst_inh" id="lpa1dst_inh<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa1dst_inh'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa1dst_inh')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="lpa2_done">
                                                    <label for="lpa2_done" class="form-label">lpa2_done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa2_done" id="lpa2_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa2_done'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa2_done')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="lpa2_date" id="lpa2_date1" class="form-label">lpa2_date</label>
                                                        <input type="date" value="<?php if ($costing['lpa2_date']) {
                                                                                        print_r($costing['lpa2_date']);
                                                                                    } ?>" id="lpa2_date" name="lpa2_date" class="form-control" placeholder="Enter here" />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="lpa2_mtbdetected">
                                                    <label for="lpa2_mtbdetected" class="form-label">lpa2_mtbdetected</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mtb_detected_not_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa2_mtbdetected" id="lpa2_mtbdetected<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa2_mtbdetected'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa2_mtbdetected')">Unset</button>

                                                    </div>
                                                </div>


                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="lpa2dst_lfx">
                                                    <label for="lpa2dst_lfx" class="form-label">lpa2dst_lfx</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sensitive_resistance_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa2dst_lfx" id="lpa2dst_lfx<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa2dst_lfx'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa2dst_lfx')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-4" id="lpa2dst_ag_cp">
                                                    <label for="lpa2dst_ag_cp" class="form-label">lpa2dst_ag_cp</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sensitive_resistance_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa2dst_ag_cp" id="lpa2dst_ag_cp<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa2dst_ag_cp'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa2dst_ag_cp')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="lpa2dstag_lowkan">
                                                    <label for="lpa2dstag_lowkan" class="form-label">lpa2dstag_lowkan</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('sensitive_resistance_na', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="lpa2dstag_lowkan" id="lpa2dstag_lowkan<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['lpa2dstag_lowkan'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('lpa2dstag_lowkan')">Unset</button>

                                                    </div>
                                                </div>


                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="nanop_done">
                                                    <label for="nanop_done" class="form-label">nanop_done</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('yes_no', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nanop_done" id="nanop_done<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nanop_done'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nanop_done')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-4" id="posnegcontrol">
                                                    <label for="posnegcontrol" class="form-label">posnegcontrol</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pass_fails', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="posnegcontrol" id="posnegcontrol<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['posnegcontrol'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('posnegcontrol')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-4" id="sample_control">
                                                    <label for="sample_control" class="form-label">sample_control</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pass_fails', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="sample_control" id="sample_control<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['sample_control'] == $value['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('sample_control')">Unset</button>

                                                    </div>
                                                </div>


                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4" id="internalcontrol">
                                                    <label for="internalcontrol" class="form-label">internalcontrol</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pass_fails', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="internalcontrol" id="internalcontrol<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['internalcontrol'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('internalcontrol')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-4" id="hsp65">
                                                    <label for="hsp65" class="form-label">hsp65</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('pass_fails', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="hsp65" id="hsp65<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['hsp65'] == $value['id']) {
                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('hsp65')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="nanopseq_date" class="form-label">nanopseq_date</label>
                                                        <input type="date" value="<?php if ($costing['nanopseq_date']) {
                                                                                        print_r($costing['nanopseq_date']);
                                                                                    } ?>" id="nanopseq_date" name="nanopseq_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="myco_results">
                                                    <label for="myco_results" class="form-label">myco_results</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('mtb_detected_not_faled', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="myco_results" id="myco_results<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['myco_results'] == $value['id']) {
                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('myco_results')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="myco_type">
                                                    <label for="myco_type" class="form-label">myco_type</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('myco_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="myco_type" id="myco_type<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['myco_type'] == $value['id']) {
                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('myco_type')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="myco_spp">
                                                    <label for="myco_spp" class="form-label">myco_spp</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('myco_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="myco_spp" id="myco_spp<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['myco_spp'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('myco_spp')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="myco_lineage" class="form-label">myco_lineage</label>
                                                        <input type="text" value="<?php if ($costing['myco_lineage']) {
                                                                                        print_r($costing['myco_lineage']);
                                                                                    } ?>" id="myco_lineage" name="myco_lineage" class="form-control" placeholder="Enter date" />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="nano_rif">
                                                    <label for="nano_rif" class="form-label">nano_rif</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_rif" id="nano_rif<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_rif'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_rif')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="nano_inh">
                                                    <label for="nano_inh" class="form-label">nano_inh</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_inh" id="nano_inh<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_inh'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_inh')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_kan">
                                                    <label for="nano_kan" class="form-label">nano_kan</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_kan" id="nano_kan<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_kan'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_kan')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_mxf">
                                                    <label for="nano_mxf" class="form-label">nano_mxf</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_mxf" id="nano_mxf<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_mxf'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_mxf')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="nano_cap">
                                                    <label for="nano_cap" class="form-label">nano_cap</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_cap" id="nano_cap<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_cap'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_cap')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="nano_emb">
                                                    <label for="nano_emb" class="form-label">nano_emb</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_emb" id="nano_emb<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_emb'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_emb')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_pza">
                                                    <label for="nano_pza" class="form-label">nano_pza</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_pza" id="nano_pza<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_pza'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_pza')">Unset</button>

                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="nano_amk">
                                                    <label for="nano_amk" class="form-label">nano_amk</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_amk" id="nano_amk<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_amk'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_amk')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="nano_bdq">
                                                    <label for="nano_bdq" class="form-label">nano_bdq</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_bdq" id="nano_bdq<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_bdq'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_bdq')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="nano_cfz">
                                                    <label for="nano_cfz" class="form-label">nano_inh</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_cfz" id="nano_cfz<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_cfz'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_cfz')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_dlm">
                                                    <label for="nano_dlm" class="form-label">nano_dlm</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_dlm" id="nano_dlm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_dlm'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_dlm')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_eto">
                                                    <label for="nano_eto" class="form-label">nano_eto</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_eto" id="nano_eto<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_eto'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_eto')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-3" id="nano_lfx">
                                                    <label for="nano_lfx" class="form-label">nano_lfx</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_lfx" id="nano_lfx<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_lfx'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_lfx')">Unset</button>

                                                    </div>
                                                </div>


                                                <div class="col-sm-3" id="nano_lzd">
                                                    <label for="nano_lzd" class="form-label">nano_lzd</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_lzd" id="nano_lzd<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_lzd'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_lzd')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_pmd">
                                                    <label for="nano_pmd" class="form-label">nano_kan</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_pmd" id="nano_pmd<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_pmd'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_pmd')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="nano_stm">
                                                    <label for="nano_stm" class="form-label">nano_mxf</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('nano_type', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nano_stm" id="nano_stm<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['nano_stm'] == $value['id']) {
                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('nano_stm')">Unset</button>

                                                    </div>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">ANY COMENT OR REMARKS</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Remarks / Comments:</label>
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($costing['comments']) {
                                                                                                                                                            print_r($costing['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">FORM STATUS</h3>
                                                </div>
                                            </div>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-6" id="form_completness">
                                                    <label>Complete?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('form_completness', 'status', 1) as $value) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="form_completness" id="form_completness<?= $value['id']; ?>" value="<?= $value['id']; ?>" <?php if ($costing['form_completness'] == $value['id']) {
                                                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                                                } ?> required>
                                                                    <label class="form-check-label"><?= $value['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <button onclick="unsetRadio('form_completness')">Unset</button>

                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="date_completed" class="form-label">Date form completed</label>
                                                        <input type="date" value="<?php if ($costing['date_completed']) {
                                                                                        print_r($costing['date_completed']);
                                                                                    } ?>" id="date_completed" name="date_completed" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter date" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_validations" value="Submit" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                                <!-- /.card -->
                            </div>
                            <!--/.col (right) -->
                        </div>
                        <!-- /.row -->
                    </div><!-- /.container-fluid -->
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->
        <?php } elseif ($_GET['id'] == 18) { ?>
        <?php } elseif ($_GET['id'] == 19) { ?>
        <?php } elseif ($_GET['id'] == 20) { ?>
        <?php } elseif ($_GET['id'] == 21) { ?>
        <?php } elseif ($_GET['id'] == 22) { ?>
        <?php } elseif ($_GET['id'] == 23) { ?>
        <?php } elseif ($_GET['id'] == 24) { ?>
        <?php } elseif ($_GET['id'] == 25) { ?>
        <?php } elseif ($_GET['id'] == 26) { ?>
        <?php } elseif ($_GET['id'] == 27) { ?>
        <?php } elseif ($_GET['id'] == 28) { ?>
        <?php } ?>

        <?php include 'footer.php'; ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Select2 -->
    <script src="plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap color picker -->
    <script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Bootstrap Switch -->
    <script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- BS-Stepper -->
    <script src="plugins/bs-stepper/js/bs-stepper.min.js"></script>
    <!-- dropzonejs -->
    <script src="plugins/dropzone/min/dropzone.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <!-- <script src="../../dist/js/demo.js"></script> -->
    <!-- Page specific script -->


    <!-- clients Js -->
    <script src="myjs/add/clients/insurance.js"></script>
    <script src="myjs/add/clients/insurance_name.js"></script>
    <script src="myjs/add/clients/relation_patient.js"></script>
    <!-- <script src="myjs/add/clients/validate_hidden_with_values.js"></script>
    <script src="myjs/add/clients/validate_required_attribute.js"></script>
    <script src="myjs/add/clients/validate_required_radio_checkboxes.js"></script>-->

    <!-- SCREENING Js -->
    <script src="myjs/add/screening/conset.js"></script>
    <script src="myjs/add/screening/art.js"></script>

    <!-- Enrollment Js -->
    <script src="myjs/add/enrollment/other_diseases.js"></script>
    <script src="myjs/add/enrollment/other_samples.js"></script>
    <script src="myjs/add/enrollment/regimen_changed.js"></script>
    <script src="myjs/add/enrollment/sputum_collected.js"></script>
    <script src="myjs/add/enrollment/sputum_samples.js"></script>
    <script src="myjs/add/enrollment/tb_category.js"></script>
    <script src="myjs/add/enrollment/tx_previous.js"></script>


    <!-- RESPIRATORY format numbers Js -->
    <script src="myjs/add/respiratory/sample_received.js"></script>
    <script src="myjs/add/respiratory/test_rejected.js"></script>
    <script src="myjs/add/respiratory/afb_microscopy.js"></script>
    <script src="myjs/add/respiratory/wrd_test.js"></script>
    <script src="myjs/add/respiratory/sequence_type.js"></script>
    <script src="myjs/add/respiratory/test_repeatition.js"></script>

    <!-- NON RESPIRATORY format numbers Js -->
    <script src="myjs/add/non_respiratory/n_sample_received.js"></script>
    <script src="myjs/add/non_respiratory/n_test_rejected.js"></script>
    <script src="myjs/add/non_respiratory/n_afb_microscopy.js"></script>
    <script src="myjs/add/non_respiratory/n_wrd_test.js"></script>
    <script src="myjs/add/non_respiratory/n_sequence_type.js"></script>
    <script src="myjs/add/non_respiratory/n_test_repeatition.js"></script>
    <script src="myjs/add/non_respiratory/afb.js"></script>

    <!-- Diagnosis Test format numbers Js -->
    <script src="myjs/add/diagnosis_test/sample_methods.js"></script>
    <script src="myjs/add/diagnosis_test/qn79.js"></script>
    <script src="myjs/add/diagnosis_test/qn80.js"></script>
    <script src="myjs/add/diagnosis_test/qn81.js"></script>
    <script src="myjs/add/diagnosis_test/qn82.js"></script>
    <script src="myjs/add/diagnosis_test/qn83.js"></script>
    <script src="myjs/add/diagnosis_test/qn84.js"></script>
    <script src="myjs/add/diagnosis_test/qn85.js"></script>
    <script src="myjs/add/diagnosis_test/qn86.js"></script>
    <script src="myjs/add/diagnosis_test/qn87.js"></script>
    <script src="myjs/add/diagnosis_test/qn88.js"></script>
    <script src="myjs/add/diagnosis_test/qn89.js"></script>
    <script src="myjs/add/diagnosis_test/qn90.js"></script>
    <script src="myjs/add/diagnosis_test/qn91.js"></script>
    <script src="myjs/add/diagnosis_test/qn92.js"></script>
    <script src="myjs/add/diagnosis_test/qn93.js"></script>





    <script src="myjs/add/radio.js"></script>
    <!-- <script src="myjs/add/radios1.js"></script>
    <script src="myjs/add/radios2.js"></script>
    <script src="myjs/add/radios3.js"></script>
    <script src="myjs/add/radios4.js"></script>
    <script src="myjs/add/radios96.js"></script> -->
    <script src="myjs/add/checkbox1.js"></script>
    <script src="myjs/add/many_many.js"></script>
    <script src="myjs/add/many_many1.js"></script>
    <script src="myjs/add/many_many2.js"></script>
    <script src="myjs/add/many_many3.js"></script>
    <script src="myjs/add/many_many4.js"></script>
    <script src="myjs/add/many_many5.js"></script>
    <script src="myjs/add/many_one.js"></script>
    <script src="myjs/add/one_many.js"></script>


    <script>
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            //Datemask dd/mm/yyyy
            $('#datemask').inputmask('dd/mm/yyyy', {
                'placeholder': 'dd/mm/yyyy'
            })
            //Datemask2 mm/dd/yyyy
            $('#datemask2').inputmask('mm/dd/yyyy', {
                'placeholder': 'mm/dd/yyyy'
            })
            //Money Euro
            $('[data-mask]').inputmask()

            //Date picker
            $('#reservationdate').datetimepicker({
                format: 'L'
            });

            //Date and time picker
            $('#reservationdatetime').datetimepicker({
                icons: {
                    time: 'far fa-clock'
                }
            });

            //Date range picker
            $('#reservation').daterangepicker()
            //Date range picker with time picker
            $('#reservationtime').daterangepicker({
                timePicker: true,
                timePickerIncrement: 30,
                locale: {
                    format: 'MM/DD/YYYY hh:mm A'
                }
            })
            //Date range as a button
            $('#daterange-btn').daterangepicker({
                    ranges: {
                        'Today': [moment(), moment()],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function(start, end) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
                }
            )

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            //Bootstrap Duallistbox
            $('.duallistbox').bootstrapDualListbox()

            //Colorpicker
            $('.my-colorpicker1').colorpicker()
            //color picker with addon
            $('.my-colorpicker2').colorpicker()

            $('.my-colorpicker2').on('colorpickerChange', function(event) {
                $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
            })

            $("input[data-bootstrap-switch]").each(function() {
                $(this).bootstrapSwitch('state', $(this).prop('checked'));
            })

            $('#regions_id').change(function() {
                var region_id = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#districts_id').html(data);
                    }
                });
            });

            $('#region').change(function() {
                var region = $(this).val();
                $.ajax({
                    url: "process.php?content=region_id",
                    method: "GET",
                    data: {
                        region_id: region
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#district').html(data);
                    }
                });
            });

            $('#district').change(function() {
                var district_id = $(this).val();
                $.ajax({
                    url: "process.php?content=district_id",
                    method: "GET",
                    data: {
                        district_id: district_id
                    },
                    dataType: "text",
                    success: function(data) {
                        $('#ward').html(data);
                    }
                });
            });

        })

        // BS-Stepper Init
        document.addEventListener('DOMContentLoaded', function() {
            window.stepper = new Stepper(document.querySelector('.bs-stepper'))
        })

        // DropzoneJS Demo Code Start
        Dropzone.autoDiscover = false

        // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
        var previewNode = document.querySelector("#template")
        previewNode.id = ""
        var previewTemplate = previewNode.parentNode.innerHTML
        previewNode.parentNode.removeChild(previewNode)

        var myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
            url: "/target-url", // Set the url
            thumbnailWidth: 80,
            thumbnailHeight: 80,
            parallelUploads: 20,
            previewTemplate: previewTemplate,
            autoQueue: false, // Make sure the files aren't queued until manually added
            previewsContainer: "#previews", // Define the container to display the previews
            clickable: ".fileinput-button" // Define the element that should be used as click trigger to select files.
        })

        myDropzone.on("addedfile", function(file) {
            // Hookup the start button
            file.previewElement.querySelector(".start").onclick = function() {
                myDropzone.enqueueFile(file)
            }
        })

        // Update the total progress bar
        myDropzone.on("totaluploadprogress", function(progress) {
            document.querySelector("#total-progress .progress-bar").style.width = progress + "%"
        })

        myDropzone.on("sending", function(file) {
            // Show the total progress bar when upload starts
            document.querySelector("#total-progress").style.opacity = "1"
            // And disable the start button
            file.previewElement.querySelector(".start").setAttribute("disabled", "disabled")
        })

        // Hide the total progress bar when nothing's uploading anymore
        myDropzone.on("queuecomplete", function(progress) {
            document.querySelector("#total-progress").style.opacity = "0"
        })

        // Setup the buttons for all transfers
        // The "add files" button doesn't need to be setup because the config
        // `clickable` has already been specified.
        document.querySelector("#actions .start").onclick = function() {
            myDropzone.enqueueFiles(myDropzone.getFilesWithStatus(Dropzone.ADDED))
        }
        document.querySelector("#actions .cancel").onclick = function() {
            myDropzone.removeAllFiles(true)
        }
        // DropzoneJS Demo Code End


        // $("#packs_per_day, #packs_per_day").on("input", function() {
        //     setTimeout(function() {
        //         var weight = $("#packs_per_day").val();
        //         var height = $("#packs_per_day").val() / 100; // Convert cm to m
        //         var bmi = weight / (height * height);
        //         $("#packs_per_year").text(bmi.toFixed(2));
        //     }, 1);
        // });
    </script>

</body>

</html>