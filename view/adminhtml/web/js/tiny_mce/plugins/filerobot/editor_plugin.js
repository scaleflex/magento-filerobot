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
                ed.ui.registry.addIcon('filerobot',
                    '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="25" viewBox="0 0 45 43" fill="none">\n' +
                    '<path d="M9.86668 36.5293C11.3776 34.5602 11.0062 31.739 9.03711 30.228C7.06798 28.7171 4.24681 29.0885 2.73584 31.0576C1.22488 33.0268 1.59629 35.8479 3.56542 37.3589C5.53455 38.8699 8.35572 38.4984 9.86668 36.5293Z" fill="#155BCD"/>\n' +
                    '<path d="M42.2641 36.5264C43.7751 34.5573 43.4037 31.7361 41.4346 30.2251C39.4654 28.7142 36.6443 29.0856 35.1333 31.0547C33.6223 33.0238 33.9938 35.845 35.9629 37.356C37.932 38.8669 40.7532 38.4955 42.2641 36.5264Z" fill="#155BCD"/>\n' +
                    '<path d="M26.9837 7.55669C27.6387 5.16263 26.2288 2.69093 23.8348 2.03599C21.4407 1.38104 18.969 2.79088 18.314 5.18494C17.6591 7.579 19.0689 10.0507 21.463 10.7057C23.8571 11.3606 26.3288 9.95076 26.9837 7.55669Z" fill="#155BCD"/>\n' +
                    '<path d="M36.602 24.5029L37.6253 22.7389C37.6754 22.6602 37.8078 22.4384 37.9617 22.1629L38.0476 22.0162C38.1048 21.916 38.1585 21.8158 38.2086 21.7156C38.3173 21.5109 38.4152 21.3007 38.502 21.0858C38.502 21.0358 38.5413 20.9892 38.5557 20.9427C39.0827 19.5197 39.0712 17.9532 38.5235 16.5381L38.4698 16.4021L38.4376 16.3198C37.9605 15.1467 37.1418 14.1442 36.0877 13.4423C35.0336 12.7404 33.7929 12.3716 32.5265 12.3839H32.3083L21.8315 12.3302H21.7707L15.7666 12.298H15.6879H13.4802C13.3085 12.298 12.8648 12.2801 12.3817 12.298H12.3388C11.7686 12.336 11.207 12.4566 10.6714 12.6558C10.3602 12.7684 10.0577 12.9036 9.76612 13.0601L9.6552 13.1353C8.89741 13.5757 8.23749 14.1663 7.71586 14.8707L7.57274 15.0746C7.54411 15.1175 7.51549 15.1641 7.48329 15.207C6.94853 16.0198 6.61042 16.9459 6.49573 17.9121C6.49573 18.0444 6.4671 18.1768 6.45994 18.3092C6.45994 18.3379 6.45994 18.3701 6.45994 18.3987C6.45994 18.4273 6.45994 18.5024 6.45994 18.5525C6.45408 18.8273 6.46603 19.1022 6.49573 19.3755C6.52077 19.5866 6.55655 19.7941 6.60307 20.0053C6.60307 20.0303 6.60307 20.0589 6.60307 20.0876C6.63169 20.214 6.6639 20.3392 6.69968 20.4633C6.71757 20.5133 6.7283 20.567 6.74619 20.6171C6.76408 20.6672 6.78197 20.7173 6.79987 20.7674C6.86358 20.9539 6.93764 21.1366 7.02171 21.3148C7.04676 21.3757 7.07538 21.4329 7.104 21.4938L7.13621 21.5653C7.333 21.9446 7.59779 22.3954 7.85183 22.857L15.5806 36.4073L16.5645 38.0926C17.663 40.4005 19.2696 41.6493 21.2877 42.0286C21.5745 42.0872 21.865 42.1267 22.1571 42.1466H22.1965H22.5078C25.0125 42.2182 26.9447 41.0446 28.2328 38.8297C29.3062 37.0013 30.6623 34.672 31.7715 32.7684C32.913 30.8076 33.829 29.3477 33.8075 29.2511L36.602 24.5029ZM17.4269 25.0862L17.1335 21.8373C17.0707 20.537 17.0958 19.234 17.2086 17.9371H17.2372C19.2112 18.2931 21.1532 18.8076 23.0445 19.4757C26.197 20.5507 29.1783 22.0739 31.8968 23.9984L32.0149 24.0807L31.954 24.1308C31.954 24.1308 31.8503 24.2417 31.657 24.435C31.038 25.0325 29.6998 26.3099 28.2507 27.5694C27.3812 28.3136 26.3865 29.1223 25.2916 29.9381C24.1358 30.7718 22.6151 31.813 22.4291 31.924C21.4057 32.5859 20.3359 33.2192 19.2374 33.7917V33.7595L17.4269 25.0862Z" fill="#155BCD"/>\n' +
                    '</svg>'
                    );

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
