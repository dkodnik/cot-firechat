<?php defined('COT_CODE') or die('Wrong URL');
/* ====================
[BEGIN_COT_EXT]
Hooks=global
Tags=footer.tpl:{PHP.out.firechat}
[END_COT_EXT]
==================== */

cot_rc_link_footer('//cdn.firebase.com/v0/firebase.js');
cot_rc_link_footer($cfg['plugins_dir'] . '/firechat/lib/firechat-default.min.css');
cot_rc_link_footer($cfg['plugins_dir'] . '/firechat/lib/firechat-default.min.js');

include_once $cfg['plugins_dir'] . '/firechat/lib/FirebaseToken.php';

$fireTokenGen = new Services_FirebaseTokenGenerator($cfg['plugin']['firechat']['firebase_secret']);
$fireToken = $fireTokenGen->createToken(array('id' => $usr['id']));

$out['firechat'] = <<<HTM
<div id="firechat-wrapper"></div>
<script type='text/javascript'>
  var firechatRef = new Firebase('https://{$cfg['plugin']['firechat']['firebase_app']}.firebaseio.com/chat');
  firechatRef.auth('{$fireToken}');
  var firechat = new FirechatUI(firechatRef, document.getElementById("firechat-wrapper"));
  firechat.setUser({$usr['id']}, '{$usr['name']}');
</script>
HTM;
