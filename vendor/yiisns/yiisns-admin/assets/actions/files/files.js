(function(sx, $, _)
{
    sx.createNamespace('classes.files', sx);
    sx.createNamespace('classes.files.sources', sx);
    /**
    *
    * @type {*|void|Function}
    * @private
    */
    sx.classes.files._Source = sx.classes.Component.extend({

        /**
         * @param Manager
         * @param opts
         */
        construct: function(Manager, opts)
        {
            var self = this;

            if (! (Manager instanceof sx.classes.files._Manager))
            {
                throw new Error('The download manager has not been transferred');
            }

            opts = opts || {};
            opts['manager'] = Manager;
            opts['id']      = "sx-" + self.strRand();

            this.inProcess  = false;
            this.queue      = 0;

            this.applyParentMethod(sx.classes.Component, 'construct', [opts]);
        },

        _init: function()
        {
            var self = this;

            this.allFiles = 0;
            this.elseFiles = 0;

            this.bind("startUpload", function(e, data)
            {
                self.allFiles = Number(data.queueLength);
                self.elseFiles = Number(data.queueLength);
            });

            this.bind("completeUploadFile", function(e, data)
            {
                self.elseFiles = self.elseFiles - 1;
                var uploadedFiles = (self.allFiles - self.elseFiles);
                var pct = (uploadedFiles * 100)/self.allFiles;

                self.triggerOnProgress({
                    'pct': pct,
                    'elseFiles': self.elseFiles,
                    'allFiles': self.allFiles,
                    'uploadedFiles': uploadedFiles,
                });
            });

            this._initManagerEvents();
            this._afterInit();
        },

        _initManagerEvents: function()
        {
            var self = this;

            this.bind("error", function(e, message)
            {
                self.getManager().trigger("error", message);
            });

            this.bind("completeUpload", function(e, data)
            {
                self.getManager().trigger('completeUpload', data);
            });

            this.bind("startUpload", function(e, data)
            {
                //queueLength
                self.getManager().trigger('startUpload', data);
            });

            this.bind("startUploadFile", function(e, data)
            {
                //queueLength
                self.getManager().trigger('startUploadFile', data);
            });

            this.bind("completeUploadFile", function(e, data)
            {
                //queueLength
                self.getManager().trigger('completeUploadFile', data);
            });

            this.bind("onProgressFile", function(e, data)
            {
                //queueLength
                self.getManager().trigger('onProgressFile', data);
            });

            this.bind("onProgress", function(e, data)
            {
                //queueLength
                self.getManager().trigger('onProgress', data);
            });
        },

        _afterInit: function()
        {},

        /**
         * @returns {string}
         */
        strRand: function()
        {
            var result       = '';
            var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
                for( i = 0; i < 6; ++i ) {
                    position = Math.floor ( Math.random() * max_position );
                    result = result + words.substring(position, position + 1);
                }
            return result;
        },

        /**
         *
         * @param data
         * @returns {sx.classes.files.sources.Base}
         */
        triggerStartUpload: function(data)
        {
            this.trigger("startUpload", data);
            return this;
        },

        

        /**
         * @param data
         * @returns {sx.classes.files._Source}
         */
        triggerCompleteUpload: function(data)
        {
            this.trigger("completeUpload", data);
            return this;
        },

        /**
         *
         * @param data
         * @returns {sx.classes.files.sources.Base}
         */
        triggerStartUploadFile: function(data)
        {
            this.trigger("startUploadFile", data);
            return this;
        },

        /**
         *
         * @param data
         * @returns {sx.classes.files.sources.Base}
         */
        triggerCompleteUploadFile: function(data)
        {
            this.trigger("completeUploadFile", data);
            return this;
        },

        /**
         * @param data
         * @returns {sx.classes.files._Source}
         */
        triggerOnProgress: function(data)
        {
            this.trigger("onProgress", data);
            return this;
        },

        /**
         *
         * @param data
         * @returns {sx.classes.files.sources.Base}
         */
        triggerOnProgressFile: function(data)
        {
            this.trigger("onProgressFile", data);
            return this;
        },

        /**
         *
         * @param msg
         * @returns {sx.classes.files.sources.Base}
         */
        triggerError: function(data)
        {
            this.trigger("error", data);
            return this;
        },

        /**
         *
         * @returns {sx.classes.files._Manager}
         */
        getManager: function()
        {
            return this.get("manager");
        },

        /**
         * @param str
         * @returns {string}
         */
        safeName: function(str)
        {
            return String( str )
               .replace( /&/g, '&amp;' )
               .replace( /"/g, '&quot;' )
               .replace( /'/g, '&#39;' )
               .replace( /</g, '&lt;' )
               .replace( />/g, '&gt;' );
        }
    });

    sx.classes.files.sources.RemoteUpload = sx.classes.files._Source.extend({

        run: function()
        {
            var self = this;

            sx.prompt("Enter the URL of the file from http://", {
                'yes': function (e, result)
                {
                    self._processing(result);
                }
            });
        },

        _processing: function(link)
        {
            var self = this;

            this.httpLinks = [link];

            self.queue = _.size(this.httpLinks);
            self.inProcess = true;

            self.triggerStartUpload({
                'queueLength': _.size(this.httpLinks)
            });

            _.each(this.httpLinks, function (link, key) {
                self.triggerStartUploadFile({
                    'name': link,
                    'additional': {}
                });

                var ajaxData = _.extend(self.getManager().getCommonData(), {
                    'link': link
                });

                var ajax = sx.ajax.preparePostQuery(self.get('url'), ajaxData);

                ajax.onComplete(function (e, data)
                {
                    self.triggerCompleteUploadFile({
                        'response': data.jqXHR.responseJSON
                    });

                    self.queue = self.queue - 1;

                    if (self.queue == 0)
                    {
                        self.inProcess = false;
                        self.triggerCompleteUpload({});
                    }
                });

                ajax.execute();
            });
        }
    });

    sx.classes.files.sources.FileManagerUpload = sx.classes.files._Source.extend({

        _init: function ()
        {}
    });

    /**
     * @type {*|Function|void}
     */
    sx.classes.files.sources.SimpleUpload = sx.classes.files._Source.extend({

        _afterInit: function()
        {
            var self = this;

            this.uploaderObj = null;

            this.getManager().bind("changeData", function(e, data)
            {
                if (self.uploaderObj)
                {
                    self.uploaderObj.setData(self.getManager().getCommonData());
                }
            });

            if (self.uploaderObj)
            {
                self.uploaderObj.setData(self.getManager().getCommonData());
            }
        },

        _onDomReady: function()
        {
            /*this.jControllButton = $("<div>", {
                'id' : this.get('id'),
                'style':'display: none;'
            }).append("test").appendTo($("body"));*/
        },

        _onWindowReady: function()
        {
            var self        = this;

            this.buttons    = this.get('buttons', [
                document.getElementById('source-simpleUpload')
            ]);

            this.uploaderObj = new ss.SimpleUpload(_.extend({
                queue: true,
                debug: false,
                maxUploads: 1,
                multiple: true,
                button: this.buttons,
                onExtError: function(filename, extension)
                {
                    self.triggerError({
                        'message' : filename + " File type not allowed for download"
                    });
                },
                onSizeError: function(filename, fileSize)
                {
                    self.triggerError({
                        'message' : filename + " Too large, allowed no more than " + Number(self.get("options").maxSize) + " Kb"
                    });
                },

                onProgress: function(pct)
                {
                    self.triggerOnProgressFile({
                        'pct': pct
                    });
                },

                onError: function( filename, type, status, statusText, response, uploadBtn )
                {
                    if (status == 413)
                    {
                        self.triggerError({
                            'message' : 'The file could not be loaded. Too big.'
                        });
                    } else
                    {
                        self.triggerError({
                            'message' : 'Error loading file. Error code: ' + status + " " + statusText
                        });
                    }

                    self.triggerCompleteUploadFile({
                        'name' : filename,
                        'response' : response,
                    });

                    self.queue      = this._queue.length;

                    if (this._queue.length == 0)
                    {
                        self.inProcess  = false;
                        self.triggerCompleteUpload({});
                    }

                },

                onSubmit: function(filename, ext)
                {
                    if (self.inProcess === false)
                    {
                        self.queue      = this._queue.length;
                        self.inProcess = true;

                        self.triggerStartUpload({
                            'queueLength' : this._queue.length,
                        });

                    }

                    self.triggerStartUploadFile({
                        'name' : filename,
                        'additional' :
                        {
                            'ext': ext
                        },
                    });
                },

                onComplete: function(filename, response)
                {
                    self.triggerCompleteUploadFile({
                        'name' : filename,
                        'response' : response,
                    });

                    self.queue      = this._queue.length;

                    if (this._queue.length == 0)
                    {
                        self.inProcess  = false;
                        self.triggerCompleteUpload({});
                    }
                }
            }, this.get("options")));


            if (self.uploaderObj)
            {
                self.uploaderObj.setData(self.getManager().getCommonData());
            }
        },

    });

    sx.classes.files._UploadProgress = sx.classes.Widget.extend({

        /**
         * @param Manager
         * @param opts
         */
        construct: function(Manager, wrapper, opts)
        {
            if (! (Manager instanceof sx.classes.files._Manager))
            {
                throw new Error('Not transferred to Download manager');
            }

            opts = opts || {};
            opts['manager'] = Manager;

            this.applyParentMethod(sx.classes.Widget, 'construct', [wrapper, opts]);
        },

        /**
         *
         * @returns {sx.classes.files._Manager}
         */
        getManager: function()
        {
            return this.get("manager");
        },

        /**
         * @param pct
         */
        updateProgress: function(pct)
        {
            $('.progress-bar', this.getWrapper()).css('width', Number(pct) + '%');
        }

    });

    sx.classes.files.AllUploadProgress = sx.classes.files._UploadProgress.extend({

        _init: function()
        {
            var self = this;

            this.getManager().bind("startUpload", function(e, data)
            {
                self.updateProgress(0);
                $('.sx-uploadedFiles', self.getWrapper()).empty().append(0);
                $('.sx-allFiles', self.getWrapper()).empty().append(Number(data.queueLength));;

                self.getWrapper().show();
                //data.queueLength
            });

            this.getManager().bind("completeUpload", function(e, data)
            {
                self.getWrapper().hide();
                //data.queueLength
            });

            this.getManager().bind("onProgress", function(e, data)
            {
                self.updateProgress(data.pct);

                $('.sx-uploadedFiles', self.getWrapper()).empty().append(data.uploadedFiles);
                $('.sx-allFiles', self.getWrapper()).empty().append(data.allFiles);
            });
        },
    });

    sx.classes.files.OneFileUploadProgress = sx.classes.files._UploadProgress.extend({
        _init: function()
        {
            var self = this;

            this.getManager().bind("startUploadFile", function(e, data)
            {
                self.updateProgress(0);
                self.getWrapper().show();

                $('.sx-uploaded-file-name', self.getWrapper()).empty().append(data.name);
            });

            this.getManager().bind("completeUploadFile", function(e, data)
            {
                self.getWrapper().hide();
            });

            this.getManager().bind("onProgressFile", function(e, data)
            {
                self.updateProgress(data.pct);
            });
        },
    });

    sx.classes.files._Manager = sx.classes.Widget.extend({

        _init: function()
        {
            var self = this;

            this.sources = [];

            if (this.get('completeUpload'))
            {
                self.bind('completeUpload', function(e, data)
                {
                    var callback = self.get('completeUpload');
                    callback(data);
                });
            }

            if (this.get('completeUploadFile'))
            {
                self.bind('completeUploadFile', function(e, data)
                {
                    var callback = self.get('completeUploadFile');
                    callback(data);
                });
            }
        },

        getCommonData: function()
        {
            return this.get('commonData', {});
        },

        /**
         * @param data
         * @returns {sx.classes.files._Manager}
         */
        setCommonData: function(data)
        {
            this.set('commonData', data);
            this.trigger('changeData');

            return this;
        },

        /**
         * @param data
         * @returns {sx.classes.files._Manager}
         */
        mergeCommonData: function(data)
        {
            var newData = _.extend(this.get('commonData', {}), data);
            return this.setCommonData(newData);
        },
    });

    sx.classes.files.Manager = sx.classes.files._Manager.extend({});

    sx.classes.DefaultFileManager = sx.classes.files.Manager.extend({

        _init: function()
        {
            this.applyParentMethod(sx.classes.files._Manager, '_init', []); // TODO: make a workaround for magic parent calling

            this.SourceSimpleUpload = new sx.classes.files.sources.SimpleUpload(this, this.get("simpleUpload"));
            this.SourceRemoteUpload = new sx.classes.files.sources.RemoteUpload(this, this.get("remoteUpload"));
            this.SourceFileManagerUpload = new sx.classes.files.sources.FileManagerUpload(this);

            this.AllUploadProgress      = new sx.classes.files.AllUploadProgress(this,      this.get('allUploadProgressSelector', ".sx-progress-bar"));
            this.OneFileUploadProgress  = new sx.classes.files.OneFileUploadProgress(this,  this.get('oneFileUploadProgressSelector', ".sx-progress-bar-file"));

            this.bind('error', function(e, data)
            {
                sx.notify.error(data.message);
            });

            this.bind('completeUpload', function(e, data)
            {
                sx.notify.success('Upload complete');
            });

            this.bind('startUpload', function(e, data)
            {
                if (data.queueLength > 2)
                {
                    sx.notify.info('Start download: ' + data.queueLength + ' (files)');
                }
            });
        },
    });

    sx.classes.CustomFileManager = sx.classes.DefaultFileManager.extend({

        _init: function()
        {

            if (this.get('simpleUploadButtons', []))
            {
                var buttons = [];
                _.each(this.get('simpleUploadButtons', []), function(value, key)
                {
                    buttons.push(document.getElementById(value))
                });

                this.set('simpleUpload', _.extend(
                    this.get('simpleUpload', {}),
                    {
                        'buttons' : buttons
                    }

                ));
            }

            this.applyParentMethod(sx.classes.DefaultFileManager, '_init', []); // TODO: make a workaround for magic parent calling
        },

        _onDomReady: function()
        {
            var self = this;

            if (this.get('remoteUploadButtonSelector', ".source-remoteUpload"))
            {
                $( this.get('remoteUploadButtonSelector', ".source-remoteUpload") ).on('click', function()
                {
                    self.SourceRemoteUpload.run();
                });
            }
        },
    });

})(sx, sx.$, sx._);