(function(b,f,d) {
	
	if(b.Skeeks||b.sx)
		throw Error("Skeeks or sx object is already defined in global namespace.");
	var a = b.sx = b.Skeeks = {};
	a._ = d;
	a.$ = f;
	a.createNamespace = function(c,b) {
		b = b||a;
		for(var h = c.split("."), g = b, d = 0, f = h.length; d<f ;++d)
		{
			var k = h[d];
			g[k]||(g[k] = {});
			g = g[k]
		}
		return g
	};
	a.version = "1.2";
	a._readyTrigger = !1;
	a._ready = function() {
		a._readyTrigger = !0;
		a.EventManager.trigger("ready")
	};
	a.isReady = function() {
		return a._readyTrigger
	};
	a.init = function(c) {
		a.config.merge(c);
		a._ready()
	};
	a.onReady = function(c) {
		a.isReady() ? c() : a.EventManager.bind("ready",c);
		return this
	}
})(window, jQuery, _);

(function(b,f) {
	
	b.classes = {};
	b.classes.Base = function(){};
	b.classes.Base.prototype.construct = function(){};
	b.classes.Base.prototype.applyParentMethod = function(b,a,c) {
		b.prototype[a].apply(this,c||[])
	};
	b.classes.Base.extend = function(d) {
		b.__isExtending = !0;
		var a = function(){};
		a.prototype = new this;
		var c = function() {
			if(!b.__isExtending) {
				for(var a in d)
					if(d.hasOwnProperty(a)) {
						var e = d[a];
						f.isFunction(e)||(c.prototype[a] = f.clone(e))
					}
				this.construct.apply(this,arguments)
			}
		};
		c.prototype = new a;
		for(var e in d)
			d.hasOwnProperty(e) && (a = d[e], f.isFunction(a) && (c.prototype[e] = a));
			c.prototype.constructor = c;
			c.prototype.parentClass = this.prototype;
			c.extend = this.extend;
			c.prototype.parent = this.prototype;
			b.__isExtending = !1;
		return c
	}
})(Skeeks, Skeeks._);

(function(b,f,d) {
	
	b.createNamespace("classes", b);
	b.classes._Entity = b.classes.Base.extend({
		construct:function(a) {
			this._opts = a||{};
			this._coreInit()}, _coreInit:function(){this._validate();
			this._init()
		},
		_validate:function() {},
		_init:function(){},
		toArray:function() {
			return this._opts}, merge:function(a) {
				a = a||{};
				this._opts = d.extend(this._opts,a);
				return this
			}, 
			mergeDefaults:function(a) {
				a = a||{};this._opts = d.extend(a,this._opts||{});
				return this
			},
			exist:function(a) {
				return "undefined" == typeof this._opts[a] ? !1 : !0
			},
			isset:function(a) {
				return this.exist(a)
			}, 
			clear:function() {
				this._opts = {}
			}, 
			get:function(a,c) {
				return this.exist(a) ? this._opts[a] : c
			},
			set:function(a,c) {
				this._opts[a] = c;
				return this
			}, 
			hasOpt:function(a) {
				return this.exist(a)
			}, 
			getOpt:function(a,c) {
				return this.get(a,c)
			}, 
			setOpt:function(a,c) {
				return this.set(a,c)
			}, 
			setOpts:function(a) {
			    this._opts = a;
				return this
			},
		    getOpts:function() {
				return this.toArray()
			}, 
			mergeOpts:function(a) {
				return this.merge(a)
			},
			defaultOpts:function(a) {
				return this.mergeDefaults(a)
			}
		});
	b.classes.Entity = b.classes._Entity.extend({})
})(sx,sx.$,sx._);

(function(b,f,d)
{
	b.EventManager = { _$:f("<div/>"), _hooks:{}, trigger:function(a,c) {
		
		if(this._hooks[a]&&this._hooks[a].length)
			for(var b = 0, h = this._hooks[a].length; b<h; ++b) {
				var g = this._hooks[a][b];
				if(d.isFunction(g)) {
					g = g(c);
					if(!1 === g)
						return this;
					c = g||c
				}
			}
			this._$.trigger.apply(this._$,[a,c]);
			return this
		}, 
		bind:function(a,c) {
		    this._$.bind(a,c);
		    return this
		}, 
		unbind:function(a,c) {
			this._$.unbind(a,c)
		}, 
		hook:function(a,c) {
			this._hooks[a] || (this._hooks[a] = []);
			this._hooks[a].push(c);
			return this
		},
		unhook:function(a,c) {
			if(this._hooks[a] && this._hooks[a].length)
				for(var b = 0, h = this._hooks[a].length; b<h; ++b)
				    c == this._hooks[a][b] && (this._hooks[a][b] = null);
			return this
		},
		hooks:function() {
			return this._hooks
		}
	};
	b.createNamespace("classes", b);
	b.classes.EventManager = b.classes.Base.extend({_hooks:{}, construct:function(a) {
		this._opts = a||{};
		this._$ = f("<div/>")
	}, 
	trigger:function(a,c) {
		if(this._hooks[a] && this._hooks[a].length) {
			for(var b = 0, h = this._hooks[a].length; b<h; ++b) {
				var g = this._hooks[a][b];
				if(d.isFunction(g)) {
					g = g(c);
					if(!1 === g)
						return this;
					c = g||c
				}
			}    // 为if条件增加一对大括号
		}
		this._$.trigger.apply(this._$,[a,c]);
			return this
		}, 
		bind:function(a,c) {
			this._$.bind(a,c);
			return this
		}, 
		unbind:function(a,c) {
			this._$.unbind(a,c)
		}, 
		hook:function(a,c) {
			this._hooks[a] || (this._hooks[a] = []);
			this._hooks[a].push(c);
			return this
		},
		unhook:function(a,c) {
			if(this._hooks[a] && this._hooks[a].length)
				for(var b = 0, h = this._hooks[a].length; b<h; ++b)
					c == this._hooks[a][b]&&(this._hooks[a][b] = null);
			return this
		}, 
		hooks:function() {
			return this._hooks
		}
	})
})(Skeeks, Skeeks.$, Skeeks._);

(function(b,f,d) {
	b.createNamespace("classes", b);
	b.classes._Config = b.classes.Entity.extend({
		_init:function() {
			this.mergeDefaults({
				env:"dev", lang:"zh-cn", loadedTime:null, cookie:{namespace:"sx"}  // 修改了语言
			})
		}, 
		isDev:function() {
			return "dev" == this.get("env") ? !0 : !1
		},
		isProduct:function() {
			return "product" == this.get("env") ? !0 : !1
		}
	});
	b.classes.Config = b.classes._Config.extend();
	b.config = new b.classes.Config
})(Skeeks,Skeeks.$,Skeeks._);

(function(b,f,d) {
	
	b.createNamespace("classes", b);
	b.classes._Cookie = b.classes.Base.extend({_globalNamespace:b.config.get("cookie").namespace, _namespace:"", _opts:"",construct:function(a,c) {
		this._namespace = a||"";
		this._opts=c||{}
	},
	set:function(a,c,e) {
		b.cookie.set(this._cookieName(a), c, e);
		return this
	},
	get:function(a) {
		return b.cookie.get(this._cookieName(a))
	},
	getAll:function() {
		var a = {}, c = b.cookie.getAll(), e = this.getPrefix();
		c && d.each(c, function(c,b) {
			if(b.substring(0,e.length) == e) {
				var d = b.substring(e.length);
				a[d] = c
			}
		});
		return a
	},
	setNamespace:function(a) {
		this._namespace = a;
		return this
	},
	getNamspace:function() {
		return this._namespace
	},
	getGlobalNamspace:function() {
		return this._globalNamespace
	},
	getFullNamespace:function() {
		return this.getGlobalNamspace() + "__" + this.getNamspace()
	},
	getPrefix:function() {
		return this.getFullNamespace() + "__"
	},
	_cookieName:function(a) {
		return this.getPrefix()+a
	}});
	
	b.classes.Cookie = b.classes._Cookie.extend({});
	b.cookie = {
			_defaultOptions:{path:"/"},
			
			set:function(a, c, b) {
				b = b||{};
				null === c&&(c = "", b.expires = -1);
				var h = "";
				b.expires && ("number" == typeof b.expires||b.expires.toUTCString) && ("number" == typeof b.expires ? (h = new Date, h.setTime(h.getTime() + 864E5 * b.expires)): h = b.expires, h = "; expires = " + h.toUTCString());
				b = d.extend(this._defaultOptions, b);
				var g = b.path ? "; path=" + b.path : "", f = b.domain ? "; domain = " + b.domain:"";
				b = b.secure ? "; secure" : "";
				document.cookie = [a, "=", encodeURIComponent(c), h, g, f, b].join("")
			},
			get:function(a) {
				var b = null;
				if(document.cookie && "" != document.cookie)
					for(var e = document.cookie.split(";"), d = 0; d<e.length; d++) {
						var g = jQuery.trim(e[d]);
						if(g.substring(0,a.length+1) == a+"=") {
							b = decodeURIComponent(g.substring(a.length+1));
							"true" === b ? b = !0 : "false" === b&&(b = !1);
							break
						}
					}
				return b
			},
			getAll:function() {
				var a = {};
				if(document.cookie && "" != document.cookie)
					for(var c=document.cookie.split(";"), e=0; e<c.length; e++) {
						var d = jQuery.trim(c[e]), g = b.helpers.String.strpos(d,"=",0);
						if(g) {
							var f = decodeURIComponent(d.substring(g+1)), d = decodeURIComponent(d.substring(0,g));
							"true" === f ? f =! 0 : "false" === f && (f=!1); a[d] = f}}
				return a
			}
		}
})(sx, sx.$, sx._);

(function(b,f,d,a) {
	b.createNamespace("classes", b);
	b.createNamespace("classes._core", b);
	b.classes._Component = b.classes.Entity.extend({
		_coreInit:function() {
			var c = this;
			this._cookieManager = this._eventManager = null;
			this._validate();
			this._init();
			b.registerComponent(this);
			this._domReadyTrigger = this._windowReadyTrigger = 0;
			this.onDomReady(function() {
				c._onDomReady()
			});
			this.onWindowReady(function() {
				c._onWindowReady()
			});
			f(d.bind(this._domReady, this));
			"complete" == document.readyState ? c._windowReady() : f(a).load(function() {
				c._windowReady()
			}
		)},
		_init:function(){},
		_onDomReady:function(){},
		_onWindowReady:function(){},
		_domReady:function() {
			this._domReadyTrigger = 1;
			this.trigger("onDomReady",this)
		},
		onDomReady:function(a) {
			1 == this._domReadyTrigger ? a(this) : this.bind("onDomReady", a);
			return this
		},
		_windowReady:function() {
			this._windowReadyTrigger = 1;
			this.trigger("onWindowReady", this)
		},
		onWindowReady:function(a) {
			1 == this._windowReadyTrigger ? a(this) : this.bind("onWindowReady", a);
			return this
		},
		getCookieManager:function() { null === this._cookieManager && (this._cookieManager = new b.classes.Cookie);
		return this._cookieManager
	},
	getEventManager:function() {
		null === this._eventManager && (this._eventManager = new b.classes.EventManager);
		return this._eventManager
	},
	bind:function(a,b) {
		this.getEventManager().bind(a,b);
		return this
	},
	unbind:function(a,b) {
		this.getEventManager().unbind(a,b);
		return this
	},
	trigger:function(a,b) {
		this.getEventManager().trigger(a,b);
		return this
	},
	hook:function(a,b) {
		this.getEventManager().hook(a,b);
		return this
	},
	unhook:function(a,b) {
		this.getEventManager().unhook(a, b);
		return this},hooks:function() {
			return this.getEventManager().hooks()
		}
	});
	b.classes.Component = b.classes._Component.extend({});
	b.components = [];
	b.registerComponent = function(a) {
		if(!(a instanceof b.classes._Component))
			throw Error("Instance of sx.classes.Component was expected.");
		b.components.push(a);
		return a
	}
})(sx,sx.$,sx._,window);

(function(b,f,d) {
	b.createNamespace("classes", b);
	b.classes._AjaxHandler = b.classes.Component.extend({
		construct:function(a,c) {
			if(!(a instanceof b.classes._AjaxQuery))
				throw Error("invalid ajaxQuery class");
			c = c||{};
			this._ajaxQuery = a;
			this.applyParentMethod(b.classes.Component,"construct",[c])
		},
		_init:function(){},
		getAjaxQuery:function() {
			return this._ajaxQuery
		}
	});
	b.classes.AjaxHandler = b.classes._AjaxHandler.extend({});
	
	b.classes._AjaxQuery = b.classes.Component.extend({
		_url:"",
		construct:function(a,c) {
			this._url = a;
			this.applyParentMethod(b.classes.Component,"construct", [c]);
			b.ajax.registerQuery(this);
			this._executing = 0
		},
		_init:function() {
			var a = this,
			b = this.get("ajaxStart");
			null !== b && (this.onAjaxStart(b), this.set("ajaxStart", null));
			b = this.get("ajaxStop");
			null !== b && (this.onAjaxStop(b), this.set("ajaxStop", null));
			b = this.get("ajaxComplete");
			null !== b && (this.onAjaxComplete(b), this.set("ajaxComplete", null));
			b = this.get("beforeSend");
			null !== b && (this.onBeforeSend(b), this.set("beforeSend", null));
			b = this.get("complete");
			null !== b && (this.onComplete(b), this.set("complete", null));
			b = this.get("success");
			null !== b && (this.onSuccess(b), this.set("success", null));
			b = this.get("error");
			null !== b && (this.onError(b), this.set("error", null));
			this.onComplete(function() {
				a._executing = Number(a._executing-1);
				0 > a._executing&&(a._executing=0)
			});
			this._additional = null
		},
		execute:function() {
			var a = this;
			!0 === this.get("allowCountExecuting", !0) && (a._executing = Number(a._executing+1));
			a.trigger("beforeExecute",{ajax:a});
			var b = this.getOpts();
			d.extend(b, {ajaxStart:function() {
				a.trigger("ajaxStart", {ajax:a})
			},
			ajaxStop:function() {
				a.trigger("ajaxStop", {ajax:a})
			},
			ajaxComplete:function() {
				a.trigger("ajaxComplete", {ajax:a})
			},
			beforeSend:function() {
				a.trigger("beforeSend", {ajax:a})
			},
			complete:function(b,c,d) {
				a.trigger("complete", {ajax:a, jqXHR:b, textStatus:c, errorThrown:d})
			},
			success:function(b,c,d) {
				a.trigger("success", {ajax:a, response:b, textStatus:c, jqXHR:d})
			},
			error:function(b,c,d) {
				a.trigger("error", {ajax:a, errorThrown:d, textStatus:c, jqXHR:b})
			}
		});
		return f.ajax(this.getUrl(),b)
		}, 
	    isExecuting:function() {
			return!!this._executing},
			getUrl:function() {
				return this._url
			},
			setUrl:function(a) {
				this._url = a;
				return this
			},
			setData:function(a) {
				this.set("data", a);
				return this
			},
			getData:function(a) {
				return this.get("data", {})
			},
			mergeData:function(a) { 
				a = a||{};
				a = d.extend(this.getData(), a);
				this.setData(a);
				return this
			},
			getType:function() {
				return String(this.get("type"))
			},
			setType:function(a) {
				this.set("type", String(a));
				return this
			},
			getSettings:function() {
				return this._opts
			},
			getAdditional:function() {
				return this._additional
			},
			setAdditional:function(a) {
				this._additional = a;
				return this
			},
			onAjaxStart:function(a) {
				this.bind("ajaxStart", a);
				return this
			},
			onAjaxStop:function(a) {
				this.bind("ajaxStop", a);
				return this
			},
			onAjaxComplete:function(a) {
				this.bind("ajaxComplete", a);
				return this
			},
			onSuccess:function(a) {
				this.bind("success", a);
				return this
			},
			onError:function(a) {
				this.getEventManager().bind("error", a);
				return this
			},
			onComplete:function(a) {
				this.getEventManager().bind("complete", a);
				return this
			},
			onBeforeSend:function(a) {
				this.getEventManager().bind("beforeSend", a);
				return this
			}
		});
	b.classes.AjaxQuery = b.classes._AjaxQuery.extend({});
	b.ajax = {
			ajaxStart:"ajaxStart", 
			ajaxStop:"ajaxStop",
			ajaxSend:"ajaxSend",
			ajaxSuccess:"ajaxSuccess",
			ajaxError:"ajaxError",
			ajaxComplete:"ajaxComplete",
			queries:[],
			registerQuery:function(a) {
				if(!(a instanceof b.classes._AjaxQuery))
					throw Error("Instance of sx.classes._AjaxQuery was expected.");
				this.queries.push(a);
				return a
			},
			hasExecutingQueries:function() {
				return!!d.size(this.getExecutingQueries())
			},
			getExecutingQueries:function() {
				return d.filter(this.queries, function(a) {
					return a.isExecuting()
				})
			},
			init:function() {
				f(d.bind(this._onDomReady, this))
			},
			_onDomReady:function() {
				var a = this;
				f(document).bind(a.ajaxStart, function() {
					b.EventManager.trigger(a.ajaxStart)
				}).
				bind(a.ajaxStop, function() {b.EventManager.trigger(a.ajaxStop)}).
				bind(a.ajaxSend,function(){b.EventManager.trigger(a.ajaxSend)}).
				bind(a.ajaxSuccess,function(){b.EventManager.trigger(a.ajaxSuccess)}).
				bind(a.ajaxError,function(){b.EventManager.trigger(a.ajaxError)}).
				bind(a.ajaxComplete,function(){b.EventManager.trigger(a.ajaxComplete)})
			},
			prepareGetQuery:function(a, c, e) {
				e = e||{};
				d.extend(e, {type:"GET", data:c, dataType:"json"});
				return new b.classes.AjaxQuery(a,e)
			},
			preparePostQuery:function(a, c, e) {
				e = e||{};
				d.extend(e,{type:"POST", data:c, dataType:"json"});
				return new b.classes.AjaxQuery(a,e)
			},
			prepareQuery:function(a, c, e) {
				e = e||{};
				c = c||{};
				a = a||"";
				d.extend(e,{data:c,dataType:"json"});
				return new b.classes.AjaxQuery(a,e)
			}
		};
	b.onReady(function() {
		b.ajax.init()
	})
})(Skeeks,Skeeks.$,Skeeks._);