if (window.tallytoo) {
  if (!window.tallytoo.tally_cb) {
    window.tallytoo.tally_cb = function() {};
  }


  window.tallytoo.tally_bought_cb = function(contentId, element) {
    var json = JSON.parse(element.dataset.item); 
    window.tallytoo.hideContainer(json.containerId);    
  };

  window.tallytoo.hideContainer = function(containerId) {
    if (containerId) {
      var el = document.getElementById(containerId);
      if (el) {
        el.setAttribute('style', 'display: none;');
      }
    }
  }

  var shouldHandleBought = __HANDLE_BOUGHT__;
  var boughtFunc = null;
  if (shouldHandleBought) {  
    boughtFunc = window.tallytoo.tally_bought_cb;
  }

  var json = '__DISPLAY__';
  var display = null;
  if (json) {
    try {
      display = JSON.parse(json);
    } catch (err) {
      console.error("Error parsing tallybutton display parameters: ", err);
      console.error(json);
    }
  }

  window.tallybutton = window.tallytoo.TallyButton.Create(
    {
      apiKey: "__APIKEY__", 
      popoverZ: __POPOVERZ__, 
      onSuccess: window.tallytoo.tally_cb, 
      onContentAlreadyBought: boughtFunc,
      allowFreeAccess: __ALLOW_FREE__ ,
      display: display,
      alwaysPopup: __ALWAYS_POPUP__
    }
  );
}