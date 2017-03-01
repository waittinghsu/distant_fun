<html>
<head>
  <title>Demo: Getting an email address using the Google+ Sign-in button</title>
  <style type="text/css">
  html, body { margin: 0; padding: 0; }
  .hide { display: none;}
  .show { display: block;}
  </style>
  <script src="https://apis.google.com/js/plusone.js" type="text/javascript"></script>
  <script type="text/javascript">
  /*
   * Triggered when the user accepts the sign in, cancels, or closes the
   * authorization dialog.
   */
  function loginFinishedCallback(authResult) {
    if (authResult) {
      if (authResult['error'] == undefined){
        gapi.auth.setToken(authResult); // Store the returned token.
        toggleElement('signin-button'); // Hide the sign-in button after successfully signing in the user.
        getEmail();                     // Trigger request to get the email address.
      } else {
        console.log('An error occurred');
      }
    } else {
      console.log('Empty authResult');  // Something went wrong
    }
  }

  /*
   * Initiates the request to the userinfo endpoint to get the user's email
   * address. This function relies on the gapi.auth.setToken containing a valid
   * OAuth access token.
   *
   * When the request completes, the getEmailCallback is triggered and passed
   * the result of the request.
   */
  function getEmail(){
    // Load the oauth2 libraries to enable the userinfo methods.
    gapi.client.load('oauth2', 'v2', function() {
          var request = gapi.client.oauth2.userinfo.get();
          request.execute(getEmailCallback);
        });
  }

  function getEmailCallback(obj){
    var el = document.getElementById('email');
    var email = '';

    if (obj['email']) {
      email = 'Email: ' + obj['email'];
    }

    //console.log(obj);   // Uncomment to inspect the full object.

    el.innerHTML = email;
    toggleElement('email');
  }

  function toggleElement(id) {
    var el = document.getElementById(id);
    if (el.getAttribute('class') == 'hide') {
      el.setAttribute('class', 'show');
    } else {
      el.setAttribute('class', 'hide');
    }
  }
  </script>
</head>
<body>
  <div id="signin-button" class="show">
     <div class="g-signin" data-callback="loginFinishedCallback"
      data-approvalprompt="force"
      data-clientid="56697249155-vh98hep3201q00inumc68sbn8niq369c.apps.googleusercontent.com"
      data-scope="56697249155-vh98hep3201q00inumc68sbn8niq369c@developer.gserviceaccount.com"
      data-height="short"
      data-cookiepolicy="single_host_origin"
      >
    </div>
    <!-- In most cases, you don't want to use approvalprompt=force. Specified
    here to facilitate the demo.-->
  </div>

  <div id="email" class="hide"></div>
</body>
</html>
