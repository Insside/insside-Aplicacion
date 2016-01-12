var UvumiOdometer = new Class({
    Implements: [Options, Events],
    options: {
        counterClass: 'odometer',
        digits: 6,
        image: 'css/odometer.gif',
        overlay: 'css/overlay.png',
        startDuration: 1200,
        cruiseDuration: 100,
        transition: 'linear',
        onComplete: $empty,
        url: false,
        refreshRate: 10,
        indicatorClass: 'loading'
    },
    initialize: function(a, b) {
        this.counter = a;
        this.setOptions(b);
        window.addEvent('domready', this.domReady.bind(this))
    },
    domReady: function() {
        this.counter = $(this.counter);
        this.image = new Asset.image(this.options.image, {
            onload: this.build.bind(this)
        })
    },
    build: function() {
        this.fullHeight = this.image.height;
        this.height = (this.fullHeight / 10).toInt();
        this.width = this.image.width;
        var c = this.counter.get('html').clean().toInt();
        if (isNaN(c)) {
            c = 0
        }
        this.counter.empty().setStyles({
            width: this.options.digits * this.width,
            height: this.height,
            overflow: 'hidden',
            display: 'block',
            position: (this.counter.getStyle('position') == 'absolute' ? 'absolute' : 'relative')
        }).addClass(this.options.counterClass);
        this.counter.set('title', 'Double-click on counter to directly jump to final value');
        this.numbers = [];
        for (var i = 0; i < this.options.digits; i++) {
            var d = this.addNumber();
            d.inject(this.counter);
            this.numbers.push(d)
        }
        
        if (this.options.overlay) {
            this.overlay = Element('div', {
                styles: {
                    'position': 'absolute',
                    'top': 0,
                    'left': 0,
                    'width': '100%',
                    'height': this.height,
                    'font-size': 0,
                    'line-height': 0,
                    'background-image': 'url(' + this.options.overlay + ')',
                    'background-position': 'left center'
                }
            }).inject(this.counter)
        }
        this.clear = new Element('br', {
            styles: {
                'clear': 'right'
            }
        }).inject(this.counter);
        this.animation = new Fx.Elements(this.numbers, {
            link: 'chain',
            duration: this.options.startDuration,
            transition: this.options.transition,
            onStart: function() {
                this.animating = true;
                this.currentCount = this.currentCount + (this.direction ? 1 : -1);
                if (this.step <= this.mid) {
                    this.animation.options.duration = (this.options.startDuration - (1 - Math.exp(-this.step)) * this.durationVariation).toInt();
                    this.step++
                } else {
                    this.step++;
                    this.animation.options.duration = (this.options.startDuration - (1 - Math.exp(this.step - 2 * this.mid)) * this.durationVariation).toInt()
                }
            }.bind(this),
            onChainComplete: function() {
                this.animating = false;
                this.fireEvent('onComplete', this.value);
                (function() {
                    this.refreshed = false
                }).delay(this.options.refreshRate * 1000, this)
            }.bind(this)
        });
        this.durationVariation = this.options.startDuration - this.options.cruiseDuration;
        this.spins = [];
        this.setValue(c);
        if (this.options.url) {
            if (this.options.indicatorClass) {
                this.indicator = new Element('div', {
                    'class': this.options.indicatorClass
                })
            }
            this.request = new Request({
                url: this.options.url,
                autoCancel: true,
                onComplete: function(a) {
                    var b = a.toInt();
                    this.countTo(b);
                    if (this.indicator) {
                        (function() {
                            this.indicator.dispose()
                        }).delay(1000, this)
                    }
                }.bind(this)
            });
            this.refreshed = true;
            $(document.body).addEvent('mousemove', this.refresh.bind(this));
            (function() {
                this.refreshed = false
            }).delay(this.options.refreshRate * 1000, this)
        }
        this.counter.addEvent('dblclick', this.override.bind(this))
    },
    addNumber: function() {
        return number = new Element('div', {
            styles: {
                width: this.width,
                height: this.height,
                'font-size': 0,
                'line-height': 0,
                'float': 'right',
                'background-image': 'url(' + this.options.image + ')',
                'background-position': 'bottom center'
            }
        })
    },
    setValue: function(a) {
        if (isNaN(a)) {
            return false
        }
        a = a.toInt();
        if (a < 0) {
            a = 0
        }
        this.value = a;
        this.currentCount = a;
        this.convertNumber();
        for (var i = 0; i < this.options.digits; i++) {
            this.numbers[i].setStyle('background-position', this.getCoord(this.spins[i]))
        }
    },
    countTo: function(a) {
        if (isNaN(a)) {
            return false
        }
        a = a.toInt();
        if (a < 0) {
            a = 0
        }
        if (a == this.value) {
            return
        }
        if (this.animating) {
            this.animation.cancel();
            this.value = this.currentCount;
            this.convertNumber()
        }
        var b = Math.abs(a - this.value);
        this.mid = b / 2;
        this.step = 0;
        if (a > this.value) {
            this.direction = true;
            for (var i = this.value + 1; i <= a; i++) {
                this.enqueueAnim(i)
            }
        } else {
            this.direction = false;
            for (var i = this.value - 1; i >= a; i--) {
                this.enqueueAnim(i)
            }
        }
    },
    convertNumber: function() {
        var a = this.value + "";
        if (a.length > this.options.digits) {
            var b = this.addNumber();
            b.inject((this.overlay ? this.overlay : this.clear), 'before');
            this.numbers.push(b);
            this.options.digits++;
            this.counter.setStyle('width', this.options.digits * this.width);
            this.animation.elements = this.animation.subject = $$(this.numbers);
            b.setStyle('background-position', this.getCoord(0));
            this.convertNumber();
            return
        } else {
            while (a.length < this.options.digits) {
                a = "0" + a
            }
            for (var i = 0; i < a.length; i++) {
                this.spins[i] = a.charAt(a.length - 1 - i)
            }
        }
    },
    getCoord: function(a) {
        return '0px ' + (this.height + a * this.height) + 'px'
    },
    enqueueAnim: function(i) {
        var b = {};
        var c = $A(this.spins);
        this.value = i;
        this.convertNumber();
        this.spins.each(function(a, j) {
            if (c[j] != a) {
                if (a == 0 && this.direction) {
                    b[j] = {
                        'background-position': [this.getCoord(-1), this.getCoord(0)]
                    }
                } else if (a == 9 && !this.direction) {
                    b[j] = {
                        'background-position': [this.getCoord(10), this.getCoord(9)]
                    }
                } else {
                    b[j] = {
                        'background-position': this.getCoord(a)
                    }
                }
            }
        }, this);
        this.animation.start(b)
    },
    refresh: function() {
        if (!this.refreshed) {
            this.refreshed = true;
            if (!this.animating) {
                this.request.send();
                if (this.indicator) {
                    var a = this.counter.getCoordinates();
                    this.indicator.setStyles({
                        position: 'absolute',
                        top: a.top,
                        left: a.right
                    });
                    this.indicator.inject(document.body)
                }
            }
        }
    },
    getValue: function() {
        return this.value
    },
    override: function() {
        if (this.animating) {
            this.animation.cancel().fireEvent('onChainComplete');
            this.setValue(this.value)
        }
    }
});