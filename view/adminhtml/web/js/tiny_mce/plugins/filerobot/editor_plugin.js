tinyMCE.addI18n({
    en: {
        file_robot:
            {
                title: "File Robot"
            },
    }
});

define([
    'jquery'
], function ($) {
    tinymce.create('tinymce.plugins.ScaleflexFileRobot', {
        /**
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {
            var t = this;
            t.editor = ed;
            ed.contentCSS = ['filerobot'];

            ed.addCommand('mceFileRobotModal', t._showFireRobotModal, t);

            ed.addButton('filerobot', {
                title: 'file_robot.title',
                cmd: 'mceFileRobotModal',
                image: url + '/img/icon.gif'
            });
        },

        getInfo: function () {
            return {
                longname: 'TinyMCE File Robot plugin',
                author: 'Scaleflex',
                authorurl: 'https://www.scaleflex.com/',
                infourl: 'https://www.scaleflex.com/',
                version: "1.0"
            };
        },

        _showFireRobotModal: function () {
            var ed = this.editor;
            window.fileRobotActiveEditor = ed;
            $("#file-robot-modal-btn").trigger('click')
        }
    });

    // Register plugin
    tinymce.PluginManager.add('filerobot', tinymce.plugins.ScaleflexFileRobot);
})
