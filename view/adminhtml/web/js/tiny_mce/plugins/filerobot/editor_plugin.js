define([
    'jquery'
], function ($) {
    tinymce.create('tinymce.plugins.ScaleflexFilerobot', {
        /**
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init: function (ed, url) {
            const t = this;
            t.editor = ed;

            ed.addCommand('mceFileRobotModal', t._showFilerobotModal, t);

            if (ed.editorManager.majorVersion === '5') {
                ed.ui.registry.addButton('filerobot', {
                    tooltip: 'DAM by Scaleflex',
                    icon: 'filerobot',
                    onAction: function () {
                        window.fileRobotActiveEditor = ed;
                        $("#filerobot-modal-btn").trigger('click');
                    }
                });
            } else {
                ed.addButton('filerobot', {
                    title: 'Filerobot DAM Widget',
                    cmd: 'mceFileRobotModal',
                    image: url + '/img/icon.svg'
                });
            }

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
                    let newSrc = src.replace(oldWidth, newWidth).replace(oldHeight, newHeight);

                    // Update image url after resized
                    let content = "";

                    if (ed.editorManager.majorVersion === '5') {
                        content = ed.getContent({format: 'html'});
                    } else {
                        content = ed.getContent();
                    }

                    content = content.replaceAll('&amp;', '&');
                    content = content.replace(src, newSrc);
                    ed.setContent(content);
                    window.activeObject = undefined;
                }
            });

        },

        getInfo: function () {
            return {
                longname: 'TinyMCE DAM Filerobot plugin',
                author: 'Scaleflex',
                authorurl: 'https://www.scaleflex.com/',
                infourl: 'https://www.scaleflex.com/',
                version: "1.1"
            };
        },

        _showFilerobotModal: function () {
            const ed = this.editor;
            window.fileRobotActiveEditor = ed;
            $("#filerobot-modal-btn").trigger('click');
        }
    });

    // Register plugin
    tinymce.PluginManager.add('filerobot', tinymce.plugins.ScaleflexFilerobot);
});
