webhook: function(req, res) {

   if (req.query['hub.verify_token'] === 'my_token_code') {
      res.send(req.query['hub.challenge']);
   } else {
      res.send('Error, wrong validation token');    
   }
}