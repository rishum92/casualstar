! function(t) {
    if ("object" == typeof exports && "undefined" != typeof module) module.exports = t();
    else if ("function" == typeof define && define.amd) define([], t);
    else {
        var e;
        e = "undefined" != typeof window ? window : "undefined" != typeof global ? global : "undefined" != typeof self ? self : this, e.io = t()
    }
}(function() {
    var t;
    return function e(t, n, r) {
        function o(s, a) {
            if (!n[s]) {
                if (!t[s]) {
                    var c = "function" == typeof require && require;
                    if (!a && c) return c(s, !0);
                    if (i) return i(s, !0);
                    var p = new Error("Cannot find module '" + s + "'");
                    throw p.code = "MODULE_NOT_FOUND", p
                }
                var u = n[s] = {
                    exports: {}
                };
                t[s][0].call(u.exports, function(e) {
                    var n = t[s][1][e];
                    return o(n ? n : e)
                }, u, u.exports, e, t, n, r)
            }
            return n[s].exports
        }
        for (var i = "function" == typeof require && require, s = 0; s < r.length; s++) o(r[s]);
        return o
    }({
        1: [function(t, e, n) {
            e.exports = t("./lib/")
        }, {
            "./lib/": 2
        }],
        2: [function(t, e, n) {
            e.exports = t("./socket"), e.exports.parser = t("engine.io-parser")
        }, {
            "./socket": 3,
            "engine.io-parser": 19
        }],
        3: [function(t, e, n) {
            (function(n) {
                function r(t, e) {
                    if (!(this instanceof r)) return new r(t, e);
                    e = e || {}, t && "object" == typeof t && (e = t, t = null), t ? (t = u(t), e.hostname = t.host, e.secure = "https" == t.protocol || "wss" == t.protocol, e.port = t.port, t.query && (e.query = t.query)) : e.host && (e.hostname = u(e.host).host), this.secure = null != e.secure ? e.secure : n.location && "https:" == location.protocol, e.hostname && !e.port && (e.port = this.secure ? "443" : "80"), this.agent = e.agent || !1, this.hostname = e.hostname || (n.location ? location.hostname : "localhost"), this.port = e.port || (n.location && location.port ? location.port : this.secure ? 443 : 80), this.query = e.query || {}, "string" == typeof this.query && (this.query = h.decode(this.query)), this.upgrade = !1 !== e.upgrade, this.path = (e.path || "/engine.io").replace(/\/$/, "") + "/", this.forceJSONP = !!e.forceJSONP, this.jsonp = !1 !== e.jsonp, this.forceBase64 = !!e.forceBase64, this.enablesXDR = !!e.enablesXDR, this.timestampParam = e.timestampParam || "t", this.timestampRequests = e.timestampRequests, this.transports = e.transports || ["polling", "websocket"], this.readyState = "", this.writeBuffer = [], this.policyPort = e.policyPort || 843, this.rememberUpgrade = e.rememberUpgrade || !1, this.binaryType = null, this.onlyBinaryUpgrades = e.onlyBinaryUpgrades, this.perMessageDeflate = !1 !== e.perMessageDeflate ? e.perMessageDeflate || {} : !1, !0 === this.perMessageDeflate && (this.perMessageDeflate = {}), this.perMessageDeflate && null == this.perMessageDeflate.threshold && (this.perMessageDeflate.threshold = 1024), this.pfx = e.pfx || null, this.key = e.key || null, this.passphrase = e.passphrase || null, this.cert = e.cert || null, this.ca = e.ca || null, this.ciphers = e.ciphers || null, this.rejectUnauthorized = void 0 === e.rejectUnauthorized ? null : e.rejectUnauthorized;
                    var o = "object" == typeof n && n;
                    o.global === o && e.extraHeaders && Object.keys(e.extraHeaders).length > 0 && (this.extraHeaders = e.extraHeaders), this.open()
                }

                function o(t) {
                    var e = {};
                    for (var n in t) t.hasOwnProperty(n) && (e[n] = t[n]);
                    return e
                }
                var i = t("./transports"),
                    s = t("component-emitter"),
                    a = t("debug")("engine.io-client:socket"),
                    c = t("indexof"),
                    p = t("engine.io-parser"),
                    u = t("parseuri"),
                    f = t("parsejson"),
                    h = t("parseqs");
                e.exports = r, r.priorWebsocketSuccess = !1, s(r.prototype), r.protocol = p.protocol, r.Socket = r, r.Transport = t("./transport"), r.transports = t("./transports"), r.parser = t("engine.io-parser"), r.prototype.createTransport = function(t) {
                    a('creating transport "%s"', t);
                    var e = o(this.query);
                    e.EIO = p.protocol, e.transport = t, this.id && (e.sid = this.id);
                    var n = new i[t]({
                        agent: this.agent,
                        hostname: this.hostname,
                        port: 22222,
                        secure: this.secure,
                        path: this.path,
                        query: e,
                        forceJSONP: this.forceJSONP,
                        jsonp: this.jsonp,
                        forceBase64: this.forceBase64,
                        enablesXDR: this.enablesXDR,
                        timestampRequests: this.timestampRequests,
                        timestampParam: this.timestampParam,
                        policyPort: this.policyPort,
                        socket: this,
                        pfx: this.pfx,
                        key: this.key,
                        passphrase: this.passphrase,
                        cert: this.cert,
                        ca: this.ca,
                        ciphers: this.ciphers,
                        rejectUnauthorized: this.rejectUnauthorized,
                        perMessageDeflate: this.perMessageDeflate,
                        extraHeaders: this.extraHeaders
                    });
                    return n
                }, r.prototype.open = function() {
                    var t;
                    if (this.rememberUpgrade && r.priorWebsocketSuccess && -1 != this.transports.indexOf("websocket")) t = "websocket";
                    else {
                        if (0 === this.transports.length) {
                            var e = this;
                            return void setTimeout(function() {
                                e.emit("error", "No transports available")
                            }, 0)
                        }
                        t = this.transports[0]
                    }
                    this.readyState = "opening";
                    try {
                        t = this.createTransport(t)
                    } catch (n) {
                        return this.transports.shift(), void this.open()
                    }
                    t.open(), this.setTransport(t)
                }, r.prototype.setTransport = function(t) {
                    a("setting transport %s", t.name);
                    var e = this;
                    this.transport && (a("clearing existing transport %s", this.transport.name), this.transport.removeAllListeners()), this.transport = t, t.on("drain", function() {
                        e.onDrain()
                    }).on("packet", function(t) {
                        e.onPacket(t)
                    }).on("error", function(t) {
                        e.onError(t)
                    }).on("close", function() {
                        e.onClose("transport close")
                    })
                }, r.prototype.probe = function(t) {
                    function e() {
                        if (h.onlyBinaryUpgrades) {
                            var e = !this.supportsBinary && h.transport.supportsBinary;
                            f = f || e
                        }
                        f || (a('probe transport "%s" opened', t), u.send([{
                            type: "ping",
                            data: "probe"
                        }]), u.once("packet", function(e) {
                            if (!f)
                                if ("pong" == e.type && "probe" == e.data) {
                                    if (a('probe transport "%s" pong', t), h.upgrading = !0, h.emit("upgrading", u), !u) return;
                                    r.priorWebsocketSuccess = "websocket" == u.name, a('pausing current transport "%s"', h.transport.name), h.transport.pause(function() {
                                        f || "closed" != h.readyState && (a("changing transport and sending upgrade packet"), p(), h.setTransport(u), u.send([{
                                            type: "upgrade"
                                        }]), h.emit("upgrade", u), u = null, h.upgrading = !1, h.flush())
                                    })
                                } else {
                                    a('probe transport "%s" failed', t);
                                    var n = new Error("probe error");
                                    n.transport = u.name, h.emit("upgradeError", n)
                                }
                        }))
                    }

                    function n() {
                        f || (f = !0, p(), u.close(), u = null)
                    }

                    function o(e) {
                        var r = new Error("probe error: " + e);
                        r.transport = u.name, n(), a('probe transport "%s" failed because of error: %s', t, e), h.emit("upgradeError", r)
                    }

                    function i() {
                        o("transport closed")
                    }

                    function s() {
                        o("socket closed")
                    }

                    function c(t) {
                        u && t.name != u.name && (a('"%s" works - aborting "%s"', t.name, u.name), n())
                    }

                    function p() {
                        u.removeListener("open", e), u.removeListener("error", o), u.removeListener("close", i), h.removeListener("close", s), h.removeListener("upgrading", c)
                    }
                    a('probing transport "%s"', t);
                    var u = this.createTransport(t, {
                            probe: 1
                        }),
                        f = !1,
                        h = this;
                    r.priorWebsocketSuccess = !1, u.once("open", e), u.once("error", o), u.once("close", i), this.once("close", s), this.once("upgrading", c), u.open()
                }, r.prototype.onOpen = function() {
                    if (a("socket open"), this.readyState = "open", r.priorWebsocketSuccess = "websocket" == this.transport.name, this.emit("open"), this.flush(), "open" == this.readyState && this.upgrade && this.transport.pause) {
                        a("starting upgrade probes");
                        for (var t = 0, e = this.upgrades.length; e > t; t++) this.probe(this.upgrades[t])
                    }
                }, r.prototype.onPacket = function(t) {
                    if ("opening" == this.readyState || "open" == this.readyState) switch (a('socket receive: type "%s", data "%s"', t.type, t.data), this.emit("packet", t), this.emit("heartbeat"), t.type) {
                        case "open":
                            this.onHandshake(f(t.data));
                            break;
                        case "pong":
                            this.setPing(), this.emit("pong");
                            break;
                        case "error":
                            var e = new Error("server error");
                            e.code = t.data, this.onError(e);
                            break;
                        case "message":
                            this.emit("data", t.data), this.emit("message", t.data)
                    } else a('packet received with socket readyState "%s"', this.readyState)
                }, r.prototype.onHandshake = function(t) {
                    this.emit("handshake", t), this.id = t.sid, this.transport.query.sid = t.sid, this.upgrades = this.filterUpgrades(t.upgrades), this.pingInterval = t.pingInterval, this.pingTimeout = t.pingTimeout, this.onOpen(), "closed" != this.readyState && (this.setPing(), this.removeListener("heartbeat", this.onHeartbeat), this.on("heartbeat", this.onHeartbeat))
                }, r.prototype.onHeartbeat = function(t) {
                    clearTimeout(this.pingTimeoutTimer);
                    var e = this;
                    e.pingTimeoutTimer = setTimeout(function() {
                        "closed" != e.readyState && e.onClose("ping timeout")
                    }, t || e.pingInterval + e.pingTimeout)
                }, r.prototype.setPing = function() {
                    var t = this;
                    clearTimeout(t.pingIntervalTimer), t.pingIntervalTimer = setTimeout(function() {
                        a("writing ping packet - expecting pong within %sms", t.pingTimeout), t.ping(), t.onHeartbeat(t.pingTimeout)
                    }, t.pingInterval)
                }, r.prototype.ping = function() {
                    var t = this;
                    this.sendPacket("ping", function() {
                        t.emit("ping")
                    })
                }, r.prototype.onDrain = function() {
                    this.writeBuffer.splice(0, this.prevBufferLen), this.prevBufferLen = 0, 0 === this.writeBuffer.length ? this.emit("drain") : this.flush()
                }, r.prototype.flush = function() {
                    "closed" != this.readyState && this.transport.writable && !this.upgrading && this.writeBuffer.length && (a("flushing %d packets in socket", this.writeBuffer.length), this.transport.send(this.writeBuffer), this.prevBufferLen = this.writeBuffer.length, this.emit("flush"))
                }, r.prototype.write = r.prototype.send = function(t, e, n) {
                    return this.sendPacket("message", t, e, n), this
                }, r.prototype.sendPacket = function(t, e, n, r) {
                    if ("function" == typeof e && (r = e, e = void 0), "function" == typeof n && (r = n, n = null), "closing" != this.readyState && "closed" != this.readyState) {
                        n = n || {}, n.compress = !1 !== n.compress;
                        var o = {
                            type: t,
                            data: e,
                            options: n
                        };
                        this.emit("packetCreate", o), this.writeBuffer.push(o), r && this.once("flush", r), this.flush()
                    }
                }, r.prototype.close = function() {
                    function t() {
                        r.onClose("forced close"), a("socket closing - telling transport to close"), r.transport.close()
                    }

                    function e() {
                        r.removeListener("upgrade", e), r.removeListener("upgradeError", e), t()
                    }

                    function n() {
                        r.once("upgrade", e), r.once("upgradeError", e)
                    }
                    if ("opening" == this.readyState || "open" == this.readyState) {
                        this.readyState = "closing";
                        var r = this;
                        this.writeBuffer.length ? this.once("drain", function() {
                            this.upgrading ? n() : t()
                        }) : this.upgrading ? n() : t()
                    }
                    return this
                }, r.prototype.onError = function(t) {
                    a("socket error %j", t), r.priorWebsocketSuccess = !1, this.emit("error", t), this.onClose("transport error", t)
                }, r.prototype.onClose = function(t, e) {
                    if ("opening" == this.readyState || "open" == this.readyState || "closing" == this.readyState) {
                        a('socket close with reason: "%s"', t);
                        var n = this;
                        clearTimeout(this.pingIntervalTimer), clearTimeout(this.pingTimeoutTimer), this.transport.removeAllListeners("close"), this.transport.close(), this.transport.removeAllListeners(), this.readyState = "closed", this.id = null, this.emit("close", t, e), n.writeBuffer = [], n.prevBufferLen = 0
                    }
                }, r.prototype.filterUpgrades = function(t) {
                    for (var e = [], n = 0, r = t.length; r > n; n++) ~c(this.transports, t[n]) && e.push(t[n]);
                    return e
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./transport": 4,
            "./transports": 5,
            "component-emitter": 15,
            debug: 17,
            "engine.io-parser": 19,
            indexof: 23,
            parsejson: 26,
            parseqs: 27,
            parseuri: 28
        }],
        4: [function(t, e, n) {
            function r(t) {
                this.path = t.path, this.hostname = t.hostname, this.port = t.port, this.secure = t.secure, this.query = t.query, this.timestampParam = t.timestampParam, this.timestampRequests = t.timestampRequests, this.readyState = "", this.agent = t.agent || !1, this.socket = t.socket, this.enablesXDR = t.enablesXDR, this.pfx = t.pfx, this.key = t.key, this.passphrase = t.passphrase, this.cert = t.cert, this.ca = t.ca, this.ciphers = t.ciphers, this.rejectUnauthorized = t.rejectUnauthorized, this.extraHeaders = t.extraHeaders
            }
            var o = t("engine.io-parser"),
                i = t("component-emitter");
            e.exports = r, i(r.prototype), r.prototype.onError = function(t, e) {
                var n = new Error(t);
                return n.type = "TransportError", n.description = e, this.emit("error", n), this
            }, r.prototype.open = function() {
                return ("closed" == this.readyState || "" == this.readyState) && (this.readyState = "opening", this.doOpen()), this
            }, r.prototype.close = function() {
                return ("opening" == this.readyState || "open" == this.readyState) && (this.doClose(), this.onClose()), this
            }, r.prototype.send = function(t) {
                if ("open" != this.readyState) throw new Error("Transport not open");
                this.write(t)
            }, r.prototype.onOpen = function() {
                this.readyState = "open", this.writable = !0, this.emit("open")
            }, r.prototype.onData = function(t) {
                var e = o.decodePacket(t, this.socket.binaryType);
                this.onPacket(e)
            }, r.prototype.onPacket = function(t) {
                this.emit("packet", t)
            }, r.prototype.onClose = function() {
                this.readyState = "closed", this.emit("close")
            }
        }, {
            "component-emitter": 15,
            "engine.io-parser": 19
        }],
        5: [function(t, e, n) {
            (function(e) {
                function r(t) {
                    var n, r = !1,
                        a = !1,
                        c = !1 !== t.jsonp;
                    if (e.location) {
                        var p = "https:" == location.protocol,
                            u = location.port;
                        u || (u = p ? 443 : 80), r = t.hostname != location.hostname || u != t.port, a = t.secure != p
                    }
                    if (t.xdomain = r, t.xscheme = a, n = new o(t), "open" in n && !t.forceJSONP) return new i(t);
                    if (!c) throw new Error("JSONP disabled");
                    return new s(t)
                }
                var o = t("xmlhttprequest-ssl"),
                    i = t("./polling-xhr"),
                    s = t("./polling-jsonp"),
                    a = t("./websocket");
                n.polling = r, n.websocket = a
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./polling-jsonp": 6,
            "./polling-xhr": 7,
            "./websocket": 9,
            "xmlhttprequest-ssl": 10
        }],
        6: [function(t, e, n) {
            (function(n) {
                function r() {}

                function o(t) {
                    i.call(this, t), this.query = this.query || {}, a || (n.___eio || (n.___eio = []), a = n.___eio), this.index = a.length;
                    var e = this;
                    a.push(function(t) {
                        e.onData(t)
                    }), this.query.j = this.index, n.document && n.addEventListener && n.addEventListener("beforeunload", function() {
                        e.script && (e.script.onerror = r)
                    }, !1)
                }
                var i = t("./polling"),
                    s = t("component-inherit");
                e.exports = o;
                var a, c = /\n/g,
                    p = /\\n/g;
                s(o, i), o.prototype.supportsBinary = !1, o.prototype.doClose = function() {
                    this.script && (this.script.parentNode.removeChild(this.script), this.script = null), this.form && (this.form.parentNode.removeChild(this.form), this.form = null, this.iframe = null), i.prototype.doClose.call(this)
                }, o.prototype.doPoll = function() {
                    var t = this,
                        e = document.createElement("script");
                    this.script && (this.script.parentNode.removeChild(this.script), this.script = null), e.async = !0, e.src = this.uri(), e.onerror = function(e) {
                        t.onError("jsonp poll error", e)
                    };
                    var n = document.getElementsByTagName("script")[0];
                    n ? n.parentNode.insertBefore(e, n) : (document.head || document.body).appendChild(e), this.script = e;
                    var r = "undefined" != typeof navigator && /gecko/i.test(navigator.userAgent);
                    r && setTimeout(function() {
                        var t = document.createElement("iframe");
                        document.body.appendChild(t), document.body.removeChild(t)
                    }, 100)
                }, o.prototype.doWrite = function(t, e) {
                    function n() {
                        r(), e()
                    }

                    function r() {
                        if (o.iframe) try {
                            o.form.removeChild(o.iframe)
                        } catch (t) {
                            o.onError("jsonp polling iframe removal error", t)
                        }
                        try {
                            var e = '<iframe src="javascript:0" name="' + o.iframeId + '">';
                            i = document.createElement(e)
                        } catch (t) {
                            i = document.createElement("iframe"), i.name = o.iframeId, i.src = "javascript:0"
                        }
                        i.id = o.iframeId, o.form.appendChild(i), o.iframe = i
                    }
                    var o = this;
                    if (!this.form) {
                        var i, s = document.createElement("form"),
                            a = document.createElement("textarea"),
                            u = this.iframeId = "eio_iframe_" + this.index;
                        s.className = "socketio", s.style.position = "absolute", s.style.top = "-1000px", s.style.left = "-1000px", s.target = u, s.method = "POST", s.setAttribute("accept-charset", "utf-8"), a.name = "d", s.appendChild(a), document.body.appendChild(s), this.form = s, this.area = a
                    }
                    this.form.action = this.uri(), r(), t = t.replace(p, "\\\n"), this.area.value = t.replace(c, "\\n");
                    try {
                        this.form.submit()
                    } catch (f) {}
                    this.iframe.attachEvent ? this.iframe.onreadystatechange = function() {
                        "complete" == o.iframe.readyState && n()
                    } : this.iframe.onload = n
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./polling": 8,
            "component-inherit": 16
        }],
        7: [function(t, e, n) {
            (function(n) {
                function r() {}

                function o(t) {
                    if (c.call(this, t), n.location) {
                        var e = "https:" == location.protocol,
                            r = location.port;
                        r || (r = e ? 443 : 80), this.xd = t.hostname != n.location.hostname || r != t.port, this.xs = t.secure != e
                    } else this.extraHeaders = t.extraHeaders
                }

                function i(t) {
                    this.method = t.method || "GET", this.uri = t.uri, this.xd = !!t.xd, this.xs = !!t.xs, this.async = !1 !== t.async, this.data = void 0 != t.data ? t.data : null, this.agent = t.agent, this.isBinary = t.isBinary, this.supportsBinary = t.supportsBinary, this.enablesXDR = t.enablesXDR, this.pfx = t.pfx, this.key = t.key, this.passphrase = t.passphrase, this.cert = t.cert, this.ca = t.ca, this.ciphers = t.ciphers, this.rejectUnauthorized = t.rejectUnauthorized, this.extraHeaders = t.extraHeaders, this.create()
                }

                function s() {
                    for (var t in i.requests) i.requests.hasOwnProperty(t) && i.requests[t].abort()
                }
                var a = t("xmlhttprequest-ssl"),
                    c = t("./polling"),
                    p = t("component-emitter"),
                    u = t("component-inherit"),
                    f = t("debug")("engine.io-client:polling-xhr");
                e.exports = o, e.exports.Request = i, u(o, c), o.prototype.supportsBinary = !0, o.prototype.request = function(t) {
                    return t = t || {}, t.uri = this.uri(), t.xd = this.xd, t.xs = this.xs, t.agent = this.agent || !1, t.supportsBinary = this.supportsBinary, t.enablesXDR = this.enablesXDR, t.pfx = this.pfx, t.key = this.key, t.passphrase = this.passphrase, t.cert = this.cert, t.ca = this.ca, t.ciphers = this.ciphers, t.rejectUnauthorized = this.rejectUnauthorized, t.extraHeaders = this.extraHeaders, new i(t)
                }, o.prototype.doWrite = function(t, e) {
                    var n = "string" != typeof t && void 0 !== t,
                        r = this.request({
                            method: "POST",
                            data: t,
                            isBinary: n
                        }),
                        o = this;
                    r.on("success", e), r.on("error", function(t) {
                        o.onError("xhr post error", t)
                    }), this.sendXhr = r
                }, o.prototype.doPoll = function() {
                    f("xhr poll");
                    var t = this.request(),
                        e = this;
                    t.on("data", function(t) {
                        e.onData(t)
                    }), t.on("error", function(t) {
                        e.onError("xhr poll error", t)
                    }), this.pollXhr = t
                }, p(i.prototype), i.prototype.create = function() {
                    var t = {
                        agent: this.agent,
                        xdomain: this.xd,
                        xscheme: this.xs,
                        enablesXDR: this.enablesXDR
                    };
                    t.pfx = this.pfx, t.key = this.key, t.passphrase = this.passphrase, t.cert = this.cert, t.ca = this.ca, t.ciphers = this.ciphers, t.rejectUnauthorized = this.rejectUnauthorized;
                    var e = this.xhr = new a(t),
                        r = this;
                    try {
                        f("xhr open %s: %s", this.method, this.uri), e.open(this.method, this.uri, this.async);
                        try {
                            if (this.extraHeaders) {
                                e.setDisableHeaderCheck(!0);
                                for (var o in this.extraHeaders) this.extraHeaders.hasOwnProperty(o) && e.setRequestHeader(o, this.extraHeaders[o])
                            }
                        } catch (s) {}
                        if (this.supportsBinary && (e.responseType = "arraybuffer"), "POST" == this.method) try {
                            this.isBinary ? e.setRequestHeader("Content-type", "application/octet-stream") : e.setRequestHeader("Content-type", "text/plain;charset=UTF-8")
                        } catch (s) {}
                        "withCredentials" in e && (e.withCredentials = !0), this.hasXDR() ? (e.onload = function() {
                            r.onLoad()
                        }, e.onerror = function() {
                            r.onError(e.responseText)
                        }) : e.onreadystatechange = function() {
                            4 == e.readyState && (200 == e.status || 1223 == e.status ? r.onLoad() : setTimeout(function() {
                                r.onError(e.status)
                            }, 0))
                        }, f("xhr data %s", this.data), e.send(this.data)
                    } catch (s) {
                        return void setTimeout(function() {
                            r.onError(s)
                        }, 0)
                    }
                    n.document && (this.index = i.requestsCount++, i.requests[this.index] = this)
                }, i.prototype.onSuccess = function() {
                    this.emit("success"), this.cleanup()
                }, i.prototype.onData = function(t) {
                    this.emit("data", t), this.onSuccess()
                }, i.prototype.onError = function(t) {
                    this.emit("error", t), this.cleanup(!0)
                }, i.prototype.cleanup = function(t) {
                    if ("undefined" != typeof this.xhr && null !== this.xhr) {
                        if (this.hasXDR() ? this.xhr.onload = this.xhr.onerror = r : this.xhr.onreadystatechange = r, t) try {
                            this.xhr.abort()
                        } catch (e) {}
                        n.document && delete i.requests[this.index], this.xhr = null
                    }
                }, i.prototype.onLoad = function() {
                    var t;
                    try {
                        var e;
                        try {
                            e = this.xhr.getResponseHeader("Content-Type").split(";")[0]
                        } catch (n) {}
                        if ("application/octet-stream" === e) t = this.xhr.response;
                        else if (this.supportsBinary) try {
                            t = String.fromCharCode.apply(null, new Uint8Array(this.xhr.response))
                        } catch (n) {
                            for (var r = new Uint8Array(this.xhr.response), o = [], i = 0, s = r.length; s > i; i++) o.push(r[i]);
                            t = String.fromCharCode.apply(null, o)
                        } else t = this.xhr.responseText
                    } catch (n) {
                        this.onError(n)
                    }
                    null != t && this.onData(t)
                }, i.prototype.hasXDR = function() {
                    return "undefined" != typeof n.XDomainRequest && !this.xs && this.enablesXDR
                }, i.prototype.abort = function() {
                    this.cleanup()
                }, n.document && (i.requestsCount = 0, i.requests = {}, n.attachEvent ? n.attachEvent("onunload", s) : n.addEventListener && n.addEventListener("beforeunload", s, !1))
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./polling": 8,
            "component-emitter": 15,
            "component-inherit": 16,
            debug: 17,
            "xmlhttprequest-ssl": 10
        }],
        8: [function(t, e, n) {
            function r(t) {
                var e = t && t.forceBase64;
                (!u || e) && (this.supportsBinary = !1), o.call(this, t)
            }
            var o = t("../transport"),
                i = t("parseqs"),
                s = t("engine.io-parser"),
                a = t("component-inherit"),
                c = t("yeast"),
                p = t("debug")("engine.io-client:polling");
            e.exports = r;
            var u = function() {
                var e = t("xmlhttprequest-ssl"),
                    n = new e({
                        xdomain: !1
                    });
                return null != n.responseType
            }();
            a(r, o), r.prototype.name = "polling", r.prototype.doOpen = function() {
                this.poll()
            }, r.prototype.pause = function(t) {
                function e() {
                    p("paused"), n.readyState = "paused", t()
                }
                var n = this;
                if (this.readyState = "pausing", this.polling || !this.writable) {
                    var r = 0;
                    this.polling && (p("we are currently polling - waiting to pause"), r++, this.once("pollComplete", function() {
                        p("pre-pause polling complete"), --r || e()
                    })), this.writable || (p("we are currently writing - waiting to pause"), r++, this.once("drain", function() {
                        p("pre-pause writing complete"), --r || e()
                    }))
                } else e()
            }, r.prototype.poll = function() {
                p("polling"), this.polling = !0, this.doPoll(), this.emit("poll")
            }, r.prototype.onData = function(t) {
                var e = this;
                p("polling got data %s", t);
                var n = function(t, n, r) {
                    return "opening" == e.readyState && e.onOpen(), "close" == t.type ? (e.onClose(), !1) : void e.onPacket(t)
                };
                s.decodePayload(t, this.socket.binaryType, n), "closed" != this.readyState && (this.polling = !1, this.emit("pollComplete"), "open" == this.readyState ? this.poll() : p('ignoring poll - transport state "%s"', this.readyState))
            }, r.prototype.doClose = function() {
                function t() {
                    p("writing close packet"), e.write([{
                        type: "close"
                    }])
                }
                var e = this;
                "open" == this.readyState ? (p("transport open - closing"), t()) : (p("transport not open - deferring close"), this.once("open", t))
            }, r.prototype.write = function(t) {
                var e = this;
                this.writable = !1;
                var n = function() {
                        e.writable = !0, e.emit("drain")
                    },
                    e = this;
                s.encodePayload(t, this.supportsBinary, function(t) {
                    e.doWrite(t, n)
                })
            }, r.prototype.uri = function() {
                var t = this.query || {},
                    e = this.secure ? "https" : "http",
                    n = "";
                !1 !== this.timestampRequests && (t[this.timestampParam] = c()), this.supportsBinary || t.sid || (t.b64 = 1), t = i.encode(t), this.port && ("https" == e && 443 != this.port || "http" == e && 80 != this.port) && (n = ":" + this.port), t.length && (t = "?" + t);
                var r = -1 !== this.hostname.indexOf(":");
                return e + "://" + (r ? "[" + this.hostname + "]" : this.hostname) + n + this.path + t
            }
        }, {
            "../transport": 4,
            "component-inherit": 16,
            debug: 17,
            "engine.io-parser": 19,
            parseqs: 27,
            "xmlhttprequest-ssl": 10,
            yeast: 30
        }],
        9: [function(t, e, n) {
            (function(n) {
                function r(t) {
                    var e = t && t.forceBase64;
                    e && (this.supportsBinary = !1), this.perMessageDeflate = t.perMessageDeflate, o.call(this, t)
                }
                var o = t("../transport"),
                    i = t("engine.io-parser"),
                    s = t("parseqs"),
                    a = t("component-inherit"),
                    c = t("yeast"),
                    p = t("debug")("engine.io-client:websocket"),
                    u = n.WebSocket || n.MozWebSocket,
                    f = u;
                if (!f && "undefined" == typeof window) try {
                    f = t("ws")
                } catch (h) {}
                e.exports = r, a(r, o), r.prototype.name = "websocket", r.prototype.supportsBinary = !0, r.prototype.doOpen = function() {
                    if (this.check()) {
                        var t = this.uri(),
                            e = void 0,
                            n = {
                                agent: this.agent,
                                perMessageDeflate: this.perMessageDeflate
                            };
                        n.pfx = this.pfx, n.key = this.key, n.passphrase = this.passphrase, n.cert = this.cert, n.ca = this.ca, n.ciphers = this.ciphers, n.rejectUnauthorized = this.rejectUnauthorized, this.extraHeaders && (n.headers = this.extraHeaders), this.ws = u ? new f(t) : new f(t, e, n), void 0 === this.ws.binaryType && (this.supportsBinary = !1), this.ws.supports && this.ws.supports.binary ? (this.supportsBinary = !0, this.ws.binaryType = "buffer") : this.ws.binaryType = "arraybuffer", this.addEventListeners()
                    }
                }, r.prototype.addEventListeners = function() {
                    var t = this;
                    this.ws.onopen = function() {
                        t.onOpen()
                    }, this.ws.onclose = function() {
                        t.onClose()
                    }, this.ws.onmessage = function(e) {
                        t.onData(e.data)
                    }, this.ws.onerror = function(e) {
                        t.onError("websocket error", e)
                    }
                }, "undefined" != typeof navigator && /iPad|iPhone|iPod/i.test(navigator.userAgent) && (r.prototype.onData = function(t) {
                    var e = this;
                    setTimeout(function() {
                        o.prototype.onData.call(e, t)
                    }, 0)
                }), r.prototype.write = function(t) {
                    function e() {
                        r.emit("flush"), setTimeout(function() {
                            r.writable = !0, r.emit("drain")
                        }, 0)
                    }
                    var r = this;
                    this.writable = !1;
                    for (var o = t.length, s = 0, a = o; a > s; s++) ! function(t) {
                        i.encodePacket(t, r.supportsBinary, function(i) {
                            if (!u) {
                                var s = {};
                                if (t.options && (s.compress = t.options.compress), r.perMessageDeflate) {
                                    var a = "string" == typeof i ? n.Buffer.byteLength(i) : i.length;
                                    a < r.perMessageDeflate.threshold && (s.compress = !1)
                                }
                            }
                            try {
                                u ? r.ws.send(i) : r.ws.send(i, s)
                            } catch (c) {
                                p("websocket closed before onclose event")
                            }--o || e()
                        })
                    }(t[s])
                }, r.prototype.onClose = function() {
                    o.prototype.onClose.call(this)
                }, r.prototype.doClose = function() {
                    "undefined" != typeof this.ws && this.ws.close()
                }, r.prototype.uri = function() {
                    var t = this.query || {},
                        e = this.secure ? "wss" : "ws",
                        n = "";
                    this.port && ("wss" == e && 443 != this.port || "ws" == e && 80 != this.port) && (n = ":" + this.port), this.timestampRequests && (t[this.timestampParam] = c()), this.supportsBinary || (t.b64 = 1), t = s.encode(t), t.length && (t = "?" + t);
                    var r = -1 !== this.hostname.indexOf(":");
                    return e + "://" + (r ? "[" + this.hostname + "]" : this.hostname) + n + this.path + t
                }, r.prototype.check = function() {
                    return !(!f || "__initialize" in f && this.name === r.prototype.name)
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "../transport": 4,
            "component-inherit": 16,
            debug: 17,
            "engine.io-parser": 19,
            parseqs: 27,
            ws: void 0,
            yeast: 30
        }],
        10: [function(t, e, n) {
            var r = t("has-cors");
            e.exports = function(t) {
                var e = t.xdomain,
                    n = t.xscheme,
                    o = t.enablesXDR;
                try {
                    if ("undefined" != typeof XMLHttpRequest && (!e || r)) return new XMLHttpRequest
                } catch (i) {}
                try {
                    if ("undefined" != typeof XDomainRequest && !n && o) return new XDomainRequest
                } catch (i) {}
                if (!e) try {
                    return new ActiveXObject("Microsoft.XMLHTTP")
                } catch (i) {}
            }
        }, {
            "has-cors": 22
        }],
        11: [function(t, e, n) {
            function r(t, e, n) {
                function r(t, o) {
                    if (r.count <= 0) throw new Error("after called too many times");
                    --r.count, t ? (i = !0, e(t), e = n) : 0 !== r.count || i || e(null, o)
                }
                var i = !1;
                return n = n || o, r.count = t, 0 === t ? e() : r
            }

            function o() {}
            e.exports = r
        }, {}],
        12: [function(t, e, n) {
            e.exports = function(t, e, n) {
                var r = t.byteLength;
                if (e = e || 0, n = n || r, t.slice) return t.slice(e, n);
                if (0 > e && (e += r), 0 > n && (n += r), n > r && (n = r), e >= r || e >= n || 0 === r) return new ArrayBuffer(0);
                for (var o = new Uint8Array(t), i = new Uint8Array(n - e), s = e, a = 0; n > s; s++, a++) i[a] = o[s];
                return i.buffer
            }
        }, {}],
        13: [function(t, e, n) {
            ! function(t) {
                "use strict";
                n.encode = function(e) {
                    var n, r = new Uint8Array(e),
                        o = r.length,
                        i = "";
                    for (n = 0; o > n; n += 3) i += t[r[n] >> 2], i += t[(3 & r[n]) << 4 | r[n + 1] >> 4], i += t[(15 & r[n + 1]) << 2 | r[n + 2] >> 6], i += t[63 & r[n + 2]];
                    return o % 3 === 2 ? i = i.substring(0, i.length - 1) + "=" : o % 3 === 1 && (i = i.substring(0, i.length - 2) + "=="), i
                }, n.decode = function(e) {
                    var n, r, o, i, s, a = .75 * e.length,
                        c = e.length,
                        p = 0;
                    "=" === e[e.length - 1] && (a--, "=" === e[e.length - 2] && a--);
                    var u = new ArrayBuffer(a),
                        f = new Uint8Array(u);
                    for (n = 0; c > n; n += 4) r = t.indexOf(e[n]), o = t.indexOf(e[n + 1]), i = t.indexOf(e[n + 2]), s = t.indexOf(e[n + 3]), f[p++] = r << 2 | o >> 4, f[p++] = (15 & o) << 4 | i >> 2, f[p++] = (3 & i) << 6 | 63 & s;
                    return u
                }
            }("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/")
        }, {}],
        14: [function(t, e, n) {
            (function(t) {
                function n(t) {
                    for (var e = 0; e < t.length; e++) {
                        var n = t[e];
                        if (n.buffer instanceof ArrayBuffer) {
                            var r = n.buffer;
                            if (n.byteLength !== r.byteLength) {
                                var o = new Uint8Array(n.byteLength);
                                o.set(new Uint8Array(r, n.byteOffset, n.byteLength)), r = o.buffer
                            }
                            t[e] = r
                        }
                    }
                }

                function r(t, e) {
                    e = e || {};
                    var r = new i;
                    n(t);
                    for (var o = 0; o < t.length; o++) r.append(t[o]);
                    return e.type ? r.getBlob(e.type) : r.getBlob()
                }

                function o(t, e) {
                    return n(t), new Blob(t, e || {})
                }
                var i = t.BlobBuilder || t.WebKitBlobBuilder || t.MSBlobBuilder || t.MozBlobBuilder,
                    s = function() {
                        try {
                            var t = new Blob(["hi"]);
                            return 2 === t.size
                        } catch (e) {
                            return !1
                        }
                    }(),
                    a = s && function() {
                        try {
                            var t = new Blob([new Uint8Array([1, 2])]);
                            return 2 === t.size
                        } catch (e) {
                            return !1
                        }
                    }(),
                    c = i && i.prototype.append && i.prototype.getBlob;
                e.exports = function() {
                    return s ? a ? t.Blob : o : c ? r : void 0
                }()
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {}],
        15: [function(t, e, n) {
            function r(t) {
                return t ? o(t) : void 0
            }

            function o(t) {
                for (var e in r.prototype) t[e] = r.prototype[e];
                return t
            }
            e.exports = r, r.prototype.on = r.prototype.addEventListener = function(t, e) {
                return this._callbacks = this._callbacks || {}, (this._callbacks[t] = this._callbacks[t] || []).push(e), this
            }, r.prototype.once = function(t, e) {
                function n() {
                    r.off(t, n), e.apply(this, arguments)
                }
                var r = this;
                return this._callbacks = this._callbacks || {}, n.fn = e, this.on(t, n), this
            }, r.prototype.off = r.prototype.removeListener = r.prototype.removeAllListeners = r.prototype.removeEventListener = function(t, e) {
                if (this._callbacks = this._callbacks || {}, 0 == arguments.length) return this._callbacks = {}, this;
                var n = this._callbacks[t];
                if (!n) return this;
                if (1 == arguments.length) return delete this._callbacks[t], this;
                for (var r, o = 0; o < n.length; o++)
                    if (r = n[o], r === e || r.fn === e) {
                        n.splice(o, 1);
                        break
                    }
                return this
            }, r.prototype.emit = function(t) {
                this._callbacks = this._callbacks || {};
                var e = [].slice.call(arguments, 1),
                    n = this._callbacks[t];
                if (n) {
                    n = n.slice(0);
                    for (var r = 0, o = n.length; o > r; ++r) n[r].apply(this, e)
                }
                return this
            }, r.prototype.listeners = function(t) {
                return this._callbacks = this._callbacks || {}, this._callbacks[t] || []
            }, r.prototype.hasListeners = function(t) {
                return !!this.listeners(t).length
            }
        }, {}],
        16: [function(t, e, n) {
            e.exports = function(t, e) {
                var n = function() {};
                n.prototype = e.prototype, t.prototype = new n, t.prototype.constructor = t
            }
        }, {}],
        17: [function(t, e, n) {
            function r() {
                return "WebkitAppearance" in document.documentElement.style || window.console && (console.firebug || console.exception && console.table) || navigator.userAgent.toLowerCase().match(/firefox\/(\d+)/) && parseInt(RegExp.$1, 10) >= 31
            }

            function o() {
                var t = arguments,
                    e = this.useColors;
                if (t[0] = (e ? "%c" : "") + this.namespace + (e ? " %c" : " ") + t[0] + (e ? "%c " : " ") + "+" + n.humanize(this.diff), !e) return t;
                var r = "color: " + this.color;
                t = [t[0], r, "color: inherit"].concat(Array.prototype.slice.call(t, 1));
                var o = 0,
                    i = 0;
                return t[0].replace(/%[a-z%]/g, function(t) {
                    "%%" !== t && (o++, "%c" === t && (i = o))
                }), t.splice(i, 0, r), t
            }

            function i() {
                return "object" == typeof console && console.log && Function.prototype.apply.call(console.log, console, arguments)
            }

            function s(t) {
                try {
                    null == t ? n.storage.removeItem("debug") : n.storage.debug = t
                } catch (e) {}
            }

            function a() {
                var t;
                try {
                    t = n.storage.debug
                } catch (e) {}
                return t
            }

            function c() {
                try {
                    return window.localStorage
                } catch (t) {}
            }
            n = e.exports = t("./debug"), n.log = i, n.formatArgs = o, n.save = s, n.load = a, n.useColors = r, n.storage = "undefined" != typeof chrome && "undefined" != typeof chrome.storage ? chrome.storage.local : c(), n.colors = ["lightseagreen", "forestgreen", "goldenrod", "dodgerblue", "darkorchid", "crimson"], n.formatters.j = function(t) {
                return JSON.stringify(t)
            }, n.enable(a())
        }, {
            "./debug": 18
        }],
        18: [function(t, e, n) {
            function r() {
                return n.colors[u++ % n.colors.length]
            }

            function o(t) {
                function e() {}

                function o() {
                    var t = o,
                        e = +new Date,
                        i = e - (p || e);
                    t.diff = i, t.prev = p, t.curr = e, p = e, null == t.useColors && (t.useColors = n.useColors()), null == t.color && t.useColors && (t.color = r());
                    var s = Array.prototype.slice.call(arguments);
                    s[0] = n.coerce(s[0]), "string" != typeof s[0] && (s = ["%o"].concat(s));
                    var a = 0;
                    s[0] = s[0].replace(/%([a-z%])/g, function(e, r) {
                        if ("%%" === e) return e;
                        a++;
                        var o = n.formatters[r];
                        if ("function" == typeof o) {
                            var i = s[a];
                            e = o.call(t, i), s.splice(a, 1), a--
                        }
                        return e
                    }), "function" == typeof n.formatArgs && (s = n.formatArgs.apply(t, s));
                    var c = o.log || n.log || console.log.bind(console);
                    c.apply(t, s)
                }
                e.enabled = !1, o.enabled = !0;
                var i = n.enabled(t) ? o : e;
                return i.namespace = t, i
            }

            function i(t) {
                n.save(t);
                for (var e = (t || "").split(/[\s,]+/), r = e.length, o = 0; r > o; o++) e[o] && (t = e[o].replace(/\*/g, ".*?"), "-" === t[0] ? n.skips.push(new RegExp("^" + t.substr(1) + "$")) : n.names.push(new RegExp("^" + t + "$")))
            }

            function s() {
                n.enable("")
            }

            function a(t) {
                var e, r;
                for (e = 0, r = n.skips.length; r > e; e++)
                    if (n.skips[e].test(t)) return !1;
                for (e = 0, r = n.names.length; r > e; e++)
                    if (n.names[e].test(t)) return !0;
                return !1
            }

            function c(t) {
                return t instanceof Error ? t.stack || t.message : t
            }
            n = e.exports = o, n.coerce = c, n.disable = s, n.enable = i, n.enabled = a, n.humanize = t("ms"), n.names = [], n.skips = [], n.formatters = {};
            var p, u = 0
        }, {
            ms: 25
        }],
        19: [function(t, e, n) {
            (function(e) {
                function r(t, e) {
                    var r = "b" + n.packets[t.type] + t.data.data;
                    return e(r)
                }

                function o(t, e, r) {
                    if (!e) return n.encodeBase64Packet(t, r);
                    var o = t.data,
                        i = new Uint8Array(o),
                        s = new Uint8Array(1 + o.byteLength);
                    s[0] = m[t.type];
                    for (var a = 0; a < i.length; a++) s[a + 1] = i[a];
                    return r(s.buffer)
                }

                function i(t, e, r) {
                    if (!e) return n.encodeBase64Packet(t, r);
                    var o = new FileReader;
                    return o.onload = function() {
                        t.data = o.result, n.encodePacket(t, e, !0, r)
                    }, o.readAsArrayBuffer(t.data)
                }

                function s(t, e, r) {
                    if (!e) return n.encodeBase64Packet(t, r);
                    if (g) return i(t, e, r);
                    var o = new Uint8Array(1);
                    o[0] = m[t.type];
                    var s = new w([o.buffer, t.data]);
                    return r(s)
                }

                function a(t, e, n) {
                    for (var r = new Array(t.length), o = h(t.length, n), i = function(t, n, o) {
                            e(n, function(e, n) {
                                r[t] = n, o(e, r)
                            })
                        }, s = 0; s < t.length; s++) i(s, t[s], o)
                }
                var c = t("./keys"),
                    p = t("has-binary"),
                    u = t("arraybuffer.slice"),
                    f = t("base64-arraybuffer"),
                    h = t("after"),
                    l = t("utf8"),
                    d = navigator.userAgent.match(/Android/i),
                    y = /PhantomJS/i.test(navigator.userAgent),
                    g = d || y;
                n.protocol = 3;
                var m = n.packets = {
                        open: 0,
                        close: 1,
                        ping: 2,
                        pong: 3,
                        message: 4,
                        upgrade: 5,
                        noop: 6
                    },
                    b = c(m),
                    v = {
                        type: "error",
                        data: "parser error"
                    },
                    w = t("blob");
                n.encodePacket = function(t, n, i, a) {
                    "function" == typeof n && (a = n, n = !1), "function" == typeof i && (a = i, i = null);
                    var c = void 0 === t.data ? void 0 : t.data.buffer || t.data;
                    if (e.ArrayBuffer && c instanceof ArrayBuffer) return o(t, n, a);
                    if (w && c instanceof e.Blob) return s(t, n, a);
                    if (c && c.base64) return r(t, a);
                    var p = m[t.type];
                    return void 0 !== t.data && (p += i ? l.encode(String(t.data)) : String(t.data)), a("" + p)
                }, n.encodeBase64Packet = function(t, r) {
                    var o = "b" + n.packets[t.type];
                    if (w && t.data instanceof e.Blob) {
                        var i = new FileReader;
                        return i.onload = function() {
                            var t = i.result.split(",")[1];
                            r(o + t)
                        }, i.readAsDataURL(t.data)
                    }
                    var s;
                    try {
                        s = String.fromCharCode.apply(null, new Uint8Array(t.data))
                    } catch (a) {
                        for (var c = new Uint8Array(t.data), p = new Array(c.length), u = 0; u < c.length; u++) p[u] = c[u];
                        s = String.fromCharCode.apply(null, p)
                    }
                    return o += e.btoa(s), r(o)
                }, n.decodePacket = function(t, e, r) {
                    if ("string" == typeof t || void 0 === t) {
                        if ("b" == t.charAt(0)) return n.decodeBase64Packet(t.substr(1), e);
                        if (r) try {
                            t = l.decode(t)
                        } catch (o) {
                            return v
                        }
                        var i = t.charAt(0);
                        return Number(i) == i && b[i] ? t.length > 1 ? {
                            type: b[i],
                            data: t.substring(1)
                        } : {
                            type: b[i]
                        } : v
                    }
                    var s = new Uint8Array(t),
                        i = s[0],
                        a = u(t, 1);
                    return w && "blob" === e && (a = new w([a])), {
                        type: b[i],
                        data: a
                    }
                }, n.decodeBase64Packet = function(t, n) {
                    var r = b[t.charAt(0)];
                    if (!e.ArrayBuffer) return {
                        type: r,
                        data: {
                            base64: !0,
                            data: t.substr(1)
                        }
                    };
                    var o = f.decode(t.substr(1));
                    return "blob" === n && w && (o = new w([o])), {
                        type: r,
                        data: o
                    }
                }, n.encodePayload = function(t, e, r) {
                    function o(t) {
                        return t.length + ":" + t
                    }

                    function i(t, r) {
                        n.encodePacket(t, s ? e : !1, !0, function(t) {
                            r(null, o(t))
                        })
                    }
                    "function" == typeof e && (r = e, e = null);
                    var s = p(t);
                    return e && s ? w && !g ? n.encodePayloadAsBlob(t, r) : n.encodePayloadAsArrayBuffer(t, r) : t.length ? void a(t, i, function(t, e) {
                        return r(e.join(""))
                    }) : r("0:")
                }, n.decodePayload = function(t, e, r) {
                    if ("string" != typeof t) return n.decodePayloadAsBinary(t, e, r);
                    "function" == typeof e && (r = e, e = null);
                    var o;
                    if ("" == t) return r(v, 0, 1);
                    for (var i, s, a = "", c = 0, p = t.length; p > c; c++) {
                        var u = t.charAt(c);
                        if (":" != u) a += u;
                        else {
                            if ("" == a || a != (i = Number(a))) return r(v, 0, 1);
                            if (s = t.substr(c + 1, i), a != s.length) return r(v, 0, 1);
                            if (s.length) {
                                if (o = n.decodePacket(s, e, !0), v.type == o.type && v.data == o.data) return r(v, 0, 1);
                                var f = r(o, c + i, p);
                                if (!1 === f) return
                            }
                            c += i, a = ""
                        }
                    }
                    return "" != a ? r(v, 0, 1) : void 0
                }, n.encodePayloadAsArrayBuffer = function(t, e) {
                    function r(t, e) {
                        n.encodePacket(t, !0, !0, function(t) {
                            return e(null, t)
                        })
                    }
                    return t.length ? void a(t, r, function(t, n) {
                        var r = n.reduce(function(t, e) {
                                var n;
                                return n = "string" == typeof e ? e.length : e.byteLength, t + n.toString().length + n + 2
                            }, 0),
                            o = new Uint8Array(r),
                            i = 0;
                        return n.forEach(function(t) {
                            var e = "string" == typeof t,
                                n = t;
                            if (e) {
                                for (var r = new Uint8Array(t.length), s = 0; s < t.length; s++) r[s] = t.charCodeAt(s);
                                n = r.buffer
                            }
                            e ? o[i++] = 0 : o[i++] = 1;
                            for (var a = n.byteLength.toString(), s = 0; s < a.length; s++) o[i++] = parseInt(a[s]);
                            o[i++] = 255;
                            for (var r = new Uint8Array(n), s = 0; s < r.length; s++) o[i++] = r[s]
                        }), e(o.buffer)
                    }) : e(new ArrayBuffer(0))
                }, n.encodePayloadAsBlob = function(t, e) {
                    function r(t, e) {
                        n.encodePacket(t, !0, !0, function(t) {
                            var n = new Uint8Array(1);
                            if (n[0] = 1, "string" == typeof t) {
                                for (var r = new Uint8Array(t.length), o = 0; o < t.length; o++) r[o] = t.charCodeAt(o);
                                t = r.buffer, n[0] = 0
                            }
                            for (var i = t instanceof ArrayBuffer ? t.byteLength : t.size, s = i.toString(), a = new Uint8Array(s.length + 1), o = 0; o < s.length; o++) a[o] = parseInt(s[o]);
                            if (a[s.length] = 255, w) {
                                var c = new w([n.buffer, a.buffer, t]);
                                e(null, c)
                            }
                        })
                    }
                    a(t, r, function(t, n) {
                        return e(new w(n))
                    })
                }, n.decodePayloadAsBinary = function(t, e, r) {
                    "function" == typeof e && (r = e, e = null);
                    for (var o = t, i = [], s = !1; o.byteLength > 0;) {
                        for (var a = new Uint8Array(o), c = 0 === a[0], p = "", f = 1; 255 != a[f]; f++) {
                            if (p.length > 310) {
                                s = !0;
                                break
                            }
                            p += a[f]
                        }
                        if (s) return r(v, 0, 1);
                        o = u(o, 2 + p.length), p = parseInt(p);
                        var h = u(o, 0, p);
                        if (c) try {
                            h = String.fromCharCode.apply(null, new Uint8Array(h))
                        } catch (l) {
                            var d = new Uint8Array(h);
                            h = "";
                            for (var f = 0; f < d.length; f++) h += String.fromCharCode(d[f])
                        }
                        i.push(h), o = u(o, p)
                    }
                    var y = i.length;
                    i.forEach(function(t, o) {
                        r(n.decodePacket(t, e, !0), o, y)
                    })
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./keys": 20,
            after: 11,
            "arraybuffer.slice": 12,
            "base64-arraybuffer": 13,
            blob: 14,
            "has-binary": 21,
            utf8: 29
        }],
        20: [function(t, e, n) {
            e.exports = Object.keys || function(t) {
                var e = [],
                    n = Object.prototype.hasOwnProperty;
                for (var r in t) n.call(t, r) && e.push(r);
                return e
            }
        }, {}],
        21: [function(t, e, n) {
            (function(n) {
                function r(t) {
                    function e(t) {
                        if (!t) return !1;
                        if (n.Buffer && n.Buffer.isBuffer(t) || n.ArrayBuffer && t instanceof ArrayBuffer || n.Blob && t instanceof Blob || n.File && t instanceof File) return !0;
                        if (o(t)) {
                            for (var r = 0; r < t.length; r++)
                                if (e(t[r])) return !0
                        } else if (t && "object" == typeof t) {
                            t.toJSON && (t = t.toJSON());
                            for (var i in t)
                                if (Object.prototype.hasOwnProperty.call(t, i) && e(t[i])) return !0
                        }
                        return !1
                    }
                    return e(t)
                }
                var o = t("isarray");
                e.exports = r
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            isarray: 24
        }],
        22: [function(t, e, n) {
            try {
                e.exports = "undefined" != typeof XMLHttpRequest && "withCredentials" in new XMLHttpRequest
            } catch (r) {
                e.exports = !1
            }
        }, {}],
        23: [function(t, e, n) {
            var r = [].indexOf;
            e.exports = function(t, e) {
                if (r) return t.indexOf(e);
                for (var n = 0; n < t.length; ++n)
                    if (t[n] === e) return n;
                return -1
            }
        }, {}],
        24: [function(t, e, n) {
            e.exports = Array.isArray || function(t) {
                return "[object Array]" == Object.prototype.toString.call(t)
            }
        }, {}],
        25: [function(t, e, n) {
            function r(t) {
                if (t = "" + t, !(t.length > 1e4)) {
                    var e = /^((?:\d+)?\.?\d+) *(milliseconds?|msecs?|ms|seconds?|secs?|s|minutes?|mins?|m|hours?|hrs?|h|days?|d|years?|yrs?|y)?$/i.exec(t);
                    if (e) {
                        var n = parseFloat(e[1]),
                            r = (e[2] || "ms").toLowerCase();
                        switch (r) {
                            case "years":
                            case "year":
                            case "yrs":
                            case "yr":
                            case "y":
                                return n * f;
                            case "days":
                            case "day":
                            case "d":
                                return n * u;
                            case "hours":
                            case "hour":
                            case "hrs":
                            case "hr":
                            case "h":
                                return n * p;
                            case "minutes":
                            case "minute":
                            case "mins":
                            case "min":
                            case "m":
                                return n * c;
                            case "seconds":
                            case "second":
                            case "secs":
                            case "sec":
                            case "s":
                                return n * a;
                            case "milliseconds":
                            case "millisecond":
                            case "msecs":
                            case "msec":
                            case "ms":
                                return n
                        }
                    }
                }
            }

            function o(t) {
                return t >= u ? Math.round(t / u) + "d" : t >= p ? Math.round(t / p) + "h" : t >= c ? Math.round(t / c) + "m" : t >= a ? Math.round(t / a) + "s" : t + "ms"
            }

            function i(t) {
                return s(t, u, "day") || s(t, p, "hour") || s(t, c, "minute") || s(t, a, "second") || t + " ms"
            }

            function s(t, e, n) {
                return e > t ? void 0 : 1.5 * e > t ? Math.floor(t / e) + " " + n : Math.ceil(t / e) + " " + n + "s"
            }
            var a = 1e3,
                c = 60 * a,
                p = 60 * c,
                u = 24 * p,
                f = 365.25 * u;
            e.exports = function(t, e) {
                return e = e || {}, "string" == typeof t ? r(t) : e["long"] ? i(t) : o(t)
            }
        }, {}],
        26: [function(t, e, n) {
            (function(t) {
                var n = /^[\],:{}\s]*$/,
                    r = /\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,
                    o = /"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
                    i = /(?:^|:|,)(?:\s*\[)+/g,
                    s = /^\s+/,
                    a = /\s+$/;
                e.exports = function(e) {
                    return "string" == typeof e && e ? (e = e.replace(s, "").replace(a, ""), t.JSON && JSON.parse ? JSON.parse(e) : n.test(e.replace(r, "@").replace(o, "]").replace(i, "")) ? new Function("return " + e)() : void 0) : null
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {}],
        27: [function(t, e, n) {
            n.encode = function(t) {
                var e = "";
                for (var n in t) t.hasOwnProperty(n) && (e.length && (e += "&"), e += encodeURIComponent(n) + "=" + encodeURIComponent(t[n]));
                return e
            }, n.decode = function(t) {
                for (var e = {}, n = t.split("&"), r = 0, o = n.length; o > r; r++) {
                    var i = n[r].split("=");
                    e[decodeURIComponent(i[0])] = decodeURIComponent(i[1])
                }
                return e
            }
        }, {}],
        28: [function(t, e, n) {
            var r = /^(?:(?![^:@]+:[^:@\/]*@)(http|https|ws|wss):\/\/)?((?:(([^:@]*)(?::([^:@]*))?)?@)?((?:[a-f0-9]{0,4}:){2,7}[a-f0-9]{0,4}|[^:\/?#]*)(?::(\d*))?)(((\/(?:[^?#](?![^?#\/]*\.[^?#\/.]+(?:[?#]|$)))*\/?)?([^?#\/]*))(?:\?([^#]*))?(?:#(.*))?)/,
                o = ["source", "protocol", "authority", "userInfo", "user", "password", "host", "port", "relative", "path", "directory", "file", "query", "anchor"];
            e.exports = function(t) {
                var e = t,
                    n = t.indexOf("["),
                    i = t.indexOf("]"); - 1 != n && -1 != i && (t = t.substring(0, n) + t.substring(n, i).replace(/:/g, ";") + t.substring(i, t.length));
                for (var s = r.exec(t || ""), a = {}, c = 14; c--;) a[o[c]] = s[c] || "";
                return -1 != n && -1 != i && (a.source = e, a.host = a.host.substring(1, a.host.length - 1).replace(/;/g, ":"), a.authority = a.authority.replace("[", "").replace("]", "").replace(/;/g, ":"), a.ipv6uri = !0), a
            }
        }, {}],
        29: [function(e, n, r) {
            (function(e) {
                ! function(o) {
                    function i(t) {
                        for (var e, n, r = [], o = 0, i = t.length; i > o;) e = t.charCodeAt(o++), e >= 55296 && 56319 >= e && i > o ? (n = t.charCodeAt(o++), 56320 == (64512 & n) ? r.push(((1023 & e) << 10) + (1023 & n) + 65536) : (r.push(e), o--)) : r.push(e);
                        return r
                    }

                    function s(t) {
                        for (var e, n = t.length, r = -1, o = ""; ++r < n;) e = t[r], e > 65535 && (e -= 65536, o += w(e >>> 10 & 1023 | 55296), e = 56320 | 1023 & e), o += w(e);
                        return o
                    }

                    function a(t) {
                        if (t >= 55296 && 57343 >= t) throw Error("Lone surrogate U+" + t.toString(16).toUpperCase() + " is not a scalar value")
                    }

                    function c(t, e) {
                        return w(t >> e & 63 | 128)
                    }

                    function p(t) {
                        if (0 == (4294967168 & t)) return w(t);
                        var e = "";
                        return 0 == (4294965248 & t) ? e = w(t >> 6 & 31 | 192) : 0 == (4294901760 & t) ? (a(t), e = w(t >> 12 & 15 | 224), e += c(t, 6)) : 0 == (4292870144 & t) && (e = w(t >> 18 & 7 | 240), e += c(t, 12), e += c(t, 6)), e += w(63 & t | 128)
                    }

                    function u(t) {
                        for (var e, n = i(t), r = n.length, o = -1, s = ""; ++o < r;) e = n[o], s += p(e);
                        return s
                    }

                    function f() {
                        if (v >= b) throw Error("Invalid byte index");
                        var t = 255 & m[v];
                        if (v++, 128 == (192 & t)) return 63 & t;
                        throw Error("Invalid continuation byte")
                    }

                    function h() {
                        var t, e, n, r, o;
                        if (v > b) throw Error("Invalid byte index");
                        if (v == b) return !1;
                        if (t = 255 & m[v], v++, 0 == (128 & t)) return t;
                        if (192 == (224 & t)) {
                            var e = f();
                            if (o = (31 & t) << 6 | e, o >= 128) return o;
                            throw Error("Invalid continuation byte")
                        }
                        if (224 == (240 & t)) {
                            if (e = f(), n = f(), o = (15 & t) << 12 | e << 6 | n, o >= 2048) return a(o), o;
                            throw Error("Invalid continuation byte")
                        }
                        if (240 == (248 & t) && (e = f(), n = f(), r = f(), o = (15 & t) << 18 | e << 12 | n << 6 | r, o >= 65536 && 1114111 >= o)) return o;
                        throw Error("Invalid UTF-8 detected")
                    }

                    function l(t) {
                        m = i(t), b = m.length, v = 0;
                        for (var e, n = [];
                            (e = h()) !== !1;) n.push(e);
                        return s(n)
                    }
                    var d = "object" == typeof r && r,
                        y = "object" == typeof n && n && n.exports == d && n,
                        g = "object" == typeof e && e;
                    (g.global === g || g.window === g) && (o = g);
                    var m, b, v, w = String.fromCharCode,
                        k = {
                            version: "2.0.0",
                            encode: u,
                            decode: l
                        };
                    if ("function" == typeof t && "object" == typeof t.amd && t.amd) t(function() {
                        return k
                    });
                    else if (d && !d.nodeType)
                        if (y) y.exports = k;
                        else {
                            var x = {},
                                A = x.hasOwnProperty;
                            for (var B in k) A.call(k, B) && (d[B] = k[B])
                        }
                    else o.utf8 = k
                }(this)
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {}],
        30: [function(t, e, n) {
            "use strict";

            function r(t) {
                var e = "";
                do e = a[t % c] + e, t = Math.floor(t / c); while (t > 0);
                return e
            }

            function o(t) {
                var e = 0;
                for (f = 0; f < t.length; f++) e = e * c + p[t.charAt(f)];
                return e
            }

            function i() {
                var t = r(+new Date);
                return t !== s ? (u = 0, s = t) : t + "." + r(u++)
            }
            for (var s, a = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz-_".split(""), c = 64, p = {}, u = 0, f = 0; c > f; f++) p[a[f]] = f;
            i.encode = r, i.decode = o, e.exports = i
        }, {}],
        31: [function(t, e, n) {
            function r(t, e) {
                "object" == typeof t && (e = t, t = void 0), e = e || {};
                var n, r = o(t),
                    i = r.source,
                    p = r.id,
                    u = r.path,
                    f = c[p] && u in c[p].nsps,
                    h = e.forceNew || e["force new connection"] || !1 === e.multiplex || f;
                return h ? (a("ignoring socket cache for %s", i), n = s(i, e)) : (c[p] || (a("new io instance for %s", i), c[p] = s(i, e)), n = c[p]), n.socket(r.path)
            }
            var o = t("./url"),
                i = t("socket.io-parser"),
                s = t("./manager"),
                a = t("debug")("socket.io-client");
            e.exports = n = r;
            var c = n.managers = {};
            n.protocol = i.protocol, n.connect = r, n.Manager = t("./manager"), n.Socket = t("./socket")
        }, {
            "./manager": 32,
            "./socket": 34,
            "./url": 35,
            debug: 39,
            "socket.io-parser": 47
        }],
        32: [function(t, e, n) {
            function r(t, e) {
                return this instanceof r ? (t && "object" == typeof t && (e = t, t = void 0), e = e || {}, e.path = e.path || "/socket.io", this.nsps = {}, this.subs = [], this.opts = e, this.reconnection(e.reconnection !== !1), this.reconnectionAttempts(e.reconnectionAttempts || 1 / 0), this.reconnectionDelay(e.reconnectionDelay || 1e3), this.reconnectionDelayMax(e.reconnectionDelayMax || 5e3), this.randomizationFactor(e.randomizationFactor || .5), this.backoff = new h({
                    min: this.reconnectionDelay(),
                    max: this.reconnectionDelayMax(),
                    jitter: this.randomizationFactor()
                }), this.timeout(null == e.timeout ? 2e4 : e.timeout), this.readyState = "closed", this.uri = t, this.connecting = [], this.lastPing = null, this.encoding = !1, this.packetBuffer = [], this.encoder = new a.Encoder, this.decoder = new a.Decoder, this.autoConnect = e.autoConnect !== !1, void(this.autoConnect && this.open())) : new r(t, e)
            }
            var o = t("engine.io-client"),
                i = t("./socket"),
                s = t("component-emitter"),
                a = t("socket.io-parser"),
                c = t("./on"),
                p = t("component-bind"),
                u = t("debug")("socket.io-client:manager"),
                f = t("indexof"),
                h = t("backo2"),
                l = Object.prototype.hasOwnProperty;
            e.exports = r, r.prototype.emitAll = function() {
                this.emit.apply(this, arguments);
                for (var t in this.nsps) l.call(this.nsps, t) && this.nsps[t].emit.apply(this.nsps[t], arguments)
            }, r.prototype.updateSocketIds = function() {
                for (var t in this.nsps) l.call(this.nsps, t) && (this.nsps[t].id = this.engine.id)
            }, s(r.prototype), r.prototype.reconnection = function(t) {
                return arguments.length ? (this._reconnection = !!t, this) : this._reconnection
            }, r.prototype.reconnectionAttempts = function(t) {
                return arguments.length ? (this._reconnectionAttempts = t, this) : this._reconnectionAttempts
            }, r.prototype.reconnectionDelay = function(t) {
                return arguments.length ? (this._reconnectionDelay = t, this.backoff && this.backoff.setMin(t), this) : this._reconnectionDelay
            }, r.prototype.randomizationFactor = function(t) {
                return arguments.length ? (this._randomizationFactor = t, this.backoff && this.backoff.setJitter(t), this) : this._randomizationFactor
            }, r.prototype.reconnectionDelayMax = function(t) {
                return arguments.length ? (this._reconnectionDelayMax = t, this.backoff && this.backoff.setMax(t), this) : this._reconnectionDelayMax
            }, r.prototype.timeout = function(t) {
                return arguments.length ? (this._timeout = t, this) : this._timeout
            }, r.prototype.maybeReconnectOnOpen = function() {
                !this.reconnecting && this._reconnection && 0 === this.backoff.attempts && this.reconnect()
            }, r.prototype.open = r.prototype.connect = function(t) {
                if (u("readyState %s", this.readyState), ~this.readyState.indexOf("open")) return this;
                u("opening %s", this.uri), this.engine = o(this.uri, this.opts);
                var e = this.engine,
                    n = this;
                this.readyState = "opening", this.skipReconnect = !1;
                var r = c(e, "open", function() {
                        n.onopen(), t && t()
                    }),
                    i = c(e, "error", function(e) {
                        if (u("connect_error"), n.cleanup(), n.readyState = "closed", n.emitAll("connect_error", e), t) {
                            var r = new Error("Connection error");
                            r.data = e, t(r)
                        } else n.maybeReconnectOnOpen()
                    });
                if (!1 !== this._timeout) {
                    var s = this._timeout;
                    u("connect attempt will timeout after %d", s);
                    var a = setTimeout(function() {
                        u("connect attempt timed out after %d", s), r.destroy(), e.close(), e.emit("error", "timeout"), n.emitAll("connect_timeout", s)
                    }, s);
                    this.subs.push({
                        destroy: function() {
                            clearTimeout(a)
                        }
                    })
                }
                return this.subs.push(r), this.subs.push(i), this
            }, r.prototype.onopen = function() {
                u("open"), this.cleanup(), this.readyState = "open", this.emit("open");
                var t = this.engine;
                this.subs.push(c(t, "data", p(this, "ondata"))), this.subs.push(c(t, "ping", p(this, "onping"))), this.subs.push(c(t, "pong", p(this, "onpong"))), this.subs.push(c(t, "error", p(this, "onerror"))), this.subs.push(c(t, "close", p(this, "onclose"))), this.subs.push(c(this.decoder, "decoded", p(this, "ondecoded")))
            }, r.prototype.onping = function() {
                this.lastPing = new Date, this.emitAll("ping")
            }, r.prototype.onpong = function() {
                this.emitAll("pong", new Date - this.lastPing)
            }, r.prototype.ondata = function(t) {
                this.decoder.add(t)
            }, r.prototype.ondecoded = function(t) {
                this.emit("packet", t)
            }, r.prototype.onerror = function(t) {
                u("error", t), this.emitAll("error", t)
            }, r.prototype.socket = function(t) {
                function e() {
                    ~f(r.connecting, n) || r.connecting.push(n)
                }
                var n = this.nsps[t];
                if (!n) {
                    n = new i(this, t), this.nsps[t] = n;
                    var r = this;
                    n.on("connecting", e), n.on("connect", function() {
                        n.id = r.engine.id
                    }), this.autoConnect && e()
                }
                return n
            }, r.prototype.destroy = function(t) {
                var e = f(this.connecting, t);
                ~e && this.connecting.splice(e, 1), this.connecting.length || this.close()
            }, r.prototype.packet = function(t) {
                u("writing packet %j", t);
                var e = this;
                e.encoding ? e.packetBuffer.push(t) : (e.encoding = !0, this.encoder.encode(t, function(n) {
                    for (var r = 0; r < n.length; r++) e.engine.write(n[r], t.options);
                    e.encoding = !1, e.processPacketQueue()
                }))
            }, r.prototype.processPacketQueue = function() {
                if (this.packetBuffer.length > 0 && !this.encoding) {
                    var t = this.packetBuffer.shift();
                    this.packet(t)
                }
            }, r.prototype.cleanup = function() {
                u("cleanup");
                for (var t; t = this.subs.shift();) t.destroy();
                this.packetBuffer = [], this.encoding = !1, this.lastPing = null, this.decoder.destroy()
            }, r.prototype.close = r.prototype.disconnect = function() {
                u("disconnect"), this.skipReconnect = !0, this.reconnecting = !1, "opening" == this.readyState && this.cleanup(), this.backoff.reset(), this.readyState = "closed", this.engine && this.engine.close()
            }, r.prototype.onclose = function(t) {
                u("onclose"), this.cleanup(), this.backoff.reset(), this.readyState = "closed", this.emit("close", t), this._reconnection && !this.skipReconnect && this.reconnect()
            }, r.prototype.reconnect = function() {
                if (this.reconnecting || this.skipReconnect) return this;
                var t = this;
                if (this.backoff.attempts >= this._reconnectionAttempts) u("reconnect failed"), this.backoff.reset(), this.emitAll("reconnect_failed"), this.reconnecting = !1;
                else {
                    var e = this.backoff.duration();
                    u("will wait %dms before reconnect attempt", e), this.reconnecting = !0;
                    var n = setTimeout(function() {
                        t.skipReconnect || (u("attempting reconnect"), t.emitAll("reconnect_attempt", t.backoff.attempts), t.emitAll("reconnecting", t.backoff.attempts), t.skipReconnect || t.open(function(e) {
                            e ? (u("reconnect attempt error"), t.reconnecting = !1, t.reconnect(), t.emitAll("reconnect_error", e.data)) : (u("reconnect success"), t.onreconnect())
                        }))
                    }, e);
                    this.subs.push({
                        destroy: function() {
                            clearTimeout(n)
                        }
                    })
                }
            }, r.prototype.onreconnect = function() {
                var t = this.backoff.attempts;
                this.reconnecting = !1, this.backoff.reset(), this.updateSocketIds(), this.emitAll("reconnect", t)
            }
        }, {
            "./on": 33,
            "./socket": 34,
            backo2: 36,
            "component-bind": 37,
            "component-emitter": 38,
            debug: 39,
            "engine.io-client": 1,
            indexof: 42,
            "socket.io-parser": 47
        }],
        33: [function(t, e, n) {
            function r(t, e, n) {
                return t.on(e, n), {
                    destroy: function() {
                        t.removeListener(e, n)
                    }
                }
            }
            e.exports = r
        }, {}],
        34: [function(t, e, n) {
            function r(t, e) {
                this.io = t, this.nsp = e, this.json = this, this.ids = 0, this.acks = {}, this.receiveBuffer = [], this.sendBuffer = [], this.connected = !1, this.disconnected = !0, this.io.autoConnect && this.open()
            }
            var o = t("socket.io-parser"),
                i = t("component-emitter"),
                s = t("to-array"),
                a = t("./on"),
                c = t("component-bind"),
                p = t("debug")("socket.io-client:socket"),
                u = t("has-binary");
            e.exports = n = r;
            var f = {
                    connect: 1,
                    connect_error: 1,
                    connect_timeout: 1,
                    connecting: 1,
                    disconnect: 1,
                    error: 1,
                    reconnect: 1,
                    reconnect_attempt: 1,
                    reconnect_failed: 1,
                    reconnect_error: 1,
                    reconnecting: 1,
                    ping: 1,
                    pong: 1
                },
                h = i.prototype.emit;
            i(r.prototype), r.prototype.subEvents = function() {
                if (!this.subs) {
                    var t = this.io;
                    this.subs = [a(t, "open", c(this, "onopen")), a(t, "packet", c(this, "onpacket")), a(t, "close", c(this, "onclose"))]
                }
            }, r.prototype.open = r.prototype.connect = function() {
                return this.connected ? this : (this.subEvents(), this.io.open(), "open" == this.io.readyState && this.onopen(), this.emit("connecting"), this)
            }, r.prototype.send = function() {
                var t = s(arguments);
                return t.unshift("message"), this.emit.apply(this, t), this
            }, r.prototype.emit = function(t) {
                if (f.hasOwnProperty(t)) return h.apply(this, arguments), this;
                var e = s(arguments),
                    n = o.EVENT;
                u(e) && (n = o.BINARY_EVENT);
                var r = {
                    type: n,
                    data: e
                };
                return r.options = {}, r.options.compress = !this.flags || !1 !== this.flags.compress, "function" == typeof e[e.length - 1] && (p("emitting packet with ack id %d", this.ids), this.acks[this.ids] = e.pop(), r.id = this.ids++), this.connected ? this.packet(r) : this.sendBuffer.push(r), delete this.flags, this
            }, r.prototype.packet = function(t) {
                t.nsp = this.nsp, this.io.packet(t)
            }, r.prototype.onopen = function() {
                p("transport is open - connecting"), "/" != this.nsp && this.packet({
                    type: o.CONNECT
                })
            }, r.prototype.onclose = function(t) {
                p("close (%s)", t), this.connected = !1, this.disconnected = !0, delete this.id, this.emit("disconnect", t)
            }, r.prototype.onpacket = function(t) {
                if (t.nsp == this.nsp) switch (t.type) {
                    case o.CONNECT:
                        this.onconnect();
                        break;
                    case o.EVENT:
                        this.onevent(t);
                        break;
                    case o.BINARY_EVENT:
                        this.onevent(t);
                        break;
                    case o.ACK:
                        this.onack(t);
                        break;
                    case o.BINARY_ACK:
                        this.onack(t);
                        break;
                    case o.DISCONNECT:
                        this.ondisconnect();
                        break;
                    case o.ERROR:
                        this.emit("error", t.data)
                }
            }, r.prototype.onevent = function(t) {
                var e = t.data || [];
                p("emitting event %j", e), null != t.id && (p("attaching ack callback to event"), e.push(this.ack(t.id))), this.connected ? h.apply(this, e) : this.receiveBuffer.push(e)
            }, r.prototype.ack = function(t) {
                var e = this,
                    n = !1;
                return function() {
                    if (!n) {
                        n = !0;
                        var r = s(arguments);
                        p("sending ack %j", r);
                        var i = u(r) ? o.BINARY_ACK : o.ACK;
                        e.packet({
                            type: i,
                            id: t,
                            data: r
                        })
                    }
                }
            }, r.prototype.onack = function(t) {
                var e = this.acks[t.id];
                "function" == typeof e ? (p("calling ack %s with %j", t.id, t.data), e.apply(this, t.data), delete this.acks[t.id]) : p("bad ack %s", t.id)
            }, r.prototype.onconnect = function() {
                this.connected = !0, this.disconnected = !1, this.emit("connect"), this.emitBuffered()
            }, r.prototype.emitBuffered = function() {
                var t;
                for (t = 0; t < this.receiveBuffer.length; t++) h.apply(this, this.receiveBuffer[t]);
                for (this.receiveBuffer = [], t = 0; t < this.sendBuffer.length; t++) this.packet(this.sendBuffer[t]);
                this.sendBuffer = []
            }, r.prototype.ondisconnect = function() {
                p("server disconnect (%s)", this.nsp), this.destroy(), this.onclose("io server disconnect")
            }, r.prototype.destroy = function() {
                if (this.subs) {
                    for (var t = 0; t < this.subs.length; t++) this.subs[t].destroy();
                    this.subs = null
                }
                this.io.destroy(this)
            }, r.prototype.close = r.prototype.disconnect = function() {
                return this.connected && (p("performing disconnect (%s)", this.nsp), this.packet({
                    type: o.DISCONNECT
                })), this.destroy(), this.connected && this.onclose("io client disconnect"), this
            }, r.prototype.compress = function(t) {
                return this.flags = this.flags || {}, this.flags.compress = t, this
            }
        }, {
            "./on": 33,
            "component-bind": 37,
            "component-emitter": 38,
            debug: 39,
            "has-binary": 41,
            "socket.io-parser": 47,
            "to-array": 51
        }],
        35: [function(t, e, n) {
            (function(n) {
                function r(t, e) {
                    var r = t,
                        e = e || n.location;
                    null == t && (t = e.protocol + "//" + e.host), "string" == typeof t && ("/" == t.charAt(0) && (t = "/" == t.charAt(1) ? e.protocol + t : e.host + t), /^(https?|wss?):\/\//.test(t) || (i("protocol-less url %s", t), t = "undefined" != typeof e ? e.protocol + "//" + t : "https://" + t), i("parse %s", t), r = o(t)), r.port || (/^(http|ws)$/.test(r.protocol) ? r.port = "80" : /^(http|ws)s$/.test(r.protocol) && (r.port = "443")), r.path = r.path || "/";
                    var s = -1 !== r.host.indexOf(":"),
                        a = s ? "[" + r.host + "]" : r.host;
                    return r.id = r.protocol + "://" + a + ":" + r.port, r.href = r.protocol + "://" + a + (e && e.port == r.port ? "" : ":" + r.port), r
                }
                var o = t("parseuri"),
                    i = t("debug")("socket.io-client:url");
                e.exports = r
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            debug: 39,
            parseuri: 45
        }],
        36: [function(t, e, n) {
            function r(t) {
                t = t || {}, this.ms = t.min || 100, this.max = t.max || 1e4, this.factor = t.factor || 2, this.jitter = t.jitter > 0 && t.jitter <= 1 ? t.jitter : 0, this.attempts = 0
            }
            e.exports = r, r.prototype.duration = function() {
                var t = this.ms * Math.pow(this.factor, this.attempts++);
                if (this.jitter) {
                    var e = Math.random(),
                        n = Math.floor(e * this.jitter * t);
                    t = 0 == (1 & Math.floor(10 * e)) ? t - n : t + n
                }
                return 0 | Math.min(t, this.max)
            }, r.prototype.reset = function() {
                this.attempts = 0
            }, r.prototype.setMin = function(t) {
                this.ms = t
            }, r.prototype.setMax = function(t) {
                this.max = t
            }, r.prototype.setJitter = function(t) {
                this.jitter = t
            }
        }, {}],
        37: [function(t, e, n) {
            var r = [].slice;
            e.exports = function(t, e) {
                if ("string" == typeof e && (e = t[e]), "function" != typeof e) throw new Error("bind() requires a function");
                var n = r.call(arguments, 2);
                return function() {
                    return e.apply(t, n.concat(r.call(arguments)))
                }
            }
        }, {}],
        38: [function(t, e, n) {
            function r(t) {
                return t ? o(t) : void 0
            }

            function o(t) {
                for (var e in r.prototype) t[e] = r.prototype[e];
                return t
            }
            e.exports = r, r.prototype.on = r.prototype.addEventListener = function(t, e) {
                return this._callbacks = this._callbacks || {}, (this._callbacks["$" + t] = this._callbacks["$" + t] || []).push(e), this
            }, r.prototype.once = function(t, e) {
                function n() {
                    this.off(t, n), e.apply(this, arguments)
                }
                return n.fn = e, this.on(t, n), this
            }, r.prototype.off = r.prototype.removeListener = r.prototype.removeAllListeners = r.prototype.removeEventListener = function(t, e) {
                if (this._callbacks = this._callbacks || {}, 0 == arguments.length) return this._callbacks = {}, this;
                var n = this._callbacks["$" + t];
                if (!n) return this;
                if (1 == arguments.length) return delete this._callbacks["$" + t], this;
                for (var r, o = 0; o < n.length; o++)
                    if (r = n[o], r === e || r.fn === e) {
                        n.splice(o, 1);
                        break
                    }
                return this
            }, r.prototype.emit = function(t) {
                this._callbacks = this._callbacks || {};
                var e = [].slice.call(arguments, 1),
                    n = this._callbacks["$" + t];
                if (n) {
                    n = n.slice(0);
                    for (var r = 0, o = n.length; o > r; ++r) n[r].apply(this, e)
                }
                return this
            }, r.prototype.listeners = function(t) {
                return this._callbacks = this._callbacks || {}, this._callbacks["$" + t] || []
            }, r.prototype.hasListeners = function(t) {
                return !!this.listeners(t).length
            }
        }, {}],
        39: [function(t, e, n) {
            arguments[4][17][0].apply(n, arguments)
        }, {
            "./debug": 40,
            dup: 17
        }],
        40: [function(t, e, n) {
            arguments[4][18][0].apply(n, arguments)
        }, {
            dup: 18,
            ms: 44
        }],
        41: [function(t, e, n) {
            (function(n) {
                function r(t) {
                    function e(t) {
                        if (!t) return !1;
                        if (n.Buffer && n.Buffer.isBuffer && n.Buffer.isBuffer(t) || n.ArrayBuffer && t instanceof ArrayBuffer || n.Blob && t instanceof Blob || n.File && t instanceof File) return !0;
                        if (o(t)) {
                            for (var r = 0; r < t.length; r++)
                                if (e(t[r])) return !0
                        } else if (t && "object" == typeof t) {
                            t.toJSON && "function" == typeof t.toJSON && (t = t.toJSON());
                            for (var i in t)
                                if (Object.prototype.hasOwnProperty.call(t, i) && e(t[i])) return !0
                        }
                        return !1
                    }
                    return e(t)
                }
                var o = t("isarray");
                e.exports = r
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            isarray: 43
        }],
        42: [function(t, e, n) {
            arguments[4][23][0].apply(n, arguments)
        }, {
            dup: 23
        }],
        43: [function(t, e, n) {
            arguments[4][24][0].apply(n, arguments)
        }, {
            dup: 24
        }],
        44: [function(t, e, n) {
            arguments[4][25][0].apply(n, arguments)
        }, {
            dup: 25
        }],
        45: [function(t, e, n) {
            arguments[4][28][0].apply(n, arguments)
        }, {
            dup: 28
        }],
        46: [function(t, e, n) {
            (function(e) {
                var r = t("isarray"),
                    o = t("./is-buffer");
                n.deconstructPacket = function(t) {
                    function e(t) {
                        if (!t) return t;
                        if (o(t)) {
                            var i = {
                                _placeholder: !0,
                                num: n.length
                            };
                            return n.push(t), i
                        }
                        if (r(t)) {
                            for (var s = new Array(t.length), a = 0; a < t.length; a++) s[a] = e(t[a]);
                            return s
                        }
                        if ("object" == typeof t && !(t instanceof Date)) {
                            var s = {};
                            for (var c in t) s[c] = e(t[c]);
                            return s
                        }
                        return t
                    }
                    var n = [],
                        i = t.data,
                        s = t;
                    return s.data = e(i), s.attachments = n.length, {
                        packet: s,
                        buffers: n
                    }
                }, n.reconstructPacket = function(t, e) {
                    function n(t) {
                        if (t && t._placeholder) {
                            var o = e[t.num];
                            return o
                        }
                        if (r(t)) {
                            for (var i = 0; i < t.length; i++) t[i] = n(t[i]);
                            return t
                        }
                        if (t && "object" == typeof t) {
                            for (var s in t) t[s] = n(t[s]);
                            return t
                        }
                        return t
                    }
                    return t.data = n(t.data), t.attachments = void 0, t
                }, n.removeBlobs = function(t, n) {
                    function i(t, c, p) {
                        if (!t) return t;
                        if (e.Blob && t instanceof Blob || e.File && t instanceof File) {
                            s++;
                            var u = new FileReader;
                            u.onload = function() {
                                p ? p[c] = this.result : a = this.result, --s || n(a)
                            }, u.readAsArrayBuffer(t)
                        } else if (r(t))
                            for (var f = 0; f < t.length; f++) i(t[f], f, t);
                        else if (t && "object" == typeof t && !o(t))
                            for (var h in t) i(t[h], h, t)
                    }
                    var s = 0,
                        a = t;
                    i(a), s || n(a)
                }
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {
            "./is-buffer": 48,
            isarray: 43
        }],
        47: [function(t, e, n) {
            function r() {}

            function o(t) {
                var e = "",
                    r = !1;
                return e += t.type, (n.BINARY_EVENT == t.type || n.BINARY_ACK == t.type) && (e += t.attachments, e += "-"), t.nsp && "/" != t.nsp && (r = !0, e += t.nsp), null != t.id && (r && (e += ",", r = !1), e += t.id), null != t.data && (r && (e += ","), e += f.stringify(t.data)), u("encoded %j as %s", t, e), e
            }

            function i(t, e) {
                function n(t) {
                    var n = l.deconstructPacket(t),
                        r = o(n.packet),
                        i = n.buffers;
                    i.unshift(r), e(i)
                }
                l.removeBlobs(t, n)
            }

            function s() {
                this.reconstructor = null
            }

            function a(t) {
                var e = {},
                    r = 0;
                if (e.type = Number(t.charAt(0)), null == n.types[e.type]) return p();
                if (n.BINARY_EVENT == e.type || n.BINARY_ACK == e.type) {
                    for (var o = "";
                        "-" != t.charAt(++r) && (o += t.charAt(r), r != t.length););
                    if (o != Number(o) || "-" != t.charAt(r)) throw new Error("Illegal attachments");
                    e.attachments = Number(o)
                }
                if ("/" == t.charAt(r + 1))
                    for (e.nsp = ""; ++r;) {
                        var i = t.charAt(r);
                        if ("," == i) break;
                        if (e.nsp += i, r == t.length) break
                    } else e.nsp = "/";
                var s = t.charAt(r + 1);
                if ("" !== s && Number(s) == s) {
                    for (e.id = ""; ++r;) {
                        var i = t.charAt(r);
                        if (null == i || Number(i) != i) {
                            --r;
                            break
                        }
                        if (e.id += t.charAt(r), r == t.length) break
                    }
                    e.id = Number(e.id)
                }
                if (t.charAt(++r)) try {
                    e.data = f.parse(t.substr(r))
                } catch (a) {
                    return p()
                }
                return u("decoded %s as %j", t, e), e
            }

            function c(t) {
                this.reconPack = t, this.buffers = []
            }

            function p(t) {
                return {
                    type: n.ERROR,
                    data: "parser error"
                }
            }
            var u = t("debug")("socket.io-parser"),
                f = t("json3"),
                h = (t("isarray"), t("component-emitter")),
                l = t("./binary"),
                d = t("./is-buffer");
            n.protocol = 4, n.types = ["CONNECT", "DISCONNECT", "EVENT", "BINARY_EVENT", "ACK", "BINARY_ACK", "ERROR"], n.CONNECT = 0, n.DISCONNECT = 1, n.EVENT = 2, n.ACK = 3, n.ERROR = 4, n.BINARY_EVENT = 5, n.BINARY_ACK = 6, n.Encoder = r, n.Decoder = s, r.prototype.encode = function(t, e) {
                if (u("encoding packet %j", t), n.BINARY_EVENT == t.type || n.BINARY_ACK == t.type) i(t, e);
                else {
                    var r = o(t);
                    e([r])
                }
            }, h(s.prototype), s.prototype.add = function(t) {
                var e;
                if ("string" == typeof t) e = a(t), n.BINARY_EVENT == e.type || n.BINARY_ACK == e.type ? (this.reconstructor = new c(e), 0 === this.reconstructor.reconPack.attachments && this.emit("decoded", e)) : this.emit("decoded", e);
                else {
                    if (!d(t) && !t.base64) throw new Error("Unknown type: " + t);
                    if (!this.reconstructor) throw new Error("got binary data when not reconstructing a packet");
                    e = this.reconstructor.takeBinaryData(t), e && (this.reconstructor = null, this.emit("decoded", e))
                }
            }, s.prototype.destroy = function() {
                this.reconstructor && this.reconstructor.finishedReconstruction()
            }, c.prototype.takeBinaryData = function(t) {
                if (this.buffers.push(t), this.buffers.length == this.reconPack.attachments) {
                    var e = l.reconstructPacket(this.reconPack, this.buffers);
                    return this.finishedReconstruction(), e
                }
                return null
            }, c.prototype.finishedReconstruction = function() {
                this.reconPack = null, this.buffers = []
            }
        }, {
            "./binary": 46,
            "./is-buffer": 48,
            "component-emitter": 49,
            debug: 39,
            isarray: 43,
            json3: 50
        }],
        48: [function(t, e, n) {
            (function(t) {
                function n(e) {
                    return t.Buffer && t.Buffer.isBuffer(e) || t.ArrayBuffer && e instanceof ArrayBuffer
                }
                e.exports = n
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {}],
        49: [function(t, e, n) {
            arguments[4][15][0].apply(n, arguments)
        }, {
            dup: 15
        }],
        50: [function(e, n, r) {
            (function(e) {
                (function() {
                    function o(t, e) {
                        function n(t) {
                            if (n[t] !== g) return n[t];
                            var o;
                            if ("bug-string-char-index" == t) o = "a" != "a" [0];
                            else if ("json" == t) o = n("json-stringify") && n("json-parse");
                            else {
                                var s, a = '{"a":[1,true,false,null,"\\u0000\\b\\n\\f\\r\\t"]}';
                                if ("json-stringify" == t) {
                                    var c = e.stringify,
                                        u = "function" == typeof c && v;
                                    if (u) {
                                        (s = function() {
                                            return 1
                                        }).toJSON = s;
                                        try {
                                            u = "0" === c(0) && "0" === c(new r) && '""' == c(new i) && c(b) === g && c(g) === g && c() === g && "1" === c(s) && "[1]" == c([s]) && "[null]" == c([g]) && "null" == c(null) && "[null,null,null]" == c([g, b, null]) && c({
                                                a: [s, !0, !1, null, "\x00\b\n\f\r	"]
                                            }) == a && "1" === c(null, s) && "[\n 1,\n 2\n]" == c([1, 2], null, 1) && '"-271821-04-20T00:00:00.000Z"' == c(new p(-864e13)) && '"+275760-09-13T00:00:00.000Z"' == c(new p(864e13)) && '"-000001-01-01T00:00:00.000Z"' == c(new p(-621987552e5)) && '"1969-12-31T23:59:59.999Z"' == c(new p(-1))
                                        } catch (f) {
                                            u = !1
                                        }
                                    }
                                    o = u
                                }
                                if ("json-parse" == t) {
                                    var h = e.parse;
                                    if ("function" == typeof h) try {
                                        if (0 === h("0") && !h(!1)) {
                                            s = h(a);
                                            var l = 5 == s.a.length && 1 === s.a[0];
                                            if (l) {
                                                try {
                                                    l = !h('"	"')
                                                } catch (f) {}
                                                if (l) try {
                                                    l = 1 !== h("01")
                                                } catch (f) {}
                                                if (l) try {
                                                    l = 1 !== h("1.")
                                                } catch (f) {}
                                            }
                                        }
                                    } catch (f) {
                                        l = !1
                                    }
                                    o = l
                                }
                            }
                            return n[t] = !!o
                        }
                        t || (t = c.Object()), e || (e = c.Object());
                        var r = t.Number || c.Number,
                            i = t.String || c.String,
                            a = t.Object || c.Object,
                            p = t.Date || c.Date,
                            u = t.SyntaxError || c.SyntaxError,
                            f = t.TypeError || c.TypeError,
                            h = t.Math || c.Math,
                            l = t.JSON || c.JSON;
                        "object" == typeof l && l && (e.stringify = l.stringify, e.parse = l.parse);
                        var d, y, g, m = a.prototype,
                            b = m.toString,
                            v = new p(-0xc782b5b800cec);
                        try {
                            v = -109252 == v.getUTCFullYear() && 0 === v.getUTCMonth() && 1 === v.getUTCDate() && 10 == v.getUTCHours() && 37 == v.getUTCMinutes() && 6 == v.getUTCSeconds() && 708 == v.getUTCMilliseconds()
                        } catch (w) {}
                        if (!n("json")) {
                            var k = "[object Function]",
                                x = "[object Date]",
                                A = "[object Number]",
                                B = "[object String]",
                                C = "[object Array]",
                                S = "[object Boolean]",
                                E = n("bug-string-char-index");
                            if (!v) var _ = h.floor,
                                T = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
                                O = function(t, e) {
                                    return T[e] + 365 * (t - 1970) + _((t - 1969 + (e = +(e > 1))) / 4) - _((t - 1901 + e) / 100) + _((t - 1601 + e) / 400)
                                };
                            if ((d = m.hasOwnProperty) || (d = function(t) {
                                    var e, n = {};
                                    return (n.__proto__ = null, n.__proto__ = {
                                        toString: 1
                                    }, n).toString != b ? d = function(t) {
                                        var e = this.__proto__,
                                            n = t in (this.__proto__ = null, this);
                                        return this.__proto__ = e, n
                                    } : (e = n.constructor, d = function(t) {
                                        var n = (this.constructor || e).prototype;
                                        return t in this && !(t in n && this[t] === n[t])
                                    }), n = null, d.call(this, t)
                                }), y = function(t, e) {
                                    var n, r, o, i = 0;
                                    (n = function() {
                                        this.valueOf = 0
                                    }).prototype.valueOf = 0, r = new n;
                                    for (o in r) d.call(r, o) && i++;
                                    return n = r = null, i ? y = 2 == i ? function(t, e) {
                                        var n, r = {},
                                            o = b.call(t) == k;
                                        for (n in t) o && "prototype" == n || d.call(r, n) || !(r[n] = 1) || !d.call(t, n) || e(n)
                                    } : function(t, e) {
                                        var n, r, o = b.call(t) == k;
                                        for (n in t) o && "prototype" == n || !d.call(t, n) || (r = "constructor" === n) || e(n);
                                        (r || d.call(t, n = "constructor")) && e(n)
                                    } : (r = ["valueOf", "toString", "toLocaleString", "propertyIsEnumerable", "isPrototypeOf", "hasOwnProperty", "constructor"], y = function(t, e) {
                                        var n, o, i = b.call(t) == k,
                                            a = !i && "function" != typeof t.constructor && s[typeof t.hasOwnProperty] && t.hasOwnProperty || d;
                                        for (n in t) i && "prototype" == n || !a.call(t, n) || e(n);
                                        for (o = r.length; n = r[--o]; a.call(t, n) && e(n));
                                    }), y(t, e)
                                }, !n("json-stringify")) {
                                var j = {
                                        92: "\\\\",
                                        34: '\\"',
                                        8: "\\b",
                                        12: "\\f",
                                        10: "\\n",
                                        13: "\\r",
                                        9: "\\t"
                                    },
                                    P = "000000",
                                    N = function(t, e) {
                                        return (P + (e || 0)).slice(-t)
                                    },
                                    R = "\\u00",
                                    D = function(t) {
                                        for (var e = '"', n = 0, r = t.length, o = !E || r > 10, i = o && (E ? t.split("") : t); r > n; n++) {
                                            var s = t.charCodeAt(n);
                                            switch (s) {
                                                case 8:
                                                case 9:
                                                case 10:
                                                case 12:
                                                case 13:
                                                case 34:
                                                case 92:
                                                    e += j[s];
                                                    break;
                                                default:
                                                    if (32 > s) {
                                                        e += R + N(2, s.toString(16));
                                                        break
                                                    }
                                                    e += o ? i[n] : t.charAt(n)
                                            }
                                        }
                                        return e + '"'
                                    },
                                    U = function(t, e, n, r, o, i, s) {
                                        var a, c, p, u, h, l, m, v, w, k, E, T, j, P, R, q;
                                        try {
                                            a = e[t]
                                        } catch (L) {}
                                        if ("object" == typeof a && a)
                                            if (c = b.call(a), c != x || d.call(a, "toJSON")) "function" == typeof a.toJSON && (c != A && c != B && c != C || d.call(a, "toJSON")) && (a = a.toJSON(t));
                                            else if (a > -1 / 0 && 1 / 0 > a) {
                                            if (O) {
                                                for (h = _(a / 864e5), p = _(h / 365.2425) + 1970 - 1; O(p + 1, 0) <= h; p++);
                                                for (u = _((h - O(p, 0)) / 30.42); O(p, u + 1) <= h; u++);
                                                h = 1 + h - O(p, u), l = (a % 864e5 + 864e5) % 864e5, m = _(l / 36e5) % 24, v = _(l / 6e4) % 60, w = _(l / 1e3) % 60, k = l % 1e3
                                            } else p = a.getUTCFullYear(), u = a.getUTCMonth(), h = a.getUTCDate(), m = a.getUTCHours(), v = a.getUTCMinutes(), w = a.getUTCSeconds(), k = a.getUTCMilliseconds();
                                            a = (0 >= p || p >= 1e4 ? (0 > p ? "-" : "+") + N(6, 0 > p ? -p : p) : N(4, p)) + "-" + N(2, u + 1) + "-" + N(2, h) + "T" + N(2, m) + ":" + N(2, v) + ":" + N(2, w) + "." + N(3, k) + "Z"
                                        } else a = null;
                                        if (n && (a = n.call(e, t, a)), null === a) return "null";
                                        if (c = b.call(a), c == S) return "" + a;
                                        if (c == A) return a > -1 / 0 && 1 / 0 > a ? "" + a : "null";
                                        if (c == B) return D("" + a);
                                        if ("object" == typeof a) {
                                            for (P = s.length; P--;)
                                                if (s[P] === a) throw f();
                                            if (s.push(a), E = [], R = i, i += o, c == C) {
                                                for (j = 0, P = a.length; P > j; j++) T = U(j, a, n, r, o, i, s), E.push(T === g ? "null" : T);
                                                q = E.length ? o ? "[\n" + i + E.join(",\n" + i) + "\n" + R + "]" : "[" + E.join(",") + "]" : "[]"
                                            } else y(r || a, function(t) {
                                                var e = U(t, a, n, r, o, i, s);
                                                e !== g && E.push(D(t) + ":" + (o ? " " : "") + e)
                                            }), q = E.length ? o ? "{\n" + i + E.join(",\n" + i) + "\n" + R + "}" : "{" + E.join(",") + "}" : "{}";
                                            return s.pop(), q
                                        }
                                    };
                                e.stringify = function(t, e, n) {
                                    var r, o, i, a;
                                    if (s[typeof e] && e)
                                        if ((a = b.call(e)) == k) o = e;
                                        else if (a == C) {
                                        i = {};
                                        for (var c, p = 0, u = e.length; u > p; c = e[p++], a = b.call(c), (a == B || a == A) && (i[c] = 1));
                                    }
                                    if (n)
                                        if ((a = b.call(n)) == A) {
                                            if ((n -= n % 1) > 0)
                                                for (r = "", n > 10 && (n = 10); r.length < n; r += " ");
                                        } else a == B && (r = n.length <= 10 ? n : n.slice(0, 10));
                                    return U("", (c = {}, c[""] = t, c), o, i, r, "", [])
                                }
                            }
                            if (!n("json-parse")) {
                                var q, L, M = i.fromCharCode,
                                    I = {
                                        92: "\\",
                                        34: '"',
                                        47: "/",
                                        98: "\b",
                                        116: "	",
                                        110: "\n",
                                        102: "\f",
                                        114: "\r"
                                    },
                                    H = function() {
                                        throw q = L = null, u()
                                    },
                                    z = function() {
                                        for (var t, e, n, r, o, i = L, s = i.length; s > q;) switch (o = i.charCodeAt(q)) {
                                            case 9:
                                            case 10:
                                            case 13:
                                            case 32:
                                                q++;
                                                break;
                                            case 123:
                                            case 125:
                                            case 91:
                                            case 93:
                                            case 58:
                                            case 44:
                                                return t = E ? i.charAt(q) : i[q], q++, t;
                                            case 34:
                                                for (t = "@", q++; s > q;)
                                                    if (o = i.charCodeAt(q), 32 > o) H();
                                                    else if (92 == o) switch (o = i.charCodeAt(++q)) {
                                                    case 92:
                                                    case 34:
                                                    case 47:
                                                    case 98:
                                                    case 116:
                                                    case 110:
                                                    case 102:
                                                    case 114:
                                                        t += I[o], q++;
                                                        break;
                                                    case 117:
                                                        for (e = ++q, n = q + 4; n > q; q++) o = i.charCodeAt(q), o >= 48 && 57 >= o || o >= 97 && 102 >= o || o >= 65 && 70 >= o || H();
                                                        t += M("0x" + i.slice(e, q));
                                                        break;
                                                    default:
                                                        H()
                                                } else {
                                                    if (34 == o) break;
                                                    for (o = i.charCodeAt(q), e = q; o >= 32 && 92 != o && 34 != o;) o = i.charCodeAt(++q);
                                                    t += i.slice(e, q)
                                                }
                                                if (34 == i.charCodeAt(q)) return q++, t;
                                                H();
                                            default:
                                                if (e = q, 45 == o && (r = !0, o = i.charCodeAt(++q)), o >= 48 && 57 >= o) {
                                                    for (48 == o && (o = i.charCodeAt(q + 1), o >= 48 && 57 >= o) && H(), r = !1; s > q && (o = i.charCodeAt(q), o >= 48 && 57 >= o); q++);
                                                    if (46 == i.charCodeAt(q)) {
                                                        for (n = ++q; s > n && (o = i.charCodeAt(n), o >= 48 && 57 >= o); n++);
                                                        n == q && H(), q = n
                                                    }
                                                    if (o = i.charCodeAt(q), 101 == o || 69 == o) {
                                                        for (o = i.charCodeAt(++q), (43 == o || 45 == o) && q++, n = q; s > n && (o = i.charCodeAt(n), o >= 48 && 57 >= o); n++);
                                                        n == q && H(), q = n
                                                    }
                                                    return +i.slice(e, q)
                                                }
                                                if (r && H(), "true" == i.slice(q, q + 4)) return q += 4, !0;
                                                if ("false" == i.slice(q, q + 5)) return q += 5, !1;
                                                if ("null" == i.slice(q, q + 4)) return q += 4, null;
                                                H()
                                        }
                                        return "$"
                                    },
                                    J = function(t) {
                                        var e, n;
                                        if ("$" == t && H(), "string" == typeof t) {
                                            if ("@" == (E ? t.charAt(0) : t[0])) return t.slice(1);
                                            if ("[" == t) {
                                                for (e = []; t = z(), "]" != t; n || (n = !0)) n && ("," == t ? (t = z(), "]" == t && H()) : H()), "," == t && H(), e.push(J(t));
                                                return e
                                            }
                                            if ("{" == t) {
                                                for (e = {}; t = z(), "}" != t; n || (n = !0)) n && ("," == t ? (t = z(), "}" == t && H()) : H()), ("," == t || "string" != typeof t || "@" != (E ? t.charAt(0) : t[0]) || ":" != z()) && H(), e[t.slice(1)] = J(z());
                                                return e
                                            }
                                            H()
                                        }
                                        return t
                                    },
                                    X = function(t, e, n) {
                                        var r = F(t, e, n);
                                        r === g ? delete t[e] : t[e] = r
                                    },
                                    F = function(t, e, n) {
                                        var r, o = t[e];
                                        if ("object" == typeof o && o)
                                            if (b.call(o) == C)
                                                for (r = o.length; r--;) X(o, r, n);
                                            else y(o, function(t) {
                                                X(o, t, n)
                                            });
                                        return n.call(t, e, o)
                                    };
                                e.parse = function(t, e) {
                                    var n, r;
                                    return q = 0, L = "" + t, n = J(z()), "$" != z() && H(), q = L = null, e && b.call(e) == k ? F((r = {}, r[""] = n, r), "", e) : n
                                }
                            }
                        }
                        return e.runInContext = o, e
                    }
                    var i = "function" == typeof t && t.amd,
                        s = {
                            "function": !0,
                            object: !0
                        },
                        a = s[typeof r] && r && !r.nodeType && r,
                        c = s[typeof window] && window || this,
                        p = a && s[typeof n] && n && !n.nodeType && "object" == typeof e && e;
                    if (!p || p.global !== p && p.window !== p && p.self !== p || (c = p), a && !i) o(c, a);
                    else {
                        var u = c.JSON,
                            f = c.JSON3,
                            h = !1,
                            l = o(c, c.JSON3 = {
                                noConflict: function() {
                                    return h || (h = !0, c.JSON = u, c.JSON3 = f, u = f = null), l
                                }
                            });
                        c.JSON = {
                            parse: l.parse,
                            stringify: l.stringify
                        }
                    }
                    i && t(function() {
                        return l
                    })
                }).call(this)
            }).call(this, "undefined" != typeof self ? self : "undefined" != typeof window ? window : "undefined" != typeof global ? global : {})
        }, {}],
        51: [function(t, e, n) {
            function r(t, e) {
                var n = [];
                e = e || 0;
                for (var r = e || 0; r < t.length; r++) n[r - e] = t[r];
                return n
            }
            e.exports = r
        }, {}]
    }, {}, [31])(31)
});