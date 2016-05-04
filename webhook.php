<?php

$challenge = $_REQUEST['hub_challenge'];
$verify_token = $_REQUEST['hub_verify_token'];

if ($verify_token === 'my_token_code') {
	echo $challenge;
}
<script type="text/javascript">
app.post('/webhook/', function (req, res) {
	messaging_events = req.body.entry[0].messaging;
	for (i = 0; i < messaging_events.length; i++) {
		event = req.body.entry[0].messaging[i];
		sender = event.sender.id;
		if (event.message && event.message.text) {
			text = event.message.text;
      // Handle a text message from this sender
		}
	}
	res.sendStatus(200);
});
</script>