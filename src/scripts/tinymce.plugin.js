(function() {
  tinymce.create("tinymce.plugins.tallytoo_plugin", {

      //url argument holds the absolute url of our plugin directory
      init : function(ed, url) {

          //paywall
          ed.addButton("tallytoo_paywall", {
              title : "Add tallytoo paywall",
              cmd : "tallytoo_paywall_command",
              image : url + "/../../images/paywall.png"
          });

          ed.addCommand("tallytoo_paywall_command", function() {
              var selected_text = ed.selection.getContent();
              var return_text = "[tallytoo-paywall cost=1]" + selected_text + "[/tallytoo-paywall]";
              ed.execCommand("mceInsertContent", 0, return_text);
          });


          //donate wall
          ed.addButton("tallytoo_donatewall", {
            title : "Add tallytoo donate wall",
            cmd : "tallytoo_donatewall_command",
            image : url + "/../../images/donatewall.png"
          });

          //button functionality.
          ed.addCommand("tallytoo_donatewall_command", function() {
              var selected_text = ed.selection.getContent();
              var return_text = "[tallytoo-donatewall cost=1]" + selected_text + "[/tallytoo-donatewall]";
              ed.execCommand("mceInsertContent", 0, return_text);
          });

          //donate
          ed.addButton("tallytoo_donate", {
            title : "Add tallytoo donate request",
            cmd : "tallytoo_donate_command",
            image : url + "/../../images/donateinline.png"
          });

          //button functionality.
          ed.addCommand("tallytoo_donate_command", function() {
              var selected_text = ed.selection.getContent();
              var return_text = "[tallytoo-donate cost=1]" + selected_text + "[/tallytoo-donate]";
              ed.execCommand("mceInsertContent", 0, return_text);
          });

          //fade
          ed.addButton("tallytoo_fade", {
            title : "Apply tallytoo fadout",
            cmd : "tallytoo_fade_command",
            image : url + "/../../images/fade.png"
          });

          //button functionality.
          ed.addCommand("tallytoo_fade_command", function() {
              var selected_text = ed.selection.getContent();
              var return_text = "[tallytoo-fade]" + selected_text + "[/tallytoo-fade]";
              ed.execCommand("mceInsertContent", 0, return_text);
          });

      },

      createControl : function(n, cm) {
          return null;
      },

      getInfo : function() {
          return {
              longname : "Tallytoo Buttons",
              author : "tallytoo",
              version : "1"
          };
      }
  });

  tinymce.PluginManager.add("tallytoo_plugin", tinymce.plugins.tallytoo_plugin);
})();