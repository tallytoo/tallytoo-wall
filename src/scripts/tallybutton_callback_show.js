if (window.tallytoo) {

  window.tallytoo.showContent = function(contentContainerId) {
    if (contentContainerId) {
      var el = document.getElementById(contentContainerId);
      if (el) {
        var fullHeight = el.scrollHeight;
        el.setAttribute('style', 'max-height: ' + fullHeight  + 'px;');
      }
    }
  }

  window.tallytoo.hideFade = function(fadeId) {
    if (fadeId) {
      var el = document.getElementById(fadeId);
      if (el) {
        el.setAttribute('style', 'background-color: unset');
        el.setAttribute('style', 'background: unset');
      }
    }
  }

  window.tallytoo.tally_cb = function(access_token, contentId, element) {
    var json = JSON.parse(element.dataset.item); 

    // In wall mode, unhide content & hide tallytoo button
    window.tallytoo.showContent(json.contentContainerId);    
    window.tallytoo.hideFade(json.fadeId);

    // In all cases, disable the wall container
    window.tallytoo.hideContainer(json.containerId);
  }

  window.tallytoo.tally_skip_cb = function(url, containerId = null, contentContainerId = null, fadeId = null ) {
    window.tallytoo.showContent(contentContainerId);    
    window.tallytoo.hideFade(fadeId);    
    window.tallytoo.hideContainer(containerId);
  }
}