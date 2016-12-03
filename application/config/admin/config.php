<?php return [
  'default_theme' => 'default',
  'default_lang' => 'zh-cn',
  'lang_switch_on' => true,
  // 'default_controller' => 'Settings',
  // 'default_action' => 'info',

  'USER_AUTH_ON'      => 1,
  'USER_AUTH_TYPE'    => 2,
  'USER_AUTH_KEY'     => 'USER_ID',
  'ADMIN_AUTH_KEY'    => 'ADMIN_ID',
  'USER_AUTH_GATEWAY' => 'account/login',
  'NOT_AUTH_MODULE'   => 'Account',
  'NOT_AUTH_ACTION'   => 'login,verify',
  'RBAC_ROLE_TABLE'   => 'np_role',
  'RBAC_USER_TABLE'   => 'np_role_admin',
  'RBAC_ACCESS_TABLE' => 'np_access',
  'RBAC_NODE_TABLE'   => 'np_node',
];