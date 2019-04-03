if (window.tallytoo) {
  window.addEventListener("load", 
    function() {
      if (window.tallybutton && window.tallybutton.Load) {
        window.tallybutton.Load();
      }
    }
  );
}
