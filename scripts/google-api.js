function GsignIn() {
  let oauth2Endpoint = "https://accounts.google.com/o/oauth2/v2/auth";

  let form = document.createElement('form');
  form.setAttribute('method', 'GET');
  form.setAttribute('action', oauth2Endpoint);

  let params = {
    "client_id": "1028273265947-karpptahvldi2499tn663is3e4ulq4gl.apps.googleusercontent.com",
    "redirect_uri": "http://localhost/dishcovery/api/google_signin.php",
    "response_type": "code",
    "scope": "profile email",
    "include_granted_scopes": 'true',
    'state': 'pass-through-value',
    'access_type': 'offline'
};

  for (var p in params) {
    let input = document.createElement('input');
    input.setAttribute('type', 'hidden');
    input.setAttribute('name', p);
    input.setAttribute('value', params[p]);
    form.appendChild(input);
  }

  document.body.appendChild(form);

  form.submit();
}
