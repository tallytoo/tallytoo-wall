if (window.tallytoo) {
  window.tallytoo.tally_cb = function(access_token, contentId, element) {
    var json = JSON.parse(element.dataset.item); 

    if (json.mode === 'pay' || json.mode === 'donate') {
      // If in "wall" mode, redirect with the access token provided
      document.cookie="tt_at=" + access_token + "; path=/"; 
      window.location.href = json.redirect;
    } else if (json.mode === 'donateinline') {
      // If in "inline donate" mode, don't redirect, just hide the element
      window.tallytoo.hideContainer(json.containerId);
    }  
    
  }

  window.tallytoo.tally_skip_cb = function(url) {
    if (url) {
      document.cookie="tt_skip=1; path=/"; 
      window.location.href = url;
    } else {
      console.log("Skipping article");
    }
  }
}