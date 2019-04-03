'use strict';
 (function($){
    $(function(){
        // Paywall
        if( $('#__ELEMENT_ID__').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
                    mode: '__EDIT_MODE__'
                }
            );
            var editor = wp.codeEditor.initialize( $('#__ELEMENT_ID__'), editorSettings );
        }

    });
})(jQuery);