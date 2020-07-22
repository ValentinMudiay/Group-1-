(function() {
    tinymce.PluginManager.add('wpvc_voting_button', function( editor, url ) {
        editor.addButton( 'wpvc_voting_button', {
            title: 'Insert Voting Shortcodes',
            type: 'menubutton',
            icon: 'wpvc_button-own-icon',
            menu: [
                {
                    text: 'Show Contestants',
                    value: '[showcontestants id=]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },                 
                {
                    text: 'Add Contestants',
                    value: '[addcontestants id=]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },                
                {
                    text: 'Upcoming Contestants',
                    value: '[upcomingcontestants id]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                },
                {
                    text: 'End Contestants',
                    value: '[endcontestants id]',
                    onclick: function() {
                        editor.insertContent(this.value());
                    }
                }
           ]
        });
    });
})();