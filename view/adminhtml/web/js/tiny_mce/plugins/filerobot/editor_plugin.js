tinyMCE.addI18n({
    en: {
        filerobot:
            {
                title: "File Robot"
            },
    }
});

define([
    'jquery'
], function ($) {
    tinymce.create('tinymce.plugins.ScaleflexFilerobot', {
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
                title: 'filerobot.title',
                cmd: 'mceFileRobotModal',
                image: url + '/img/icon.svg'
            });

            ed.on('ObjectResizeStart', function (e) {
                window.activeObject = e;
            });

            ed.on('ObjectResized', function (e) {
                const object = jQuery(e.target);

                if (object.prop('nodeName') === 'IMG') {
                    // Get OLD Value
                    const oldObject = window.activeObject;
                    const oldWidth = oldObject.width;
                    const oldHeight = oldObject.height;

                    const newWidth = e.width;
                    const newHeight = e.height;
                    const src = object.attr('src');

                    // Update src URL
                    let newSrc = src.replace(oldWidth, newWidth);
                    newSrc = newSrc.replace(oldHeight, newHeight);

                    // Update image url after resized
                    let content = ed.getContent();
                    content = content.replaceAll('&amp;', '&');
                    content = content.replace(src, newSrc);
                    ed.setContent(content);
                    window.activeObject = undefined;
                }
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
    tinymce.PluginManager.add('filerobot', tinymce.plugins.ScaleflexFilerobot);
})
