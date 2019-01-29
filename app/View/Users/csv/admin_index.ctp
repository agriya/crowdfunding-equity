<?php
$UserCount = $user->User->find('count', array(
    'conditions' => $conditions,
    'recursive' => -1,
));
$page = ceil($UserCount / 20);
for($i=1;$i<=$page;$i++) {
    $user->request->params['named']['page'] = $i;
    $user->paginate = array(
        'conditions' => $conditions,
        'order' => array(
            'User.id' => 'desc'
        ) ,
        'recursive' => 0
    );
    $Users = $user->paginate();
    if (!empty($Users)) {
        $data = array();
        foreach($Users as $key => $User) {
            $data[]['User'] = array(
            __l('Username') => $User['User']['username'],
            __l('Email') => $User['User']['email'],
            __l('Email Confirmed') => $this->Html->cBool($User['User']['is_email_confirmed'],false),
            __l('Login count') => $User['User']['user_login_count'],
            __l('Sign Up IP') => $User['Ip']['ip'],
            __l('Created on') => $User['User']['created'],
            __l('Total Withdraw Amount') => $User['User']['total_amount_withdrawn'],
              );
            if (isPluginEnabled('Projects')) {
                $project = array(
                sprintf(__l('%s Count'), Configure::read('project.alt_name_for_project_singular_caps')) => $User['User']['project_count'],
                sprintf(__l('%s Fund Count'), Configure::read('project.alt_name_for_project_singular_caps')) => $User['User']['unique_project_fund_count'],
                );
                $data[$key]['User'] = array_merge($data[$key]['User'], $project);
            }
            if (isPluginEnabled('Wallet')) {
                $wallet= array (
                     __l('Available Balance') => $User['User']['available_wallet_amount']
                );
                $data[$key]['User'] = array_merge($data[$key]['User'], $wallet);
            }
        }
        if ($i == 1) {
            $this->Csv->addGrid($data);
        } else {
            $this->Csv->addGrid($data, false);
        }
    }
}
echo $this->Csv->render(true);
?>