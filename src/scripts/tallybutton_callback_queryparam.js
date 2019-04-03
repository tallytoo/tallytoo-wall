if (window.tallytoo) {

  window.tallytoo.append_query_param = function(url, append) {
    if (url.indexOf('?') < 0) {
      return url + "?" + append;
    } else {
      return url + "&" + append;
    }

  }

  window.tallytoo.tally_cb = function(access_token, contentId, element) {
    var json = JSON.parse(element.dataset.item); 

    if (json.mode === 'pay' || json.mode === 'donate') {
      // If in "wall" mode, redirect with the access token provided
      window.location.href = window.tallytoo.append_query_param(json.redirect, 'tt_at=' + access_token);
    } else if (json.mode === 'donateinline') {
      // If in "inline donate" mode, don't redirect, just hide the element
      window.tallytoo.hideContainer(json.containerId);
    }  
  }

  window.tallytoo.tally_skip_cb = function(url) {
    if (url) {
      window.location.href = window.tallytoo.append_query_param(url, "tt_skip=1");
    } else {
      console.log("Skipping article");
    }
  }
}