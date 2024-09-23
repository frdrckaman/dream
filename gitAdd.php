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

                    $staff = $override->getNews('user', 'status', 1, 'id', $_GET['staff_id']);

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
                            'accessLevel' => $accessLevel,
                            'power' => Input::get('power'),
                            'password' => Hash::make($password, $salt),
                            'salt' => $salt,
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
        } elseif (Input::get('add_position')) {
            $validate = $validate->check($_POST, array(
                'name' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                try {
                    $user->createRecord('position', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Position Successful Added';
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
                    $user->createRecord('site', array(
                        'name' => Input::get('name'),
                    ));
                    $successMessage = 'Site Successful Added';
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_client')) {
            if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                $validate = $validate->check($_POST, array(
                    'date_registered' => array(
                        'required' => true,
                    ),
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'sex' => array(
                        'required' => true,
                    ),
                    'hospital_id' => array(
                        'required' => true,
                        // 'unique' => 'clients'
                    ),
                    'site' => array(
                        'required' => true,
                    ),
                ));
            } else {
                $validate = $validate->check($_POST, array(
                    'date_registered' => array(
                        'required' => true,
                    ),
                    'firstname' => array(
                        'required' => true,
                    ),
                    'middlename' => array(
                        'required' => true,
                    ),
                    'lastname' => array(
                        'required' => true,
                    ),
                    'sex' => array(
                        'required' => true,
                    ),
                    'hospital_id' => array(
                        'required' => true,
                        // 'unique' => 'clients'
                    ),
                ));
            }
            if ($validate->passed()) {
                // $date = date('Y-m-d', strtotime('+1 month', strtotime('2015-01-01')));
                try {
                    $site_id = $user->data()->site_id;
                    if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                        $site_id = Input::get('site');
                    }

                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid']);

                    $age = $user->dateDiffYears(Input::get('date_registered'), Input::get('dob'));

                    if ($clients) {
                        $user->updateRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'district' => Input::get('district'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'pay_services' => Input::get('pay_services'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'interview_type' => Input::get('interview_type'),
                            'comments' => Input::get('comments'),
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $_GET['cid']);

                        $successMessage = 'Client Updated Successful';
                    } else {

                        $std_id = $override->getNews('study_id', 'site_id', $site_id, 'status', 0)[0];

                        $user->createRecord('clients', array(
                            'date_registered' => Input::get('date_registered'),
                            'study_id' => $std_id['study_id'],
                            'firstname' => Input::get('firstname'),
                            'middlename' => Input::get('middlename'),
                            'lastname' => Input::get('lastname'),
                            'sex' => Input::get('sex'),
                            'dob' => Input::get('dob'),
                            'age' => $age,
                            'hospital_id' => Input::get('hospital_id'),
                            'patient_phone' => Input::get('patient_phone'),
                            'patient_phone2' => Input::get('patient_phone2'),
                            'supporter_fname' => Input::get('supporter_fname'),
                            'supporter_mname' => Input::get('supporter_mname'),
                            'supporter_lname' => Input::get('supporter_lname'),
                            'supporter_phone' => Input::get('supporter_phone'),
                            'supporter_phone2' => Input::get('supporter_phone2'),
                            'relation_patient' => Input::get('relation_patient'),
                            'relation_patient_other' => Input::get('relation_patient_other'),
                            'district' => Input::get('district'),
                            'street' => Input::get('street'),
                            'location' => Input::get('location'),
                            'house_number' => Input::get('house_number'),
                            'head_household' => Input::get('head_household'),
                            'education' => Input::get('education'),
                            'occupation' => Input::get('occupation'),
                            'health_insurance' => Input::get('health_insurance'),
                            'insurance_name' => Input::get('insurance_name'),
                            'insurance_name_other' => Input::get('insurance_name_other'),
                            'pay_services' => Input::get('pay_services'),
                            'comments' => Input::get('comments'),
                            'interview_type' => Input::get('interview_type'),
                            'status' => 1,
                            'screened' => 0,
                            'eligible' => 0,
                            'enrolled' => 0,
                            'end_study' => 0,
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $site_id,
                        ));

                        $last_row = $override->lastRow('clients', 'id')[0];

                        $user->updateRecord('study_id', array(
                            'status' => 1,
                            'client_id' => $last_row['id'],
                        ), $std_id['id']);

                        $user->createRecord('visit', array(
                            'sequence' => 0,
                            'study_id' => $std_id['study_id'],
                            'visit_code' => 'RS',
                            'visit_name' => 'Registration & Screening',
                            'expected_date' => Input::get('date_registered'),
                            'visit_date' => '',
                            'visit_status' => 0,
                            'status' => 1,
                            'patient_id' => $last_row['id'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $site_id,
                        ));

                        $successMessage = 'Client  Added Successful';
                    }
                    Redirect::to('info.php?id=3&status=7');
                } catch (Exception $e) {
                    die($e->getMessage());
                }
            }
        } elseif (Input::get('add_kap')) {
            $validate = $validate->check($_POST, array(
                'interview_date' => array(
                    'required' => true,
                ),
                'saratani_mapafu' => array(
                    'required' => true,
                ),
                'uhusiano_saratani' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $kap = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid']);
                $vitu_hatarishi = implode(',', Input::get('vitu_hatarishi'));
                $dalili_saratani = implode(',', Input::get('dalili_saratani'));
                $saratani_vipimo = implode(',', Input::get('saratani_vipimo'));
                $matibabu = implode(',', Input::get('matibabu'));
                $kundi = implode(',', Input::get('kundi'));
                $ushawishi = implode(',', Input::get('ushawishi'));
                $saratani_hatari = implode(',', Input::get('saratani_hatari'));

                if ($kap) {
                    $user->updateRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'saratani_mapafu' => Input::get('saratani_mapafu'),
                        'uhusiano_saratani' => Input::get('uhusiano_saratani'),
                        'kusambazwa_saratani' => Input::get('kusambazwa_saratani'),
                        'vitu_hatarishi' => $vitu_hatarishi,
                        'vitu_hatarishi_other' => Input::get('vitu_hatarishi_other'),
                        'dalili_saratani' => $dalili_saratani,
                        'dalili_saratani_other' => Input::get('dalili_saratani_other'),
                        'saratani_vipimo' => $saratani_vipimo,
                        'saratani_vipimo_other' => Input::get('saratani_vipimo_other'),
                        'saratani_inatibika' => Input::get('saratani_inatibika'),
                        'matibabu_saratani' => Input::get('matibabu_saratani'),
                        'matibabu' => $matibabu,
                        'matibabu_other' => Input::get('matibabu_other'),
                        'saratani_uchunguzi' => Input::get('saratani_uchunguzi'),
                        'uchunguzi_maana' => Input::get('uchunguzi_maana'),
                        'uchunguzi_maana_other' => Input::get('uchunguzi_maana_other'),
                        'uchunguzi_faida' => Input::get('uchunguzi_faida'),
                        'uchunguzi_faida_other' => Input::get('uchunguzi_faida_other'),
                        'uchunguzi_hatari' => Input::get('uchunguzi_hatari'),
                        'uchunguzi_hatari_other' => Input::get('uchunguzi_hatari_other'),
                        'saratani_hatari' => $saratani_hatari,
                        'saratani_hatari_other' => Input::get('saratani_hatari_other'),
                        'kundi' => $kundi,
                        'kundi_other' => Input::get('kundi_other'),
                        'ushawishi' => $ushawishi,
                        'ushawishi_other' => Input::get('ushawishi_other'),
                        'hitaji_elimu' => Input::get('hitaji_elimu'),
                        'vifo' => Input::get('vifo'),
                        'tayari_dalili' => Input::get('tayari_dalili'),
                        'saratani_kutibika' => Input::get('saratani_kutibika'),
                        'saratani_wasiwasi' => Input::get('saratani_wasiwasi'),
                        'saratani_umuhimu' => Input::get('saratani_umuhimu'),
                        'saratani_kufa' => Input::get('saratani_kufa'),
                        'uchunguzi_haraka' => Input::get('uchunguzi_haraka'),
                        'wapi_matibabu' => Input::get('wapi_matibabu'),
                        'wapi_matibabu_other' => Input::get('wapi_matibabu_other'),
                        'saratani_ushauri' => Input::get('saratani_ushauri'),
                        'saratani_ujumbe' => Input::get('saratani_ujumbe'),
                        'comments' => Input::get('comments'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $kap[0]['id']);

                    $successMessage = 'Kap  Successful Updated';
                } else {
                    $user->createRecord('kap', array(
                        'interview_date' => Input::get('interview_date'),
                        'study_id' => $_GET['study_id'],
                        'saratani_mapafu' => Input::get('saratani_mapafu'),
                        'uhusiano_saratani' => Input::get('uhusiano_saratani'),
                        'kusambazwa_saratani' => Input::get('kusambazwa_saratani'),
                        'vitu_hatarishi' => $vitu_hatarishi,
                        'vitu_hatarishi_other' => Input::get('vitu_hatarishi_other'),
                        'dalili_saratani' => $dalili_saratani,
                        'dalili_saratani_other' => Input::get('dalili_saratani_other'),
                        'saratani_vipimo' => $saratani_vipimo,
                        'saratani_vipimo_other' => Input::get('saratani_vipimo_other'),
                        'saratani_inatibika' => Input::get('saratani_inatibika'),
                        'matibabu_saratani' => Input::get('matibabu_saratani'),
                        'matibabu' => $matibabu,
                        'matibabu_other' => Input::get('matibabu_other'),
                        'saratani_uchunguzi' => Input::get('saratani_uchunguzi'),
                        'uchunguzi_maana' => Input::get('uchunguzi_maana'),
                        'uchunguzi_maana_other' => Input::get('uchunguzi_maana_other'),
                        'uchunguzi_faida' => Input::get('uchunguzi_faida'),
                        'uchunguzi_faida_other' => Input::get('uchunguzi_faida_other'),
                        'uchunguzi_hatari' => Input::get('uchunguzi_hatari'),
                        'uchunguzi_hatari_other' => Input::get('uchunguzi_hatari_other'),
                        'saratani_hatari' => $saratani_hatari,
                        'saratani_hatari_other' => Input::get('saratani_hatari_other'),
                        'kundi' => $kundi,
                        'kundi_other' => Input::get('kundi_other'),
                        'ushawishi' => $ushawishi,
                        'ushawishi_other' => Input::get('ushawishi_other'),
                        'hitaji_elimu' => Input::get('hitaji_elimu'),
                        'vifo' => Input::get('vifo'),
                        'tayari_dalili' => Input::get('tayari_dalili'),
                        'saratani_kutibika' => Input::get('saratani_kutibika'),
                        'saratani_wasiwasi' => Input::get('saratani_wasiwasi'),
                        'saratani_umuhimu' => Input::get('saratani_umuhimu'),
                        'saratani_kufa' => Input::get('saratani_kufa'),
                        'uchunguzi_haraka' => Input::get('uchunguzi_haraka'),
                        'wapi_matibabu' => Input::get('wapi_matibabu'),
                        'wapi_matibabu_other' => Input::get('wapi_matibabu_other'),
                        'saratani_ushauri' => Input::get('saratani_ushauri'),
                        'saratani_ujumbe' => Input::get('saratani_ujumbe'),
                        'comments' => Input::get('comments'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $successMessage = 'Kap  Successful Added';
                }

                // Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_history')) {
            $validate = $validate->check($_POST, array(
                'screening_date' => array(
                    'required' => true,
                ),
                'ever_smoked' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $history = $override->getNews('history', 'status', 1, 'patient_id', $_GET['cid']);
                $date1 = Input::get('start_smoking');
                $packs = Input::get('packs_cigarette_day');
                $eligible = 0;


                if (Input::get('ever_smoked') == 1) {
                    if (Input::get('currently_smoking') == 1) {
                        $date2 = date('Y', strtotime(Input::get('screening_date')));
                        if (Input::get('type_smoked') == 1) {
                            $years = $date2 - $date1;
                            $packs_year = $packs * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        } elseif (Input::get('type_smoked') == 2) {
                            $years = $date2 - $date1;
                            $packs_year = ($packs / 20) * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        }
                    } elseif (Input::get('currently_smoking') == 2) {
                        $date2 = Input::get('quit_smoking');
                        if (Input::get('type_smoked') == 1) {
                            $years = $date2 - $date1;
                            $packs_year = $packs * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        } elseif (Input::get('type_smoked') == 2) {
                            $years = $date2 - $date1;
                            $packs_year = ($packs / 20) * $years;
                            if ($packs_year >= 20) {
                                $eligible = 1;
                            }
                        }
                    }
                }

                if (Input::get('ever_smoked') == 1) {
                    if (Input::get('start_smoking') == '') {
                        $errorMessage = 'Please the add value from the question ' . ' "When did you start smoking?" ' . ' before submit';
                    } elseif (Input::get('currently_smoking') == '') {
                        $errorMessage = 'Please add the value from the question ' . ' "Are you Currently Smoking?" ' . ' before submit';
                    } elseif (Input::get('currently_smoking') == 2) {
                        if (Input::get('quit_smoking') == '') {
                            $errorMessage = 'Please the add value from the question ' . ' "When did you quit smoking in years?" ' . ' before submit';
                        } elseif (Input::get('quit_smoking') < Input::get('start_smoking')) {
                            $errorMessage = 'Please the value from the question ' . ' "When did you quit smoking in years?" ' . 'can not be less than ' . ' When did you start smoking?';
                        } else {
                            if (!$history) {

                                $user->createRecord('history', array(
                                    'screening_date' => Input::get('screening_date'),
                                    'study_id' => $_GET['study_id'],
                                    'ever_smoked' => Input::get('ever_smoked'),
                                    'start_smoking' => Input::get('start_smoking'),
                                    'smoking_long' => Input::get('smoking_long'),
                                    'type_smoked' => Input::get('type_smoked'),
                                    'currently_smoking' => Input::get('currently_smoking'),
                                    'quit_smoking' => Input::get('quit_smoking'),
                                    'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                    'pack_year' => $packs_year,
                                    'eligible' => $eligible,
                                    'status' => 1,
                                    'patient_id' => $_GET['cid'],
                                    'create_on' => date('Y-m-d H:i:s'),
                                    'staff_id' => $user->data()->id,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                    'site_id' => $clients['site_id'],
                                ));

                                if ($eligible) {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                                } else {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                                }

                                $user->updateRecord('clients', array(
                                    'screened' => 1,
                                    'eligible' => $eligible,
                                ), $_GET['cid']);

                                $successMessage = 'History  Successful Added';

                                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                            } else {
                                $user->updateRecord('history', array(
                                    'screening_date' => Input::get('screening_date'),
                                    'study_id' => $_GET['study_id'],
                                    'ever_smoked' => Input::get('ever_smoked'),
                                    'start_smoking' => Input::get('start_smoking'),
                                    'smoking_long' => Input::get('smoking_long'),
                                    'type_smoked' => Input::get('type_smoked'),
                                    'currently_smoking' => Input::get('currently_smoking'),
                                    'quit_smoking' => Input::get('quit_smoking'),
                                    'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                    'pack_year' => $packs_year,
                                    'eligible' => $eligible,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                ), $history[0]['id']);

                                if ($eligible) {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                                } else {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                                }
                            }

                            $user->updateRecord('clients', array(
                                'screened' => 1,
                                'eligible' => $eligible,
                            ), $_GET['cid']);

                            $successMessage = 'History  Successful Updated';

                            Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                        }
                    } elseif (Input::get('currently_smoking') == 1) {
                        if (Input::get('quit_smoking') != '') {
                            $errorMessage = 'Please remove value from the question ' . ' "When did you quit smoking in years?" ' . ' before submit';
                        } elseif (Input::get('start_smoking') > date('Y', strtotime(Input::get('screening_date')))) {
                            $errorMessage = 'Please the value from the question ' . ' "When did you start smoking?" ' . 'can not be greater than ' . ' Screening date';
                        } else {
                            if (!$history) {

                                $user->createRecord('history', array(
                                    'screening_date' => Input::get('screening_date'),
                                    'study_id' => $_GET['study_id'],
                                    'ever_smoked' => Input::get('ever_smoked'),
                                    'start_smoking' => Input::get('start_smoking'),
                                    'smoking_long' => Input::get('smoking_long'),
                                    'type_smoked' => Input::get('type_smoked'),
                                    'currently_smoking' => Input::get('currently_smoking'),
                                    'quit_smoking' => Input::get('quit_smoking'),
                                    'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                    'pack_year' => $packs_year,
                                    'eligible' => $eligible,
                                    'status' => 1,
                                    'patient_id' => $_GET['cid'],
                                    'create_on' => date('Y-m-d H:i:s'),
                                    'staff_id' => $user->data()->id,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                    'site_id' => $clients['site_id'],
                                ));

                                if ($eligible) {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                                } else {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                                }

                                $user->updateRecord('clients', array(
                                    'screened' => 1,
                                    'eligible' => $eligible,
                                ), $_GET['cid']);

                                $successMessage = 'History  Successful Added';

                                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                            } else {
                                $user->updateRecord('history', array(
                                    'screening_date' => Input::get('screening_date'),
                                    'study_id' => $_GET['study_id'],
                                    'ever_smoked' => Input::get('ever_smoked'),
                                    'start_smoking' => Input::get('start_smoking'),
                                    'smoking_long' => Input::get('smoking_long'),
                                    'type_smoked' => Input::get('type_smoked'),
                                    'currently_smoking' => Input::get('currently_smoking'),
                                    'quit_smoking' => Input::get('quit_smoking'),
                                    'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                    'pack_year' => $packs_year,
                                    'eligible' => $eligible,
                                    'update_on' => date('Y-m-d H:i:s'),
                                    'update_id' => $user->data()->id,
                                ), $history[0]['id']);

                                if ($eligible) {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                                } else {
                                    $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                                }
                            }

                            $user->updateRecord('clients', array(
                                'screened' => 1,
                                'eligible' => $eligible,
                            ), $_GET['cid']);

                            $successMessage = 'History  Successful Updated';

                            Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                        }
                    } elseif (Input::get('type_smoked') == '') {
                        $errorMessage = 'Please add the value from the question ' . ' "Amount smoked per day in cigarette sticks/packs?" ' . ' before submit';
                    } elseif (Input::get('packs_cigarette_day') == '') {
                        $errorMessage = 'Please add the value from the question ' . ' "Number of packs per day" ' . ' before submit';
                    } else {

                        if (!$history) {

                            $user->createRecord('history', array(
                                'screening_date' => Input::get('screening_date'),
                                'study_id' => $_GET['study_id'],
                                'ever_smoked' => Input::get('ever_smoked'),
                                'start_smoking' => Input::get('start_smoking'),
                                'smoking_long' => Input::get('smoking_long'),
                                'type_smoked' => Input::get('type_smoked'),
                                'currently_smoking' => Input::get('currently_smoking'),
                                'quit_smoking' => Input::get('quit_smoking'),
                                'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                'pack_year' => $packs_year,
                                'eligible' => $eligible,
                                'status' => 1,
                                'patient_id' => $_GET['cid'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients['site_id'],
                            ));

                            if ($eligible) {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                            } else {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                            }

                            $user->updateRecord('clients', array(
                                'screened' => 1,
                                'eligible' => $eligible,
                            ), $_GET['cid']);

                            $successMessage = 'History  Successful Added';

                            Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                        } else {
                            $user->updateRecord('history', array(
                                'screening_date' => Input::get('screening_date'),
                                'study_id' => $_GET['study_id'],
                                'ever_smoked' => Input::get('ever_smoked'),
                                'start_smoking' => Input::get('start_smoking'),
                                'smoking_long' => Input::get('smoking_long'),
                                'type_smoked' => Input::get('type_smoked'),
                                'currently_smoking' => Input::get('currently_smoking'),
                                'quit_smoking' => Input::get('quit_smoking'),
                                'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                'pack_year' => $packs_year,
                                'eligible' => $eligible,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), $history[0]['id']);

                            if ($eligible) {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                            } else {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                            }
                        }

                        $user->updateRecord('clients', array(
                            'screened' => 1,
                            'eligible' => $eligible,
                        ), $_GET['cid']);

                        $successMessage = 'History  Successful Updated';

                        Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                    }
                } elseif (Input::get('ever_smoked') == 2) {
                    if (Input::get('start_smoking') != '') {
                        $errorMessage = 'Please remove the value from the question ' . ' "When did you start smoking?" ' . ' before submit';
                    } elseif (Input::get('currently_smoking') != '') {
                        $errorMessage = 'Please remove the value from the question ' . ' "Are you Currently Smoking?" ' . ' before submit';
                    } elseif (Input::get('quit_smoking') != '') {
                        $errorMessage = 'Please remove the value from the question ' . ' "When did you quit smoking in years?" ' . ' before submit';
                    } elseif (Input::get('type_smoked') != '') {
                        $errorMessage = 'Please remove the value from the question ' . ' "Amount smoked per day in cigarette sticks/packs?" ' . ' before submit';
                    } elseif (Input::get('packs_cigarette_day') != '') {
                        $errorMessage = 'Please remove the value from the question ' . ' "Number of packs per day" ' . ' before submit';
                    } else {

                        if (!$history) {

                            $user->createRecord('history', array(
                                'screening_date' => Input::get('screening_date'),
                                'study_id' => $_GET['study_id'],
                                'ever_smoked' => Input::get('ever_smoked'),
                                'start_smoking' => Input::get('start_smoking'),
                                'smoking_long' => Input::get('smoking_long'),
                                'type_smoked' => Input::get('type_smoked'),
                                'currently_smoking' => Input::get('currently_smoking'),
                                'quit_smoking' => Input::get('quit_smoking'),
                                'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                'pack_year' => $packs_year,
                                'eligible' => $eligible,
                                'status' => 1,
                                'patient_id' => $_GET['cid'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients['site_id'],
                            ));

                            if ($eligible) {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                            } else {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                            }

                            $user->updateRecord('clients', array(
                                'screened' => 1,
                                'eligible' => $eligible,
                            ), $_GET['cid']);

                            $successMessage = 'History  Successful Added';

                            Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                        } else {
                            $user->updateRecord('history', array(
                                'screening_date' => Input::get('screening_date'),
                                'study_id' => $_GET['study_id'],
                                'ever_smoked' => Input::get('ever_smoked'),
                                'start_smoking' => Input::get('start_smoking'),
                                'smoking_long' => Input::get('smoking_long'),
                                'type_smoked' => Input::get('type_smoked'),
                                'currently_smoking' => Input::get('currently_smoking'),
                                'quit_smoking' => Input::get('quit_smoking'),
                                'packs_cigarette_day' => Input::get('packs_cigarette_day'),
                                'pack_year' => $packs_year,
                                'eligible' => $eligible,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), $history[0]['id']);

                            if ($eligible) {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 1);
                            } else {
                                $user->visit_delete1($_GET['cid'], Input::get('screening_date'), $_GET['study_id'], $user->data()->id, $clients['site_id'], 0);
                            }
                        }

                        $user->updateRecord('clients', array(
                            'screened' => 1,
                            'eligible' => $eligible,
                        ), $_GET['cid']);

                        $successMessage = 'History  Successful Updated';

                        Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                    }
                }
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_results')) {
            $validate = $validate->check($_POST, array(
                'test_date' => array(
                    'required' => true,
                ),
                'results_date' => array(
                    'required' => true,
                ),
                'ldct_results' => array(
                    'required' => true,
                ),
                'rad_score' => array(
                    'required' => true,
                ),
                'findings' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];
                $results = $override->get3('results', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($results) {
                    $user->updateRecord('results', array(
                        'test_date' => Input::get('test_date'),
                        'results_date' => Input::get('results_date'),
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $results[0]['id']);
                    $successMessage = 'Results  Successful Updated';
                } else {
                    $user->createRecord('results', array(
                        'test_date' => Input::get('test_date'),
                        'results_date' => Input::get('results_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'ldct_results' => Input::get('ldct_results'),
                        'rad_score' => Input::get('rad_score'),
                        'findings' => Input::get('findings'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));

                    $user->updateRecord('clients', array(
                        'enrolled' => 1,
                    ), $_GET['cid']);

                    $successMessage = 'Results  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_classification')) {
            $validate = $validate->check($_POST, array(
                'classification_date' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                if (count(Input::get('category')) == 1) {
                    foreach (Input::get('category') as $value) {
                        $visit_code = '';
                        $visit_name = '';

                        if ($value == 1) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 2) {
                            $visit_code = 'M12';
                            $visit_name = 'Month 12';
                            $expected_date = date('Y-m-d', strtotime('+12 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 3) {
                            $visit_code = 'M06';
                            $visit_name = 'Month 6';
                            $expected_date = date('Y-m-d', strtotime('+6 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 4) {
                            $visit_code = 'M03';
                            $visit_name = 'Month 3';
                            $expected_date = date('Y-m-d', strtotime('+3 month', strtotime(Input::get('classification_date'))));
                        } elseif ($value == 5) {
                            $visit_code = 'RFT';
                            $visit_name = 'Referred';
                            $expected_date = date('Y-m-d', strtotime('+2 month', strtotime(Input::get('classification_date'))));
                        }
                    }

                    $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                    $classification = $override->get3('classification', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                    if ($classification) {
                        $user->updateRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'category' => $value,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                        ), $classification[0]['id']);
                        $successMessage = 'Classification  Successful Updated';
                    } else {
                        $user->createRecord('classification', array(
                            'classification_date' => Input::get('classification_date'),
                            'visit_code' => $_GET['visit_code'],
                            'study_id' => $_GET['study_id'],
                            'sequence' => $_GET['sequence'],
                            'category' => $value,
                            'status' => 1,
                            'patient_id' => $_GET['cid'],
                            'create_on' => date('Y-m-d H:i:s'),
                            'staff_id' => $user->data()->id,
                            'update_on' => date('Y-m-d H:i:s'),
                            'update_id' => $user->data()->id,
                            'site_id' => $clients['site_id'],
                        ));


                        $successMessage = 'Classification  Successful Added';
                    }

                    if ($_GET['sequence'] == 1) {
                        $visit_id = $override->getNews('visit', 'patient_id', $_GET['cid'], 'sequence', 2);
                        if ($visit_id) {
                            $user->updateRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                            ), $visit_id[0]['id']);
                        } else {
                            $user->createRecord('visit', array(
                                'expected_date' => $expected_date,
                                'visit_date' => '',
                                'visit_code' => $visit_code,
                                'visit_name' => $visit_name,
                                'study_id' => $_GET['study_id'],
                                'sequence' => 2,
                                'visit_status' => 0,
                                'status' => 1,
                                'patient_id' => $_GET['cid'],
                                'create_on' => date('Y-m-d H:i:s'),
                                'staff_id' => $user->data()->id,
                                'update_on' => date('Y-m-d H:i:s'),
                                'update_id' => $user->data()->id,
                                'site_id' => $clients['site_id'],
                            ));
                        }
                    }

                    Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
                } else {
                    $errorMessage = 'Please chose only one Classification!';
                }
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
        } elseif (Input::get('add_economic')) {
            $validate = $validate->check($_POST, array(
                'economic_date' => array(
                    'required' => true,
                ),
                'income_household' => array(
                    'required' => true,
                ),
                'income_patient' => array(
                    'required' => true,
                ),
            ));
            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $economic = $override->get3('economic', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($economic) {
                    $user->updateRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'income_household' => Input::get('income_household'),
                        'income_household_other' => Input::get('income_household_other'),
                        'income_patient' => Input::get('income_patient'),
                        'income_patient_other' => Input::get('income_patient_other'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $economic[0]['id']);
                    $successMessage = 'Economic  Successful Updated';
                } else {
                    $user->createRecord('economic', array(
                        'economic_date' => Input::get('economic_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'income_household' => Input::get('income_household'),
                        'income_household_other' => Input::get('income_household_other'),
                        'income_patient' => Input::get('income_patient'),
                        'income_patient_other' => Input::get('income_patient_other'),
                        'monthly_earn' => Input::get('monthly_earn'),
                        'member_earn' => Input::get('member_earn'),
                        'transport' => Input::get('transport'),
                        'support_earn' => Input::get('support_earn'),
                        'food_drinks' => Input::get('food_drinks'),
                        'other_cost' => Input::get('other_cost'),
                        'days' => Input::get('days'),
                        'hours' => Input::get('hours'),
                        'registration' => Input::get('registration'),
                        'consultation' => Input::get('consultation'),
                        'diagnostic' => Input::get('diagnostic'),
                        'medications' => Input::get('medications'),
                        'other_medical_cost' => Input::get('other_medical_cost'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));
                    $successMessage = 'Economic  Successful Added';
                }

                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
            } else {
                $pageError = $validate->errors();
            }
        } elseif (Input::get('add_outcome')) {
            $validate = $validate->check($_POST, array(
                'visit_date' => array(
                    'required' => true,
                ),
                'diagnosis' => array(
                    'required' => true,
                ),
                'outcome' => array(
                    'required' => true,
                ),
            ));

            if ($validate->passed()) {
                $clients = $override->getNews('clients', 'status', 1, 'id', $_GET['cid'])[0];

                $outcome = $override->get3('outcome', 'status', 1, 'patient_id', $_GET['cid'], 'sequence', $_GET['sequence']);

                if ($outcome) {
                    $user->updateRecord('outcome', array(
                        'visit_date' => Input::get('visit_date'),
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'outcome_date' => Input::get('outcome_date'),
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                    ), $outcome[0]['id']);

                    $successMessage = 'Outcome  Successful Updated';
                } else {
                    $user->createRecord('outcome', array(
                        'visit_date' => Input::get('visit_date'),
                        'visit_code' => $_GET['visit_code'],
                        'study_id' => $_GET['study_id'],
                        'sequence' => $_GET['sequence'],
                        'diagnosis' => Input::get('diagnosis'),
                        'outcome' => Input::get('outcome'),
                        'outcome_date' => Input::get('outcome_date'),
                        'status' => 1,
                        'patient_id' => $_GET['cid'],
                        'create_on' => date('Y-m-d H:i:s'),
                        'staff_id' => $user->data()->id,
                        'update_on' => date('Y-m-d H:i:s'),
                        'update_id' => $user->data()->id,
                        'site_id' => $clients['site_id'],
                    ));
                    $successMessage = 'Outcome  Successful Added';
                }
                Redirect::to('info.php?id=4&cid=' . $_GET['cid'] . '&sequence=' . $_GET['sequence'] . '&visit_code=' . $_GET['visit_code'] . '&study_id=' . $_GET['study_id'] . '&status=' . $_GET['status']);
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
    <title>Lung Cancer Database | Add Page</title>

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

        .hidden {
            display: none;
        }
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
                                                            <input class="form-control" type="number" min="0" max="2" name="power" id="power" value="<?php if ($staff['power']) {
                                                                                                                                                            print_r($staff['power']);
                                                                                                                                                        }  ?>" />
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
        <?php } elseif ($_GET['id'] == 3) { ?>
        <?php } elseif ($_GET['id'] == 4) { ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Add New Client</h1>
                            </div>
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="info.php?id=3&&status=<?= $_GET['status']; ?>">
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
                            $relation = $override->get('relation', 'id', $clients['relation_patient'])[0];
                            $sex = $override->get('sex', 'id', $clients['sex'])[0];
                            $district = $override->get('district', 'id', $clients['district'])[0];
                            $education = $override->get('education', 'id', $clients['education'])[0];
                            $occupation = $override->get('occupation', 'id', $clients['occupation'])[0];
                            $insurance = $override->get('insurance', 'id', $clients['health_insurance'])[0];
                            $payments = $override->get('payments', 'id', $clients['pay_services'])[0];
                            $household = $override->get('household', 'id', $clients['head_household'])[0];
                            ?>
                            <!-- right column -->
                            <div class="col-md-12">
                                <!-- general form elements disabled -->
                                <div class="card card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Client Details</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="clients" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Registration Date:</label>
                                                            <input class="form-control" type="date" max="<?= date('Y-m-d'); ?>" name="date_registered" id="date_registered" value="<?php if ($clients['date_registered']) {
                                                                                                                                                                                        print_r($clients['date_registered']);
                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Hospital ID ( CTC ID )</label>
                                                            <input class="form-control" type="text" minlength="14" maxlength="14" size="14" pattern=[0]{1}[0-9]{13} name="hospital_id" id="hospital_id" placeholder="Type CTC ID..." value="<?php if ($clients['hospital_id']) {
                                                                                                                                                                                                                                                print_r($clients['hospital_id']);
                                                                                                                                                                                                                                            }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone" id="patient_phone" value="<?php if ($clients['patient_phone']) {
                                                                                                                                                                                                            print_r($clients['patient_phone']);
                                                                                                                                                                                                        }  ?>" required /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Patient Phone Number</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="patient_phone2" id="patient_phone2" value="<?php if ($clients['patient_phone2']) {
                                                                                                                                                                                                                print_r($clients['patient_phone2']);
                                                                                                                                                                                                            }  ?>" /> <span>Example: 0700 000 111</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
                                                    <label>SEX</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="sex" id="sex" value="1" <?php if ($clients['sex'] == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            } ?>>
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

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>First Name</label>
                                                            <input class="form-control" type="text" name="firstname" id="firstname" placeholder="Type firstname..." onkeyup="fetchData()" value="<?php if ($clients['firstname']) {
                                                                                                                                                                                                        print_r($clients['firstname']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Middle Name</label>
                                                            <input class="form-control" type="text" name="middlename" id="middlename" placeholder="Type middlename..." onkeyup="fetchData()" value="<?php if ($clients['middlename']) {
                                                                                                                                                                                                        print_r($clients['middlename']);
                                                                                                                                                                                                    }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Last Name</label>
                                                            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Type lastname..." onkeyup="fetchData()" value="<?php if ($clients['lastname']) {
                                                                                                                                                                                                    print_r($clients['lastname']);
                                                                                                                                                                                                }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
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
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">treatment supporter or next of kin details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>First Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_fname" id="supporter_fname" value="<?php if ($clients['supporter_fname']) {
                                                                                                                                                            print_r($clients['supporter_fname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Middle Name(Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_mname" id="supporter_mname" value="<?php if ($clients['supporter_mname']) {
                                                                                                                                                            print_r($clients['supporter_mname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Last Name (Supporter):</label>
                                                            <input class="form-control" type="text" name="supporter_lname" id="supporter_lname" value="<?php if ($clients['supporter_lname']) {
                                                                                                                                                            print_r($clients['supporter_lname']);
                                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number(Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone" id="supporter_phone" value="<?php if ($clients['supporter_phone']) {
                                                                                                                                                                                                                print_r($clients['supporter_phone']);
                                                                                                                                                                                                            }  ?>" required />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Mobile number 2 (Supporter)</label>
                                                            <input class="form-control" type="tel" pattern=[0]{1}[0-9]{9} minlength="10" maxlength="10" name="supporter_phone2" id="supporter_phone2" value="<?php if ($clients['supporter_phone2']) {
                                                                                                                                                                                                                    print_r($clients['supporter_phone2']);
                                                                                                                                                                                                                }  ?>" />
                                                        </div>
                                                        <span>Example: 0700 000 111</span>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Relation to patient(Supporter)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('relation', 'status', 1) as $relation) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="relation_patient" id="relation_patient<?= $relation['id']; ?>" value="<?= $relation['id']; ?>" <?php if ($clients['relation_patient'] == $relation['id']) {
                                                                                                                                                                                                                            echo 'checked';
                                                                                                                                                                                                                        } ?>>
                                                                    <label class="form-check-label"><?= $relation['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3" id="relation_patient_other">
                                                    <label>Other relation patient</label>
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <textarea class="form-control" name="relation_patient_other" id="relation_patient_other_value" rows="3" placeholder="Type other relation here...">
                                                                <?php if ($clients['relation_patient_other']) {
                                                                    print_r($clients['relation_patient_other']);
                                                                }  ?>
                                                            </textarea>
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
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>District</label>
                                                            <select id="district" name="district" class="form-control" required>
                                                                <option value="<?= $district['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($district['name']);
                                                                                                        } else {
                                                                                                            echo 'Select district';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('district', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Residence street</label>
                                                            <input class="form-control" type="text" name="street" id="street" value="<?php if ($clients['street']) {
                                                                                                                                            print_r($clients['street']);
                                                                                                                                        }  ?>" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Location:</label>
                                                            <textarea class="form-control" name="location" rows="3" placeholder="Type location here..." required>
                                                                <?php if ($clients['location']) {
                                                                    print_r($clients['location']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2">
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


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Other Details</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Who is the head of your household?</label>
                                                            <select id="head_household" name="head_household" class="form-control" required>
                                                                <option value="<?= $household['id'] ?>"><?php if ($clients) {
                                                                                                            print_r($household['name']);
                                                                                                        } else {
                                                                                                            echo 'Select household head';
                                                                                                        } ?>
                                                                </option>
                                                                <?php foreach ($override->get('household', 'status', 1) as $value) { ?>
                                                                    <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-4">
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <label>Level of educations</label>
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


                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">health insurance</h3>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>Do you own health insurance?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance1" value="1" <?php if ($clients['health_insurance'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="health_insurance" id="health_insurance2" value="2" <?php if ($clients['health_insurance'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="pay_services">
                                                    <label>If no, how do you pay for your health care services</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('payments', 'status', 1) as $payment) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="pay_services" id="pay_services<?= $payment['id']; ?>" value="<?= $payment['id']; ?>" <?php if ($clients['pay_services'] == $payment['id']) {
                                                                                                                                                                                                                echo 'checked';
                                                                                                                                                                                                            } ?>>
                                                                    <label class="form-check-label"><?= $payment['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name">
                                                    <label>Name of insurance:</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <?php foreach ($override->get('insurance', 'status', 1) as $insurance) { ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="insurance_name" id="insurance_name<?= $insurance['id']; ?>" value="<?= $insurance['id']; ?>" <?php if ($clients['insurance_name'] == $insurance['id']) {
                                                                                                                                                                                                                        echo 'checked';
                                                                                                                                                                                                                    } ?>>
                                                                    <label class="form-check-label"><?= $insurance['name']; ?></label>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4" id="insurance_name_other">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Other Name of insurance:</label>
                                                            <textarea class="form-control" name="insurance_name_other" rows="3" placeholder="Type other insurance here...">
                                                                <?php if ($clients['insurance_name_other']) {
                                                                    print_r($clients['insurance_name_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">Type of Interview</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                                                ?>
                                                    <div class="col-md-3">
                                                        <div class="card card-warning">
                                                            <div class="card-header">
                                                                <h3 class="card-title">Site Name</h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>


                                                <div class="col-md-6">
                                                    <div class="card card-warning">
                                                        <div class="card-header">
                                                            <h3 class="card-title">ANY OTHER COMENT OR REMARKS</h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <div class="row-form clearfix">
                                                        <!-- select -->
                                                        <div class="form-group">
                                                            <label>Type</label>
                                                            <select id="interview_type" name="interview_type" class="form-control" required>
                                                                <option value="<?= $clients['interview_type'] ?>"><?php if ($clients['interview_type']) {
                                                                                                                        if ($clients['interview_type'] == 1) {
                                                                                                                            echo 'Kap & Screening';
                                                                                                                        } elseif ($clients['interview_type'] == 2) {
                                                                                                                            echo 'Health Care Worker';
                                                                                                                        }
                                                                                                                    } else {
                                                                                                                        echo 'Select';
                                                                                                                    } ?>
                                                                </option>
                                                                <option value="1">Kap & Screening </option>
                                                                <option value="2">Health Care Worker </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                if ($user->data()->power == 1 || $user->data()->accessLevel == 1 || $user->data()->accessLevel == 2) {
                                                ?>
                                                    <div class="col-sm-3" id="insurance_name">
                                                        <label>Name Of Site:</label>
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
                                                <?php } ?>
                                                <div class="col-sm-6">
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
            $kap = $override->getNews('kap', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$kap) { ?>
                                    <h1>Add New KAP</h1>
                                <?php } else { ?>
                                    <h1>Update KAP</h1>
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
                                    <?php if (!$kap) { ?>
                                        <li class="breadcrumb-item active">Add New KAP</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update KAP</li>
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
                                        <h3 class="card-title">Sehemu ya 2: Uelewa juu ya Saratani ya mapafu. (Usimsomee machaguo)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="interview_date" class="form-label">Interview Date</label>
                                                        <input type="date" value="<?php if ($kap['interview_date']) {
                                                                                        print_r($kap['interview_date']);
                                                                                    } ?>" id="interview_date" name="interview_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter interview date" required />
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="saratani_mapafu" class="form-label">1. Je, unaweza kuniambia nini maana ya ugonjwa wa Saratani ya mapafu? </label>
                                                        <select name="saratani_mapafu" id="saratani_mapafu" class="form-control" required>
                                                            <option value="<?= $kap['saratani_mapafu'] ?>"><?php if ($kap['saratani_mapafu']) {
                                                                                                                if ($kap['saratani_mapafu'] == 1) {
                                                                                                                    echo 'Ugonjwa wa saratani ya mapafu ni ugonjwa ambao unatokea endapo seli za mapafu zinazaliana bila mpangilio maalum, na unaweza ukasambaa kwenye tezi za mwili na sehemu zinginezo.';
                                                                                                                } elseif ($kap['saratani_mapafu'] == 2) {
                                                                                                                    echo 'Wagonjwa wenye saratani ya mapafu hawaonyeshi dalili zozote wakati wa hatua za mwanzoni za ugonjwa.';
                                                                                                                } elseif ($kap['saratani_mapafu'] == 3) {
                                                                                                                    echo 'Sina uhakika nini maana ya ugonjwa wa saratani ya mapafu.';
                                                                                                                } elseif ($kap['saratani_mapafu'] == 4) {
                                                                                                                    echo 'Sijawahi kusikia kitu chochote juu ya ugonjwa wa saratani ya mapafu.';
                                                                                                                } elseif ($kap['saratani_mapafu'] == 99) {
                                                                                                                    echo 'Sijui';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                            </option>
                                                            <option value="1">a. Ugonjwa wa saratani ya mapafu ni ugonjwa ambao unatokea endapo seli za mapafu zinazaliana bila mpangilio maalum, na unaweza ukasambaa kwenye tezi za mwili na sehemu zinginezo.</option>
                                                            <option value="2">b. Wagonjwa wenye saratani ya mapafu hawaonyeshi dalili zozote wakati wa hatua za mwanzoni za ugonjwa.</option>
                                                            <option value="3">c. Sina uhakika nini maana ya ugonjwa wa saratani ya mapafu.</option>
                                                            <option value="4">d. Sijawahi kusikia kitu chochote juu ya ugonjwa wa saratani ya mapafu.</option>
                                                            <option value="99">e. Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="uhusiano_saratani" class="form-label">2. Je, kuna uhusiano kati ya saratani ya mapafu na maambukizi ya Virusi vya UKIMWI? </label>
                                                        <select name="uhusiano_saratani" id="uhusiano_saratani" class="form-control" required>
                                                            <option value="<?= $kap['uhusiano_saratani'] ?>"><?php if ($kap['uhusiano_saratani']) {
                                                                                                                    if ($kap['uhusiano_saratani'] == 1) {
                                                                                                                        echo 'Ndio';
                                                                                                                    } elseif ($kap['uhusiano_saratani'] == 2) {
                                                                                                                        echo 'Hapana';
                                                                                                                    } elseif ($kap['uhusiano_saratani'] == 99) {
                                                                                                                        echo 'Sijui';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-3">
                                                    <div class="mb-3">
                                                        <label for="kusambazwa_saratani" class="form-label">3. Je, saratani ya mapafu inaweza kusambazwa kutoka kwa mtu mmoja kwenda kwa mtu mwingine? </label>
                                                        <select name="kusambazwa_saratani" id="kusambazwa_saratani" class="form-control" required>
                                                            <option value="<?= $kap['kusambazwa_saratani'] ?>"><?php if ($kap['kusambazwa_saratani']) {
                                                                                                                    if ($kap['kusambazwa_saratani'] == 1) {
                                                                                                                        echo 'Ndio';
                                                                                                                    } elseif ($kap['kusambazwa_saratani'] == 2) {
                                                                                                                        echo 'Hapana';
                                                                                                                    } elseif ($kap['kusambazwa_saratani'] == 99) {
                                                                                                                        echo 'Sijui';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>4. Je, vitu gani hatarishi vinaweza kusababisha mtu kupata saratani ya mapafu? (Multiple answer)</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="1" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Uvutaji sigara</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="2" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kufanya kazi kwenye migodi</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="3" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kufanya kazi viwandani. (kiwanda cha bidhaa ya kemikali)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="4" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kufanya kazi katika maeneo yenye hewa chafu sana.(highly air pollutes areas)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="5" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Mtu akiwa na saratani nyingine yeyote mwilini</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="6" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 6) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kuwa na mtu kwenye familia mwenye historia ya saratani ya mapafu</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="7" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 7) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kuwa na historia ya kupigwa mionzi ya kifua</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi[]" value="8" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 8) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Kutumia uzazi wa mpango (vidonge vya majira).</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="vitu_hatarishi[]" id="vitu_hatarishi" value="96" <?php foreach (explode(',', $kap['vitu_hatarishi']) as $value) {
                                                                                                                                                                        if ($value == 96) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        }
                                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="vitu_hatarishi_other" id="vitu_hatarishi_other" rows="3" placeholder="Type other here..."><?php if ($kap['vitu_hatarishi_other']) {
                                                                                                                                                                                            print_r($kap['vitu_hatarishi_other']);
                                                                                                                                                                                        }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <label>5. Je, mtu mwenye Saratani ya mapafu anakua na dalili zipi? ( Multiple answer )</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="1" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kikohozi cha Zaidi ya wiki 2 au 3</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="2" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 2) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kikohozi cha muda mrefu kinachozidi kuwa kibaya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="3" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 3) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kukohoa damu au makohozi yenye rangi ya kutu (spit or phlegm)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="4" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 4) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Magonjwa ya mara kwa mara ya kifua kama bronchitis, pneumonia etc</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="5" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 5) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Maumivu ya kifua yanayoongezeka wakati wa kupumua au kukohoa</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="6" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 6) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kupumua kwa shida (Persistent breathlessness)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="7" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 7) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Uchovu wa mara kwa mara au r lack of energy</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="8" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 8) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kutoa kisauti wakati wa kupumua (Wheezing)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="9" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 9) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kukosa pumzi (Shortness of breath)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani[]" value="10" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 10) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kupungua uzito kusiko na sababu</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="dalili_saratani[]" id="dalili_saratani" value="96" <?php foreach (explode(',', $kap['dalili_saratani']) as $value) {
                                                                                                                                                                            if ($value == 96) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="dalili_saratani_other" id="dalili_saratani_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($kap['dalili_saratani_other']) {
                                                                print_r($kap['dalili_saratani_other']);
                                                            }  ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <label>6. Kama mtu akigundulika ana saratani ya mapafu ,ni vipimo gani vinatakiwa kufanyika? (Multiple answer)</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo[]" value="1" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Vipimo vya damu</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo[]" value="2" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 2) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Picha ya kifua (Chest X-ray)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo[]" value="3" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 3) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">CT scan ya kifua</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo[]" value="4" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 4) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kutoa kinyama kwenye mapafu (Lung Biopsy)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo[]" value="99" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 99) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Sijui</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="saratani_vipimo[]" id="saratani_vipimo" value="96" <?php foreach (explode(',', $kap['saratani_vipimo']) as $value) {
                                                                                                                                                                            if ($value == 96) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            }
                                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="saratani_vipimo_other" id="saratani_vipimo_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($kap['saratani_vipimo_other']) {
                                                                print_r($kap['saratani_vipimo_other']);
                                                            }  ?>
                                                        </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>7. Je, ugonjwa wa saratani ya mapafu unatibika ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_inatibika" id="saratani_inatibika1" value="1" <?php if ($kap['saratani_inatibika'] == 1) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_inatibika" id="saratani_inatibika2" value="2" <?php if ($kap['saratani_inatibika'] == 2) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" id="matibabu_saratani">
                                                    <label>8. Kama jibu ni ndio, Je unajua njia yoyote ya matibabu ya saratani ya mapafu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="matibabu_saratani" id="matibabu_saratani1" value="1" <?php if ($kap['matibabu_saratani'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="matibabu_saratani" id="matibabu_saratani2" value="2" <?php if ($kap['matibabu_saratani'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="matibabu1">
                                                    <label>9. Kama jibu ni ndio, je ni njia gani za matibabu ya saratani ya mapafu unazozijua? Zitaje.. (Multiple answer)</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="1" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Upasuaji</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="2" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Tiba kemikali (Chemotherapy)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="3" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 3) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Tiba ya mionzi (Radiotherapy)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="4" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 4) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Tiba ya kinga (Immunotherapy)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="5" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 5) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Kizuizi cha Tyrosine Kinase (Tyrosine kinase inhibitor)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="6" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 6) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Tiba inayolengwa na kinga. (Immune target therapy)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu[]" value="99" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                                if ($value == 99) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                }
                                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Sijui</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="matibabu[]" id="matibabu" value="96" <?php foreach (explode(',', $kap['matibabu']) as $value) {
                                                                                                                                                            if ($value == 96) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            }
                                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="matibabu_other" id="matibabu_other" rows="3" placeholder="Type other here...">
                                                            <?php if ($kap['matibabu_other']) {
                                                                print_r($kap['matibabu_other']);
                                                            }  ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 3; Uchunguzi(Screening) wa saratani ya mapafu. (Usimusmoee machaguo)</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <label for="saratani_uchunguzi" class="form-label">1. Je, umewahi kusikia chochote kuhusu uchunguzi wa saratani ya mapafu, inawezekana kwa kusoma mahali Fulani, kusikia kwenye vyombo vya habari au kusikia kutoka kituo cha kutolea huduma za Afya? </label>
                                                        <select name="saratani_uchunguzi" id="saratani_uchunguzi" class="form-control" required>
                                                            <option value="<?= $kap['saratani_uchunguzi'] ?>"><?php if ($kap['saratani_uchunguzi']) {
                                                                                                                    if ($kap['saratani_uchunguzi'] == 1) {
                                                                                                                        echo 'Ndio';
                                                                                                                    } elseif ($kap['saratani_uchunguzi'] == 2) {
                                                                                                                        echo 'Hapana';
                                                                                                                    } elseif ($kap['saratani_uchunguzi'] == 99) {
                                                                                                                        echo 'Sijui';
                                                                                                                    }
                                                                                                                } else {
                                                                                                                    echo 'Select';
                                                                                                                } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>2. Nini maana ya uchunguzi wa saratani ya mapafu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_maana" id="uchunguzi_maana1" value="1" <?php if ($kap['uchunguzi_maana'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Uchunguzi wa saratani ya mapafu ni mchakato ambao hutumiwa kugundua uwepo wa saratani ya mapafu kwa watu wenye afya nzuri na wenye hatari kubwa ya kupata saratani ya mapafu</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_maana" id="uchunguzi_maana2" value="2" <?php if ($kap['uchunguzi_maana'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Uchunguzi wa saratani ya mapafu ni mkakati wa uchunguzi wa saratani ya mapafu inayotumiwa kutambua saratani ya mapafu mapema kabla ya kuonyesha dalili ambapo ni hatua ya mwanzoni kabisa ambayo kuna uwezekano mkubwa wa kutibika</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_maana" id="uchunguzi_maana3" value="3" <?php if ($kap['uchunguzi_maana'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Uchunguzi wa saratani ya mapafu ni kipimo cha kugundua saratani ya mapafu mapema kabla ya dalili kutokea</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_maana" id="uchunguzi_maana99" value="99" <?php if ($kap['uchunguzi_maana'] == 99) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sijui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_maana" id="uchunguzi_maana96" value="96" <?php if ($kap['uchunguzi_maana'] == 96) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nyinginezo</label>
                                                            </div>
                                                            <textarea class="form-control" name="uchunguzi_maana_other" id="uchunguzi_maana_other" rows="2" placeholder="Type other here..."><?php if ($kap['uchunguzi_maana_other']) {
                                                                                                                                                                                                    print_r($kap['uchunguzi_maana_other']);
                                                                                                                                                                                                }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>3. Je, kuna faida gani ya kufanya uchunguzi wa saratani ya mapafu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_faida" id="uchunguzi_faida1" value="1" <?php if ($kap['uchunguzi_faida'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Utambuzi wa mapema ambao unaokoa maisha</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_faida" id="uchunguzi_faida2" value="2" <?php if ($kap['uchunguzi_faida'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Kugundua saratani ya mapafu katika hatua ya awali wakati kuna uwezekano mkubwa wa kupona</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_faida" id="uchunguzi_faida3" value="3" <?php if ($kap['uchunguzi_faida'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Hupunguza hatari ya kufa kwa saratani ya mapafu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_faida" id="uchunguzi_faida99" value="99" <?php if ($kap['uchunguzi_faida'] == 99) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sijui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_faida" id="uchunguzi_faida96" value="96" <?php if ($kap['uchunguzi_faida'] == 96) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nyinginezo</label>
                                                            </div>
                                                            <textarea class="form-control" name="uchunguzi_faida_other" id="uchunguzi_faida_other" rows="2" placeholder="Type other here..."><?php if ($kap['uchunguzi_faida_other']) {
                                                                                                                                                                                                    print_r($kap['uchunguzi_faida_other']);
                                                                                                                                                                                                }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <label>4. Je, kuna hatari zozote za kufanya uchunguzi wa saratani ya mapafu?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_hatari" id="uchunguzi_hatari1" value="1" <?php if ($kap['uchunguzi_hatari'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Ndio</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_hatari" id="uchunguzi_hatari2" value="2" <?php if ($kap['uchunguzi_hatari'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Hapana</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_hatari" id="uchunguzi_hatari99" value="99" <?php if ($kap['uchunguzi_hatari'] == 99) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sijui</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-6" id="saratani_hatari">
                                                    <label>5. Kama jibu hapo juu ni ndio, je ni hatari gani zinazoweza kutokana na kufanya uchunguzi wa saratani ya mapafu? (Multiple answer)</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari1" value="1" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 1) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Hatari ya kupata mionzi mwilini, kwa kuwa inatumia skana ya LDCT</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari2" value="2" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 2) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Uwoga Madaktari wanaweza wakagundua magonjwa mengine yanayofanana na saratani ya mapafu ambayo siyo saratani ya mapafu (False positives)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari3" value="3" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 3) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Unaweza kupata uvimbe vidogo vidogo ambavyo ni saratani zinazokua polepole ambazo hazitakuletea madhara</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari4" value="4" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 4) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Msongo wa mawaso(Pychological distress)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari5" value="5" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 5) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Uchunguzi wa kupita kiasi (Overdiagnosis)</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari99" value="99" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 99) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Sijui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="saratani_hatari[]" id="saratani_hatari96" value="96" <?php foreach (explode(',', $kap['saratani_hatari']) as $value) {
                                                                                                                                                                                if ($value == 96) {
                                                                                                                                                                                    echo 'checked';
                                                                                                                                                                                }
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Nyinginezo</label>
                                                            </div>
                                                            <textarea class="form-control" name="saratani_hatari_other" id="saratani_hatari_other" rows="2" placeholder="Type other here..."><?php if ($kap['saratani_hatari_other']) {
                                                                                                                                                                                                    print_r($kap['saratani_hatari_other']);
                                                                                                                                                                                                }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="col-6">
                                                    <label>6. Je, ni kundi gani la watu linalofaa kufanyiwa uchunguzi wa saratani ya mapafu? (Multiple answer)</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="1" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 1) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Wazee(Zaidi ya miaka 45) ambao wanavuta sigara kwa sasa, au walivuta sigara zamani</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="2" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 2) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Vijana (chini ya miaka 45) ambao wamevuta sigara kwa miaka mingi</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="3" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 3) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">TVijana (chini ya miaka 45) waliowahi kuvuta sana sigara lakini wakaacha</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="4" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 4) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Watu ambao wana historia ya kuugua saratani kwenye familia zao</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="5" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 5) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Watu wenye viashiria vya saratani ya mapafu</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="6" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 6) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Watu wenye afya njema</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" value="99" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                            if ($value == 99) {
                                                                                                                                                echo 'checked';
                                                                                                                                            }
                                                                                                                                        } ?>>
                                                            <label class="form-check-label">Sijui</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="kundi[]" id="kundi" value="96" <?php foreach (explode(',', $kap['kundi']) as $value) {
                                                                                                                                                        if ($value == 96) {
                                                                                                                                                            echo 'checked';
                                                                                                                                                        }
                                                                                                                                                    } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="kundi_other" id="kundi_other" rows="3" placeholder="Type other here..."><?php if ($kap['kundi_other']) {
                                                                                                                                                                            print_r($kap['kundi_other']);
                                                                                                                                                                        }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-6">
                                                    <label>7. Je! Unazani nani ana ushawishi mkubwa katika kutoa elimu ya ugonjwa wa Saratani ya Mapafu? (Multiple answer)</label>
                                                    <!-- checkbox -->
                                                    <div class="form-group">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="1" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 1) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Watoa huduma ya Afya ngazi ya jamii (CHWs)</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="2" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 2) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Wataalamu wa Afya</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="3" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 3) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Watu waliopona ugonjwa wa saratani ya mapafu</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="4" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 4) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Viongozi wa Dini</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="5" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 5) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Waganga wa jadi/jamii/Ukoo</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="6" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 6) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Viongozi wa jamii/mtaa/kijiji</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" value="7" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                if ($value == 7) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                }
                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Serikali</label>
                                                        </div>

                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="ushawishi[]" id="ushawishi" value="96" <?php foreach (explode(',', $kap['ushawishi']) as $value) {
                                                                                                                                                                if ($value == 96) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                }
                                                                                                                                                            } ?>>
                                                            <label class="form-check-label">Other</label>
                                                        </div>
                                                        <textarea class="form-control" name="ushawishi_other" id="ushawishi_other" rows="2" placeholder="Type other here..."><?php if ($kap['ushawishi_other']) {
                                                                                                                                                                                    print_r($kap['ushawishi_other']);
                                                                                                                                                                                }  ?>
                                                                </textarea>
                                                    </div>
                                                </div>

                                                <div class="col-6" id="hitaji_elimu1">
                                                    <div class="mb-3">
                                                        <label for="hitaji_elimu" class="form-label">8. Je unahisi unahitaji taarifa/elimu Zaidi juu ya uchunguzi wa awali wa ugonjwa wa Saratani ya Mapafu na ugonjwa wenyewe kwa jumla?</label>
                                                        <select name="hitaji_elimu" id="hitaji_elimu" class="form-control">
                                                            <option value="<?= $kap['hitaji_elimu'] ?>"><?php if ($kap['hitaji_elimu']) {
                                                                                                            if ($kap['hitaji_elimu'] == 1) {
                                                                                                                echo 'Ndio';
                                                                                                            } elseif ($kap['hitaji_elimu'] == 2) {
                                                                                                                echo 'Hapana';
                                                                                                            } elseif ($kap['hitaji_elimu'] == 99) {
                                                                                                                echo 'Sijui';
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo 'Select';
                                                                                                        } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 4; Mtazamo juu ya uchunguzi wa saratani ya mapafu</h3>
                                                </div>
                                            </div>

                                            <div class="card-header">
                                                <h3 class="card-title">Fikiria kuhusu uchunguzi wa saratani ya mapafu, unaweza kuniambia ni kwa kiasi gani unakubaliana na kila kauli zifuatazo?</h3>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-3">
                                                    <label>1. Fikiria kuhusu vifo vinavyotokea kwasababu ya Saratani; “Nisingependa kujua kama nina saratani ya mapafu</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="vifo" id="vifo1" value="1" <?php if ($kap['vifo'] == 1) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="vifo" id="vifo2" value="2" <?php if ($kap['vifo'] == 2) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="vifo" id="vifo3" value="3" <?php if ($kap['vifo'] == 3) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="vifo" id="vifo4" value="4" <?php if ($kap['vifo'] == 4) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="vifo" id="vifo5" value="5" <?php if ($kap['vifo'] == 5) {
                                                                                                                                                    echo 'checked';
                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>2. Fikiria jinsi dalili zinavyoonekana, “ Kwenda kwa daktari wangu mapema nikiwa tayari na dalili za ugonjwa wa saratani ya mapafu,akulete utofauti wowote wa mimi kupona saratani ya mapafu</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tayari_dalili" id="tayari_dalili1" value="1" <?php if ($kap['tayari_dalili'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tayari_dalili" id="tayari_dalili2" value="2" <?php if ($kap['tayari_dalili'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tayari_dalili" id="tayari_dalili3" value="3" <?php if ($kap['tayari_dalili'] == 3) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tayari_dalili" id="tayari_dalili4" value="4" <?php if ($kap['tayari_dalili'] == 4) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="tayari_dalili" id="tayari_dalili5" value="5" <?php if ($kap['tayari_dalili'] == 5) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>3. Fikiria jinsi dalili zinavyoonekana ; “Endapo saratani ya mapafu ikigundulika mapema, kuna uwezekano mkubwa wa kutibika”</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kutibika" id="saratani_kutibika1" value="1" <?php if ($kap['saratani_kutibika'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kutibika" id="saratani_kutibika2" value="2" <?php if ($kap['saratani_kutibika'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kutibika" id="tsaratani_kutibika3" value="3" <?php if ($kap['saratani_kutibika'] == 3) {
                                                                                                                                                                                echo 'checked';
                                                                                                                                                                            } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kutibika" id="saratani_kutibika4" value="4" <?php if ($kap['saratani_kutibika'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kutibika" id="saratani_kutibika5" value="5" <?php if ($kap['saratani_kutibika'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>4. “Ningependelea kutokwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu nina wasiwasi juu ya kile kinachoweza kugundulika wakati wa uchunguzi wa saratani ya mapafu”</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_wasiwasi" id="saratani_wasiwasi1" value="1" <?php if ($kap['saratani_wasiwasi'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_wasiwasi" id="saratani_wasiwasi2" value="2" <?php if ($kap['saratani_wasiwasi'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_wasiwasi" id="saratani_wasiwasi3" value="3" <?php if ($kap['saratani_wasiwasi'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_wasiwasi" id="saratani_wasiwasi4" value="4" <?php if ($kap['saratani_wasiwasi'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_wasiwasi" id="saratani_wasiwasi5" value="5" <?php if ($kap['saratani_wasiwasi'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label>5. “Sidhani kama kuna umuhimu wowote wa kwenda kufanya uchunguzi wa saratani ya mapafu kwa sababu haita athiri matokeo”</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_umuhimu" id="saratani_umuhimu1" value="1" <?php if ($kap['saratani_umuhimu'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_umuhimu" id="saratani_umuhimu2" value="2" <?php if ($kap['saratani_umuhimu'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_umuhimu" id="saratani_umuhimu3" value="3" <?php if ($kap['saratani_umuhimu'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_umuhimu" id="saratani_umuhimu4" value="4" <?php if ($kap['saratani_umuhimu'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_umuhimu" id="saratani_umuhimu5" value="5" <?php if ($kap['saratani_umuhimu'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>6.“Kufanya uchunguzi wa saratani ya mapafu kunaweza kupunguza uwezekano wangu wa kufa kutokana na saratani ya mapafu.”</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kufa" id="saratani_kufa1" value="1" <?php if ($kap['saratani_kufa'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kufa" id="saratani_kufa2" value="2" <?php if ($kap['saratani_kufa'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kufa" id="saratani_kufa3" value="3" <?php if ($kap['saratani_kufa'] == 3) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kufa" id="saratani_kufa4" value="4" <?php if ($kap['saratani_kufa'] == 4) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="saratani_kufa" id="saratani_kufa5" value="5" <?php if ($kap['saratani_kufa'] == 5) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>7. “Endapo nitapata dalili zozote za awali za ugonjwa wa Saratani ya mapafu nitakwenda kwa ajili ya uchunguzi wa saratani ya mapafu haraka iwezekanavyo”</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_haraka" id="uchunguzi_haraka1" value="1" <?php if ($kap['uchunguzi_haraka'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali sana</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_haraka" id="uchunguzi_haraka2" value="2" <?php if ($kap['uchunguzi_haraka'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nakubali</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_haraka" id="uchunguzi_haraka3" value="3" <?php if ($kap['uchunguzi_haraka'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Kawaida</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_haraka" id="uchunguzi_haraka4" value="4" <?php if ($kap['uchunguzi_haraka'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali kabisa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="uchunguzi_haraka" id="uchunguzi_haraka5" value="5" <?php if ($kap['uchunguzi_haraka'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Sikubali</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Sehemu ya 5; Utaratibu(Practice) juu ya uchunguzi wa saratani ya mapafu</h3>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="row">

                                                <div class="col-sm-4" id="matibabu_saratani">
                                                    <label>8. Je katika jamii yako, watu wakiumwa, huwa wanapendelea kwenda wapi kupata matibabu ?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu1" value="1" <?php if ($kap['wapi_matibabu'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kituo cha afya kilichopo karibu</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu2" value="2" <?php if ($kap['wapi_matibabu'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Mganga wa jadi</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu3" value="3" <?php if ($kap['wapi_matibabu'] == 3) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kanisani/msikitini</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu4" value="4" <?php if ($kap['wapi_matibabu'] == 4) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Duka la Dawa</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu5" value="5" <?php if ($kap['wapi_matibabu'] == 5) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Kituo cha tiba asili</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu6" value="6" <?php if ($kap['wapi_matibabu'] == 6) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                <label class="form-check-label">Wanajitibu wenyewe</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu99" value="99" <?php if ($kap['wapi_matibabu'] == 99) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Sijui</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="wapi_matibabu" id="wapi_matibabu96" value="96" <?php if ($kap['wapi_matibabu'] == 96) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Nyinginezo</label>
                                                            </div>
                                                            <textarea class="form-control" name="wapi_matibabu_other" id="wapi_matibabu_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($kap['wapi_matibabu_other']) {
                                                                print_r($kap['wapi_matibabu_other']);
                                                            }  ?>
                                                        </textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="saratani_ushauri" class="form-label">9. Je! Wewe/watu katika jamii huwa wanakwenda kwenye vituo vya kutolea huduma za Afya kwa ajili ya ushauri kuhusu uchunguzi wa ugonjwa wa Saratani ya Mapafu?</label>
                                                        <select name="saratani_ushauri" id="saratani_ushauri" class="form-control" required>
                                                            <option value="<?= $kap['saratani_ushauri'] ?>"><?php if ($kap['saratani_ushauri']) {
                                                                                                                if ($kap['saratani_ushauri'] == 1) {
                                                                                                                    echo 'Ndio';
                                                                                                                } elseif ($kap['saratani_ushauri'] == 2) {
                                                                                                                    echo 'Hapana';
                                                                                                                } elseif ($kap['saratani_ushauri'] == 99) {
                                                                                                                    echo 'Sijui';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="saratani_ujumbe" class="form-label">10. Katika mwezi uliopita umesikia ujumbe wa afya kuhusu maswala ya uchunguzi wa awali wa Saratani ya mapafu?</label>
                                                        <select name="saratani_ujumbe" id="saratani_ujumbe" class="form-control" required>
                                                            <option value="<?= $kap['saratani_ujumbe'] ?>"><?php if ($kap['saratani_ujumbe']) {
                                                                                                                if ($kap['saratani_ujumbe'] == 1) {
                                                                                                                    echo 'Ndio';
                                                                                                                } elseif ($kap['saratani_ujumbe'] == 2) {
                                                                                                                    echo 'Hapana';
                                                                                                                } elseif ($kap['saratani_ujumbe'] == 99) {
                                                                                                                    echo 'Sijui';
                                                                                                                }
                                                                                                            } else {
                                                                                                                echo 'Select';
                                                                                                            } ?>
                                                            </option>
                                                            <option value="1">Ndio</option>
                                                            <option value="2">Hapana</option>
                                                            <option value="99">Sijui</option>
                                                        </select>
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
                                                            <textarea class="form-control" name="comments" rows="3" placeholder="Type comments here..."><?php if ($kap['comments']) {
                                                                                                                                                            print_r($kap['comments']);
                                                                                                                                                        }  ?>
                                                                </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="submit" name="add_kap" value="Submit" class="btn btn-primary">
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
            $history = $override->getNews('history', 'status', 1, 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if (!$history) { ?>
                                    <h1>Add New HISTORY</h1>
                                <?php } else { ?>
                                    <h1>Update HISTORY</h1>
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
                                    <?php if (!$history) { ?>
                                        <li class="breadcrumb-item active">Add New HISTORY</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update HISTORY</li>
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
                                        <h3 class="card-title">Part B: Smoking history</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="screening_date" class="form-label">Screening date</label>
                                                        <input type="date" value="<?php if ($history['screening_date']) {
                                                                                        print_r($history['screening_date']);
                                                                                    } ?>" id="screening_date" name="screening_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter screening date" required />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3">
                                                    <label>Have you ever smoked cigarette?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="ever_smoked" id="ever_smoked1" value="1" <?php if ($history['ever_smoked'] == 1) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?> onchange="toggleRequired(this)" required>
                                                                <label class=" form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="ever_smoked" id="ever_smoked2" value="2" <?php if ($history['ever_smoked'] == 2) {
                                                                                                                                                                echo 'checked';
                                                                                                                                                            } ?> onchange="toggleRequired(this)" required>
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-3" id="start_smoking">
                                                    <div class="mb-2">
                                                        <label for="start_smoking" class="form-label">When did you start smoking?</label>
                                                        <input type="number" value="<?php if ($history['start_smoking']) {
                                                                                        print_r($history['start_smoking']);
                                                                                    } ?>" min="1970" max="<?= date('Y') ?>" name="start_smoking" id="start_smoking1" class="form-control" placeholder="Enter Year" />
                                                    </div>
                                                </div>

                                                <div class="col-sm-3" id="currently_smoking">
                                                    <label>Are you Currently Smoking?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="currently_smoking" id="currently_smoking1" value="1" <?php if ($history['currently_smoking'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> onchange="toggleRequiredCurrentlySmoking(this)">
                                                                <label class="form-check-label">Yes</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="currently_smoking" id="currently_smoking2" value="2" <?php if ($history['currently_smoking'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?> onchange="toggleRequiredCurrentlySmoking(this)">
                                                                <label class="form-check-label">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div id="ever_smoked">
                                                <div class="row">
                                                    <div class="col-3" id="quit_smoking">
                                                        <div class="mb-3">
                                                            <label for="quit_smoking" class="form-label">When did you quit smoking in years?</label>
                                                            <input type="number" value="<?php if ($history['quit_smoking']) {
                                                                                            print_r($history['quit_smoking']);
                                                                                        } ?>" min="1970" max="<?= date('Y') ?>" name="quit_smoking" id="quit_smoking1" class="form-control" placeholder="Enter Year" />
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-3">
                                                        <label>Amount smoked per day in cigarette sticks/packs?</label>
                                                        <!-- radio -->
                                                        <div class="row-form clearfix">
                                                            <div class="form-group">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="type_smoked" id="type_smoked1" value="1" <?php if ($history['type_smoked'] == 1) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label">Packs</label>
                                                                </div>

                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="type_smoked" id="type_smoked2" value="2" <?php if ($history['type_smoked'] == 2) {
                                                                                                                                                                    echo 'checked';
                                                                                                                                                                } ?>>
                                                                    <label class="form-check-label">Cigarette</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="packs_per_day" id="packs_per_day" class="form-label">Number of packs per day</label>
                                                            <label for="cigarette_per_day" id="cigarette_per_day" class="form-label">Number of Cigarette per day</label>
                                                            <input type="number" value="<?php if ($history['packs_cigarette_day']) {
                                                                                            print_r($history['packs_cigarette_day']);
                                                                                        } ?>" min="0" max="1000" name="packs_cigarette_day" id="packs_cigarette_day" class="form-control" placeholder="Enter amount" />
                                                        </div>
                                                    </div>

                                                    <div class="col-3">
                                                        <div class="mb-3">
                                                            <label for="pack_year" class="form-label">Number of Pack year</label>
                                                            <input type="number" value="<?php if ($history['pack_year']) {
                                                                                            print_r($history['pack_year']);
                                                                                        } ?>" min="0" name="pack_year" class="form-control" readonly />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>

                                            <?php if ($history['eligible']) { ?>
                                                <div class="text-center"> Eligible ?
                                                    <a class="btn btn-success">Yes</a>
                                                </div>
                                            <?php } else { ?>
                                                <div class="text-center"> Eligible ?
                                                    <a class="btn btn-warning text-center">No</a>
                                                </div>
                                            <?php } ?>

                                            <hr>
                                            <!-- /.card-body -->
                                            <div class="card-footer">
                                                <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&study_id=<?= $_GET['study_id']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                                <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                                <input type="submit" name="add_history" value="Submit" class="btn btn-primary">
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
            $results = $override->get3('results', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($results) { ?>
                                    <h1>Add New test results</h1>
                                <?php } else { ?>
                                    <h1>Update test results</h1>
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
                                        <li class="breadcrumb-item active">Add New test results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update test results</li>
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
                                        <h3 class="card-title">CRF2: Screeing test results using LDCT</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="test_date" class="form-label">Date of Test</label>
                                                        <input type="date" value="<?php if ($results) {
                                                                                        print_r($results['test_date']);
                                                                                    } ?>" id="test_date" name="test_date" class="form-control" placeholder="Enter test date" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="results_date" class="form-label">Date of Results</label>
                                                        <input type="date" value="<?php if ($results) {
                                                                                        print_r($results['results_date']);
                                                                                    } ?>" id="results_date" name="results_date" class="form-control" placeholder="Enter results date" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="ldct_results" class="form-label">LDCT RESULTS</label>
                                                        <textarea class="form-control" name="ldct_results" id="ldct_results" rows="4" placeholder="Enter LDCT results" required>
                                                            <?php if ($results) {
                                                                print_r($results['ldct_results']);
                                                            } ?>
                                                        </textarea>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="rad_score" class="form-label">RAD SCORE</label>
                                                        <input type="number" value="<?php if ($results) {
                                                                                        print_r($results['rad_score']);
                                                                                    } ?>" id="rad_score" name="rad_score" min="0" class="form-control" placeholder="Enter RAD score" required />
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="findings" class="form-label">FINDINGS:</label>
                                                        <textarea class="form-control" name="findings" id="findings" rows="4" placeholder="Enter findings" required>
                                                                                            <?php if ($results) {
                                                                                                print_r($results['findings']);
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
                                            <input type="submit" name="add_results" value="Submit" class="btn btn-primary">
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
            <?php
            $classification = $override->get3('classification', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($classification) { ?>
                                    <h1>Add New LUNG- RADS CLASSIFICATION</h1>
                                <?php } else { ?>
                                    <h1>Update LUNG- RADS CLASSIFICATION</h1>
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
                                    <?php if ($classification) { ?>
                                        <li class="breadcrumb-item active">Add New LUNG- RADS CLASSIFICATION</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update LUNG- RADS CLASSIFICATION</li>
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
                                        <h3 class="card-title">LUNG- RADS CLASSIFICATION</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <label for="classification_date" class="form-label">Clasification Date</label>
                                                        <input type="date" value="<?php if ($classification) {
                                                                                        print_r($classification['classification_date']);
                                                                                    } ?>" id="classification_date" name="classification_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter classification date" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="1" <?php if ($classification['category'] == 1) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 1</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 1) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="2" <?php if ($classification['category'] == 2) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 2</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 2) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="3" <?php if ($classification['category'] == 3) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 3</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 3) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="4" <?php if ($classification['category'] == 4) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4A</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 4) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="mb-2">
                                                        <input type="checkbox" name="category[]" value="5" <?php if ($classification['category'] == 5) {
                                                                                                                echo 'checked';
                                                                                                            } ?>>
                                                        <label for="ldct_results" class="form-label">Category 4B</label><br>
                                                        <?php foreach ($override->getNews('lung_rads', 'status', 1, 'category', 5) as $cat) { ?>
                                                            - <label><?= $cat['name'] ?></label> <br>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_classification" value="Submit" class="btn btn-primary">
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

        <?php } elseif ($_GET['id'] == 9) { ?>
            <?php
            $economic = $override->get3('economic', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($history) { ?>
                                    <h1>Add New CRF3</h1>
                                <?php } else { ?>
                                    <h1>Update CRF3</h1>
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
                                    <?php if ($history) { ?>
                                        <li class="breadcrumb-item active">Add New CRF3</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update CRF3</li>
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
                                        <h3 class="card-title">CRF3: Taarifa za kiuchumi (Wakati wa screening)</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="economic" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3">
                                                    <div class="mb-2">
                                                        <label for="economic_date" class="form-label">Tarehe</label>
                                                        <input type="date" value="<?php if ($economic['economic_date']) {
                                                                                        print_r($economic['economic_date']);
                                                                                    } ?>" max="<?= date('Y-m-d'); ?>" id="economic_date" name="economic_date" class="form-control" placeholder="Enter economic date" required />
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <label>Chanzo kikuu cha kipato cha mkuu wa kaya?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household1" value="1" <?php if ($economic['income_household'] == 1) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Msharaha kwa mwezi</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household2" value="2" <?php if ($economic['income_household'] == 2) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Posho kwa siku</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household3" value="3" <?php if ($economic['income_household'] == 3) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya biashara</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household4" value="4" <?php if ($economic['income_household'] == 4) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya mazao au mifugo</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household5" value="5" <?php if ($economic['income_household'] == 5) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Hana kipato</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household6" value="6" <?php if ($economic['income_household'] == 6) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Mstaafu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_household" id="income_household96" value="96" <?php if ($economic['income_household'] == 96) {
                                                                                                                                                                            echo 'checked';
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label">Nyingine, Taja</label>
                                                            </div>
                                                            <textarea class="form-control" name="income_household_other" id="income_household_other" rows="2" placeholder="Type other here...">
                                                                <?php if ($economic['income_household_other']) {
                                                                    print_r($economic['income_household_other']);
                                                                }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-4">
                                                    <label>Chanzo kikuu cha mapato cha mgonjwa?</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient1" value="1" <?php if ($economic['income_patient'] == 1) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Msharaha kwa mwezi</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient2" value="2" <?php if ($economic['income_patient'] == 2) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Posho kwa siku</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient3" value="3" <?php if ($economic['income_patient'] == 3) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya biashara</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient4" value="4" <?php if ($economic['income_patient'] == 4) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Pato kutokana na mauzo ya mazao au mifugo</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient5" value="5" <?php if ($economic['income_patient'] == 5) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Hana kipato</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient6" value="6" <?php if ($economic['income_patient'] == 6) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Mstaafu</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="income_patient" id="income_patient96" value="96" <?php if ($economic['income_patient'] == 96) {
                                                                                                                                                                        echo 'checked';
                                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Nyingine, Taja</label>
                                                            </div>
                                                            <textarea class="form-control" name="income_patient_other" id="income_patient_other" rows="2" placeholder="Type other here...">
                                                            <?php if ($economic['income_patient_other']) {
                                                                print_r($economic['income_patient_other']);
                                                            }  ?>
                                                            </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="monthly_earn" class="form-label">Je, unaingiza shilingi ngapi kwa mwezi kutoka kwenye vyanzo vyako vyote vya fedha? <br> ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['monthly_earn']) {
                                                                                        print_r($economic['monthly_earn']);
                                                                                    } ?>" min="0" max="100000000" id="monthly_earn" name="monthly_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="member_earn" class="form-label">Kwa mwezi, ni kiasi gani wanakaya wenzako wanaingiza kutoka kwenye vyanzo vyote vya fedha? (kwa ujumla)?<br> ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['member_earn']) {
                                                                                        print_r($economic['member_earn']);
                                                                                    } ?>" min="0" max="100000000" id="member_earn" name="member_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="transport" class="form-label">Ulilipa kiasi gani kwa ajili ya usafiri ulipoenda hospitali kwa ajili ya kufanyiwa uchunguzi wa saratani ya mapafu? <br> ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['transport']) {
                                                                                        print_r($economic['transport']);
                                                                                    } ?>" min="0" max="100000000" id="transport" name="transport" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="support_earn" class="form-label">Kama ulisindikizwa, alilipa fedha kiasi gani kwa ajili ya usafiri? <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['support_earn']) {
                                                                                        print_r($economic['support_earn']);
                                                                                    } ?>" min="0" max="100000000" id="support_earn" name="support_earn" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="food_drinks" class="form-label">Ulilipa fedha kiasi gani kwa ajili ya chakula na vinywaji? <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['food_drinks']) {
                                                                                        print_r($economic['food_drinks']);
                                                                                    } ?>" min="0" max="100000000" id="food_drinks" name="food_drinks" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>


                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="other_cost" class="form-label">Je, kuna gharama yoyote ambayo ulilipa tofauti na hizo ulizotaja hapo, kama ndio, ni shilingi ngapi? ( TSHS ) </label>
                                                        <input type="text" value="<?php if ($economic['other_cost']) {
                                                                                        print_r($economic['other_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_cost" name="other_cost" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>

                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title">Je, kwa mwezi, unapoteza muda kiasi gani unapotembelea kliniki?</h3>
                                                </div>
                                            </div>


                                            <hr>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="days" class="form-label">Siku</label>
                                                        <input type="text" value="<?php if ($economic['days']) {
                                                                                        print_r($economic['days']);
                                                                                    } ?>" min="0" max="100" id="days" name="days" class="form-control" placeholder="Enter days" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="hours" class="form-label">Masaa</label>
                                                        <input type="text" value="<?php if ($economic['hours']) {
                                                                                        print_r($economic['hours']);
                                                                                    } ?>" min="0" max="100" id="hours" name="hours" class="form-control" placeholder="Enter hours" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="card card-warning">
                                                <div class="card-header">
                                                    <h3 class="card-title"> Je, ulilipa gharama kiasi gani kwa huduma zifuatazo?
                                                    </h3>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="registration" class="form-label">Usajili <br> ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['registration']) {
                                                                                        print_r($economic['registration']);
                                                                                    } ?>" min="0" max="100000000" id="registration" name="registration" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="consultation" class="form-label">Kumuona daktari (Consultation) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['consultation']) {
                                                                                        print_r($economic['consultation']);
                                                                                    } ?>" min="0" max="100000000" id="consultation" name="consultation" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="diagnostic" class="form-label">Vipimo (Diagnostic tests) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['diagnostic']) {
                                                                                        print_r($economic['diagnostic']);
                                                                                    } ?>" min="0" max="100000000" id="diagnostic" name="diagnostic" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="mb-3">
                                                        <label for="medications" class="form-label">Dawa (Medications) <br>( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['medications']) {
                                                                                        print_r($economic['medications']);
                                                                                    } ?>" min="0" max="100000000" id="medications" name="medications" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>

                                                <div class="col-4">
                                                    <div class="mb-3">
                                                        <label for="other_medical_cost" class="form-label">Gharama zingine za ziada kwa ajili ya matibabu (Any other direct medical costs) ( TSHS )</label>
                                                        <input type="text" value="<?php if ($economic['other_medical_cost']) {
                                                                                        print_r($economic['other_medical_cost']);
                                                                                    } ?>" min="0" max="100000000" id="other_medical_cost" name="other_medical_cost" class="form-control" placeholder="Enter TSHS" pattern="^\d{1,3}(,\d{3})*(\.\d+)?$" title="Please enter numbers only" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_economic" value="Submit" class="btn btn-primary">
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
        <?php } elseif ($_GET['id'] == 10) { ?>
            <?php
            $outcome = $override->get3('outcome', 'status', 1, 'sequence', $_GET['sequence'], 'patient_id', $_GET['cid'])[0];
            ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <?php if ($outcome) { ?>
                                    <h1>Add New outcome results</h1>
                                <?php } else { ?>
                                    <h1>Update outcome results</h1>
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
                                    <?php if ($results) { ?>
                                        <li class="breadcrumb-item active">Add New outcome results</li>
                                    <?php } else { ?>
                                        <li class="breadcrumb-item active">Update outcome results</li>
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
                                        <h3 class="card-title">CRF 3: FOLLOW UP ( PATIENT OUTCOME AFTER SCREENING )</h3>
                                    </div>
                                    <!-- /.card-header -->
                                    <form id="validation" enctype="multipart/form-data" method="post" autocomplete="off">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-2">
                                                    <div class="mb-2">
                                                        <label for="visit_date" class="form-label">Entry Date</label>
                                                        <input type="date" value="<?php if ($outcome) {
                                                                                        print_r($outcome['visit_date']);
                                                                                    } ?>" id="visit_date" name="visit_date" max="<?= date('Y-m-d') ?>" class="form-control" placeholder="Enter visit date" required />
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <div class="row-form clearfix">
                                                            <!-- select -->
                                                            <div class="form-group">
                                                                <label>Patient Diagnosis if was scored Lung- RAD 4B</label>
                                                                <textarea class="form-control" name="diagnosis" rows="3" placeholder="Type diagnosis here...">
                                                                        <?php if ($outcome['diagnosis']) {
                                                                            print_r($outcome['diagnosis']);
                                                                        }  ?>
                                                                </textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Outcome</label>
                                                    <!-- radio -->
                                                    <div class="row-form clearfix">
                                                        <div class="form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome1" value="1" <?php if ($outcome['outcome'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Await another screening</label>
                                                            </div>

                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome2" value="2" <?php if ($outcome['outcome'] == 2) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">On treatment</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome3" value="3" <?php if ($outcome['outcome'] == 3) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Recovered</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome4" value="4" <?php if ($outcome['outcome'] == 4) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Died</label>
                                                            </div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="outcome" id="outcome5" value="5" <?php if ($outcome['outcome'] == 5) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    } ?>>
                                                                <label class="form-check-label">Unknown/Loss to follow up</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-2" id="outcome_date">
                                                    <div class="mb-2">
                                                        <label for="died" id="died" class="form-label">Date of Death</label>
                                                        <label for="ltf" id="ltf" class="form-label">Date Last known to be alive</label>
                                                        <input type="date" value="<?php if ($outcome) {
                                                                                        print_r($outcome['outcome_date']);
                                                                                    } ?>" name="outcome_date" class="form-control" max="<?= date('Y-m-d') ?>" placeholder="Enter outcome date" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer">
                                            <a href="info.php?id=4&cid=<?= $_GET['cid']; ?>&status=<?= $_GET['status']; ?>" class="btn btn-default">Back</a>
                                            <input type="hidden" name="cid" value="<?= $_GET['cid'] ?>">
                                            <input type="submit" name="add_outcome" value="Submit" class="btn btn-primary">
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

        <?php } elseif ($_GET['id'] == 11) { ?>

        <?php } elseif ($_GET['id'] == 12) { ?>

        <?php } elseif ($_GET['id'] == 13) { ?>

        <?php } elseif ($_GET['id'] == 14) { ?>


        <?php } elseif ($_GET['id'] == 15) { ?>

        <?php } elseif ($_GET['id'] == 16) { ?>


        <?php } elseif ($_GET['id'] == 17) { ?>

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
    <script src="myjs/add/clients/validate_hidden_with_values.js"></script>
    <script src="myjs/add/clients/validate_required_attribute.js"></script>
    <script src="myjs/add/clients/validate_required_radio_checkboxes.js"></script>



    <!-- KAP Js -->
    <script src="myjs/add/kap/dalili_saratani.js"></script>
    <script src="myjs/add/kap/kundi.js"></script>
    <script src="myjs/add/kap/matibabu.js"></script>
    <script src="myjs/add/kap/matibabu_saratani.js"></script>
    <script src="myjs/add/kap/saratani_hatari.js"></script>
    <script src="myjs/add/kap/saratani_inatibika.js"></script>
    <script src="myjs/add/kap/saratani_vipimo.js"></script>
    <script src="myjs/add/kap/uchunguzi_faida.js"></script>
    <script src="myjs/add/kap/uchunguzi_hatari.js"></script>
    <script src="myjs/add/kap/uchunguzi_maana.js"></script>
    <script src="myjs/add/kap/ushawishi.js"></script>
    <script src="myjs/add/kap/vitu_hatarishi.js"></script>
    <script src="myjs/add/kap/wapi_matibabu.js"></script>






    <!-- HISTORY Js -->
    <script src="myjs/add/history/currently_smoking.js"></script>
    <script src="myjs/add/history/ever_smoked.js"></script>
    <script src="myjs/add/history/type_smoked.js"></script>

    <!-- economics Js -->
    <script src="myjs/add/economics/household.js"></script>
    <script src="myjs/add/economics/patient.js"></script>

    <!-- economics Js -->
    <script src="myjs/add/outcome/outcome.js"></script>

    <!-- economics radio requireds Js -->
    <script src="myjs/add/economics/format_required.js/format_radio.js"></script>



    <!-- economics format numbers Js -->
    <script src="myjs/add/economics/format_thousands/consultation.js"></script>
    <script src="myjs/add/economics/format_thousands/days.js"></script>
    <script src="myjs/add/economics/format_thousands/diagnostic.js"></script>
    <script src="myjs/add/economics/format_thousands/food_drinks.js"></script>
    <script src="myjs/add/economics/format_thousands/hours.js"></script>
    <script src="myjs/add/economics/format_thousands/medications.js"></script>
    <script src="myjs/add/economics/format_thousands/member_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/monthly_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/other_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/other_medical_cost.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/registration.js"></script>
    <script src="myjs/add/economics/format_thousands/support_earn.js"></script>
    <script src="myjs/add/economics/format_thousands/transport.js"></script>





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