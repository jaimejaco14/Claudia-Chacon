<html>
  <head>
    <title>Loading captcha with JavaScript</title>
    <script type='text/javascript'>
    var captchaContainer = null;
    var loadCaptcha = function() {
      captchaContainer = grecaptcha.render('captcha_container', {
        'sitekey' : 'Your sitekey',
        'callback' : function(response) {
          console.log(response);
        }
      });
    };
    </script>
  </head>
  <body>
      <form action="pqrprocess.php" method="POST">
          <label>Username: <input type="text" name="username" /></label>
          <small>Are you a robot?</small>
          <div id="captcha_container"></div>
          <input type="submit" value="Submit">
      </form>
      <script src="https://www.google.com/recaptcha/api.js?onload=loadCaptcha&render=explicit" async defer></script>
  </body>
</html>