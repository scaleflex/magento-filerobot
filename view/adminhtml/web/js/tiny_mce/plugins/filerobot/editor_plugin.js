tinyMCE.addI18n({en:{
    textwithbox:
        {
            file_robot : "File Robot"
        },
}});

define([
    'jquery'
], function($) {
    tinymce.create('tinymce.plugins.TextWithBoxPlugin', {
        /**
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            var t = this;
            t.editor = ed;
            ed.contentCSS = ['filerobot'];

            ed.addCommand('mceTextwithbox', t._showFireRobotPopup, t);

            ed.addButton('textwithbox', {
                title : 'textwithbox.insert_text_with_box',
                cmd : 'mceTextwithbox',
                image : url + '/img/icon.gif'
            });
        },

        getInfo : function() {
            return {
                longname : 'TinyMCE File Robot plugin',
                author : 'Scaleflex',
                authorurl : 'https://www.scaleflex.com/',
                infourl : 'https://www.scaleflex.com/',
                version : "1.0"
            };
        },

        _showFireRobotPopup: function () {
            var ed = this.editor;
            window.fileRobotActiveEditor = ed;
            $("#file-robot-modal-btn").trigger('click')
        }
    });

    // Register plugin
    tinymce.PluginManager.add('filerobot', tinymce.plugins.TextWithBoxPlugin);
})

